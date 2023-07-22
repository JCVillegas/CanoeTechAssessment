<?php

namespace App\Services;

use App\Events\DuplicateFundWarningEvent;
use App\Http\Controllers\Requests\FundPostRequest;
use App\Listeners\HandleDuplicateFundWarningListener;
use App\Models\Fund;
use App\Models\FundManager;

class FundService
{

    public function createFund(FundPostRequest $request)
    {
        $fundName      = $request->input('fund');
        $managerName   = $request->input('manager');

        // Check for duplicate
        $duplicateResult = $this->isDuplicateFund($fundName, $managerName);

        // Dispatch event
        if ($duplicateResult['isDuplicateFund']) {
            event(new DuplicateFundWarningEvent($fundName, $managerName, $duplicateResult));

        }

        $manager = $this->createManager($request->manager);

        $fund = new Fund();
        $fund->name       = $request->fund;
        $fund->manager_id = $manager->id;
        $fund->start_year = $request->year;
        $fund->aliases    = ($request->alias);
        $fund->save();

        return $fund;
    }

    private function createManager($managerName)
    {
        $manager = new FundManager();
        $manager->name = $managerName;
        $manager->save();

        return $manager;
    }

    private function isDuplicateFund($fundName, $managerName)
    {
        $result = [
            'isDuplicateFund' => false,
            'matchAlias'      => null,
            'matchFundName'     => null,
            ];

        // Check if a fund with the same name or alias exists for the same manager
        $existingFund = Fund::where(function ($query) use ($fundName) {
            $query->where('name', $fundName)
                ->orWhereJsonContains('aliases', $fundName);
        })
            ->whereHas('manager', function ($query) use ($managerName) {
                $query->where('name', $managerName);
            })
            ->get();

        if ($existingFund->count() > 0) {
            $result['isDuplicateFund'] = true;

            // Check if both fund name and alias match
            $nameMatch = $existingFund->contains('name', $fundName);
            $aliasMatch = $existingFund->contains(function ($fund) use ($fundName) {
                return in_array($fundName, $fund->aliases);
            });

            if ($nameMatch && $aliasMatch) {
                $result['matchAlias']    = $fundName;
                $result['matchFundName'] = $fundName;
            } elseif ($nameMatch) {

                $result['matchFundName'] = $fundName;
            } elseif ($aliasMatch) {
                $matchingFund = $existingFund->where('aliases', 'LIKE', '%"' . $fundName . '"%')->first();
                $result['matchAlias'] = $matchingFund->aliases;
            }
        }

        return $result;
    }






}



//If the incoming fund name matches an existing fund name or a fund alias of an existing manager with the same incoming manager
