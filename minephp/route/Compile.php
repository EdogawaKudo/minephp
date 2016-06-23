<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/4/21
 * File: Compile.php
 */
namespace minephp\route;

class Compile
{

    //模块，控制器，方法参数名称
    protected  $args=array(
        'module'=>'m',
        'controller'=>'c',
        'action'=>'a',
    );


    protected function parseGet($url)
    {
        $gets=array();
        parse_str($url,$gets);
        foreach($this->args as $k=>$v)
        {
            if(!isset($gets[$v]))
            {
                $_GET[$v]=C('http.default_'.$k);
            }
        }
    }

    /**
     * 解析pathinfo模式
     */
    protected function parseNormalModel($url)
    {
        $url=str_replace(array('&','='),'/',$url);
        $queryArr=explode('/',$url);
        $queryArr=$this->parseMcaArgs($queryArr);
        $this->parseOtherGetArgs($queryArr);

    }

    /**
     * 解析模块，控制器，方法
     * @param $queryArr URI参数列表
     * @return mixed
     */
    private function parseMcaArgs($queryArr)
    {
        foreach($this->args as $k=>$v)
        {
            //提供默认的mca
            if (!isset($queryArr[$v]))
            {
                $_GET[$v] = C('http.default_'.$k);
            } else
            {
                //分配mca
                if ($queryArr[0] == $v)
                {
                    $_GET[$v] = $queryArr[1];
                    unset($queryArr[0], $queryArr[1]);
                } else
                {
                    $_GET[$v] = $queryArr[0];
                    array_shift($queryArr);
                }
            }
        }
        return $queryArr;
    }

    /**
     * 解析其他的参数
     * @param $queryArr URI参数列表
     */
    private function parseOtherGetArgs($queryArr)
    {
        $count=count($queryArr);
        for($i=0;$i<$count;$i++)
        {
            $_GET[$queryArr[$i]]=isset($queryArr[++$i])?$queryArr[$i+1]:'';
            $i+=2;
        }
        unset($_GET[C('http.url_var')]);
    }

}