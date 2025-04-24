<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Brand\StoreBrandRequest;
use App\Http\Requests\API\Admin\Brand\UpdateBrandRequest;
use App\Http\Resources\API\Admin\BrandResource;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandsController extends Controller
{
    use HttpResponses;
    public function index()
    {
        $brands = Brand::all();
        return $this->successWithDataResponse(BrandResource::collection($brands));
    }

    public function show($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return $this->failureResponse('العلامة التجارية غير موجودة');
        }
        return $this->successWithDataResponse(BrandResource::make($brand));
    }

    public function store(StoreBrandRequest $request)
    {

        Brand::create($request->validated());
        return $this->successResponse();
    }

    public function update(UpdateBrandRequest $request, $id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return $this->failureResponse('العلامة التجارية غير موجودة');
        }
        $brand->update($request->validated());
        return $this->successResponse('تم تحديث العلامة التجارية بنجاح');
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);

        if ($brand->hasCars()) {
            return $this->failureResponse('لا يمكن حذف العلامة التجارية لأنها مرتبطة بسيارات');
        }

        $brand->delete();
        return $this->successResponse('تم حذف العلامة التجارية بنجاح');
    }
}
