<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Package;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Admin\PackageResource;
use App\Http\Requests\API\Admin\Package\StorePackageRequest;
use App\Http\Requests\API\Admin\Package\UpdatePackageRequest;

class PackageController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $packages = Package::all();
        return $this->successWithDataResponse(PackageResource::collection($packages));
    }

    public function show(Package $package)
    {
        return $this->successWithDataResponse(new PackageResource($package));
    }

    public function store(StorePackageRequest $request)
    {
        $package = Package::create($request->validated());
        $this->updateTranslations($package, $request);
        return $this->successResponse('تم إضافة الباقة بنجاح');
    }

    public function update(UpdatePackageRequest $request, Package $package)
    {
        $package->update($request->validated());
        $this->updateTranslations($package, $request);
        return $this->successResponse('تم تعديل الباقة بنجاح');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return $this->successResponse('تم حذف الباقة بنجاح');
    }

    protected function updateTranslations(Package $package, $request)
    {
        $locales = ['en', 'ar', 'ur'];
        $fields = ['title', 'description'];

        foreach ($locales as $locale) {
            foreach ($fields as $field) {
                $inputKey = "{$field}_{$locale}";
                if ($request->has($inputKey)) {
                    $package->translateOrNew($locale)->$field = $request->input($inputKey);
                }
            }
        }
        $package->save();
    }
}