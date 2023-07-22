<?php

namespace App\Services;

use App\Http\Controllers\Requests\FundPostRequest;
use App\Models\Fund;
use App\Models\FundManager;

class FundService
{

    public function createFund(FundPostRequest $request)
    {
        $manager = $this->createManager($request->manager);


        $fund = new Fund();
        $fund->name       = $request->fund;
        $fund->manager_id = $manager->id;
        $fund->start_year = $request->year;
        $fund->aliases    = $request->aliases;
        $fund->save();

        return $fund;
    }

    private function createManager($managerName)
    {
        //todo check for existing maanger
        //$manager = FundManager::where('name', $managerName)->first();
        $manager = new FundManager();
        $manager->name = $managerName;
        $manager->save();

        return $manager;
    }
}
