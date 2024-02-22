<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\CustomerFacing\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class RouteSearchResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start_station' => [
                'id' => $this->startStation->id,
                'name' => $this->startStation->name,
                'address' => $this->startStation->address,
                'city_code' => $this->startStation->cityCode,
                'distance_to_sender' => 0 === $this->startStation->distanceToUser->value() ? null : $this->startStation->distanceToUser->value(),
                'partner' => [
                    'id' => $this->startStation->partnerId,
                    'name' => $this->startStation->partnerName,
                    'avatar' => $this->startStation->imageUrl
                ],
                'latitude' => $this->startStation->latitude,
                'longitude' => $this->startStation->longitude
                
            ],
            'end_station' => [
                'id' => $this->endStation->id,
                'name' => $this->endStation->name,
                'address' => $this->endStation->address,
                'city_code' => $this->endStation->cityCode,
                'distance_to_receiver' => $this->endStation->distanceToUser->value() === 0 ? null : $this->endStation->distanceToUser->value(),
                'partner' => [
                    'id' => $this->endStation->partnerId,
                    'name' => $this->endStation->partnerName,
                    'avatar' => $this->endStation->imageUrl
                ],
                'latitude' => $this->endStation->latitude,
                'longitude' => $this->endStation->longitude
                
            ],
            'lowest_price' => $this->lowestPrice,
            'total_distance' => $this->totalDistance->value(),
            'note' => $this->note,
            'acceptable_package_types' => $this->acceptablePackageTypes,
        ];
    }
}
