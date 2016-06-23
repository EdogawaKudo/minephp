<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/6/15
 * File: DbProvider.php
 */
namespace minephp\db;
use minephp\core\ServiceProvider;
/**
 *
 * Class DbProvider
 * @package minephp\db
 */
class DbProvider extends ServiceProvider
{
    public $defer=true;

    /**
     * 初始化数据库
     */
    public function boot()
    {

    }

    public function register()
    {
        $this->app->single('Db', function($app){
                return new Db($app);
            }
        );
    }

}
