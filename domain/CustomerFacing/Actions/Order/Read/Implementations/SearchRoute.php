<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Read\Implementations;

use App\Exceptions\SearchOrderRouteException;
use App\Models\Hub;
use App\Models\OrderRoute;
use App\Models\Route;
use App\Models\RouteMilestone;
use App\Models\Station;
use App\Models\TemporaryOrderRoute;
use Clickbar\Magellan\Data\Geometries\Point;
use Clickbar\Magellan\Database\PostgisFunctions\ST;
use Domain\CustomerFacing\Actions\Order\Read\SearchRouteContract;
use Domain\CustomerFacing\DataTransferObjects\OrderRoute\SearchedOrderRouteData;
use Domain\CustomerFacing\DataTransferObjects\OrderRoute\StationData;
use Domain\CustomerFacing\DataTransferObjects\OrderRoute\TemporaryRouteCheckpointData;
use Domain\CustomerFacing\DataTransferObjects\OrderRoute\TemporaryRouteData;
use Domain\CustomerFacing\Enums\PackageType;
use Domain\Partner\Enums\StationStatus;
use Domain\PathFinding\DataTransferObjects\Path;
use Domain\PathFinding\Models\Node;
use Domain\PathFinding\Models\StringIdGraph;
use Domain\PathFinding\Services\PathFinding;
use Domain\PriceCalculation\Services\PriceCalculation;
use Domain\Shared\DataTransferObjects\PositionCodeData;
use Domain\Shared\DataTransferObjects\PositionData;
use Domain\Shared\Enums\LengthUnit;
use Domain\Shared\Services\Image;
use Domain\Shared\ValueObjects\Distance;
use Exception;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

final class SearchRoute implements SearchRouteContract
{
    private string $cacheStore = 'redis';

    private int $maxHub = 1;

    private array $context = [];

    public function __construct(
        private readonly PathFinding $pathFindingService,
        private readonly PriceCalculation $priceCalculationService,
        private readonly Image $imageService
    ) {
    }

    /**
     * @param  Collection<PackageType>  $packageTypes
     */
    public function handle(?PositionData $startPosition, ?PositionCodeData $startPositionCode, Distance $maxDistanceToStart, ?PositionData $endPosition, ?PositionCodeData $endPositionCode, Distance $maxDistanceToEnd, Collection $packageTypes, int $numberOfResults)
    {
        //step 1: find potential start station and end station
        $potentialStartStations = $this->getStationsWithinDistance(position: $startPosition, code: $startPositionCode, distance: $maxDistanceToStart);
        $potentialStartStationIds = $potentialStartStations->map(fn (Station $station) => $station->id);

        $potentialEndStations = $this->getStationsWithinDistance(position: $endPosition, code: $endPositionCode, distance: $maxDistanceToEnd);
        $potentialEndStationIds = $potentialEndStations->map(fn (Station $station) => $station->id);

        if ($potentialStartStations?->isEmpty() || $potentialStartStations?->isEmpty()) {
            throw SearchOrderRouteException::NoStationFound();
        }

        /** @var Collection<TemporaryRouteData> */
        $results = collect();

        //step 2: find straight route (route of 1 partner, no hub)
        $results = $results->merge(
            $this->findStraightRoutes($potentialStartStationIds, $potentialEndStationIds, $packageTypes)
        );

        //step 3: find routes with hubs
        $numberOfHubs = 1;

        while ($results->count() < $numberOfResults) {
            if ($numberOfHubs > $this->maxHub) {
                break;
            }

            $results = $results->merge(
                $this->findRouteWithHubs($potentialStartStationIds, $potentialEndStationIds, $startPosition, $endPosition, $packageTypes, $numberOfHubs, $numberOfResults - $results->count())
            );

            $numberOfHubs++;
        }

        if ($results->isEmpty()) {
            throw SearchOrderRouteException::NoRouteFound();
        }

        return $this->saveToDbAndFormatResults($results, $potentialStartStations, $potentialEndStations, $startPosition, $endPosition);
    }

    /**
     * @return null|Collection<Station>
     */
    private function getStationsWithinDistance(?PositionData $position, ?PositionCodeData $code, Distance $distance): ?Collection
    {
        $query = Station::query()->select()
            ->where('status', StationStatus::Active)
            ->where(function ($query) use ($position, $code, $distance) {
                if (null !== $position) {
                    $point = Point::makeGeodetic(latitude: $position->latitude, longitude: $position->longitude);

                    $query->where(
                        fn ($query) => $query
                            ->stSelect(ST::distanceSphere($point, 'geography'), 'distance_to_position')
                            ->stWhere(ST::distanceSphere($point, 'geography'), '<=', $distance->value())
                    );
                }

                if (null !== $code) {
                    $query->orWhere(
                        fn($query) => $query->where('city_code', $code->cityCode)->where('district_code', $code->districtCode)
                    );
                }
            });

        return $query->get();
    }

    /**
     * @param  Collection<int, int>  $potentialStartStationIds
     * @param  Collection<int, int>  $potentialEndStationIds
     * @param  Collection<PackageType>  $packageTypes
     * @return Collection<TemporaryRouteData>
     */
    private function findStraightRoutes(Collection $potentialStartStationIds, Collection $potentialEndStationIds, Collection $packageTypes): Collection
    {
        $routesThroughStart = Route::query()
            ->whereJsonContains('package_types', $packageTypes)
            ->with('milestones')
            ->whereHas('milestones', function ($query) use ($potentialStartStationIds): void {
                $query->whereIn('station_id', $potentialStartStationIds);
            })
            ->get();

        $routesThroughEnd = Route::query()
            ->whereJsonContains('package_types', $packageTypes)
            ->with('milestones')
            ->whereHas('milestones', function ($query) use ($potentialEndStationIds): void {
                $query->whereIn('station_id', $potentialEndStationIds);
            })
            ->get();

        // in-memory caching
        $this->context['routesThroughStart'] = $routesThroughStart;
        $this->context['routesThroughEnd'] = $routesThroughEnd;

        $matchingRoutes = $routesThroughStart->intersect($routesThroughEnd);

        if ($matchingRoutes->isEmpty()) {
            return collect();
        }

        $potentialResult = collect();

        $matchingRoutes->each(function (Route $route) use ($potentialResult, $potentialStartStationIds, $potentialEndStationIds): void {
            $milestones = $route->milestones;
            $milestonesThroughStart = $milestones->whereIn('station_id', $potentialStartStationIds);
            $milestonesThroughEnd = $milestones->whereIn('station_id', $potentialEndStationIds);

            $acceptablePackageTypes = $route->package_types;

            $milestonesThroughStart->each(function (RouteMilestone $startMilestone) use ($milestones, $potentialResult, $milestonesThroughEnd, $acceptablePackageTypes): void {
                $milestonesThroughEnd->each(function (RouteMilestone $endMilestone) use ($milestones, $potentialResult, $startMilestone, $acceptablePackageTypes): void {
                    if ($startMilestone->milestone_number < $endMilestone->milestone_number) {
                        $start = new TemporaryRouteCheckpointData(
                            id: $startMilestone->station_id,
                            type: (new Station())->getMorphClass(),
                            checkpointNumber: 1,
                            distanceFromPrevious: new Distance(0),
                        );

                        $end = new TemporaryRouteCheckpointData(
                            id: $endMilestone->station_id,
                            type: (new Station())->getMorphClass(),
                            checkpointNumber: 2,
                            distanceFromPrevious: new Distance(
                                $milestones->whereBetween('milestone_number', [$startMilestone->milestone_number + 1, $endMilestone->milestone_number])->sum('distance_from_previous')
                            ),
                        );

                        $potentialResult->push(new TemporaryRouteData(collect([$start, $end]), $acceptablePackageTypes));
                    }
                });
            });
        });

        $result = collect();

        $potentialResult->groupBy(fn (TemporaryRouteData $routeData) => $routeData->checkpoints->pluck('id'))
            ->each(function (Collection $routes) use ($result): void {
                $routes = $routes->sortBy(fn (TemporaryRouteData $routeData) => $routeData->totalDistance->value())->values();
                $result->push($routes->first());
            });

        return $result;
    }

    /**
     * @param  Collection<int, int>  $potentialStartStationIds
     * @param  Collection<int, int>  $potentialEndStationIds
     * @param  Collection<PackageType>  $packageTypes
     * @return Collection<TemporaryRouteData>
     */
    private function findRouteWithHubs(
        Collection $potentialStartStationIds,
        Collection $potentialEndStationIds,
        ?PositionData $startPosition,
        ?PositionData $endPosition,
        Collection $packageTypes,
        int $numberOfHubs,
        int $numberOfResults,
    ): Collection {
        $routes = match ($numberOfHubs) {
            1 => $this->findRouteWithOneHub($potentialStartStationIds, $potentialEndStationIds, $startPosition, $endPosition, $packageTypes, $numberOfResults),
        };

        return $routes;
    }

    private function findRouteWithOneHub(
        Collection $potentialStartStationIds,
        Collection $potentialEndStationIds,
        ?PositionData $startPosition,
        ?PositionData $endPosition,
        Collection $packageTypes,
        int $numberOfResults,
    ): Collection {
        /** @var EloquentCollection<Route> $routesThroughStart */
        $routesThroughStart = Arr::exists($this->context, 'routesThroughStart')
            ? Arr::get($this->context, 'routesThroughStart')
            : Route::query()
                ->whereJsonContains('package_types', $packageTypes)
                ->withWhereHas('milestones', function ($query) use ($potentialStartStationIds): void {
                    $query->whereIn('id', $potentialStartStationIds);
                })
                ->get();

        /** @var EloquentCollection<Route> $routesThroughEnd */
        $routesThroughEnd = Arr::exists($this->context, 'routesThroughEnd')
            ? Arr::get($this->context, 'routesThroughEnd')
            : Route::query()
                ->whereJsonContains('package_types', $packageTypes)
                ->withWhereHas('milestones', function ($query) use ($potentialEndStationIds): void {
                    $query->whereIn('id', $potentialEndStationIds);
                })
                ->get();

        // make sure we don't re-calculate the possible straight routes (which we already cover)
        $filteredRoutesThroughStart = $routesThroughStart->diff($routesThroughEnd);
        $filteredRoutesThroughEnd = $routesThroughEnd->diff($routesThroughStart);

        if ($filteredRoutesThroughStart->isEmpty() || $filteredRoutesThroughEnd->isEmpty()) {
            //we cannot find any combined routes if no route go through start OR no route go through end
            return collect();
        }

        //if routes through start and through end both exists (and are themselves not straight route) we begin to build combination routes
        $filteredRoutesThroughStart->loadMissing('milestones.hubs');
        $filteredRoutesThroughEnd->loadMissing('milestones.hubs');

        $routesThroughStartHubs = new EloquentCollection($filteredRoutesThroughStart->pluck('milestones')->collapse()->pluck('hubs')->collapse());
        $routesThroughEndHubs = new EloquentCollection($filteredRoutesThroughEnd->pluck('milestones')->collapse()->pluck('hubs')->collapse());

        $possibleHubs = $routesThroughStartHubs->merge($routesThroughEndHubs)->unique();
        $possibleHubIds = $possibleHubs->map(fn (Hub $hub) => (int) $hub->id);

        $nodes = collect([new Node(id: 1, type: 'sender')]);
        $nodes = $nodes->merge($potentialStartStationIds->map(fn (int $id) => new Node(id: $id, type: 'startStation')));
        $nodes = $nodes->merge($possibleHubIds->map(fn (int $hubId) => new Node(id: $hubId, type: 'hub')));
        $nodes = $nodes->merge($potentialEndStationIds->map(fn (int $id) => new Node(id: $id, type: 'endStation')));
        $nodes = $nodes->merge([new Node(id: 2, type: 'receiver')]);

        $graph = new StringIdGraph($nodes);

        foreach ($potentialStartStationIds as $stationId) {
            $graph->addEdge(start: $nodes->first(), end: new Node(id: $stationId, type: 'startStation'), cost: 0);
        }

        foreach ($potentialEndStationIds as $stationId) {
            $graph->addEdge(start: new Node(id: $stationId, type: 'endStation'), end: $nodes->last(), cost: 0);
        }

        $filteredRoutesThroughStart->each(function (Route $route) use ($graph, $potentialStartStationIds): void {
            $milestones = $route->milestones;

            $passThroughHubs = collect();
            $milestonesThroughStart = collect();

            $milestones->each(function (RouteMilestone $milestone, int $key) use ($passThroughHubs, $milestonesThroughStart, $potentialStartStationIds): void {
                if ($potentialStartStationIds->contains($milestone->station_id)) {
                    $milestonesThroughStart->push($milestone);
                }

                if ($milestone?->hubs?->isNotEmpty()) {
                    foreach ($milestone->hubs as $hub) {
                        $passThroughHubs->push([
                            'hub' => $hub,
                            'milestone_number' => $milestone->milestone_number,
                            'distance_from_milestone' => $hub->pivot->distance_from_milestone,
                        ]);
                    }
                    // $startMilestone->hubs->each(function (Hub $hub) use ($passThroughHubs){
                    //     $passThroughHubs->push($hub);
                    // });
                }
            });

            $milestonesThroughStart->each(function (RouteMilestone $startMilestone) use ($passThroughHubs, $graph, $milestones): void {
                $passThroughHubs->each(function (array $passThroughHub) use ($startMilestone, $graph, $milestones): void {
                    if ($startMilestone->milestone_number <= $passThroughHub['milestone_number']) {
                        $graph->addEdge(
                            start: new Node(id: $startMilestone->station_id, type: 'startStation'),
                            end: new Node(id: $passThroughHub['hub']->id, type: 'hub'),
                            cost: (int) $milestones->whereBetween('milestone_number', [$startMilestone->milestone_number + 1, $passThroughHub['milestone_number']])->sum('distance_from_previous') + (int) $passThroughHub['distance_from_milestone'],
                        );
                    }
                });
            });
        });

        $filteredRoutesThroughEnd->each(function (Route $route) use ($graph, $potentialEndStationIds): void {
            $milestones = $route->milestones;

            $passThroughHubs = collect();
            $milestonesThroughEnd = collect();

            $milestones->each(function (RouteMilestone $milestone, int $key) use ($milestones, $passThroughHubs, $milestonesThroughEnd, $potentialEndStationIds): void {
                if ($potentialEndStationIds->contains($milestone->station_id)) {
                    $milestonesThroughEnd->push($milestone);
                }

                if ($milestone?->hubs?->isNotEmpty() && $key !== ($milestones->count() - 1)) {
                    foreach ($milestone->hubs as $hub) {
                        $passThroughHubs->push([
                            'hub' => $hub,
                            'milestone_number' => $milestone->milestone_number,
                            'distance_to_next_milestone' => (int) $milestones[$key + 1]->distance_from_previous - (int) $hub->pivot->distance_from_milestone,
                        ]);
                    }
                }
            });

            $milestonesThroughEnd->each(function (RouteMilestone $endMilestone) use ($passThroughHubs, $graph, $milestones): void {
                $passThroughHubs->each(function (array $passThroughHub) use ($endMilestone, $graph, $milestones): void {
                    if ($passThroughHub['milestone_number'] < $endMilestone->milestone_number) {
                        $graph->addEdge(
                            start: new Node(id: $passThroughHub['hub']->id, type: 'hub'),
                            end: new Node(id: $endMilestone->station_id, type: 'endStation'),
                            cost: (int) $passThroughHub['distance_to_next_milestone'] + (int) $milestones->whereBetween('milestone_number', [$passThroughHub['milestone_number'] + 2, $endMilestone->milestone_number])->sum('distance_from_previous'),
                        );
                    }
                });
            });
        });

        $result = $this->pathFindingService->shortestPath($graph, $nodes->first(), $nodes->last(), $numberOfResults);

        if (count($result) === 1 && $result[0]?->cost === INF){
            return collect();
        }

        return collect($result)->map(function (Path $path) use ($graph, $filteredRoutesThroughStart, $filteredRoutesThroughEnd) {
            $checkpoints = collect();

            foreach ($path->sequence as $key => $sequenceCheckpointString) {
                $type = Str::of($sequenceCheckpointString)->afterLast('|')->value();
                $id = (int) Str::of($sequenceCheckpointString)->beforeLast('|')->value();

                if ('sender' === $type || 'receiver' === $type) {
                    continue;
                }

                $checkpoints->push(new TemporaryRouteCheckpointData(
                    id: $id,
                    type: ('startStation' === $type || 'endStation' === $type)
                        ? (new Station())->getMorphClass()
                        : (new Hub())->getMorphClass(),
                    checkpointNumber: $key,
                    distanceFromPrevious: 0 === $key
                        ? new Distance(0)
                        : new Distance(
                            value: $graph->getCost([$path->sequence[$key - 1], $sequenceCheckpointString]),
                            unit: LengthUnit::Meter,
                        )
                ));
            }

            $packageTypes1 = $filteredRoutesThroughStart->filter(function (Route $route, int $key) use ($checkpoints) {
                $hubs = new EloquentCollection($route->milestones->pluck('hubs')->collapse());
                $milestones = $route->milestones;

                return ($milestones->where('station_id', $checkpoints[0]->id)->count() > 0) && $hubs->contains($checkpoints[1]->id);
            })->first()->package_types;

            $packageTypes2 = $filteredRoutesThroughEnd->filter(function (Route $route, int $key) use ($checkpoints) {
                $hubs = new EloquentCollection($route->milestones->pluck('hubs')->collapse());
                $milestones = $route->milestones;

                return $hubs->contains($checkpoints[1]->id) && ($milestones->where('station_id', $checkpoints[2]->id)->count() > 0);
            })->first()->package_types;

            $packageTypes = collect(
                array_uintersect(
                    $packageTypes1->toArray(),
                    $packageTypes2->toArray(),
                    fn ($a, $b) => $a->value <=> $b->value
                )
            )->values();

            return new TemporaryRouteData($checkpoints, $packageTypes);
        });
    }

    /**
     * @param  Collection<TemporaryRouteData>  $temporayRoutes
     * @param  EloquentCollection<Station>  $potentialStartStations
     * @param  EloquentCollection<Station>  $potentialEndStations
     */
    private function saveToDbAndFormatResults(Collection $temporayRoutes, EloquentCollection $potentialStartStations, EloquentCollection $potentialEndStations, ?PositionData $startPosition, ?PositionData $endPosition)
    {
        return DB::transaction(function () use ($temporayRoutes, $potentialStartStations, $potentialEndStations, $startPosition, $endPosition) {
            $usedStations = new EloquentCollection();
            $startStations = new EloquentCollection();
            $endStations = new EloquentCollection();

            $temporayRoutes->each(function (TemporaryRouteData $temporayRoute) use ($usedStations, $startStations, $endStations, $potentialStartStations, $potentialEndStations): void {
                $startStation = $potentialStartStations->firstWhere('id', $temporayRoute->checkpoints->first()->id);
                $endStation = $potentialEndStations->firstWhere('id', $temporayRoute->checkpoints->last()->id);

                $usedStations->push($startStation);
                $startStations->push($startStation);

                $usedStations->push($endStation);
                $endStations->push($endStation);
            });

            $usedStations = $usedStations->unique();
            $startStations = $startStations->unique();
            $endStations = $endStations->unique();

            [$distancesFromSenderToStart, $distancesFromEndToReceiver] = $this->getUserDistances($startPosition, $endPosition, $startStations, $endStations);

            $usedStations->loadMissing('partner');

            $result = $temporayRoutes->map(function (TemporaryRouteData $temporayRoute) use ($usedStations, $distancesFromSenderToStart, $distancesFromEndToReceiver) {
                $startStation = $usedStations->firstWhere('id', $temporayRoute->checkpoints->first()->id);
                $endStation = $usedStations->firstWhere('id', $temporayRoute->checkpoints->last()->id);

                $distanceFromSender = $distancesFromSenderToStart->isEmpty()
                    ? 0
                    : $distancesFromSenderToStart->firstWhere('start_station_id', $startStation->id)['distance_meter'];

                $distanceToReceiver = $distancesFromEndToReceiver->isEmpty()
                    ? 0
                    : $distancesFromEndToReceiver->firstWhere('end_station_id', $endStation->id)['distance_meter'];

                $routeDistance = $temporayRoute->totalDistance;

                try {
                    $price = $this->priceCalculationService->calculateMinPriceForDistance(
                        distance: $routeDistance,
                    );
                } catch (Exception) {
                    $price = 13000;
                }

                $newModelData = $temporayRoute->checkpoints->map(function (TemporaryRouteCheckpointData $checkpointData) use ($routeDistance) {
                    return [
                        'checkpoint_id' => $checkpointData->id,
                        'checkpoint_type' => $checkpointData->type,
                        'checkpoint_number' => $checkpointData->checkpointNumber,
                        'distance_from_previous' => $checkpointData->distanceFromPrevious->value(),
                        'distance_percentage' => ($checkpointData->distanceFromPrevious->value() * 100) / ($routeDistance->value()),
                    ];
                });

                $model = TemporaryOrderRoute::create();
                $model->checkpoints()->createMany($newModelData->toArray());

                $startStationAvatarUrl = $this->imageService->getFileTemporaryUrl($startStation->partner->avatar_url);
                $endStationAvatarUrl = $this->imageService->getFileTemporaryUrl($endStation->partner->avatar_url);

                return new SearchedOrderRouteData(
                    id: $model->id,
                    startStation: new StationData(
                        id: $startStation->id,
                        name: $startStation->name,
                        address: $startStation->address,
                        cityCode: (string) $startStation->city_code,
                        distanceToUser: new Distance($distanceFromSender, LengthUnit::Meter),
                        partnerId: $startStation->partner->id,
                        partnerName: $startStation->partner->name,
                        imageUrl: $startStationAvatarUrl,
                        latitude: (float) $startStation->latitude,
                        longitude: (float) $startStation->longitude
                    ),
                    endStation: new StationData(
                        id: $endStation->id,
                        name: $endStation->name,
                        address: $endStation->address,
                        cityCode: (string) $endStation->city_code,
                        distanceToUser: new Distance($distanceToReceiver, LengthUnit::Meter),
                        partnerId: $endStation->partner->id,
                        partnerName: $endStation->partner->name,
                        imageUrl: $endStationAvatarUrl,
                        latitude: (float) $endStation->latitude,
                        longitude: (float) $endStation->longitude
                    ),
                    lowestPrice: $price,
                    totalDistance: $temporayRoute->totalDistance,
                    note: null,
                    acceptablePackageTypes: $temporayRoute->acceptablePackageTypes,
                );
            });

            $shortestAvgDistanceToUserRouteId = ($distancesFromSenderToStart->isNotEmpty() && $distancesFromEndToReceiver->isNotEmpty())
                ? $result->sortBy([
                    fn (SearchedOrderRouteData $a, SearchedOrderRouteData $b) => ($a->startStation->distanceToUser->value() + $a->endStation->distanceToUser->value()) <=> ($b->startStation->distanceToUser->value() + $b->endStation->distanceToUser->value()),
                    fn (SearchedOrderRouteData $a, SearchedOrderRouteData $b) => abs($a->startStation->distanceToUser->value() - $a->endStation->distanceToUser->value()) <=> abs($b->startStation->distanceToUser->value() - $b->endStation->distanceToUser->value()),
                ])->first()->id
                : -1;

            $shortestRouteId = $result->sortBy(fn (SearchedOrderRouteData $route, int $key) => $route->totalDistance->value())->first()->id;

            $nearestToSenderRouteId = ($distancesFromSenderToStart->isNotEmpty())
                ? $result->sortBy(fn (SearchedOrderRouteData $route, int $key) => $route->startStation->distanceToUser->value())->first()->id
                : -1;

            $nearestToReceiverRouteId = ($distancesFromEndToReceiver->isNotEmpty())
                ? $result->sortBy(fn (SearchedOrderRouteData $route, int $key) => $route->endStation->distanceToUser->value())->first()->id
                : -1;

            //sort result
            $sortCriteria = match (true) {
                $distancesFromSenderToStart->isNotEmpty() && $distancesFromEndToReceiver->isNotEmpty() => [
                    fn (SearchedOrderRouteData $a, SearchedOrderRouteData $b) => $a->totalDistance->value() <=> $b->totalDistance->value(),
                    fn (SearchedOrderRouteData $a, SearchedOrderRouteData $b) => ($a->startStation->distanceToUser->value() + $a->endStation->distanceToUser->value()) <=> ($b->startStation->distanceToUser->value() + $b->endStation->distanceToUser->value()),
                    fn (SearchedOrderRouteData $a, SearchedOrderRouteData $b) => abs($a->startStation->distanceToUser->value() - $a->endStation->distanceToUser->value()) <=> abs($b->startStation->distanceToUser->value() - $b->endStation->distanceToUser->value()),
                ],
                default => [
                    fn (SearchedOrderRouteData $a, SearchedOrderRouteData $b) => $a->totalDistance->value() <=> $b->totalDistance->value(),
                ],
            };

            return $result->sortBy($sortCriteria)->map(function (SearchedOrderRouteData $route) use ($shortestAvgDistanceToUserRouteId, $shortestRouteId, $nearestToSenderRouteId, $nearestToReceiverRouteId) {
                return match ($route->id) {
                    $shortestAvgDistanceToUserRouteId => $route->cloneWithNote('Gần người gửi và người nhận nhất'),
                    $shortestRouteId => $route->cloneWithNote('Quãng đường ngắn nhất'),
                    $nearestToSenderRouteId => $route->cloneWithNote('Gần người gửi nhất'),
                    $nearestToReceiverRouteId => $route->cloneWithNote('Gần người nhận nhất'),
                    default => $route
                };
            });
        });
    }

    private function getUserDistances(?PositionData $startPosition, ?PositionData $endPosition, Collection $startStations, Collection $endStations)
    {
        $key = config('services.distance_matrix.goong.key');
        $url = config('services.distance_matrix.goong.endpoint');
        //    $url = 'http://localhost';

        //build api query
        $startStationsQuery = $startStations->map(fn (Station $station) => $station->latitude . ',' . $station->longitude)->implode('|');

        $endStationsQuery = $endStations->map(fn (Station $station) => $station->latitude . ',' . $station->longitude)->implode('|');

        $senderToStartQuery = null === $startPosition ? null : [
            'destinations' => $startStationsQuery,
            'origins' => $startPosition->latitude . ',' . $startPosition->longitude,
            'units' => 'metric',
            'api_key' => $key,
        ];

        $endToReceiverQuery = null === $endPosition ? null : [
            'destinations' => $endPosition->latitude . ',' . $endPosition->longitude,
            'origins' => $endStationsQuery,
            'units' => 'metric',
            'api_key' => $key,
        ];

        //call api
        $senderToStartResponse = null;
        $endToReceiverResponse = null;

        if (null !== $senderToStartQuery && null !== $endToReceiverQuery) {
            try {
                [$senderToStartResponse, $endToReceiverResponse] = Http::pool(fn (Pool $pool) => [
                    $pool->withQueryParameters($senderToStartQuery)->get($url),
                    $pool->withQueryParameters($endToReceiverQuery)->get($url),
                ]);
                // $senderToStartResponse = Http::withQueryParameters($senderToStartQuery)->get($url);
                // $endToReceiverResponse = Http::withQueryParameters($endToReceiverQuery)->get($url);
            } catch (Exception $e) {
                $senderToStartResponse = null;
                $endToReceiverResponse = null;

                Log::error($e->getMessage());
            }

            try {
                if ($senderToStartResponse instanceof Throwable) {
                    throw $senderToStartResponse;
                }
            } catch (Exception $e) {
                $senderToStartResponse = null;
                Log::error($e->getMessage());
            }

            try {
                if ($endToReceiverResponse instanceof Throwable) {
                    throw $endToReceiverResponse;
                }
            } catch (Exception $e) {
                $endToReceiverResponse = null;
                Log::error($e->getMessage());
            }
        }

        if (null === $senderToStartQuery && null !== $endToReceiverQuery) {
            try {
                $endToReceiverResponse = Http::withQueryParameters($endToReceiverQuery)->get($url);
            } catch (Exception $e) {
                $endToReceiverResponse = null;
                Log::error($e->getMessage());
            }
        }

        if (null !== $senderToStartQuery && null === $endToReceiverQuery) {
            try {
                $senderToStartResponse = Http::withQueryParameters($senderToStartQuery)->get($url);
            } catch (Exception $e) {
                $senderToStartResponse = null;
                Log::error($e->getMessage());
            }
        }

        //parse response
        $distancesFromSenderToStart = collect();

        if (null !== $senderToStartResponse) {
            for ($i = 0; $i < count($senderToStartResponse['rows']); $i++) {
                for ($j = 0; $j < count($senderToStartResponse['rows'][$i]['elements']); $j++) {
                    $distancesFromSenderToStart->push([
                        'start_station_id' => $startStations[$j]->id,
                        'distance_meter' => $senderToStartResponse['rows'][$i]['elements'][$j]['distance']['value'],
                        'duration_second' => $senderToStartResponse['rows'][$i]['elements'][$j]['duration']['value'],
                    ]);
                }
            }
        }

        $distancesFromEndToReceiver = collect();

        if (null !== $endToReceiverResponse) {
            for ($i = 0; $i < count($endToReceiverResponse['rows']); $i++) {
                for ($j = 0; $j < count($endToReceiverResponse['rows'][$i]['elements']); $j++) {
                    $distancesFromEndToReceiver->push([
                        'end_station_id' => $endStations[$i]->id,
                        'distance_meter' => $endToReceiverResponse['rows'][$i]['elements'][$j]['distance']['value'],
                        'duration_second' => $endToReceiverResponse['rows'][$i]['elements'][$j]['duration']['value'],
                    ]);
                }
            }
        }

        // $routes = $routes->map(function (array $route) use ($distancesFromSenderToStart, $distancesFromEndToReceiver) {
        //     $distanceFromSenderToStart = $distancesFromSenderToStart->firstWhere('start_station_id', (int) $route['segments'][0]['startStation'])['distance_meter'];
        //     $distanceFromEndToReceiver = $distancesFromEndToReceiver->firstWhere('end_station_id', (int) $route['segments'][count($route['segments']) - 1]['endStation'])['distance_meter'];

        //     $route['segments'][0]['distance'] = $distanceFromSenderToStart;
        //     $route['segments'][count($route['segments']) - 1]['distance'] = $distanceFromEndToReceiver;

        //     return $route;
        // });

        return [$distancesFromSenderToStart, $distancesFromEndToReceiver];
    }

    // private function createRoutes(Collection $routes)
    // {
    //     return DB::transaction(
    //         callback: function () use ($routes) {
    //             // array_pop($route['segments']);
    //             // array_shift($route['segments']);

    //             $result = collect();

    //             foreach ($routes as $route) {
    //                 $model = OrderRoute::query()->create([
    //                     'start_station_id' => $route['segments'][1]['startStation'],
    //                     'end_station_id' => $route['segments'][2]['endStation'],
    //                     'total_distance' => $route['total_distance'],
    //                     'is_selected' => false,
    //                 ]);

    //                 $model->segments()->create([
    //                     'hub_id' => $route['segments'][1]['hub'],
    //                     'sequence_number' => 1,
    //                     'distance' => $route['segments'][1]['distance'],
    //                 ]);

    //                 $result->push($model);
    //             }

    //             return $result;
    //         },
    //         attempts: 3,
    //     );
    // }
}

// route where segment after hub

// select "segment_number"
// from "partner_route_segments"
// where "partner_routes"."id" = "partner_route_segments"."partner_route_id"
// and exists
//     (select * from "hubs" inner join "hub_in_route_segment" on "hubs"."id" = "hub_in_route_segment"."hub_id"
//         where "partner_route_segments"."id" = "hub_in_route_segment"."partner_route_segment_id")

//select * from "partner_routes" where exists (select * from "partner_route_segments" where "partner_routes"."id" = "partner_route_segments"."partner_route_id" and "end_station_id" in (3, 29, 41, 44, 54, 56, 60, 61, 87, 88, 89, 90, 91)
//and "segment_number" <= (select segment_number from "partner_route_segments" where exists (select hubs.id from "hubs" inner join "hub_in_route_segment" on "hubs"."id" = "hub_in_route_segment"."hub_id" where partner_route_segments.id = hub_in_route_segment.partner_route_segment_id) order by "segment_number" desc limit 1))

//select * from "partner_route_segments" where "partner_route_segments"."partner_route_id" in (1, 3, 4, 5, 6, 15, 16) and "end_station_id" in (3, 29, 41, 44, 54, 56, 60, 61, 87, 88, 89, 90, 91)
//and "segment_number" <= (select segment_number from "partner_route_segments" where exists (select hubs.id from "hubs" inner join "hub_in_route_segment" on "hubs"."id" = "hub_in_route_segment"."hub_id" where partner_route_segments.id = hub_in_route_segment.partner_route_segment_id) order by "segment_number" desc limit 1)
