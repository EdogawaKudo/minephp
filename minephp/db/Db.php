<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/6/15
 * File: Db.php
 */
namespace minephp\db;

/**
 * 数据库基类
 * Class Db
 * @package minephp\db
 */
class Db
{
    //数据库驱动
    protected  $driver=null;
    //app实例对象
    protected  $app=null;
    //Db连接实例
    protected $connect=null;
    public function __construct($app)
    {
        $this->app=$app;
        $this->driver='minephp\db\\'.C('database.driver');
        $this->connect=new $this->driver();
    }

    public function driver($driver)
    {
        $this->driver=$driver;
        $this->connect=new $driver;
        return $this;
    }

    public function __call($method,$param)
    {
        $invoke=new \ReflectionMethod($this->connect,$method);
        if($invoke->isPublic())
        {
            return $invoke->invokeArgs($this->connect,$param);
        }else{
            throw new \Exception('数据库驱动不存在'.$this->driver);
        }
    }

}