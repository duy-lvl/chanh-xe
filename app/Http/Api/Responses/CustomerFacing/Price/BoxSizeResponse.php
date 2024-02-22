<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\CustomerFacing\Price;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
final class BoxSizeResponse extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {   //just revert change ;-;
        //TODO delete this comment
        return [
            'data' => $this->collection
        ];
    }
}
