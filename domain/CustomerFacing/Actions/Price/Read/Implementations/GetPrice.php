<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Price\Read\Implementations;

use App\Models\BoxSize;
use Domain\CustomerFacing\Actions\Price\Read\GetPriceContract;
use Domain\CustomerFacing\Enums\PriceStatus;

final class GetPrice implements GetPriceContract
{
    public function handle(float $length, float $width, float $height, float $weight, float $distance): int
    {
        if ($length <= 0 || $width <= 0 || $height <= 0 || $weight <=0 || $distance <= 0) {
            return 0;
        }
        $boxSize = BoxSize::query()
            ->where("max_length", ">=", $length)
            ->where("max_width", ">=", $width)
            ->where("max_height", ">=", $height)
            ->where("max_weight", ">=", $weight)
            ->orderBy('max_length', 'asc')
            ->orderBy('max_width', 'asc')
            ->orderBy('max_height', 'asc')
            ->orderBy('max_weight', 'asc')
            ->first();

        if ($boxSize === null) {
            return -1;
        }
        
        $price = $boxSize->prices()
            ->where([
                ['apply_from', '<=' , now()],
                ['apply_to', '>=' , now()],
                ['status', PriceStatus::Active]
            ])
            ->orderByDesc('priority')    
            ->first();
        
        $priceItems = $price->priceItems()->orderBy('from_kilometer')->get();
        
        $value = 0;
        foreach($priceItems as $priceItem)
        {
            
            if ($priceItem->from_kilometer >= $distance)
            {
                break;
            }
            if ($distance >= $priceItem->to_kilometer)
            {
                $value += $priceItem->max_amount;                
            } 
            else 
            {
                $segmentValue = $priceItem->price_per_kilometer * ($distance - $priceItem->from_kilometer);
                if ($segmentValue <= $priceItem->min_amount) {
                    $value += $priceItem->min_amount;
                }
                else
                {
                    $value += $segmentValue;
                }
            }
        }
        
        return (int)$value;
    }
}
