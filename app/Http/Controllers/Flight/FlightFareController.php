<?php

namespace App\Http\Controllers\Flight;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFlightFareRequest;
use App\Http\Requests\UpdateFlightFareRequest;
use App\Http\Resources\FlightFareResource;
use App\Models\FlightFare;
use App\Traits\HttpResponses;

class FlightFareController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flight_fares=FlightFare::with(['flights','fare_rules']);
        return $this->success(FlightFareResource::collection($flight_fares),'flight fares retrieved successfully');
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFlightFareRequest $request)
    {
        $Flight_Fare=FlightFare::create($request->validated());
        return $this->success(new FlightFareResource($Flight_Fare),'flight fare returned successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(FlightFare $flightFare)
    {
        $flightFare->load(['flights','fare_rules']);
        return $this->success($flightFare,'flight retrieved  successfully');

    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFlightFareRequest $request, FlightFare $flightFare)
    {
        $flightFare->update($request->validated());
        return $this->success(new FlightFareResource($flightFare),"flight fare retrieved successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FlightFare $flightFare)
    {
       $flightFare->delete();
       return $this->success(null,'flight fare deleted successfully');
    }
}
