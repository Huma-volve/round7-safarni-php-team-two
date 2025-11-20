<?php

namespace App\Http\Controllers\Flight;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFlightSeatRequest;
use App\Http\Requests\UpdateFlightSeatRequest;
use App\Http\Resources\FlightSeatResource;
use App\Models\FlightSeat;
use App\Traits\HttpResponses;

class FlightSeatController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seats=FlightSeat::with('flights')->paginate(10);
        return $this->success(FlightSeatResource::collection($seats),'seats returned successfully');
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFlightSeatRequest $request)
    {
        $data=$request->validated();
        $flight_seat=FlightSeat::create($data);
        return $this->success(new FlightSeatResource($flight_seat),'flight seat returned successfully',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(FlightSeat $flightSeat)
    {
        $flightSeat->load('flights');
        return $this->success(new FlightSeatResource($flightSeat),'flight returned successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFlightSeatRequest $request, FlightSeat $flightSeat)
    {
       $data= $flightSeat->update($request->validated());
        return $this->success(new FlightSeatResource($data),'flight seat updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FlightSeat $flightSeat)
    {
        $flightSeat->delete();
        $this->success('flight deleted successfully');
    }
}
