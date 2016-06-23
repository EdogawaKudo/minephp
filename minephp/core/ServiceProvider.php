<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/4/1
 * File: ServiceProvider.php
 */
namespace minephp\core;

/**
 * Class ServiceProvider 服务抽像类
 */
abstract class ServiceProvider
{
    //延迟加载
    public $defer=false;

    //应用实例
    protected $app=null;
    //注册服务
    abstract function register();

    public function __construct($app)
    {
        $this->app=$app;
    }

    public function __call($method,$args)
    {
        if($method=='boot')
        {
            return;
        }
        throw new \BadMethodCallException('方法'.$method.'不存在');
    }
}