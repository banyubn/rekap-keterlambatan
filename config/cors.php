<?php

return [
    'paths' => ['api/*'], // Mengizinkan semua request ke API
    'allowed_methods' => ['*'], // Mengizinkan semua metode HTTP
    'allowed_origins' => ['*'], // Mengizinkan semua domain (bisa diganti dengan domain spesifik)
    'allowed_headers' => ['*'], // Mengizinkan semua headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
