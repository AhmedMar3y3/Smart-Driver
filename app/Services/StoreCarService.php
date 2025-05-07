<?php

namespace App\Services;

use App\Models\Car;
use App\Helpers\ImageUploadHelper;
use App\Traits\HttpResponses;
use Illuminate\Http\UploadedFile;

class StoreCarService
{
    use HttpResponses;

    public function createCarWithImages(array $validatedData, array $files): Car
    {
        $client = Auth('client')->user();

        $car = Car::create($validatedData + ['client_id' => $client->id]);

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