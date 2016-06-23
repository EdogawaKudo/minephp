<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/3/31
 * File: ConfigProvider.php
 */
namespace minephp\config;
use minephp\core\ServiceProvider;

class ConfigProvider extends ServiceProvider
{
    //延迟加载
    public $defer=false;

    /**
     * 启动服务提供者
     */
    public function boot()
    {
        foreach(glob((ROOT_PATH.DS.'config/*')) as $file)
        {
            $info=pathinfo($file);
            \Config::set($info['filename'],require $file);
        }
    }
    public function register()
    {
        $this->app->single('Config',function($app){
            return new Config($app);
        },true);
    }
}