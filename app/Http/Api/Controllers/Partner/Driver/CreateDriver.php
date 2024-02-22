<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Driver;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Driver\CreateDriverRequest;
use Domain\Partner\Actions\Driver\Write\CreateDriverContract;
use Illuminate\Support\Facades\Auth;

/**
 * @group Partner
 *
 * APIs for partner app
 *
 * @subgroup Driver
 *
 * @subgroupDescription Driver management
 */
final class CreateDriver extends Controller
{
    public function __construct(
        private readonly CreateDriverContract $createDriverAction
    ) {}

    /**
     * Create Driver - Handle an incoming Create Driver request from partner.
     */
    public function __invoke(CreateDriverRequest $request): mixed
    {
        $data = $request->getDriverData();

        $this->createDriverAction->handle($data);

        return response()->make(content: __('messages.partner_driver.created') , status: 201);
    }
}
