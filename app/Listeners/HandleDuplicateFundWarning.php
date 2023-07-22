<?php

namespace App\Listeners;

use App\Events\DuplicateFundWarning;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class HandleDuplicateFundWarning
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
    public function handle(DuplicateFundWarning $event): void
    {
        $fundName    = $event->fundName;
        $managerName = $event->managerName;
        $result      = $event->result;

        // Example: Logging the duplicate fund warning
        Log::info('Duplicate fund detected!', [
            'fund_name'                        => $fundName,
            'manager_name'                     => $managerName,
            'is_duplicate_fund_name'           => $result['isDuplicateFundName'],
            'is_duplicate_both_fund_and_alias' => $result['isDuplicateBothFundAndAlias'],
            'match_alias'                      => $result['matchAlias'],
        ]);
    }
}
