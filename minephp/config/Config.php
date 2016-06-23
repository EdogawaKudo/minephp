<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/3/23
 * File: Config.php
 */
namespace minephp\config;

class Config
{
    protected $items=array();//配置项集合

    /**
     * 设置配置项
     * @param $key
     * @param $name
     */
    public function set($key,$name)
    {
        foreach(explode('.',$key) as $d)
        {
            if(!isset($this->items[$d]))
            {
                $this->items[$d]=array();
            }
        }
        $this->items[$d]=$name;
    }
    /**
     * @param $key 获取配置项
     */
    public function get($key)
    {
        $tmp=$this->items;
        foreach(explode('.',$key) as $v)
        {
            if(isset($tmp[$v]))
            {
                $tmp=$tmp[$v];
            }else
            {
                return;
            }
        }
        return $tmp;
    }
}