<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Auth;

use App\Models\Customer;
use DateTimeImmutable;
use Domain\Shared\Enums\AccountStatus;

final class AuthenticateResponseData
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $phone,
        public readonly AccountStatus $status,
        public readonly string $accessToken,
        public readonly ?DateTimeImmutable $createdAt = null,
        public readonly ?DateTimeImmutable $updatedAt = null,
        public readonly ?string $email = null,
        public readonly ?DateTimeImmutable $emailVerifiedAt = null,
        public readonly ?DateTimeImmutable $phoneVerifiedAt = null,
    ) {
    }

    // public static function fromArray(array $data): self
    // {
    //     return new self(
    //         id: $data['id'],
    //         fullname: $data['fullname'],
    //         phone: $data['phone'],
    //         status: is_int($data['status']) ? AccountStatus::from($data['status']) : $data['status'],
    //         token: $data['token'],
    //         createdAt: $data['created_at'],
    //         updatedAt: $data['updated_at'],
    //         email: $data['email'] ?? null,
    //         emailVerifiedAt : $data['emailVerifiedAt'] ?? null,
    //     );
    // }

    public static function fromModel(Customer $customer, string $token): self
    {
        return new self(
            id: $customer->id,
            name: $customer->name,
            phone: $customer->phone,
            status: $customer->status,
            accessToken: $token,
            createdAt: $customer->created_at?->toImmutable(),
            updatedAt: $customer->updated_at?->toImmutable(),
            email: $customer->email,
            emailVerifiedAt : $customer->email_verified_at?->toImmutable(),
            phoneVerifiedAt : $customer->phone_verified_at?->toImmutable(),
        );
    }
}
