<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/5/5
 * File: LogFacade.php
 */
namespace minephp\log;
use minephp\core\ServiceFacade;
/**
 * 日志外观
 * Class LogFacade
 */
class LogFacade extends ServiceFacade
{
    static public function getFacadeAccessor()
    {
        return 'Log';
    }
}