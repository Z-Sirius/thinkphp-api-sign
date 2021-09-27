<?php

namespace zsirius\signature\service;

use think\Service as BaseService;
use zsirius\signature\Signature;

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
