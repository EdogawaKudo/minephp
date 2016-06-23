<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/6/15
 * File: DbFacade.php
 */
namespace minephp\db;
use minephp\core\ServiceFacade;

/**
 * 数据库外观
 * Class DbFacade
 * @package minephp\db
 */
class DbFacade extends ServiceFacade
{
    static public function getFacadeAccessor()
    {
        return 'Db';
    }
}