<?php

/**
 * 微软云OSS的相关配置信息
 */

return [
    'AccountName' => env('AZURE_ACCOUNT_NAME', ''),
    'AccountKey' => env('AZURE_ACCOUNT_KEY', ''),
    'endpoint' => env('AZURE_ENDPOINT', ''),
    'container' => env('AZURE_CONTAINER', '')
];
