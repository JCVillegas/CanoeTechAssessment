<?php

namespace App\Services;

use App\Events\DuplicateFundWarningEvent;
use App\Http\Controllers\Requests\FundPostRequest;
use App\Models\Fund;
use App\Models\FundManager;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FundService
{
    public function readFund(Request $request)
    {
        try {

            $rules = [
                'name'    => 'string|max:255',
                'manager' => 'string|max:255',
                'year'    => 'numeric',
            ];

            $validatedData = $request->validate($rules);

            $query = Fund::query();

            // Filter by name
            if (isset($validatedData['name'])) {
                $query->where('name', 'like', '%' . $validatedData['name'] . '%');
            }

            // Filter by fund manager
            if (isset($validatedData['manager'])) {
                $query->whereHas('manager', function ($subquery) use ($validatedData) {
                    $subquery->where('name', 'like', '%' . $validatedData['manager'] . '%');
                });
            }

            // Filter by year
            if (isset($validatedData['year'])) {
                $query->where('start_year', $validatedData['year']);
            }

            $funds = $query->get();

            return response()->json([
                'success' => true,
                'data'    => $funds,
            ]);

        } catch (ValidationException $e) {

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function createFund(Request $request)
    {
        try {
            $fundName    = $request->fund;
            $managerName = $request->manager;

            // Check for duplicate Fund
            $duplicateResult = $this->isDuplicateFund($fundName, $managerName);

            // Dispatch event warning
            if ($duplicateResult['isDuplicateFund']) {
                event(new DuplicateFundWarningEvent($fundName, $managerName, $duplicateResult));
            }

            $manager = $this->createManager($request->manager);

            $fund = new Fund();
            $fund->name       = $request->fund;
            $fund->manager_id = $manager->id;
            $fund->start_year = $request->year;
            $fund->aliases    = $request->alias;
            $fund->save();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Fund has been created successfully.',
                    'data'    => $fund
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'An error occurred while creating the fund.',
                    'error'   => $e->getMessage()
                ],
                500
            );
        }
    }
    public function updateFund(FundPostRequest $request, $id)

    {
        try {
            $fund = Fund::findOrFail($id);

            $fund->name = $request->fund;
            $fund->start_year = $request->year;
            $fund->aliases = $request->alias;

            // Retrieve the manager from the manager_id stored in the Fund
            $managerId = $fund->manager_id;
            $manager = FundManager::find($managerId);

            if ($manager) {
                // Update the manager's name
                $manager->name = $request->manager;
                $manager->save();
            }

            $fund->save();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Fund has been updated successfully.',
                    'data'    => $fund,
                ]
            );
        } catch (\Exception $e) {

            return response()->json(
                [
                    'success' => false,
                    'message' => 'An error occurred while updating the fund.',
                    'error'   => $e->getMessage()
                ],
                500
            );
        }
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
