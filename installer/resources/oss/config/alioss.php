<?php

/**
 * 阿里云OSS的相关配置信息
 */

return [
    'ossServer' => env('ALIOSS_SERVER', null),
    'ossServerInternal' => env('ALIOSS_SERVERINTERNAL', ''),
    'AccessKeyId' => env('ALIOSS_KEYID', ''),
    'AccessKeySecret' => env('ALIOSS_KEYSECRET', ''),
    'BucketName' => env('ALIOSS_BUCKETNAME', ''),
    'SignExpireTime' => env('ALIOSS_EXPIRE_TIME', ''),
    'BucketHttpLink' => env('ALIOSS_BUCKET_HTTP_LINK', ''),
    'BucketHttpSLink' => env('ALIOSS_BUCKET_HTTPS_LINK', '')
];
