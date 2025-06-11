<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Section\UpdateSectionRequest;
use App\Traits\HttpResponses;
use App\Models\Section;

class SectionsController extends Controller
{
    use HttpResponses;
    public function index()
    {
        $sections = Section::get(['id', 'name', 'image']);
        return $this->successWithDataResponse($sections);
    }

    public function show($id)
    {
        $section = Section::find($id);
        if (!$section) {
            return $this->failureResponse('القسم غير موجود');
        }
        return $this->successWithDataResponse($section);
    }

    public function update(UpdateSectionRequest $request, $id)
    {
        $section = Section::find($id);
        if (!$section) {
            return $this->failureResponse('القسم غير موجود');
        }
        $section->update($request->validated());
        return $this->successResponse('تم تحديث القسم بنجاح');
    }
}
