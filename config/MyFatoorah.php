<?php


return [
    'token' => env('MYFATOORAH_API_KEY'),
    'url' => rtrim(env('MYFATOORAH_API_URL'), '/'),
    'front_end_success_url' => 'https://smart-driver.vercel.app',
    'front_end_error_url' => 'https://smart-driver.vercel.app',
];
