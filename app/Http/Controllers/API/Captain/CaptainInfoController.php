<?php

namespace App\Http\Controllers\API\Captain;

use App\Models\CaptainInfo;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Captain\InfoResource;
use App\Http\Requests\API\Captain\Info\UpdateInfoRequest;
use App\Http\Requests\API\Captain\Info\CompleteInfoRequest;

class CaptainInfoController extends Controller
{
    use HttpResponses;
    public function completeInfo(CompleteInfoRequest $request)
    {
        $captain = Auth('captain')->user();

        if ($captain->info) {
            return $this->failureResponse('لقد قمت بإكمال المعلومات من قبل');
        }

        try {
            DB::beginTransaction();

            $captainInfo = CaptainInfo::create($request->validated() + ['captain_id' => $captain->id]);
            $captainInfo->addMediaFromRequest(['personal_image', 'car_image', 'license_image', 'residence_image']);
            $captain->update(['completed_info' => true]);

            DB::commit();
            return $this->successResponse('تم إكمال المعلومات بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->failureResponse('حدث خطأ أثناء إكمال المعلومات');
        }
    }

    public function show()
    {
        $captain = Auth('captain')->user();
        if (!$captain->info) {
            return $this->failureResponse('لا توجد معلومات كابتن');
        }

        return $this->successWithDataResponse(new InfoResource($captain->info));
    }

    public function update(UpdateInfoRequest $request)
    {
        $captain = Auth('captain')->user();
        $captain->info->update($request->validated());
        return $this->successResponse('تم تحديث المعلومات بنجاح');
    }
}
