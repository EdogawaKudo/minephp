<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/3/7
 * File: Index.php
 */
date_default_timezone_set('PRC');
define('APP_DEBUG',true);//应用调试
define('APP_PATH','../Application');//应用路径
require '../minephp/minephp.php';//引入框架入口文件

$reflector=new ReflectionClass('minephp\core\Boot');




/*
function getJd($sdate,$edate,$expires,$res)
{
    $StringToSign='GET'."\n".''."\n".''."\n".$expires."\n".$res;
    $accessKey='d7e7b77354052e38127709672044db5d62b2abc9';
    $secretKey='1c1ad047e73745973db170b26b54ad1b4104f6b3';
    $hash=hash_hmac('sha1',mb_convert_encoding($StringToSign, "UTF-8"),$secretKey,true);
    $signature=base64_encode($hash);
    //$url='http://jrcps.jd.com/api/bainaItem?expires='.$expires.'&accessKey='.$accessKey.'&signature='.$signature.'&url=http://baina.jd.com/detail/1578698';
    $url='http://jrcps.jd.com/api/order?expires='.$expires.'&accessKey='.$accessKey.'&signature='.$signature.'&startDate='.$sdate.'&endDate='.$edate;
    return $url;
}
$expires=round(microtime(true),3)*1000;
echo getJd('2016-04-12','2016-04-13',$expires,'/api/order');*/

