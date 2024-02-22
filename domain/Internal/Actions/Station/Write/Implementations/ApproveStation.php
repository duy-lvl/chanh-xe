<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Station\Write\Implementations;

use App\Exceptions\StationException;
use App\Models\Station;
use Domain\Internal\Actions\Station\Write\ApproveStationContract;
use Domain\Partner\Enums\StationStatus;
use Illuminate\Support\Facades\DB;

final class ApproveStation implements ApproveStationContract
{
    public function handle(int $stationId): bool
    {
        return DB::transaction(
            callback: function () use ($stationId): bool {
                $stationModel = Station::find($stationId);

                if ($stationModel->status !== StationStatus::Pending) {
                    throw StationException::StationHasBeenApprovedException();
                }

                $stationModel->status = StationStatus::Active;

                return $stationModel->save();
            },
            attempts: 3
        );

    }
}