<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Hub\Write\Implementations;

use App\Models\Hub;
use Clickbar\Magellan\Data\Geometries\Point;
use Domain\Internal\Actions\Hub\Write\CreateHubContract;
use Domain\Internal\DataTransferObjects\Hub\NewHubData;
use Illuminate\Support\Facades\DB;

final class CreateHub implements CreateHubContract
{
    public function handle(NewHubData $data): Hub
    {
        return DB::transaction(
            callback: function () use ($data): Hub {
                $hubModel = Hub::query()->create(
                    attributes: [
                        'name' => $data->name,
                        'address' => $data->address ?? null,
                        'latitude' => $data->latitude ?? null,
                        'longitude' => $data->longitude ?? null,
                        'geography' => Point::makeGeodetic(latitude: $data->latitude, longitude: $data->longitude),
                    ],
                );

                return $hubModel;
            },
            attempts: 3
        );

    }
}
