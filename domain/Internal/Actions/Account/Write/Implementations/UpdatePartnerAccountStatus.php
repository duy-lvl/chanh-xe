<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Account\Write\Implementations;

use App\Exceptions\AccountException;
use App\Models\Partner;
use Domain\Internal\Actions\Account\Write\UpdatePartnerAccountStatusContract;
use Domain\Shared\Enums\AccountStatus;
use Illuminate\Support\Facades\DB;

final class UpdatePartnerAccountStatus implements UpdatePartnerAccountStatusContract
{
    public function handle(int $id, AccountStatus $status): void
    {
        DB::transaction(
            callback: function () use ($id, $status): void {
                $partner = Partner::findOrFail($id);

                if ($partner->status === $status) {
                    throw AccountException::SameStatusException($status);
                }
                $partner->status = $status;
                $updateResult = $partner->save();
                
                if (!$updateResult) {
                    throw AccountException::UpdateFailedException();
                }
            },
            attempts: 3
        );
    }
}
