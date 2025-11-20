<?php

namespace App\Http\Controllers\Flight;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFareRulesRequest;
use App\Http\Requests\UpdateFareRulesRequest;
use App\Models\FareRules;
use App\Traits\HttpResponses;

class FareRulesController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFareRulesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FareRules $fareRules)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FareRules $fareRules)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFareRulesRequest $request, FareRules $fareRules)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FareRules $fareRules)
    {
        $fareRules->delete();
        return $this->success(null,'fare rules deleted successfully');
    }
}
