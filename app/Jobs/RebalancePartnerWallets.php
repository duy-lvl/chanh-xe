<?php

namespace App\Jobs;

use App\Models\Partner;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Domain\Partner\Services\TransactionManagement;
use Illuminate\Support\Facades\Log;

class RebalancePartnerWallets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(TransactionManagement $transactionManagementService): void
    {
        Log::info("Executing job: " . $this::class);
        $partners = Partner::select('id')->get();

        foreach ($partners as $partner){
            Log::info("Executing job: " . $this::class . ', partner: ' . $partner->id);
            $transactionManagementService->rebalanceWallets($partner->id);
        }

        Log::info("Job: " . $this::class . ' done');
    }
}
