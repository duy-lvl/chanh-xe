<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Profile\Write\Implementations;

use App\Exceptions\ProfileException;
use App\Models\Partner;
use App\Models\PartnerPhone;
use Domain\Partner\Actions\Profile\Write\UpdateProfileAvatarContract;
use Domain\Partner\DataTransferObjects\Profile\UpdateProfileData;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

final class UpdateProfileAvatar implements UpdateProfileAvatarContract
{
    public function handle(int $partnerId, UploadedFile $avatar): void
    {
        DB::transaction(
            callback: function () use ($partnerId, $avatar): void {
                $partner = Partner::query()->with('phones')->findOrFail($partnerId);
                $avatarUrl = Storage::disk('s3')->putFile('partners', $avatar, 'public');

                $partner->avatar_url = $avatarUrl;
                $updateResult = $partner->save();

                if ( ! $updateResult) {
                    throw ProfileException::UpdateFailException();
                }
            },
            attempts: 3
        );
    }
}
