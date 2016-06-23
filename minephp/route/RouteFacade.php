<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/4/18
 * File: RouteFacade.php
 */

namespace minephp\route;
use minephp\core\ServiceFacade;

class RouteFacade extends ServiceFacade
{
    static public function getFacadeAccessor()
    {
        return 'Route';
    }
}
