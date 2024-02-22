<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Transaction;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\Partner\Transaction\BalanceResource;
use Domain\Partner\Actions\Transaction\Read\ViewBalanceContract;
use Illuminate\Support\Facades\Auth;
use Request;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Transaction
 *
 * @subgroupDescription Partner get transaction
 */
final class ViewBalance extends Controller
{
    public function __construct(
        private readonly ViewBalanceContract $viewBalanceAction,
    ) {
    }

    /**
     * View balance - Handle an incoming view balance request from partner.
     */
    public function __invoke(Request $request): mixed
    {
        
        return new BalanceResource($this->viewBalanceAction->handle(Auth::id()));
    }
}
