<?php

namespace zsirius\signature\service;

use think\Service as BaseService;
use zsirius\signature\Signature;
use zsirius\signature\middleware\ApiSign;

class SignatureService extends BaseService
{
    /**
     * 注册服务
     *
     * @return mixed
     */
    public function register()
    {
        $this->app->bind('signature', Signature::class);
        // 中间件
        $this->app->middleware->add(ApiSign::class);
    }

    /**
     * 执行服务
     *
     * @return mixed
     */
    public function boot()
    {
        //
    }
}
