<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/5/5
 * File: LogProvider.php
 */
namespace minephp\log;
use minephp\core\ServiceProvider;

/**
 * 日志服务提供者
 * Class LogProvider
 */

class LogProvider extends ServiceProvider
{
    //是否延迟加载
    public $defer=false;
    public function boot()
    {

    }
    public function register()
    {
        $this->app->single(
            'Log',
            function($app){
                return new Log($app);
            },true
            );
    }
}