<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Driver\Write\Implementations;

use App\Exceptions\DriverException;
use App\Models\Driver;
use Domain\Partner\Actions\Driver\Write\DeleteDriverContract;
use Illuminate\Support\Facades\DB;

final class DeleteDriver implements DeleteDriverContract
{
    public function handle(int $partnerId, int $driverId): void
    {
        DB::transaction(
            callback: function () use ($partnerId, $driverId): void {
                $driver = Driver::findOrFail($driverId);
                if ($driver->partner_id !== $partnerId) {
                    throw DriverException::UnauthorizedException();
                }
                $result = $driver->delete() > 0;
                if ( ! $result) {
                    throw DriverException::DeleteFailException();
                }
            },
            attempts: 3
        );
    }
}
