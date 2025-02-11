<?php
/*
 * @author: 布尔
 * @name:  服务类
 * @Date: 2020-04-20 10:29:00
 */

namespace Eykj\Qcc;

use function Hyperf\Support\env;

class Service
{
    /**
     * @author: 布尔
     * @name:获取签名
     * @param {array} $param 
     * @return {string}
     */
    public function get_token(array $param): string
    {
        /* 1.拼接字符串 stringA= key + Timespan + SecretKey,2. md5*/
        return md5(env('QCC_KEY') . $param['Timespan'] . env('QCC_SECRET_KEY'));
    }
}
