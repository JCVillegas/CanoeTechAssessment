<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Requests\FundPostRequest;
use App\Services\FundService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ApiFundController
{
    protected FundService $fundService;

    public function __construct(FundService $fundService)
    {
        $this->fundService = $fundService;
    }

    public function createFund(FundPostRequest $request): JsonResponse
    {
        return $this->fundService->createFund($request);
    }

    public function readFund(Request $request): JsonResponse
    {
        return $this->fundService->createFund($request);
    }

    public function updateFund(FundPostRequest $request, $id)
    {
        return $this->fundService->updateFund($request, $id);
    }
}
