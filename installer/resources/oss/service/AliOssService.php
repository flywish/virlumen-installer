<?php

namespace App\Services;

use OSS\OssClient;

class AliOss
{

    public $ossClient;
    public $bucketName;

    public function __construct($isInternal = false)
    {
        $serverAddress = $isInternal ? config('alioss.ossServerInternal') : config('alioss.ossServer');
        $this->ossClient = new OssClient(config('alioss.AccessKeyId'), config('alioss.AccessKeySecret'), $serverAddress);
        $this->bucketName = config('alioss.BucketName');
    }

    /**
     * @param string $object 设置文件名称
     * @param string $filePath 需要上传的文件路径
     * @return null
     * @throws \OSS\Core\OssException
     */
    public function upload($object, $filePath)
    {
        return $this->ossClient->uploadFile($this->bucketName, $object, $filePath);
    }

    /**
     * 获取上传之后的访问链接
     * @param string $object oss链接
     * @return \OSS\Http\ResponseCore|string
     * @throws \OSS\Core\OssException
     */
    public function signUrl($object)
    {
        return $this->ossClient->signUrl($this->bucketName, $object, env('ALIOSS_EXPIRE_TIME',3600));
    }

}
