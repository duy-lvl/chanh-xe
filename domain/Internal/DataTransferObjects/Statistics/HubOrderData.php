<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Statistics;

use App\Models\Hub;

final readonly class HubOrderData
{
    public function __construct(
        public int $hubId,
        public string $hubName,
        public string $hubAddress,
        public int $numberOfOrders,
        
    ) {
    }

    public static function fromModel(Hub $model, int $numberOfOrders): self {
        return new self (
            hubId: $model->id,
            hubName: $model->name,
            hubAddress: $model->address,
            numberOfOrders: $numberOfOrders
            
        );
    }

    public function toArray(): array 
    {
        return [
            'hub_id' => $this->hubId,
            'hub_name' => $this->hubName,
            'hub_address' => $this->hubAddress,
            'number_of_orders' => $this->numberOfOrders
        ];
    }
}
