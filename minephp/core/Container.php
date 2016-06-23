<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/3/22
 * File: Container.php
 */
namespace minephp\core;

use ArrayAccess;
use ReflectionClass;
class Container implements  ArrayAccess
{
    //绑定实例
    public $bindings=array();
    //单例服务
    public $instance=array();


    /**
     * 将应用服务绑定到容器
     * @param $name 实例名称
     * @param $closure 返回服务对象的匿名函数
     * @param bool $force 是否为单例服务
     */
    public function bind($name,$closure,$force=false)
    {
        $this->bindings[$name]=compact("closure","force");
    }

    /**
     * 注册服务
     * @param $name 实例名称
     * @param $closure 匿名函数
     */
    public function single($name,$closure)
    {
        $this->bind($name,$closure,true);
    }

    /**
     * 注册单例服务
     * @param $name 名称
     * @param $object 对象
     */
    public function instance($name,$object)
    {
        $this->instance[$name]=$object;
    }

    /**
     * 获取服务实例
     * @param $name 服务名称
     * @param bool $force 是否单例服务
     */
    public function make($name,$force=false)
    {
        if(isset($this->instance[$name]))
        {
            return $this->instance[$name];
        }
        $closure=$this->getClosure($name);
        //获取服务实例
        $object=$this->build($closure);
        //单例绑定
        if(isset($this->bindings[$name]['force']) && $this->bindings[$name]['force'] || $force)
        {
            $this->instance[$name]=$object;
        }
        return $object;
    }

    /**
     * @param $name 实例的名称:返回类名或者匿名函数
     */
    public function getClosure($name)
    {
        return isset($this->bindings[$name])?$this->bindings[$name]['closure']:$name;
    }

    /**
     * 生成服务实例
     * @param $name 实例名称
     */
    public function build($name)
    {
        if($name instanceof \Closure)
        {
            return $name($this);
        }

        //获取类反射信息
        $reflector=new ReflectionClass($name);
        //检查类是否可以实例化，排除抽像类和接口
        if(!$reflector->isInstantiable())
        {
            throw new \Exception($name.'不能实例化');
        }

        //获取构造函数
        $constructor=$reflector->getConstructor();
        //如果没有构造函数，则直接对对象进行实例化
        if(is_null($constructor))
        {
            return new $name;
        }
        //获取构造函数参数
        $parameters=$constructor->getParameters();

        //对构造函数参数进行解析
        $dependencies=$this->getDependencies($parameters);

        //创建一个类的实例，将解析后的构造函数参数传递给构造函数
        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * 解析构造函数参数
     * @param $parametes 构造函数参数
     */
    public function getDependencies($parametes)
    {
        $dependencies=array();
        foreach($parametes as $k=>$v)
        {
            //获取参数类型
            $dependency=$v->getClass();
            if(is_null($dependency))
            {
                //如果参数类型是变量，并且参数有默认值则设置默认值
                $dependencies[]=$this->resolveNonClass($v);
            }else
            {
                //如果是一个类的话，则递归进行解析
                $dependencies[]=$this->build($dependency);
            }
        }
        return $dependencies;
    }

    private function resolveNonClass($param)
    {
        if($param->isDefaultValueAvailable())
        {
            return $param->getDefaultValue();
        }
        throw new \Exception('参数无默认值，无法实例化');
    }

    public function offsetExists($key)
    {
        return isset($this->bindings[$key]);
    }

    public function offsetGet($key)
    {
        return $this->make($key);
    }

    public function offsetSet($key,$value)
    {
        if(!$value instanceof Colsure)
        {
            $value=function()use($value)
            {
                return $value;
            };
        }
        $this->bind($key,$value);
    }

    public function offsetUnset($key)
    {
        unset($this->bindings[$key],$this->instance[$key]);
    }
}