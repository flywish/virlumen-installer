<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Transformers\UserTransformer;
use Spatie\Activitylog\Models\Activity;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Models\User;

class ExampleController extends ApiBaseController
{

    /**
     * 请求成功示例
     * @return mixed
     */
    public function successExample()
    {
        $data = ['errcode' => 0, 'errmsg' => '请求成功', 'data' => 'this is a simple data'];
        return $this->response->array($data);
    }

    /**
     * 请求分页数据
     */
    public function errorExample()
    {
        // throw new AccessDeniedHttpException('暂无权限');
        throw new BadRequestHttpException('请求方式错误');
    }

    public function paginatorExample()
    {
        $users = User::paginate(5);
        return $this->response->paginator($users, UserTransformer::class);
    }

    public function throttleExample(){
        return '测试通过';
    }

    public function activityLog(){
        activity()
            ->performedOn(new User())
            ->causedBy(1)
            ->withProperties(['customProperty' => 'customValue'])
            ->log('Look, I logged something');

        $lastLoggedActivity = Activity::all()->last();
        return $lastLoggedActivity;
    }
}
