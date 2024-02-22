<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Price\Write\Implementations;

use App\Models\BoxSize;
use Domain\Internal\Actions\Price\Write\CreateBoxSizeContract;
use Domain\Internal\DataTransferObjects\Price\BoxSizeData;
use Domain\Internal\DataTransferObjects\Price\NewBoxData;
use Illuminate\Support\Facades\DB;

final class CreateBoxSize implements CreateBoxSizeContract
{
    public function handle(NewBoxData $data): BoxSizeData
    {
        return DB::transaction(
            callback: function () use ($data): BoxSizeData {
                $model = BoxSize::query()->create(
                    attributes: [
                        'max_weight' => $data->weight->value(),
                        'max_height' => $data->dimensions->height(),
                        'max_length' => $data->dimensions->length(),
                        'max_width' => $data->dimensions->width(),
                    ]
                );

                return BoxSizeData::fromModel($model);
            },
            attempts: 3
        );
    }
}
