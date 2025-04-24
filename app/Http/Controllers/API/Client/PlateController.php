<?php

namespace App\Http\Controllers\API\Client;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Client\Plate\FilterPlateRequest;
use App\Http\Requests\API\Client\Plate\StorePlateRequest;
use App\Http\Resources\API\Client\PlateDetailsResource;
use App\Http\Resources\API\Client\PlatesResource;
use App\Traits\HttpResponses;
use App\Models\Plate;
use App\Services\filterPlateService;
use Exception;

class PlateController extends Controller
{
    use HttpResponses;

    public function index(FilterPlateRequest $request)
    {
        $filters = $request->validated();
        $query = (new filterPlateService)->getFilteredPlatesQuery($filters);
        $plates = $query->get();
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
        $client = Auth('client')->user();
        try {
            // if (!$client->isSubscribed && $client->plates()->count() >= 2) {
            //     throw new Exception('لا يمكنك اضافة لوحة جديدة, يجب عليك الاشتراك في باقة مميزة');
            // }
            Plate::create($request->validated() + ['client_id' => $client->id]);
            return $this->successResponse('تم اضافة اللوحة بنجاح');
        } catch (Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }
}
