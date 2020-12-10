<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Excel;

class ComponentController extends ApiBaseController
{
    public function exportExcel()
    {
        $data = Excel::query()->select(['name', 'email', 'email_verified_at', 'remember_token'])->get()->toArray();
        $excelData = [];
        foreach ($data as $value) {
            $excelData[] = array_values($value);
        }

        $startTime = time();
        // 使用php扩展的方式
        // $config = ['path' => 'E:\wwwroot\virlumen\public\viest'];
        // $excel = new \Vtiful\Kernel\Excel($config);
        // $filePath = $excel->fileName(date('YmdHis') . '.xlsx', 'sheet1')
        //     ->header(['name', 'email', 'email_verified_at', 'remember_token'])
        //     ->data($excelData)
        //     ->output();


        // 使用导出文件到 csv 格式
        exportToExcel('testExportUser.xlsx',['name', 'email', 'email_verified_at', 'remember_token'],$excelData);

        $endTime = time();
        echo "执行时间" . intval($endTime - $startTime) . '秒';
    }
}
