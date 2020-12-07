<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Blob\BlobSharedAccessSignatureHelper;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use Psr\Http\Message\StreamInterface;

class AzureOssService
{
    private $accountName;
    private $accountKey;
    private $endpoint;

    public function __construct()
    {
        $this->accountName = env('AZURE_ACCOUNT_NAME');
        $this->accountKey = env('AZURE_ACCOUNT_KEY');
        $this->endpoint = env('AZURE_ENDPOINT');
    }

    public function getBlobClient()
    {
        $connectionString = "DefaultEndpointsProtocol=https;AccountName=$this->accountName;AccountKey=$this->accountKey;EndpointSuffix=$this->endpoint";
        $blobClient = BlobRestProxy::createBlobService($connectionString);
        return $blobClient;
    }

    /**
     * @param string $container
     * @param string|resource|StreamInterface $content
     * @param string $remoteFilePath
     * @param string|null $contentType
     * @return false|string
     */
    public function upload(string $container, $content, string $remoteFilePath, ?string $contentType = null)
    {
        $blobClient = $this->getBlobClient();

        $options = null;
        if ($contentType) {
            $options = new CreateBlockBlobOptions();
            $options->setContentType($contentType);
        }

        try {
            $res = $blobClient->createBlockBlob($container, $remoteFilePath, $content, $options);
            if ($res->getContentMD5()) {
                return $this->getBlobUrl($container, $remoteFilePath);
            }
            return false;
        } catch (ServiceException $e) {
            $this->errCode = $e->getCode();
            $this->msg = $e->getMessage();
            return false;
        }
    }

    /**
     * @param string $container
     * @param string $remoteFilePath
     * @param string|null $contentType
     * @return bool
     */
    public function initPartUpload(string $container, string $remoteFilePath, ?string $contentType = null)
    {
        $blobClient = $this->getBlobClient();

        $options = null;
        if ($contentType) {
            $options = new CreateBlockBlobOptions();
            $options->setContentType($contentType);
        }

        try {
            $res = $blobClient->createAppendBlob($container, $remoteFilePath);
            if ($res->getETag()) {
                return true;
            }
            return false;
        } catch (ServiceException $e) {
            $this->errCode = $e->getCode();
            $this->msg = $e->getMessage();
            return false;
        }
    }

    /**
     * @param string $container
     * @param string $remoteFilePath
     * @param $file
     * @return bool
     */
    public function appendPartUpload(string $container, string $remoteFilePath, $file)
    {
        $blobClient = $this->getBlobClient();

        try {
            $res = $blobClient->appendBlock($container, $remoteFilePath, $file);
            if ($res->getETag()) {
                return true;
            }
            return false;
        } catch (ServiceException $e) {
            $this->errCode = $e->getCode();
            $this->msg = $e->getMessage();
            return false;
        }
    }

    /**
     * @param string $container
     * @param string $remoteFilePath
     * @return string
     */
    public function getBlobUrl(string $container, string $remoteFilePath)
    {
        $url = "https://{$this->accountName}.blob.{$this->endpoint}/$container/$remoteFilePath";
        return $url;
    }

    /**
     * 私有访问
     * @param $url string 原始URL
     * @return mixed
     */
    public function getSignUrl($url)
    {
        try {
            $urlInfo = parse_url($url);
            $sourceName = $urlInfo['path'];
            $url = $urlInfo['scheme'] . '://' . $urlInfo['host'] . $urlInfo['path'];
            $period = 1 * 24 * 60 * 60;//token有效期
            $time = strtotime(date('Y-m-d'));
            $expiryFormat = date('Y-m-d', $time + $period);

            $cacheKey = 'img:' . $expiryFormat . $url;
            if (Redis::get($cacheKey)) {
                $url = Redis::get($cacheKey);
            } else {
                $s = new BlobSharedAccessSignatureHelper($this->accountName, $this->accountKey);
                $token = $s->generateBlobServiceSharedAccessSignatureToken('b', $sourceName, 'r', $expiryFormat);
                $url = $url . '?' . $token;
                Redis::setex($cacheKey, 2 * 60 * 60, $url );
            }
            $url = str_replace("&amp;", "&", $url);
            return $url;
        } catch (ServiceException $e) {
            return $url;
        } catch (\Exception $e) {
            return $url;
        }
    }
}
