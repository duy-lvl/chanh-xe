<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Profile\Write\Implementations;

use App\Exceptions\ProfileException;
use App\Models\Partner;
use Domain\Partner\Actions\Profile\Write\DeleteProfileAvatarContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

final class DeleteProfileAvatar implements DeleteProfileAvatarContract
{
    public function handle(int $partnerId): void
    {
        DB::transaction(
            callback: function () use ($partnerId): void {
                $partner = Partner::query()->with('phones')->findOrFail($partnerId);

                if ($partner->avatar_url === null) {
                    return;
                }

                Storage::disk('s3')->delete($partner->avatar_url);

                $partner->avatar_url = null;
                $updateResult = $partner->save();

                if ( ! $updateResult) {
                    throw ProfileException::UpdateFailException();
                }
            },
            attempts: 3
        );
    }
}
