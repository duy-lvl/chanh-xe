<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Account\Write\Implementations;

use App\Exceptions\AccountException;
use App\Models\Staff;
use Domain\Internal\Actions\Account\Write\UpdateStaffAccountStatusContract;
use Domain\Shared\Enums\AccountStatus;
use Illuminate\Support\Facades\DB;

final class UpdateStaffAccountStatus implements UpdateStaffAccountStatusContract
{
    public function handle(int $id, AccountStatus $status): void
    {
        DB::transaction(
            callback: function () use ($id, $status): void {
                $staff = Staff::findOrFail($id);

                if ($staff->status === $status) {
                    throw AccountException::SameStatusException($status);
                }
                $staff->status = $status;
                $updateResult = $staff->save();
                
                if (!$updateResult) {
                    throw AccountException::UpdateFailedException();
                }
            },
            attempts: 3
        );
    }
}
