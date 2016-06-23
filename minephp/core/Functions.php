<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/4/20
 * File: Functions.php
 */

/**
 * 配置操作
 * @param string $name 配置键
 * @param string $value 配置值
 * @return mixed
 */
function C($name='',$value='')
{
    if($value=='')
    {
        return Config::get($name);
    }
    return Config::set($name,$value);
}
