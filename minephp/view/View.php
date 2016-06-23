<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/5/12
 * File: view.php
 */
namespace minephp\view;
/**
 * 模板类
 * Class view
 * @package minephp\view
 */

class View
{
    //模板文件
    private $viewFile='';
    //编译文件
    private $compileFile='';
    public function make($file='',$show=true,$expire='')
    {
        $expire=is_numeric($expire)?$expire:C('view.expire');
        if($expire>0 && $content=Cache::dir(STORAGE_PATH.'/view/cache')->get($_SERVER['REQUEST_URI']))
        {
            if($show)
            {
                exit($content);
            }else
            {
                return $content;
            }
        }

        if(!$this->viewFile=$this->getTplFile($file))
        {
            return false;
        }

        //编译文件
        $this->compileFile=COMPILE_PATH.DS.md5($this->viewFile).'.php';
        //编译文件
        $this->compileFile();
        //获取编译内容
        ob_start();
        require $this->compileFile;
        $content=ob_get_clean();
        if($expire>0)
        {
            if(!Cache::dir(STORAGE_PATH.'/view/cache')->set($_SERVER['REQUEST_URI'],$content,$expire))
            {
                throw new \Exception('创建缓存失败');
            }
        }
        //输出编译内容
        if($show)
        {
            exit($content);
        }
        else
        {
            return $content;
        }
    }

    /**
     * 编译模板文件
     */
    private function compileFile()
    {
        if(APP_DEBUG || !is_file($this->compileFile) || filemtime($this->compileFile)<filemtime($this->viewFile))
        {
            if(!is_dir(dirname($this->compileFile)))
            {
                mkdir(dirname($this->compileFile),0755,true);
            }
            file_put_contents($this->compileFile,file_get_contents($this->viewFile));
        }
    }

    /**
     * 获取模板文件
     * @param $file 模板文件
     */
    private function getTplFile($file)
    {
        if(!is_file($file))
        {
            //如果传递的file参数为空,则将当前的方法名称当做模板文件名称
            $filename=$file?$file:ACTION;
            $file=VIEW_PATH.DS.$filename.C('view.prefix');
            if(is_file($file))
            {
                return $file;
            }
        }
        elseif(is_file($file))
        {
            return $file;
        }
        if(APP_DEBUG)
        {
            throw new \Exception('模板文件不存在:' . $file);
        }
        else
        {
            return false;
        }
    }
}