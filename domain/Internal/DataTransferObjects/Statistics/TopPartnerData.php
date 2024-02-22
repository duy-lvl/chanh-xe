<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Statistics;

use App\Models\Partner;

final readonly class TopPartnerData
{
    public function __construct(
        public int $id,
        public string $name,
        public int $numberOfOrder,
        public ?string $avatarUrl = null,
    ) {
    }

    public static function fromModel(Partner $model, int $numberOfOrder, ?string $avatarUrl = null): self {
        return new self (
            id: $model->id,
            name: $model->name,
            numberOfOrder: $numberOfOrder,
            avatarUrl: $avatarUrl,
        );
    }
}
