<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Plate;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Client\PlatesResource;
use App\Http\Resources\API\Client\PlateDetailsResource;

class PlateController extends Controller
{
    use HttpResponses;
    public function index()
    {
        $plates = Plate::get();
        return $this->successWithDataResponse(PlatesResource::collection($plates));
    }

    public function show($id)
    {
        $plate = Plate::find($id);
        if (!$plate) {
            return $this->failureResponse('اللوحة غير موجودة');
        }
        return $this->successWithDataResponse(new PlateDetailsResource($plate));
    }

    public function destroy($id)
    {
        $plate = Plate::find($id);
        if (!$plate) {
            return $this->failureResponse('اللوحة غير موجودة');
        }
        $plate->delete();
        return $this->successResponse('تم حذف اللوحة بنجاح');
    }
}
