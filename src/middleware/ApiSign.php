<?php

namespace zsirius\signature\middleware;

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
            parse_str($request->query(), $params);
        } else {
            parse_str($request->query(), $params);
            if (!strpos($request->header('content-type'), 'multipart/form-data')) {
                $params['body'] = md5($request->getContent());
            }
        }
        unset($params['s']);
        if (config('signature.status')) {
            Signature::checkSign($params); // 不通过抛出异常
        }
        return $next($request);
    }
}
