<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Price\Write\Implementations;

use App\Models\BoxSize;
use Domain\Internal\Actions\Price\Write\CreatePriceContract;
use Domain\Internal\DataTransferObjects\Price\NewPriceData;
use Illuminate\Support\Facades\DB;

final class CreatePrice implements CreatePriceContract
{
    public function handle(int $boxSizeId, NewPriceData $data): bool
    {
        return DB::transaction(
            callback: function () use ($data, $boxSizeId): bool {
                $box = BoxSize::find($boxSizeId);

                $transformedData = collect($data->toArray());

                $priceModel = $box->prices()->create($transformedData->except(['items'])->toArray());

                $result = $priceModel->priceItems()->createMany($transformedData->only(['items'])->toArray()['items']);

                return null !== $result;
            },
            attempts: 3
        );
    }
}
