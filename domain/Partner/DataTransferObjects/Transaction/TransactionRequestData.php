<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Transaction;

use App\Models\TransactionRequest;
use DateTimeImmutable;
use Domain\Partner\Enums\TransactionRequestType;
use Facades\Domain\Shared\Services\Image;
final readonly class TransactionRequestData
{
    public function __construct(
        public int $id,
        public int $amount,
        public TransactionRequestType $type,
        public ?DateTimeImmutable $createdAt = null,
        public bool $isProceeded,
        public ?string $imageUrl
    ) {
    }

    public static function fromModel(TransactionRequest $model, bool $isProceeded): self
    {
        $imageUrl = Image::getFileTemporaryUrl($model->image_url);
        return new self(
            id: $model->id,
            amount: $model->amount,
            type: $model->type,
            createdAt: $model->created_at?->toImmutable(),
            isProceeded: $isProceeded,
            imageUrl: $imageUrl
        );
    }
}
