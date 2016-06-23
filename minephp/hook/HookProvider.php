<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/4/27
 * File: HookProvider.php
 */
namespace minephp\hook;

use minephp\core\ServiceProvider;

class HookProvider extends ServiceProvider
{
    //是否延迟加载
    public $defer=false;
    public function register()
    {
        return $this->app->single(
            'Hook',
            function($app){
                return new Hook($app);
            },true
        );
    }
}
