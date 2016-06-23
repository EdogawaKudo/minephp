<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/3/16
 * File: minephp.php
 */
//版本号
define('VERSION','1.0.0');
//调试模式
defined('APP_DEBUG') || define('APP_DEBUG',true);
//框架路径
define('MINE_PATH',__DIR__);
//根目录
define('ROOT_PATH',dirname(MINE_PATH));
//应用目录
defined('APP_PATH') || define('APP_PATH',ROOT_PATH.'/Application');

require MINE_PATH.'/core/Boot.php';//框架引导文件
require MINE_PATH.'/core/Container.php';//服务容器
require MINE_PATH.'/core/App.php';//服务初始化文件
require MINE_PATH.'/core/Functions.php';//核心函数库

minephp\core\Boot::startBoot();
$app=new minephp\core\App();
new minephp\core\Kernel($app);
