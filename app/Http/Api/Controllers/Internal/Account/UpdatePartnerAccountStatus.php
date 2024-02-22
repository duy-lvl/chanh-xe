<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Account;

use App\Http\Api\Controllers\Controller;
use Domain\Internal\Actions\Account\Write\UpdatePartnerAccountStatusContract;
use Domain\Shared\Enums\AccountStatus;
use Illuminate\Http\Request;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Account
 *
 * @subgroupDescription Account management
 */
final class UpdatePartnerAccountStatus extends Controller
{
    public function __construct(
        private readonly UpdatePartnerAccountStatusContract $updatePartnerAccountStatusAction,
    ) {
    }

    /**
     * Update Partner Account Status
     */
    public function __invoke(Request $request, int $id, int $status): mixed
    {

        $this->updatePartnerAccountStatusAction->handle(
            id: $id,
            status: AccountStatus::from($status)
        );

        return response()->make(content: "Updated successfully");
    }
}
