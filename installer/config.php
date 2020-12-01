<?php

return [
    'packages' => [
        'dingo/api' => [
            'version' => '^3.0'
        ],
        'tymon/jwt-auth' => [
            'version' => '^1.0'
        ],
        'illuminate/redis' => [
            'version' => '^8.16'
        ]
    ],
    'require-dev' => [
    ],
    'questions' => [
        'dingo-api' => [
            'question' => 'Do You want to use Dingo-Api as your default api ?',
            'default' => 'y',
            'required' => false,
            'custom-package' => false,
            'options' => [
                'y' => [
                    'name' => 'yes',
                    'packages' => [
                        'dingo/api',
                    ],
                    'resources' => [
                        'resources/dingo-api/api.php' => 'config/api.php',
                    ],
                    'env' => [
                        'API_STANDARDS_TREE' => 'x',
                        'API_SUBTYPE' => 'virlumen',
                        'API_PREFIX' => 'api',
                        'API_VERSION' => 'v1',
                        'API_NAME' => 'virLumen API',
                        'API_CONDITIONAL_REQUEST' => 'false',
                        'API_STRICT' => 'false',
                        'API_DEBUG' => 'true',
                        'API_DEFAULT_FORMAT' => 'json',
                    ]
                ],
            ],
        ],
        'jwt-auth' => [
            'question' => 'Do You want to use Jwt-Auth as your default Authentication ?',
            'default' => 'y',
            'required' => false,
            'custom-package' => false,
            'options' => [
                'y' => [
                    'name' => 'yes',
                    'packages' => [
                        'tymon/jwt-auth',
                    ],
                    'resources' => [
                        'resources/jwt-auth/auth.php' => 'config/auth.php',
                        'resources/jwt-auth/jwt.php' => 'config/jwt.php',
                    ],
                    'env' => [
                        'JWT_SECRET ' => '0Qe3X9D5KcqmFpQi3N1BYQugUw2h1ZIw7xlMJP1ULpEFbBH52G6iPkWASh3R6tak',
                        'JWT_TTL' => 60
                    ]
                ],
            ],
        ],
        'database' => [
            'question' => 'Do you want to use Database (MySQL Client) ?',
            'default' => 'y',
            'required' => false,
            'custom-package' => false,
            'options' => [
                'y' => [
                    'name' => 'yes',
                    'packages' => [],
                    'resources' => [],
                ],
            ],
        ],
        'redis' => [
            'question' => 'Do you want to use Redis Client ?',
            'default' => 'y',
            'required' => false,
            'custom-package' => false,
            'options' => [
                'y' => [
                    'name' => 'yes',
                    'packages' => [
                        'illuminate/redis',
                    ],
                    'resources' => [],
                    'env' => [
                        'REDIS_HOST' => '127.0.0.1',
                        'REDIS_PASSWORD' => null,
                        'REDIS_PORT' => 6379,
                        'REDIS_DB' => 2
                    ]
                ],
            ],
        ]
    ],
];
