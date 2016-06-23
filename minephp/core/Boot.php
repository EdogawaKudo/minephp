<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/3/16
 * File: Boot.php
 */
namespace minephp\core;
/**
 * Class Boot 框架引导文件
 * @package mine\core
 */
class Boot
{
    public function __construct()
    {

    }
    static public function startBoot()
    {
        define('IS_WIN', strstr(PHP_OS, 'WIN') ? true : false);
        define('DS', DIRECTORY_SEPARATOR);
        define('IS_GET', $_SERVER['REQUEST_METHOD'] == 'GET');
        define('IS_POST', $_SERVER['REQUEST_METHOD'] == 'POST');
        define('IS_AJAX', isset($_SERVER['HTTP_X_REQUEST_WITH']) && $_SERVER['HTTP_X_REQUEST_WITH'] == 'xmlhttprequest');
        define('__HOST__', 'http://'.$_SERVER['HTTP_HOST']);
        define('__ROOT__', __HOST__.dirname($_SERVER['SCRIPT_NAME']));
        define('__WEB__', __HOST__.rtrim($_SERVER['SCRIPT_NAME'],'/'));
        define('__URL__', __HOST__ . trim($_SERVER['REQUEST_URI'], '/'));
        define('__HISTORY__', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
        ini_set('memory_limit', '128M');
        ini_set('register_globals', 'off');


        if (version_compare(PHP_VERSION, '5.4.0', '<'))
        {
            ini_set('magic_quotes_runtime',0);//去除外部引入文件的转义符
            //去除系统自动加上的转义符号
            if(get_magic_quotes_gpc())
            {
                self::unaddslashes($_POST);
                self::unaddslashes($_GET);
                self::unaddslashes($_COOKIE);
            }
        }


    }

    /**
     * 去除转义符号
     * @param $data 转义数据
     */
    static private function unaddslashes($data)
    {
        foreach((array)$data as $k=>$v)
        {
            if(is_numeric($v))
            {
                $data[$k]=$v;
            }else{
                $data[$k]=is_array($v)?self::unaddslashes($v):stripslashes($v);
            }
        }
    }
}
