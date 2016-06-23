<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/4/15
 * File: Kernel.php
 */
namespace minephp\core;
use Exception;
use ReflectionMethod;

class Kernel
{
    protected $app=null;
    public function __construct($app)
    {
        $this->app=$app;
        //设置字符集
        header('Content-type:text/html;charset='.Config::get('app.charset'));
        //设置时区
        date_default_timezone_set(Config::get('app.timezone'));
        //路由处理
        Route::dispatch();
        //导入钩子
        $this->app['Hook']->import(Config::get('hook'));
        //执行控制器动作
        $this->execAction();
        Log::save();
    }

    /**
     * 执行控制器动作
     */
    public  function execAction()
    {
        $class=MODULE.'\\controller\\'.ucfirst(CONTROLLER);
        if(!class_exists($class,true))
        {
            throw new Exception("{$class} Not Found");
        }
        $controller=new $class();
        try
        {
            $action=new ReflectionMethod($controller,ACTION);
            if($action->isPublic())
            {
                $this->app['Hook']->listen('controller_begin');
                $result=$action->invoke($controller);
            }
            else
            {
                throw new Exception(ACTION."动作不存在");
            }
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            $action=new ReflectionMethod($controller,'__call');
            $action->invokeArgs($controller,array(ACTION,''));
        }
    }
}