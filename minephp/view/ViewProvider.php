<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/5/12
 * File: ViewProvider.php
 */
namespace minephp\view;
use minephp\core\ServiceProvider;

class ViewProvider extends ServiceProvider
{
    //是否延迟加载
    public $defer=false;


    public function register()
    {
        return $this->app->single('View',
        function($app){
            return new View($app);
        }, true);
    }
}