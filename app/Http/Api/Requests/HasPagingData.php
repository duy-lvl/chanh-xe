<?php

declare(strict_types=1);

namespace App\Http\Api\Requests;

use Domain\Shared\Constants\DefaultConstant;
use Domain\Shared\DataTransferObjects\PagingData;

trait HasPagingData
{
    public function getPagingData(): PagingData
    {
        $perPage = match (true) {
            null !== $this->perPage => $this->perPage,
            null !== $this->per_page => $this->per_page,
            default => DefaultConstant::PER_PAGE,
        };

        return new PagingData(
            page: null === $this->page ? 1 : (int) $this->page,
            perPage: (int) $perPage,
        );
    }
}
