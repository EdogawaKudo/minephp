<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/5/13
 * File: CacheFacade.php
 */
namespace minephp\cache;
use minephp\core\ServiceFacade;

class CacheFacade extends ServiceFacade
{
    static public function getFacadeAccessor()
    {
        return 'Cache';
    }
}