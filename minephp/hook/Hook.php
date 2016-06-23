<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/4/27
 * File: Hook.php
 */
namespace minephp\hook;

use \ReflectionMethod;
class Hook
{
    //钩子
    private $hook=array();

    /**
     * 添加钩子
     * @param $name 钩子名称
     * @param $action 钩子事件
     */
    public function add($name,$action)
    {
        if(!isset($this->hook[$name]))
        {
            $this->hook[$name]=array();
        }

        if(is_array($action))
        {
            $this->hook=array_merge($this->hook[$name],$action);
        }else
        {
            $this->hook[$name][]=$action;
        }
    }

    /**
     * 批量导入钩子
     * @param $hookArr
     * @param bool $recursive
     * @return bool
     */
    public function import($hookArr,$recursive=false)
    {
        if(!is_array($hookArr)) return false;
        if(!$recursive)
        {
            $this->hook=array_merge($this->hook,$hookArr);
        }else
        {
            foreach($hookArr as $name=>$action)
            {
                if(!isset($this->hook[$name]))
                {
                    $this->hook[$name]=array();
                }
                if(isset($action[_overflow]))
                {
                    $this->hook[$name]=$action;
                }else
                {
                    $this->hook[$name]=array_merge($this->hook[$name],$action);
                }
            }
        }
    }

    /**
     * 取得钩子
     * @param string $name 钩子名称
     */
    public function get($name='')
    {
        if(empty($name))
        {
            return $this->hook;
        }
        return $this->hook[$name];
    }

    /**
     * 监听钩子
     * @param $name 钩子名称
     * @param string $param 钩子事件参数
     */
    public function listen($name,$param='')
    {
        if(!isset($this->hook[$name]))
        {
            return false;
        }


        foreach($this->hook[$name] as $v)
        {
            if(!$this->execHook($v,$name,$param))
            {
                return false;
            }
        }
        return true;
    }

    /**
     * 执行钩子事件
     * @param $name 钩子名称
     * @param string $action 钩子事件
     * @param string $param 钩子参数
     */
    public  function execHook($name,$action='run',$param='')
    {
        if(substr($name,0,-4)!='Hook')
        {
            $file='addons/'.$name.'/'.$name.'.php';
            if(!is_file($file))
            {
                return false;
            }
            require_once $file;
            $class="addons\\{$name}\\{$name}Addon";
        }

        if(class_exists($class))
        {
            $obj=new $class;
            $invoke=new ReflectionMethod($obj,$action);
            if($invoke->isPublic())
            {
                $invoke->invokeArgs($obj,array($param));
            }
        }
        return false;


    }

}