# virlumen-installer

** 只是将lumen的常用的扩展做成自定义安装的形式  **

# 目录
1. 安装(#安装)
2. 说明(#说明)
3. 配置(#配置)

### <span id="安装">安装</span>

1. 通过composer创建项目(推荐)

`composer create-project virchow/virlumen-installer your-project`

2. 通过 git clone 项目

`git clone https://github.com/wei199469/virlumen-installer.git your-project`

`composer run-script pre-install-cmd`

### <span id="说明">说明</span>

1. Dingo-Api

	[Laravel 下知名扩展包 Dingo API 的中文文档](https://learnku.com/docs/dingo-api/2.0.0 "Laravel 下知名扩展包 Dingo API 的中文文档") 
此扩展集成版本控制、用户认证、节点限流等常用功能，可作为统一风格的Api

2. JWT-Auth

	[JSON Web Token Authentication for Laravel & Lumen](https://jwt-auth.readthedocs.io/en/develop/ "JSON Web Token Authentication for Laravel & Lumen")

3. Sentry-Laravel

	[开源的实时错误报告工具](https://docs.sentry.io/platforms/php/ "开源的实时错误报告工具")

### <span id="配置">配置</span>

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