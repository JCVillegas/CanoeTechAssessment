<?php

namespace App\Listeners;

use App\Events\DuplicateFundWarningEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class HandleDuplicateFundWarningListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DuplicateFundWarningEvent $event): void
    {
        $fundName    = $event->fundName;
        $managerName = $event->managerName;
        $result      = $event->result;

        $isDuplicateFundName = $result['isDuplicateFundName'] ?? false;

        if ($isDuplicateFundName) {
            // Example: Logging the duplicate fund warning
            Log::info('Duplicate fund detected!', [
                'fund_name' => $fundName,
                'manager_name' => $managerName,
                'is_duplicate_fund_name' => $result['isDuplicateFundName'],
                'is_duplicate_both_fund_and_alias' => $result['isDuplicateBothFundAndAlias'],
                'match_alias' => $result['matchAlias'],
            ]);
        }
    }
}
