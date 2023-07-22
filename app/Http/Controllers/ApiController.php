<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Requests\FundPostRequest;
use App\Services\FundService;
use Illuminate\Http\JsonResponse;

class ApiController
{
    public function createFund(FundPostRequest $request): JsonResponse
    {

        (new FundService())->createFund($request);
        return response()->json(
            [
                'success' => true,
                'message' => 'Fund has been added.'
            ],
            200
        );
    }

}
