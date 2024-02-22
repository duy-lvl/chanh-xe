<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Station\Write\Implementations;

use App\Models\Station;
use Domain\Partner\Actions\Station\Write\UpdateStationContract;
use Domain\Partner\DataTransferObjects\Station\UpdatableStationData;
use Illuminate\Support\Facades\DB;

final class UpdateStation implements UpdateStationContract
{
    public function handle(UpdatableStationData $data): Station
    {
        return DB::transaction(
            callback: function () use ($data): Station {
                $stationModel = Station::query()->findOrFail($data->id);

                $stationModel->name = $data->name;
                $stationModel->save();

                return $stationModel;
            },
            attempts: 3
        );

    }
}
