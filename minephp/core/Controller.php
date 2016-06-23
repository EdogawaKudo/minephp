<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/5/9
 * File: Controller.php
 */
namespace minephp\core;

/**
 * 控制器基类
 * Class Controller
 */
class Controller
{
    public function __construct()
    {
        if(method_exists($this,'__init'))
        {
            $this->__init();
        }
    }
}