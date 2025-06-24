<?php

return [

'paths' => ['api/*', 'sanctum/csrf-cookie'],

'allowed_methods' => ['*'],

'allowed_origins' => json_decode(env('CORS_ALLOWED_ORIGINS', '["http://localhost:5173"]'), true),

'allowed_headers' => ['*'],

'supports_credentials' => true,

];

