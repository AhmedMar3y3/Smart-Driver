<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Hero;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Hero\StoreHeroRequest;
use App\Http\Requests\API\Admin\Hero\UpdateHeroRequest;

class HeroController extends Controller
{
    use HttpResponses;
    public function getHero()
    {
        $hero = Hero::get(['id', 'title', 'image']);
        return $this->successWithDataResponse($hero);
    }
    public function store(StoreHeroRequest $request)
    {
        Hero::create($request->validated());
        return $this->successResponse('تم اضافة الهيرو بنجاح');
    }

    public function update(UpdateHeroRequest $request, $id)
    {
        $hero = Hero::find($id);
        if (!$hero) {
            return $this->failureResponse('هذا الهيرو غير موجود');
        }
        $hero->update($request->validated());
        return $this->successResponse('تم تحديث الهيرو بنجاح');
    }

    public function destroy($id)
    {
        $hero = Hero::find($id);
        if (!$hero) {
            return $this->failureResponse('هذا الهيرو غير موجود');
        }
        $hero->delete();
        return $this->successResponse('تم حذف الهيرو بنجاح');
    }
}
