<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Partner\Read\Implementations;

use App\Exceptions\AccountException;
use App\Models\Partner;
use App\Models\PartnerPhone;
use App\Models\Station;
use Domain\CustomerFacing\Actions\Partner\Read\GetPartnerDetailContract;
use Domain\CustomerFacing\DataTransferObjects\Partner\PartnerData;
use Domain\CustomerFacing\DataTransferObjects\Partner\StationData;
use Domain\Partner\Enums\StationStatus;
use Domain\Shared\DataTransferObjects\PagingData;
use Domain\Shared\Enums\AccountStatus;
use Spatie\QueryBuilder\QueryBuilder;

final class GetPartnerDetail implements GetPartnerDetailContract
{
    public function handle(int $partnerId): PartnerData
    {
        $partner = Partner::query()->with('phones')->findOrFail($partnerId);

        if ($partner->status !== AccountStatus::Active){
            throw AccountException::AccountInactiveException();
        }

        $stations = $partner->stations()->where('status', StationStatus::Active)->get()
            ->map( fn (Station $station) => StationData::fromModel($station));

        $phones = $partner->phones->map(fn (PartnerPhone $phone) => $phone->phone);

        return PartnerData::fromModel($partner, $phones, $stations);
    }
}
