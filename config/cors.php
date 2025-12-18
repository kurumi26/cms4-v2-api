<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout'],
    'allowed_methods' => ['*'],  // Allow all HTTP methods
    'allowed_origins' => ['http://localhost:3000'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],  // Allow all headers
    'exposed_headers' => [],  // Add headers that need to be exposed (optional)
    'max_age' => 0,
    'supports_credentials' => true,  // Allow cookies to be sent with requests
];

