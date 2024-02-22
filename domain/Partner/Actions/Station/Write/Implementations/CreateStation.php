<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Station\Write\Implementations;

use App\Models\Station;
use Clickbar\Magellan\Data\Geometries\Point;
use Domain\Partner\Actions\Station\Write\CreateStationContract;
use Domain\Partner\DataTransferObjects\Station\NewStationData;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

final class CreateStation implements CreateStationContract
{
    public function handle(NewStationData $data): Station
    {
        return DB::transaction(
            callback: function () use ($data): Station {
                
                $stationModel = Station::query()->create(
                    attributes: [
                        'partner_id' => $data->partnerId,
                        'name' => $data->name,
                        'address' => $data->address ?? null,
                        'latitude' => $data->latitude ?? null,
                        'longitude' => $data->longitude ?? null,
                        'city_code' => $data->cityCode,
                        'district_code' => $data->districtCode,
                        'ward_code' => $data->wardCode ?? null,
                        'status' => $data->status,
                        'geography' => Point::makeGeodetic(latitude: $data->latitude, longitude: $data->longitude),
                    ],
                );

                return $stationModel;
            },
            attempts: 3
        );

    }
}
