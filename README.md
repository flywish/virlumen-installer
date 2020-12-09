# virlumen-installer

** 只是将lumen的常用的扩展做成自定义安装的形式  **

# 目录
1. <a href="#install">安装</a>
2. <a href="#instructions">说明</a>
3. <a href="#configure">项目配置</a>

### <span id="install">安装</span>

1. 通过composer创建项目(推荐)

`composer create-project virchow/virlumen-installer your-project`

2. 通过 git clone 项目

`git clone https://github.com/wei199469/virlumen-installer.git your-project`

`composer run-script pre-install-cmd`

### <span id="instructions">说明</span>

1. Dingo-Api

	[Laravel 下知名扩展包 Dingo API 的中文文档](https://learnku.com/docs/dingo-api/2.0.0) 
此扩展集成版本控制、用户认证、节点限流等常用功能，可作为统一风格的Api

2. JWT-Auth

	[JSON Web Token Authentication for Laravel & Lumen](https://jwt-auth.readthedocs.io/en/develop/)

3. Sentry-Laravel

	[开源的实时错误报告工具](https://docs.sentry.io/platforms/php)

4. Swagger

    [RESTful 风格的 Web 服务框架](https://swagger.io/)

5. laravel-activity-log

    [快捷记录用户活动日志](https://github.com/spatie/laravel-activitylog)

6. revisionable

    [记录数据库数据变化](https://github.com/VentureCraft/revisionable)

7. Vtiful\Kernel\Excel

    [高性能导出excel](https://www.php.net/manual/zh/class.vtiful-kernel-excel.php)    


### <span id="configure">项目配置</span>

- Dingo-Api

    在 `boostrap/app.php` 中添加`$app->register(Dingo\Api\Provider\LumenServiceProvider::class);`
    
    创建自己的api路由，如
     ```php
    $api = app('Dingo\Api\Routing\Router');

    $api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1\Auth'], function ($api) {
        $api->group(['prefix' => 'user'], function ($api) {
            $api->post('login', 'AuthController@login');
            $api->group(['middleware' => 'auth'], function($api){
                $api->post('logout', 'AuthController@logout');
                $api->post('refresh', 'AuthController@refresh');
                $api->post('me', 'AuthController@me');
            });
        });
    });

    ```

- Jwt-Auth

    取消 ` $app->routeMiddleware([
        'auth' => App\Http\Middleware\Authenticate::class
    ]);` 的注释;

    取消 `$app->register(App\Providers\AuthServiceProvider::class);` 的注释;

    添加 `$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);` ;

- Oss

    阿里云OSS 参考 [阿里云官方文档](https://help.aliyun.com/document_detail/32099.html?spm=a2c4g.11186623.6.1222.347d55c1zQLNza)

    微软云Blob 参考 [Azure Blob 存储](https://docs.microsoft.com/zh-cn/azure/storage/blobs/storage-blobs-introduction)

- apidoc

    Swagger 参考 [Lumen 微服务生成 Swagger 文档](https://learnku.com/articles/21886)

    Dingo-api 参考 [Dingo-Api 文档](https://learnku.com/docs/dingo-api/2.0.0/API-Blueprint-Documentation/1454)