<?php

namespace App\Http\Controllers\Flight;

use App\Http\Requests\StoreAirportRequest;
use App\Http\Requests\UpdateAirportRequest;
use App\Http\Resources\AirPortResource;
use App\Models\Airport;
use App\Traits\HttpResponses;

class AirportController extends \Illuminate\Routing\Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
//        $this->middleware(['auth:sanctum','role:admin'])->except(['index','show']);
    }

    public function index()
    {
       $airports= Airport::paginate(10);
       return $this->success(AirPortResource::collection($airports),
           'air ports retrieved successfully',200);

    }



    public function show(Airport $airport)
    {
        return $this->success(
            new AirportResource($airport),
            'Airport details'
        );
    }
    public function store(StoreAirportRequest $request)
    {
        $airport = Airport::create($request->validated());

        return $this->success(
            new AirportResource($airport),
            'Airport created successfully',
            201 // Created Code
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAirportRequest $request, Airport $airport)
    {
        $airport->update($request->validated());
        return $this->success(
            new AirportResource($airport),
            'Airport updated successfully'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Airport $airport)
    {
        $airport->delete();

        return $this->success(
            null,
            'Airport deleted successfully'
        );
    }
}
