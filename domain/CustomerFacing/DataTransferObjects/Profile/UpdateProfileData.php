<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Profile;

use App\Models\Customer;

final readonly class UpdateProfileData
{
    public function __construct(
        public int $id,
        public string $name,
        public string $phone,
        public ?string $email = null,
    ) {
    }

    public static function fromModel(Customer $customer): self
    {
        return new self(
            id: $customer->id,
            name: $customer->name,
            phone: $customer->phone,
            email: $customer->email,
        );
    }
}
