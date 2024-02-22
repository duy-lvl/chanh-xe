<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read\Implementations;

use App\Models\Hub;
use App\Models\Order;
use App\Models\Partner;
use App\Models\Station;
use Domain\Internal\Actions\Statistics\Read\GetTopPartnerContract;
use Domain\Internal\DataTransferObjects\Statistics\TopPartnerData;
use Domain\Shared\Enums\AccountStatus;
use Domain\Shared\Services\Image;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

final class GetTopPartner implements GetTopPartnerContract
{
    public function __construct(
        private readonly Image $imageService
    ) {}
    /**
     * @return Collection<TopPartnerData>
     */
    public function handle(int $numberOfPartners = 10): Collection
    {
        $partners = Partner::query()->where('status', AccountStatus::Active)->get();

        $result = $partners->map(function (Partner $partner) {
            $avatarUrl = $this->imageService->getFileTemporaryUrl($partner->avatar_url);

            return TopPartnerData::fromModel(
                model: $partner,
                numberOfOrder: Order::query()
                    ->where(fn (Builder $query) => $query->whereRelation('endStation', 'partner_id', $partner->id)->orWhereRelation('startStation', 'partner_id', $partner->id))
                    ->where('is_cancelled', false)
                    ->whereDoesntHave('routeCheckpoints.permissions', fn (Builder $query) => $query->whereNull('achieved_at'))
                    ->count(),
                avatarUrl: $avatarUrl
            );
        });

        return $result->sortByDesc('numberOfOrder')->take($numberOfPartners)->reject(fn(TopPartnerData $data) => $data->numberOfOrder === 0);
    }
}
