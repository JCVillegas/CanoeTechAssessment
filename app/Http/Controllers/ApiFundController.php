<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Requests\FundPostRequest;
use App\Services\FundService;
use Illuminate\Http\JsonResponse;


class ApiFundController
{
    protected FundService $fundService;

    public function __construct(FundService $fundService)
    {
        $this->fundService = $fundService;
    }

    public function createFund(FundPostRequest $request): JsonResponse
    {
        $fund = $this->fundService->createFund($request);

        return response()->json(
            [
                'success' => true,
                'message' => 'Fund has been created successfully.',
                'data' => $fund
            ],
            200
        );
    }

    public function updateFund(FundPostRequest $request, $id)
    {

        $fund = $this->fundService->updateFund($request, $id);

        return response()->json(
            [
                'success' => true,
                'message' => 'Fund has been updated successfully.',
                'data' => $fund
            ],
            200
        );
    }
}
