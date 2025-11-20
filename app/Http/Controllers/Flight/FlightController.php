<?php

namespace App\Http\Controllers\Flight;

use App\Http\Controllers\Controller;

use App\Http\Controllers\DateController;
use App\Http\Requests\StoreFlightRequest;
use App\Http\Requests\UpdateFlightRequest;
use App\Http\Resources\FlightResource;
use App\Models\Flight;
use App\Traits\HttpResponses;
use Carbon\Carbon;

class FlightController extends Controller
{
    use HttpResponses;
    private function _StoreDuration(&$request)
    {
        $request['duration'] =DateController::getDiff($request->departure_at,$request->arrival_at);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flight=Flight::with(['carriers','original_airport','dest_airport'])->paginate(10);


        return $this->success(FlightResource::collection($flight), 'flights were got');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFlightRequest $request)
    {
        $this->_StoreDuration($request);
        $data = $request->all();
        $flight=Flight::create($data);

        return $this->success(new FlightResource($flight), 'flight created successfully', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Flight $flight)
    {
        return $this->success(new FlightResource($flight), 'flight retrieved successfully', 200);
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFlightRequest $request, Flight $flight)
    {
        $this->_StoreDuration($request);
        $data=$request->validated();
        $flight->update($data);
        return $this->success($flight,'flight updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flight $flight)
    {
        $flight->delete();
        return $this->success(null,'flight deleted successfully');
    }
}
