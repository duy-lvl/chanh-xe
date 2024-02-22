<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Driver\Write\Implementations;

use App\Exceptions\DriverException;
use App\Models\Driver;
use Domain\Partner\Actions\Driver\Write\UpdateDriverContract;
use Domain\Partner\DataTransferObjects\Driver\UpdateDriverData;
use Illuminate\Support\Facades\DB;

final class UpdateDriver implements UpdateDriverContract
{
    public function handle(int $partnerId, UpdateDriverData $data): void
    {
        DB::transaction(
            callback: function () use ($partnerId, $data): void {
                $driver = Driver::findOrFail($data->id);
                if ($driver->partner_id !== $partnerId) {
                    throw DriverException::UnauthorizedException();
                }
                $driver->phone = $data->phone;
                $driver->name = $data->name;
                $updateResult = $driver->save();
                if ( ! $updateResult) {
                    throw DriverException::UpdateFailException();
                }
            },
            attempts: 3
        );
    }
}
