<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Transaction;

final readonly class NewTransactionData
{
    public function __construct(
        public int $amount,
        public string $description,
    ) {
    }
}
