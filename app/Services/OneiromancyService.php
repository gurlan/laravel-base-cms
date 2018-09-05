<?php
/**
 * Created by PhpStorm.
 * User: Q1369
 * Date: 2018/9/5
 * Time: 13:11
 */
namespace App\Services;
class OneiromancyService
{
    protected  $appkey;

    public function __construct()
    {
        $this->appkey = '3b7e647316939205f798ea0611c97f22';

    }

    //************1.类型************
    public function category($fid=0)
    {
        $url = "http://v.juhe.cn/dream/category";
        $params = array(
            "key" => $this->appkey,//应用APPKEY(应用详细页查询)
            "fid" => $fid,//所属分类，默认全部，0:一级分类
        );
        $paramstring = http_build_query($params);
        $content = $this->juhecurl($url, $paramstring);
        $result = json_decode($content, true);
        if ($result)
        {
            if ($result['error_code']=='0')
            {
                print_r($result);
            }

            else{
                echo $result['error_code'] . ":" . $result['reason'];
            }
        }else{
            echo "请求失败";
        }
    }




//************2.解梦查询************
    public function query($word='',$cid='',$full=1)
    {
        $url = "http://v.juhe.cn/dream/query";
        $params = array(
            "key" => $this->appkey,//应用APPKEY(应用详细页查询)
            "q" => $word,//梦境关键字，如：黄金 需要utf8 urlencode
            "cid" =>$cid,//指定分类，默认全部
            "full" => $full,//是否显示详细信息，1:是 0:否，默认0
        );
        $paramstring = http_build_query($params);
        $content = $this->juhecurl($url, $paramstring);

        $result = json_decode($content, true);


        if ($result) {
            if ($result['error_code'] == '0') {
                $result['num'] = count($result['result']);
              return $result;
            } else {
                echo $result['error_code'] . ":" . $result['reason'];
            }
        } else {
            echo "请求失败";
        }
    }

    public  function juhecurl($url, $params = false, $ispost = 0)
    {
        $httpInfo = array();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'JuheData');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }
        $response = curl_exec($ch);
        if ($response === FALSE) {
//echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);
        return $response;
    }

}