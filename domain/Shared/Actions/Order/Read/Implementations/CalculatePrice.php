<?php

declare(strict_types=1);

namespace Domain\Shared\Actions\Order\Read\Implementations;

use App\Models\BoxSize;
use Domain\Shared\Actions\Order\Read\CalculatePriceContract;
use Domain\Shared\Enums\LengthUnit;
use Domain\Shared\ValueObjects\Dimensions;
use Domain\Shared\ValueObjects\Distance;
use Domain\Shared\ValueObjects\Weight;
use Illuminate\Support\Carbon;

final class CalculatePrice implements CalculatePriceContract
{
    public function handle(Weight $weight, Dimensions $dimensions, Distance $distance): int
    {
        $boxSize = BoxSize::query()->with('prices.priceItems')
            ->where('max_length', '>=', $dimensions->length())
            ->where('max_width', '>=', $dimensions->width())
            ->where('max_height', '>=', $dimensions->height())
            ->where('max_weight', '>=', $weight->value())
            ->orderBy('max_length', 'asc')
            ->orderBy('max_width', 'asc')
            ->orderBy('max_height', 'asc')
            ->orderBy('max_weight', 'asc')
            ->first();
        
        //get current price table
        $priceTable = $boxSize->prices()
            ->active()
            ->where('apply_from', '<=', Carbon::now())
            ->where('apply_to', '>=', Carbon::now())
            ->orderBy('priority', 'desc')
            ->first();
        
        //get price item based in Distance
        $priceItem = $priceTable->priceItems()
            ->where('from_kilometer', '<=', $distance->value(LengthUnit::Kilometer))
            ->where('to_kilometer', '>=', $distance->value(LengthUnit::Kilometer))
            ->select('price_per_kilometer')
            ->first();

        $finalCost = ((int) $distance->value(LengthUnit::Meter) * (int) $priceItem->price_per_kilometer) * 0.001; //TODO: price per meter

        return (int) $finalCost; //TODO: price per meter -> no casting
    }
}
