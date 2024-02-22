<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Route\Write\Implementations;

use App\Models\Route;
use Domain\Partner\Actions\Route\Write\CreateRouteContract;
use Domain\Partner\DataTransferObjects\Route\NewRouteData;
use Domain\Partner\DataTransferObjects\Route\RouteData;
use Domain\Partner\DataTransferObjects\RouteSegment\RouteMilestoneData;
use Illuminate\Support\Facades\DB;

final class CreateRoute implements CreateRouteContract
{
    public function handle(NewRouteData $data): RouteData
    {

        return DB::transaction(
            callback: function () use ($data): RouteData {
                $routeModel = Route::create(
                    attributes: [
                        'partner_id' => $data->partnerId,
                        'name' => $data->name,
                        'start_city_code' => $data->startCityCode,
                        'start_district_code' => $data->startDistrictCode,
                        'end_city_code' => $data->endCityCode,
                        'end_district_code' => $data->endDistrictCode,
                        'package_types' => $data->packageTypes
                    ],
                );

                $milestones = collect();

                foreach ($data->milestones as $milestone) {
                    $milestoneModel = $routeModel->milestones()->create(
                        attributes: [
                            'station_id' => $milestone->stationId,
                            'milestone_number' => $milestone->milestoneNumber,
                            'distance_from_previous' => $milestone->distanceFromPrevious,
                        ]
                    );

                    $milestones->push(RouteMilestoneData::fromModel($milestoneModel));
                    if (count($milestone->hubs) > 0) {
                        $hubs = $milestone->hubs;
                        $milestoneModel->hubs()->attach($hubs); 
                    }

                }

                $result = RouteData::fromModel($routeModel, $milestones);

                return $result;
            },
            attempts: 3
        );

    }
}
