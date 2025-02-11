<?php
/*
 * @author: 布尔
 * @name:  企业管理
 * @Date: 2020-04-20 10:29:00
 */

namespace Eykj\Qcc;

use Eykj\Base\GuzzleHttp;
use Eykj\Qcc\Service;
use function Hyperf\Support\env;

class Enterprise
{
    protected ?GuzzleHttp $GuzzleHttp;

    protected ?Service $Service;

    // 通过设置参数为 nullable，表明该参数为一个可选参数
    public function __construct(?GuzzleHttp $GuzzleHttp, ?Service $Service)
    {
        $this->GuzzleHttp = $GuzzleHttp;
        $this->Service = $Service;
    }

    /* 请求域名 */
    private $url = "https://api.qichacha.com";

    /**
     * @author: 布尔
     * @name:企业模糊搜索
     * @param {array} $param 
     * @return {array}
     */
    public function fuzzy_search(array $param): array
    {
        /*获取token写入headers */
        $param['Timespan'] = time();
        $options['headers']['Token'] = $this->Service->get_token($param);
        $options['headers']['Timespan'] = $param['Timespan'];
        $data = eyc_array_key($param, 'searchKey,provinceCode,cityCode,pageSize,pageIndex');
        $data['key'] = env('QCC_KEY');
        $query = http_build_query($data);
        $url = $this->url . '/FuzzySearch/GetList?' . $query;
        $r = $this->GuzzleHttp->get($url, $options);
        if ($r['Status'] == 200) {
            return $r['Result'];
        } elseif (isset($r['Status'])) {
            alog($r, 2);
            error((int)$r['Status'], $r['Message']);
        } else {
            error(500, '识别失败，请重试');
        }
    }
}
