<?php

namespace App\Http\Controllers\API\Captain;

use App\Traits\HttpResponses;
use App\Models\CaptainAvailability;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Captain\AvailabilityResource;
use App\Http\Requests\API\Captain\Availability\StoreAvailabilityRequest;
use App\Http\Requests\API\Captain\Availability\UpdateAvailabilityRequest;

class AvailabilityController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $availabilities = CaptainAvailability::where('captain_id', auth('captain')->user()->id)->where('is_reserved', false)->paginate(9);
        return $this->successWithDataResponse(AvailabilityResource::collection($availabilities));
    }
    public function store(StoreAvailabilityRequest $request)
    {
        CaptainAvailability::create($request->validated() + ['captain_id' => auth('captain')->user()->id]);
        return $this->successResponse('تم إضافة الفترة بنجاح');
    }

    public function update(UpdateAvailabilityRequest $request, $id)
    {
        $availability = CaptainAvailability::findOrFail($id);
        if ($availability->captain_id !== auth('captain')->user()->id) {
            return $this->failureResponse('لا يمكنك تعديل هذه الفترة');
        }
        $availability->update($request->validated());
        return $this->successResponse('تم تعديل الفترة بنجاح');
    }

    public function destroy($availability)
    {
        $availability = CaptainAvailability::findOrFail($availability);
        if ($availability->captain_id !== auth('captain')->user()->id) {
            return $this->failureResponse('لا يمكنك حذف هذه الفترة');
        }
        $availability->delete();
        return $this->successResponse('تم حذف الفترة بنجاح');
    }
}
