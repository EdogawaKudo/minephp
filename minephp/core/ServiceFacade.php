<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/4/6
 * File: ServiceFacade.php
 */
namespace minephp\core;

/**
 * 外观抽像基类
 * Class ServiceFacade
 * @package minephp\core
 */
abstract class ServiceFacade
{
    //应用对象
    static protected  $app=null;
    //解析处理
    static public $resolveInstance=array();

    static public function getFacadeRoot()
    {
        return self::resolveFacadeInstance(static::getFacadeAccessor());
    }


    /**
     * 获取外观存储器
     */
    static  protected  function getFacadeAccessor()
    {
        throw new \RuntimeException('没有实现Facade抽像类中的'.basename(__METHOD__).'方法');
    }

    /**
     * 解析实例
     * @param $name 实例名称
     */
    static protected function resolveFacadeInstance($name)
    {
        if(is_object($name))
        {
            return $name;
        }
        if(isset(self::$resolveInstance[$name]))
        {
            return self::$resolveInstance[$name];
        }
        return self::$resolveInstance[$name]=self::$app[$name];
    }

    static  public  function setFacadeInstance($app)
    {
        self::$app=$app;
    }
    static public function __callStatic($method,$args)
    {
        $instance=self::getFacadeRoot();
        return call_user_func_array(array($instance,$method),$args);
    }
}