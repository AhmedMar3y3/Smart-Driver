<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Hero;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Hero\StoreHeroRequest;

class HeroController extends Controller
{
    use HttpResponses;

    public function getHero()
    {
        $hero = Hero::first(['id', 'title_ar', 'title_en', 'title_ur', 'image']);
        return $this->successWithDataResponse($hero);
    }

    public function store(StoreHeroRequest $request)
    {
        $data = $request->validated();
        $hero = Hero::first();

        if ($hero) {
            $hero->update($data);
            return $this->successResponse('تم تحديث الهيرو بنجاح');
        } else {
            Hero::create($data);
            return $this->successResponse('تم إنشاء الهيرو بنجاح');
        }
    }

    public function update(StoreHeroRequest $request)
    {
        return $this->store($request);
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
