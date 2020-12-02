<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('getRealIp')) {
    /**
     * 获取用户的真实IP
     * @return bool|mixed|string
     */
    function getRealIp()
    {
        $ip = FALSE;
        //客户端IP 或 NONE
        if (isset($_SERVER["HTTP_CLIENT_IP"]) && $_SERVER["HTTP_CLIENT_IP"]) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        //多重代理服务器下的客户端真实IP地址（可能伪造）,如果没有使用代理，此字段为空
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER["HTTP_X_FORWARDED_FOR"]) {
            $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) {
                array_unshift($ips, $ip);
                $ip = FALSE;
            }
            for ($i = 0; $i < count($ips); $i++) {
                if (!preg_match("/^(10│172.16│192.168)./", $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        //客户端IP 或 (最后一个)代理服务器 IP
        $ip = $ip ?: ($_SERVER['REMOTE_ADDR'] ?? '');
        return $ip;
    }
}

if (!function_exists('createTree')) {
    /**
     * 生成无限级树
     * @param $list array 列表数组
     * @param $index string 唯一标示字段名称 常用ID
     * @param $pidField string 父级ID字段名称
     * @return array tree array
     */
    function createTree($list, $index = 'id', $pidField = 'parent_id', $sort = 'sort')
    {
        $last_names = array_column($list, $sort);
        array_multisort($last_names, SORT_ASC, $list);
        $tree = array();
        $list = array_column($list, null, $index);
        foreach ($list as $v) {
            if (isset($list[$v[$pidField]])) {
                $list[$v[$pidField]]['children'][] = &$list[$v[$index]];
            } else {
                $tree[] = &$list[$v[$index]];
            }
        }
        return $tree;
    }
}

if (!function_exists('traceSql')) {
    /**
     * 开启 sql 查询日志
     */
    function traceSql()
    {
        DB::enableQueryLog();
    }
}

if (!function_exists('getLastSql')) {
    /**
     * 获取最后一次执行的sql
     */
    function getLastSql()
    {
        $sql = DB::getQueryLog();
        $query = end($sql);
        return $query;
    }
}

if (!function_exists('xmlToArray')) {
    /**
     * xml 转 数组
     * @param $xml
     * @return mixed
     */
    function xmlToArray($xml)
    {
        libxml_disable_entity_loader(true);
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $val = json_decode(json_encode($xmlstring), true);

        // libxml_disable_entity_loader(true);
        // $result = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $val;
    }
}

if (!function_exists('arrayToXml')) {
    /** 数组 转 xml
     * @param $arr
     * @return string
     */
    function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= "<" . $key . ">" . arrayToXml($val) . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }
}

if (!function_exists('getOssSignLink')) {
    /**
     * 获取oss的加密链接
     * @param $weblink
     * @return \OSS\Http\ResponseCore|string
     * @throws \OSS\Core\OssException
     */
    function getOssSignLink($weblink)
    {
        if (\Illuminate\Support\Str::startsWith($weblink, env('ALIOSS_BUCKET_HTTPS_LINK')) || \Illuminate\Support\Str::startsWith($weblink, env('ALIOSS_BUCKET_HTTP_LINK'))) {
            $urlInfo = parse_url($weblink);
            return (new \App\Services\AliOss(false))->signUrl(ltrim($urlInfo['path'], '/'));
        } else {
            return $weblink;
        }
    }
}


if (!function_exists('img2Base64')) {
    function img2Base64($imgUrl)
    {
        $file = $imgUrl;
        if ($fp = fopen($file, "rb", 0)) {
            $gambar = fread($fp, filesize($file));
            fclose($fp);
            $base64 = chunk_split(base64_encode($gambar));
            // 输出
            $encode = '<img src="data:image/jpg/png/gif;base64,' . $base64 . '" >';
            echo $encode;
        }
    }
}

if (!function_exists('getPhpRunTmp')) {
    /**
     * 获取php日志应该写入的目录
     * @return string
     */
    function getPhpRunTmp()
    {
        $sapiName = php_sapi_name();
        if (in_array($sapiName, ['cli', 'cli-server'])) {
            return 'crontab';
        } else {
            return 'php';
        }

    }
}

if (!function_exists('curlSaveCookie')) {

    /**
     * 使用 curl 并保存cookie
     *
     * @param [type] $url
     * @return void
     */
    // function curlSaveCookie($url){
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_HEADER, 0);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     //若给定url自动跳转到新的url,有了下面参数可自动获取新url内容：302跳转
    //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    //     //设置cURL允许执行的最长秒数。
    //     curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    //     curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0');
    //     curl_setopt($ch, CURLOPT_REFERER, $url);
    //     curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    //     $cookie = 'cookie.txt';
    //     curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie);
    //     ob_start();
    //     $content = curl_exec($ch);
    //     ob_end_clean();
    //     curl_close($ch);
    // }

    function curlSaveCookie($url)
    {
        // 初始化CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // 获取头部信息
        curl_setopt($ch, CURLOPT_HEADER, 1);
        // 返回原生的（Raw）输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // 执行并获取返回结果
        $content = curl_exec($ch);
        // 关闭CURL
        curl_close($ch);
        // 解析HTTP数据流
        list($header, $body) = explode("\r\n\r\n", $content);
        // 解析COOKIE
        preg_match_all("/set\-cookie:([^\r\n]*)/i", $header, $matches);
        // 后面用CURL提交的时候可以直接使用
        // curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        $cookie = $matches[1];
        return $cookie;
    }
}

if (!function_exists('humanDate')) {
    function humanDate($timeStamp)
    {
        $int = time() - (int)strtotime($timeStamp);
        $str = '';
        if ($int <= 30) {
            $str = sprintf('刚刚', $int);
        } elseif ($int < 60) {
            $str = sprintf('%d秒前', $int);
        } elseif ($int < 3600) {
            $str = sprintf('%d分钟前', floor($int / 60));
        } elseif ($int < 86400) {
            $str = sprintf('%d小时前', floor($int / 3600));
        } elseif ($int < 2592000) {
            $str = sprintf('%d天前', floor($int / 86400));
        } else {
            $str = date('Y-m-d H:i:s', $timeStamp);
        }
        return $str;
    }
}

if (!function_exists('exportToExcel')) {
    /**
     * @creator Jimmy
     * @data 2016/8/22
     * @desc 数据导出到excel(csv文件)
     * @param $filename 导出的csv文件名称 如date("Y年m月j日").'-PB机构列表.csv'
     * @param array $tileArray 所有列名称
     * @param array $dataArray 所有列数据
     */
    function exportToExcel($filename, $tileArray = [], $dataArray = [])
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 0);
        ob_end_clean();
        ob_start();
        header("Content-Type: text/csv");
        header("Content-Disposition:filename=" . $filename);
        $fp = fopen('php://output', 'w');
        fwrite($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($fp, $tileArray);
        $index = 0;
        foreach ($dataArray as $item) {
            if ($index == 1000) {
                $index = 0;
                ob_flush();
                flush();
            }
            $index++;
            fputcsv($fp, $item);
        }

        ob_flush();
        flush();
        ob_end_clean();
    }
}
