<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Statistics;

use App\Models\Customer;

final readonly class TopCustomerData
{
    public function __construct(
        public int $id,
        public string $name,
        public string $phone,
        public string $email,
        public int $numberOfOrder
    ) {
    }

    public static function fromModel(Customer $model, int $numberOfOrder): self {
        return new self (
            id: $model->id,
            name: $model->name,
            email: $model->email,
            phone: $model->phone,
            numberOfOrder: $numberOfOrder
            
        );
    }
}
