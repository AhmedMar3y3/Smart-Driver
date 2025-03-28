<?php

namespace App\Services;

use App\Models\Car;
use App\Helpers\ImageUploadHelper;
use Illuminate\Http\UploadedFile;

class StoreCarService
{
    /**
     * Create a new car along with its images.
     *
     * @param array $validatedData
     * @return \App\Models\Car
     */
    public function createCarWithImages(array $validatedData, array $files): Car
    {
        $car = Car::create($validatedData + ['client_id' => Auth('client')->user()->id]);

        $data = [];
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $uploadedImagePath = ImageUploadHelper::uploadImage($file, 'CarImage');
                $data[] = ['image' => $uploadedImagePath];
            }
        }

        if (!empty($data)) {
            $car->images()->createMany($data);
        }

        return $car;
    }
}

