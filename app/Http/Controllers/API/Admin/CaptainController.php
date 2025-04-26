<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Captain;
use App\Traits\HttpResponses;

class CaptainController extends Controller
{
    use HttpResponses;

    public function approve($id)
    {
        $captain = Captain::find($id);
        if (!$captain) {
            return $this->failureResponse('لم يتم العثور على الكابتن');
        }
        $captain->update(['is_approved' => true]);
        return $this->successResponse('تمت الموافقة على الكابتن بنجاح');
    }
} 