<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Transaction;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Transaction\GetTransactionRequestRequest;
use App\Http\Api\Responses\Partner\Transaction\GetTransactionRequestResource;
use Domain\Partner\Actions\Transaction\Read\GetTransactionRequestContract;
use Illuminate\Support\Facades\Auth;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Transaction
 *
 * @subgroupDescription Partner get transaction
 */
final class GetTransactionRequest extends Controller
{
    public function __construct(
        private readonly GetTransactionRequestContract $getTransactionRequestAction,
    ) {
    }

    /**
     * Get Transaction Requests - Handle an incoming get transaction requests requested from partner.
     */
    public function __invoke(GetTransactionRequestRequest $request): mixed
    {
        $pagingData = $request->getPagingData();

        $transactionRequests = $this->getTransactionRequestAction->handle(Auth::id(), $pagingData);

        return GetTransactionRequestResource::collection($transactionRequests);
    }
}
