<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/3/22
 * File: App.php
 */
/**
 * 服务初始化
 */
namespace minephp\core;
use ReflectionClass;
class App extends Container
{
    //启动应用
    protected $booted=false;
    //服务配置
    protected $config=array();
    //类库映射
    protected $alias = array();
    //延迟加载服务
    protected $deferProviders=array();
    //已经注册的服务提供者
    protected $serviceProvides=array();
    public function __construct()
    {
        //自动加载类函数
        spl_autoload_register(array($this,'autoload'));
        spl_autoload_register(array($this,'autoloadFacade'));
        $this->config=require ROOT_PATH.'/config/service.php';//引入服务配置
        //绑定核心服务提供者
        $this->bindServiceProviders();
        //注册单例服务
        $this->instance('App',$this);
        //设置外观基类APP对象
        ServiceFacade::setFacadeInstance($this);
        $this->addMap(Config::get('app.alias'));
        $this->boot();
    }



    /**
     * 启动系统
     */
    protected function boot()
    {
        if($this->booted)
        {
            return;
        }
        foreach($this->serviceProvides as $provide)
        {
            $this->bootProvider($provide);
        }
        $this->booted=true;
    }

    /**
     * 服务加载处理
     */
    private function bindServiceProviders()
    {
        foreach($this->config['providers'] as $provider)
        {

            $reflectionClass=new ReflectionClass($provider);
            $properties=$reflectionClass->getDefaultProperties();
            //获取延迟加载服务
            if(isset($properties['defer']) && $properties['defer']==true)
            {
                $alias=substr($reflectionClass->getShortName(),0,-8);
                $this->deferProviders[$alias]=$provider;
            }else
            {
                //注册服务提供者
                $this->register($provider);
            }
        }
    }

    /**
     * 获取服务实例
     * @param 服务名称 $name
     * @param bool $force 是否注册为单例服务
     * @return object|void
     */
    public function make($name,$force=false)
    {
        if(isset($this->deferProviders[$name]))
        {
            $this->register($this->deferProviders[$name]);
            unset($this->deferProviders[$name]);
        }
        return parent::make($name,$force);
    }

    /**
     * 立即注册服务
     */
    public function register($provider)
    {
        if($registered=$this->getProvider($provider))
        {
            return $registered;
        }

        if(is_string($provider))
        {
            $provider=new $provider($this);
        }
        $provider->register();
        //记录注册的服务
        $this->serviceProvides[]=$provider;
        //启动服务提供者
        if($this->booted)
        {
            $this->bootProvider($provider);
        }
    }

    /**
     * 运行服务提供者的boot方法
     * @param $provider 服务提供者
     */
    protected function bootProvider($provider)
    {
        if(method_exists($provider,'boot'))
        {
            $provider->boot();
        }
    }
    /**
     * 获取已经注册的服务
     * @param $provider
     */
    public function getProvider($provider)
    {
        $class=is_object($provider)?get_class($provider):$provider;
        foreach($this->serviceProvides as $value)
        {
            if($value instanceof $class)
            {
                return $value;
            }
        }
    }

    /**
     * 类库映射
     * @param $alias 别名
     * @param string $namespace 命名空间
     */
    public function addMap($alias,$namespace='')
    {
        if(is_array($alias))
        {
            foreach($alias as $k=>$v)
            {
                $this->alias[$k]=$v;
            }
        }else
        {
            $this->alias[$alias]=$namespace;
        }

    }
    /**
     * 自动加载类库
     * @param $class 加载的类名
     */
    public function autoload($class)
    {
        $file=str_replace('\\',DS,$class).'.php';
        if(isset($this->alias[$class]))
        {
            require_once str_replace('\\','/',$this->alias[$class]);
        }elseif(is_file(ROOT_PATH.DS.$file))
        {
            require_once ROOT_PATH.DS.$file;
        }elseif(is_file(APP_PATH.DS.$file))
        {

            require_once APP_PATH.DS.$file;
        }elseif(defined('MODULE_PATH') && is_file(MODULE_PATH.DS.$file))
        {
            require_once MODULE_PATH.DS.$file;
        }elseif(class_exists('Config',false))
        {
            foreach((array)Config::get('app.autoload_namespace') as $key=>$val)
            {
                if(strpos($key,$class)!=false)
                {
                    $file=str_replace($key,$val,$class);
                    require_once str_replace('\\',DS,$file);
                }
            }
        }
    }

    /**
     * @param $class 自动加载facade类
     */
    public function autoloadFacade($class)
    {
        $file=str_replace('\\','/',$class);
        $facade=basename($file);
        if(isset($this->config['facades'][$facade]))
        {
            return class_alias($this->config['facades'][$facade],$class);
        }
    }
}