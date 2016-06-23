<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/4/15
 * File: Route.php
 */
namespace minephp\route;

class Route extends Compile
{
    //请求的URI
    protected $requestUri='';
    //是否是普通的get参数请求
    protected $urlType=0;
    public function __construct()
    {
        $this->requestUri=$this->getRequestUri();
    }
    /**
     * 解析路由
     */
    public function dispatch()
    {
        //路由缓存
        if(C('http.route_cache'))
        {

        }
        //解析路由
        $this->urlType==0?$this->parseGet($this->requestUri):$this->parseNormalModel($this->requestUri);
        $_REQUEST=array_merge($_REQUEST,$_GET);
        $this->defConst();
    }

    /**
     * 定义常量
     */
    private function defConst()
    {
        define('MODULE',$_GET[$this->args['module']]);
        define('CONTROLLER',$_GET[$this->args['controller']]);
        define('ACTION',$_GET[$this->args['action']]);
        define('APP',basename(APP_PATH));
        define('__APP__',__HOST__.'/'.APP);
        //设置模块，控制器，方法的URI路径
        switch($this->urlType)
        {
            //普通URL模式
            case 0:
                define('__MODULE__',__WEB__.'?'.$this->args['module'].'='.MODULE);
                define('__CONTROLLER_',__MODULE__.'&'.$this->args['controller'].'='.CONTROLLER);
                define('__ACTION__',__CONTROLLER_.'&'.$this->args['action'].'='.ACTION);
                break;
            //PATHINFO模式
            case 1:
                define('__MODULE__',__WEB__.'/'.MODULE);
                define('__CONTROLLER_',__MODULE__.'/'.CONTROLLER);
                define('__ACTION__',__CONTROLLER_.'/'.ACTION);
                break;
            //兼容PATHINFO模式
            case 2:
                define('__MODULE__',__WEB__.'?'.C('http.url_var').'='.MODULE);
                define('__CONTROLLER_',__MODULE__.'/'.CONTROLLER);
                define('__ACTION__',__CONTROLLER_.'/'.ACTION);
                break;
        }
        //模块目录
        define('MODULE_PATH',APP_PATH.'/'.MODULE);
        //模板目录
        define('VIEW_PATH',MODULE_PATH.'/view');
        //模块数据存储目录
        define('STORAGE_PATH',MODULE_PATH.'/storage');
        //模块编译文件目录
        define('COMPILE_PATH',STORAGE_PATH.'/compile');
        //模块缓存文件目录
        define('CACHE_PATH',STORAGE_PATH.'/cache');
        //公共目录
        define('__PUBLIC__',__ROOT__.'/Public');
        //模板URI路径
        define('__VIEW__',__ROOT__.'/'.trim(VIEW_PATH,'/'));

    }

    /**
     * 获取请求的URI地址
     */
    private function getRequestUri()
    {
        if(isset($_SERVER['PATH_INFO']))
        {
            $requestUri=$_SERVER['PATH_INFO'];
            $this->urlType=1;
        }elseif(isset($_REQUEST[C('http.url_var')]))
        {
            $requestUri=$_REQUEST[C('http.url_var')];
            $this->urlType=2;
        }else
        {
            /*if(dirname($_SERVER['SCRIPT_NAME'])!='/')
            {
                $requestUri=str_replace(dirname($_SERVER['SCRIPT_NAME']),'',$_SERVER['REQUEST_URI']);
            }else
            {
                $requestUri=$_SERVER['REQUEST_URI'];
            }*/
            $requestUri=$_SERVER['QUERY_STRING'];
            $this->urlType=0;
        }

        //$requestUri=trim(preg_replace('/\w+\.php/i','',$requestUri),'/');
        return $requestUri?$requestUri:'/';
    }
}