<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Driver\Write\Implementations;

use App\Exceptions\DriverException;
use App\Models\Driver;
use Domain\Partner\Actions\Driver\Write\CreateDriverContract;
use Domain\Partner\DataTransferObjects\Driver\NewDriverData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

final class CreateDriver implements CreateDriverContract
{
    public function handle(NewDriverData $data): void
    {
        DB::transaction(
            callback: function () use ($data): void {
                $avatarUrl = Storage::disk('s3')->putFile('partner_drivers', $data->avatar, 'public');
                $deletedDriver = Driver::withTrashed()->where('partner_id', $data->partnerId)
                        ->where('phone', $data->phone)->first();
                if ($deletedDriver !== null) {
                    $deletedDriver->restore();
                    Storage::disk('s3')->delete($deletedDriver->avatar_url);
                    $deletedDriver->avatar_url = $avatarUrl;
                    $deletedDriver->save();
                    return;
                }
                $avatarUrl = Storage::disk('s3')->putFile('partner_drivers', $data->avatar, 'public');
                
                $driver = Driver::query()->create(attributes: 
                    [
                        'phone' => $data->phone,
                        'avatar_url' => $avatarUrl,
                        'name' => $data->name,
                        'partner_id' => $data->partnerId
                    ]
                );
                
                if ($driver === null) {
                    throw DriverException::CreateFailException();
                }
            },
            attempts: 3
        );
    }
}
