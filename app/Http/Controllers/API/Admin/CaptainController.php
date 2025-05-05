<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Captain;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Admin\Captain\CaptainsResource;
use App\Http\Resources\API\Admin\Captain\DetailedCaptainResource;

class CaptainController extends Controller
{
    use HttpResponses;

    public function getNewCaptains()
    {
        $captains = Captain::where('is_approved', false)->get();
        return $this->successWithDataResponse(CaptainsResource::collection($captains));
    }

    public function getApprovedCaptains()
    {
        $captains = Captain::where('is_approved', true)->get();
        return $this->successWithDataResponse(CaptainsResource::collection($captains));
    }
    public function getCaptain($id)
    {
        $captain = Captain::find($id);
        if (!$captain) {
            return $this->failureResponse('لم يتم العثور على الكابتن');
        }
        return $this->successWithDataResponse(new DetailedCaptainResource($captain));
    }

    public function approve($id)
    {
        $captain = Captain::find($id);
        if (!$captain) {
            return $this->failureResponse('لم يتم العثور على الكابتن');
        }
        $captain->update(['is_approved' => true]);
        return $this->successResponse('تمت الموافقة على الكابتن بنجاح');
    }

    public function delete($id)
    {
        $captain = Captain::find($id);
        if (!$captain) {
            return $this->failureResponse('لم يتم العثور على الكابتن');
        }
        $captain->delete();
        return $this->successResponse('تم حذف الكابتن بنجاح');
    }
}
