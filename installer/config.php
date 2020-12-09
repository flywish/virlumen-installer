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
        ],
        'sentry/sentry-laravel' => [
            'version' => '^2.1'
        ],
        'palanik/lumen-cors' => [
            'version' => '^0.0.3'
        ],
        'aliyuncs/oss-sdk-php' => [
            'version' => '^2.3'
        ],
        'microsoft/azure-storage-blob' => [
            'version' => '^1.5'
        ],
        'darkaonline/swagger-lume' => [
            'version' => '8.*'
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
                        'API_STANDARDS_TREE' => '',
                        'API_SUBTYPE' => '',
                        'API_PREFIX' => '',
                        'API_VERSION' => '',
                        'API_NAME' => '',
                        'API_CONDITIONAL_REQUEST' => false,
                        'API_STRICT' => false,
                        'API_DEBUG' => true,
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
                        'REDIS_DB' => 0
                    ]
                ],
            ],
        ],
        'sentry' => [
            'question' => 'Do you want to use sentry to log errors ?',
            'default' => 'y',
            'required' => false,
            'custom-package' => false,
            'options' => [
                'y' => [
                    'name' => 'yes',
                    'packages' => [
                        'sentry/sentry-laravel',
                    ],
                    'resources' => [],
                    'env' => [
                        'SENTRY_ENABLE' => '1',
                        'SENTRY_LARAVEL_DSN' => ''
                    ]
                ],
            ],
        ],
        'cors' => [
            'question' => 'Do you want to allow this site to cross domains ?',
            'default' => 'y',
            'required' => false,
            'custom-package' => false,
            'options' => [
                'y' => [
                    'name' => 'yes',
                    'packages' => [
                        'palanik/lumen-cors',
                    ],
                    'resources' => []
                ],
            ],
        ],
        'oss' => [
            'question' => 'Which storage do you need ?',
            'default' => '1',
            'required' => false,
            'custom-package' => true,
            'options' => [
                '1' => [
                    'name' => 'aliyun-oss',
                    'packages' => [
                        'aliyuncs/oss-sdk-php'
                    ],
                    'resources' => [
                        'resources/oss/config/alioss.php' => 'config/alioss.php',
                        'resources/oss/Service/AliOssService.php' => 'app/Service/Common/AliOssService.php',
                    ],
                    'env' => [
                        'ALIOSS_SERVER' => '',
                        'ALIOSS_SERVERINTERNAL' => '',
                        'ALIOSS_KEYID' => '',
                        'ALIOSS_KEYSECRET' => '',
                        'ALIOSS_BUCKETNAME' => '',
                        'ALIOSS_BUCKET_HTTP_LINK' => '',
                        'ALIOSS_BUCKET_HTTPS_LINK' => '',
                        'ALIOSS_EXPIRE_TIME' => '3600',
                    ]
                ],
                '2' => [
                    'name' => 'azure-storage-blob',
                    'packages' => [
                        'microsoft/azure-storage-blob',
                    ],
                    'resources' => [
                        'resources/oss/config/azureoss.php' => 'config/azureoss.php',
                        'resources/oss/Service/AzureOssService.php' => 'app/Service/Common/AzureOssService.php',
                    ],
                    'env' => [
                        'AZURE_ACCOUNT_NAME' => '',
                        'AZURE_ACCOUNT_KEY' => '',
                        'AZURE_ENDPOINT' => '',
                        'AZURE_CONTAINER' => ''
                    ]
                ],
            ],
        ],
        'apidoc' => [
            'question' => 'Which tool do you want to use to generate online documentation ?',
            'default' => '1',
            'required' => false,
            'custom-package' => true,
            'options' => [
                '1' => [
                    'name' => 'swagger-lumen',
                    'packages' => [
                        'darkaonline/swagger-lume'
                    ],
                    'resources' => []
                ],
                '2' => [
                    'name' => 'dingoApi-doc',
                    'packages' => [],
                    'resources' => []
                ],
            ],
        ],
    ],
];
