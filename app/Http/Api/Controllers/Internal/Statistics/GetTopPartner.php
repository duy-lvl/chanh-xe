<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Statistics;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\Internal\Statistics\TopPartnerResource;
use Domain\Internal\Actions\Statistics\Read\GetTopPartnerContract;
use Request;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Statistics
 *
 * @subgroupDescription Internal manage statistics
 */
final class GetTopPartner extends Controller
{
    public function __construct(
        private readonly GetTopPartnerContract $getTopPartnerAction,
    ) {
    }

    /**
     * Get Top partners - Handle an incoming get top partners request from admin.
     */
    public function __invoke(Request $request, int $numberOfPartners): mixed
    {
        $partners = $this->getTopPartnerAction->handle($numberOfPartners);
        return TopPartnerResource::collection($partners);
    }
}
