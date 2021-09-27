<?php

namespace zsirius\signature;

use zsirius\signature\facade\Signature;

class ApiSign
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        if ($request->isGet() || $request->isDelete()) {
            $params = $request->query();
        } else {
            $params = $request->query();
            if (!strpos($request->header('content-type'), 'multipart/form-data')) {
                $params['body'] = md5($request->getContent());
            }
        }
        if (config('signature.status')) {
            Signature::checkSign($params); // 不通过抛出异常
        }
        return $next($request);
    }
}
