<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Statistics;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\Internal\Statistics\PartnerResource;
use Domain\Internal\Actions\Statistics\Read\GetPartnerStatisticsContract;
use Domain\Shared\Enums\AccountStatus;
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
final class GetPartner extends Controller
{
    public function __construct(
        private readonly GetPartnerStatisticsContract $getPartnerStatisticsAction,
    ) {
    }

    /**
     * Get partners - Handle an incoming get partners request from admin.
     */
    public function __invoke(Request $request): mixed
    {
        $numberOfActivePartners = $this->getPartnerStatisticsAction->handle(AccountStatus::Active);
        $numberOfInactivePartners = $this->getPartnerStatisticsAction->handle(AccountStatus::Inactive);
        return new PartnerResource([
            'active' => $numberOfActivePartners,
            'inactive' => $numberOfInactivePartners
        ]);
    }
}
