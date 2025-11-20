<?php

namespace App\Http\Controllers\Flight;

use App\Http\Controllers\Controller;
use App\Models\Carrier;
use App\Http\Resources\CarrierResource;
use App\Http\Requests\StoreCarrierRequest;
use App\Http\Requests\UpdateCarrierRequest;
use App\Traits\HttpResponses; // يجب التأكد من مسار الـ Trait

class CarrierController extends Controller
{
    use HttpResponses;

    // يمكنك إضافة الـ Middleware هنا لحماية دوال الأدمن:
    /*
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'admin'])->except(['index', 'show']);
    }
    */

    public function index()
    {
        return $this->success(
            CarrierResource::collection(Carrier::paginate(15)),
            'Carriers retrieved successfully'
        );
    }

    public function store(StoreCarrierRequest $request)
    {
        $carrier = Carrier::create($request->validated());

        return $this->success(
            new CarrierResource($carrier),
            'Carrier created successfully',
            201
        );
    }

    public function show(Carrier $carrier)
    {
        return $this->success(
            new CarrierResource($carrier),
            'Carrier details'
        );
    }

    public function update(UpdateCarrierRequest $request, Carrier $carrier)
    {
        $carrier->update($request->validated());

        return $this->success(
            new CarrierResource($carrier),
            'Carrier updated successfully'
        );
    }

    public function destroy(Carrier $carrier)
    {
        $carrier->delete();

        return $this->success(
            null,
            'Carrier deleted successfully'
        );
    }
}
