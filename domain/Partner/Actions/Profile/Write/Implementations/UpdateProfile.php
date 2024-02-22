<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Profile\Write\Implementations;

use App\Exceptions\ProfileException;
use App\Models\Partner;
use App\Models\PartnerPhone;
use Domain\Partner\Actions\Profile\Write\UpdateProfileContract;
use Domain\Partner\DataTransferObjects\Profile\UpdateProfileData;
use Illuminate\Support\Facades\DB;

final class UpdateProfile implements UpdateProfileContract
{
    public function handle(int $partnerId, UpdateProfileData $data): void
    {
        DB::transaction(
            callback: function () use ($partnerId, $data): void {
                $partner = Partner::query()->with('phones')->findOrFail($partnerId);

                $partner->name = $data->name;
                $partner->description = $data->description;

                $updateResult = $partner->save();

                $newPhones = $data->phones->diff($partner->phones->pluck('phone'));
                $deletedPhones = $partner->phones->pluck('phone')->diff($data->phones);

                $partner->phones()->createMany($newPhones->map(fn (string $phoneNumber) => ['phone' => $phoneNumber]));

                $deletedPhones->each(function (string $phoneNumber): void {
                    PartnerPhone::where('phone', $phoneNumber)->delete();
                });

                if ( ! $updateResult) {
                    throw ProfileException::UpdateFailException();
                }
            },
            attempts: 3
        );
    }
}
