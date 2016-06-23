<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/4/6
 * File: ConfigFacade.php
 */
namespace minephp\config;

use minephp\core\ServiceFacade;
class ConfigFacade extends ServiceFacade
{
    static public function getFacadeAccessor()
    {
        return 'Config';
    }
}