<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Driver\Write\Implementations;

use App\Exceptions\DriverException;
use App\Models\Driver;
use Domain\Partner\Actions\Driver\Write\UpdateDriverAvatarContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

final class UpdateDriverAvatar implements UpdateDriverAvatarContract
{
    public function handle(int $partnerId, int $driverId, UploadedFile $avatar): void
    {
        DB::transaction(
            callback: function () use ($partnerId, $driverId, $avatar): void {
                $driver = Driver::query()->findOrFail($driverId);

                if ($partnerId !== $driver->partner_id) {
                    throw DriverException::UnauthorizedException();
                }

                if ($driver->avatar_url !== null && Storage::disk('s3')->exists($driver->avatar_url)) {
                    Storage::disk('s3')->delete($driver->avatar_url);
                }

                $avatarUrl = Storage::disk('s3')->putFile('partner_drivers', $avatar, 'public');

                $driver->avatar_url = $avatarUrl;
                $updateResult = $driver->save();

                if ( ! $updateResult) {
                    throw DriverException::UpdateFailException();
                }
            },
            attempts: 3
        );
    }
}
