<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/3/30
 * File: service.php
 */
return array(
    'providers'=>array(
        'minephp\config\ConfigProvider',
        'minephp\route\RouteProvider',
        'minephp\hook\HookProvider',
        'minephp\log\LogProvider',
        'minephp\view\ViewProvider',
        'minephp\cache\CacheProvider',
        'minephp\db\DbProvider',
    ),
    'facades'=>array(
        'Config'=>'minephp\config\ConfigFacade',
        'Route'=>'minephp\route\RouteFacade',
        'Log'=>'minephp\log\LogFacade',
        'View'=>'minephp\view\ViewFacade',
        'Cache'=>'minephp\cache\CacheFacade',
        'Db'=>'minephp\db\DbFacade',
    )
);