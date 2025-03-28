<?php

namespace App\Http\Controllers\API\Client;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Client\Plate\StorePlateRequest;
use App\Http\Resources\API\Client\PlateDetailsResource;
use App\Http\Resources\API\Client\PlatesResource;
use App\Traits\HttpResponses;
use App\Models\Plate;

class PlateController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $plates = Plate::where('status', Status::PENDING->value)->get();
        return $this->successWithDataResponse(PlatesResource::collection($plates));
    }

    public function show($id)
    {
        $plate = Plate::find($id);

        if (!$plate || $plate->status == Status::SOLD->value) {
            return $this->failureResponse('اللوحة غير موجودة أو تم بيعها');
        }

        return $this->successWithDataResponse(new PlateDetailsResource($plate));
    }
    public function store(StorePlateRequest $request)
    {
        Plate::create($request->validated() + ['client_id' => Auth('client')->user()->id]);
        return $this->successResponse('تم اضافة اللوحة بنجاح');
    }
}
