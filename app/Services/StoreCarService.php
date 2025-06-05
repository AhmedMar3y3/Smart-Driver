<?php

namespace App\Services;

use App\Models\Car;
use App\Helpers\ImageUploadHelper;
use App\Traits\HttpResponses;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;

class StoreCarService
{
    use HttpResponses;

    public function createCarWithImages(array $validatedData, array $files, int $expiresInDays): Car
    {
        $client = Auth('client')->user();

        $car = Car::create($validatedData + [
            'client_id' => $client->id,
            'expires_at' => Carbon::now()->addDays($expiresInDays),
            'expiry_status' => 'active'
        ]);

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