<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/4/18
 * File: RouteProvider.php
 */
/**
 * 路由服务提供者
 */
namespace minephp\route;
use minephp\core\ServiceProvider;

class RouteProvider extends  ServiceProvider
{
    //是否延迟加载
    public $defer=false;

    /**
     * 注册服务到容器
     */
    public function register()
    {
        $this->app->single(
            'Route',
            function($app){
                return new Route($app);
            },true
        );
    }
}