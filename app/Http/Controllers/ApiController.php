<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Requests\FundPostRequest;
use Illuminate\Http\JsonResponse;

class ApiController
{
    public function addFund(FundPostRequest $request): JsonResponse
    {
        $name = $request->input('fund');
        $manager = $request->input('manager');
        $year = $request->input('year');


        //(new MovieService())->addMovie($request->title);
        return response()->json(
            [
                'success' => true,
                'message' => 'Fund has been added.'
            ],
            200
        );
    }

}
