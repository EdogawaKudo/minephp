<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/5/5
 * File: Log.php
 */
namespace minephp\log;

/**
 * 日志处理类
 * Class Log
 * @package minephp\core
 */
class Log
{
    const FATAL='FATAL';//致命错误
    const ERROR='ERROR';//一般错误
    const WARNING='WARNING';//警告信息
    const NOTICE='NOTICE';//提示信息
    const DEBUG='DEBUG';//调试信息
    const SQL="SQL";//SQL语句信息
    const EXCEPTION='EXCEPTION';//异常错误
    private $logFile='';//日志文件
    private $log=array();//日志内容

    public function __construct()
    {
        //创建日志目录
        $dir=ROOT_PATH.DS.'storage/log/'.date('Y-m');
        !is_dir($dir) && mkdir($dir,0755,true);
        $this->logFile=$dir.date('d').'.log';
    }

    /**
     * 记录日志内容
     * @param $message 日志信息
     * @param string $level 日志级别
     */
    public function record($message,$level=self::ERROR)
    {
        if(Config::get('app.log_open') && in_array($level,Config::get('app.log_level')))
        {
            $this->log[]=date('Y-m-d H:i:s')."{$level}:{$message}".PHP_EOL;
        }
    }

    /**
     * 保存日志内容
     */
    public function save()
    {
        if(!empty($this->log))
        {
            error_log(implode("",$this->log),3,$this->logFile);
        }
    }

    /**
     * 写入日志内容
     * @param $message 日志信息
     * @param string $level 日志级别
     */
    public function write($message,$level=self::ERROR)
    {
        error_log(date('Y-m-d H:i:s')."{$level}:{$message}".PHP_EOL,3,$this->logFile);
    }

}
