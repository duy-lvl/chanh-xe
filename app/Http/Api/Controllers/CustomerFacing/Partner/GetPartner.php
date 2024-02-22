<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Partner;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\CustomerFacing\Partner\GetPartnerRequest;
use App\Http\Api\Responses\CustomerFacing\Partner\PartnerResource;
use Domain\CustomerFacing\Actions\Partner\Read\GetPartnerContract;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Customer Facing
 *
 * APIs for customer app
 *
 * @subgroup Partner
 *
 * @subgroupDescription partner information
 */
final class GetPartner extends Controller
{
    public function __construct(
        private readonly GetPartnerContract $getPartnerAction,
    ) {
    }

    /**
     * Get Partner list - Return list of partners
     */
    public function __invoke(GetPartnerRequest $request): JsonResource
    {
        $pagingData = $request->getPagingData();

        $partners = $this->getPartnerAction->handle(
            pagingData: $pagingData
        );

        return PartnerResource::collection($partners);
    }
}
