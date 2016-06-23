<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/5/20
 * File: Cache.php
 */
namespace minephp\cache;
/**
 * 缓存处理基类
 * Class Cache
 */
class Cache
{
    //app对象
    private $app=null;
    //缓存连接对象
    private $connect=null;
    //当前缓存驱动
    private $driver='';
    public function __construct($app)
    {
        $this->app=$app;
        $this->driver='minephp\cache\\'.C('cache.driver');
        $this->connect=new $this->driver();
    }

    /**
     * 设置缓存驱动
     * @param $driver 缓存驱动
     * @return $this
     */
    public function driver($driver)
    {
        $this->connect=new $driver();
        return $this;
    }

    public function __call($method,$params)
    {
        $invoke=new \ReflectionMethod($this->connect,$method);

        if($invoke->isPublic())
        {
            return $invoke->invokeArgs($this->connect,$params);
        }else{
            throw new \Exception('缓存驱动调用失败'.$this->driver);
        }
    }



}