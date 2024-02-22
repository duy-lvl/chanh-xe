<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Transaction;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\Partner\Transaction\TransactionResource;
use Domain\Partner\Actions\Transaction\Read\GetTransactionContract;
use Illuminate\Http\Request;
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
final class GetTransaction extends Controller
{
    public function __construct(
        private readonly GetTransactionContract $getTransactionAction,
    ) {
    }

    /**
     * Get Transactions - Handle an incoming get transactions request from partner.
     */
    public function __invoke(Request $request): mixed
    {
        $page = null === $request->input('page') ? null : (int) $request->input('page');
        $perPage = null === $request->input('per_page') ? null : (int) $request->input('per_page');

        $transactions = $this->getTransactionAction->handle(Auth::id(), $page, $perPage);

        return TransactionResource::collection($transactions);
    }
}
