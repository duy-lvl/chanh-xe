<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Route\Write;

use Domain\Partner\DataTransferObjects\Route\NewRouteData;
use Domain\Partner\DataTransferObjects\Route\RouteData;

interface CreateRouteContract
{
    public function handle(NewRouteData $data): RouteData;
}
