<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Partner;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\CustomerFacing\Partner\GetPartnerRequest;
use App\Http\Api\Responses\CustomerFacing\Partner\PartnerDetailResource;
use Domain\CustomerFacing\Actions\Partner\Read\GetPartnerDetailContract;
use Illuminate\Http\Resources\Json\JsonResource;
use Request;

/**
 * @group Customer Facing
 *
 * APIs for customer app
 *
 * @subgroup Partner
 *
 * @subgroupDescription partner information
 */
final class GetPartnerDetail extends Controller
{
    public function __construct(
        private readonly GetPartnerDetailContract $getPartnerDetailAction,
    ) {
    }

    /**
     * Get Partner detail - Return partner's detail
     */
    public function __invoke(Request $request, int $id): JsonResource
    {
        

        $partners = $this->getPartnerDetailAction->handle(
            partnerId: $id,
            
        );

        return new PartnerDetailResource($partners);
    }
}
