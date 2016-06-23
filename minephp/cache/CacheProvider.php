<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/5/13
 * File: CacheProvider.php
 */
namespace minephp\cache;
use minephp\core\ServiceProvider;

/**
 * 缓存服务提供者
 * Class CacheProvider
 * @package minephp\cache
 */
class CacheProvider extends ServiceProvider
{
    public $defer=true;

    public function register()
    {
        return $this->app->single('Cache',function($app){
            return new Cache($app);
        });
    }
}