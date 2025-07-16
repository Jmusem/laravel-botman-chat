<?php

return [

    'paths' => ['api/*', 'botman', 'autocomplete', 'correct'],

    'allowed_methods' => ['*'],

    // Add both localhost and your actual IP origin for flexibility
    'allowed_origins' => [
        'http://localhost:3000',
        'http://102.221.33.178:3000',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
