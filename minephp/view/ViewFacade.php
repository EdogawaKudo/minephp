<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/5/12
 * File: ViewFacade.php
 */
namespace minephp\view;
use minephp\core\ServiceFacade;

/**
 * 模板外观类
 * Class ViewFacade
 * @package minephp\view
 */
class ViewFacade extends ServiceFacade
{
    static public function getFacadeAccessor()
    {
        return 'View';
    }
}