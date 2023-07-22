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

        $isDuplicateFund = $result['isDuplicateFund'] ?? false;

        if ($isDuplicateFund) {

            Log::warning('Duplicate fund detected!', [
                'fund_name'       => $fundName,
                'manager_name'    => $managerName,
                'match_fund_name' => $result['matchFundName'],
                'match_alias'     => $result['matchAlias'],
            ]);
        }
    }
}
