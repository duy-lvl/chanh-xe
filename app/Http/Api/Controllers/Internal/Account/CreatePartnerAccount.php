<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Account;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Account\CreatePartnerAccountRequest;
use App\Http\Api\Responses\Internal\Account\CreatePartnerAccountResponse;
use Domain\Internal\Actions\Account\Write\CreatePartnerAccountContract;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Account
 *
 * @subgroupDescription Account management
 */
final class CreatePartnerAccount extends Controller
{
    public function __construct(
        private readonly CreatePartnerAccountContract $createPartnerAccountAction,
    ) {
    }

    /**
     * Create Partner Account - Return with a randomly generated password
     */
    public function __invoke(CreatePartnerAccountRequest $request): JsonResource
    {
        $payload = $request->getNewPartnerAccountData();

        $result = $this->createPartnerAccountAction->handle(
            data: $payload,
        );

        return new CreatePartnerAccountResponse($result);
    }
}
