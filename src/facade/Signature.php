<?php
namespace zsirius\signature\facade;

use think\Facade;

class Signature extends Facade
{
    protected static function getFacadeClass()
    {
        return 'signature';
    }
}
