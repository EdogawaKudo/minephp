<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/5/19
 * File: File.php
 */
namespace minephp\cache;
/**
 * 文件缓存
 * Class File
 * @package minephp\cache
 */
class File extends CacheAbstract
{
    //缓存目录
    public  $dir='';
    //缓存文件
    private $file='';

    public function __construct()
    {
        $this->dir=CACHE_PATH;
        $this->connect();
    }

    /**
     * 缓存连接
     */
    public function connect()
    {
        if(!is_dir($this->dir) && !mkdir($this->dir,0755,true))
        {
            throw new \Exception('缓存目录不存在');
        }
        return $this;
    }

    /**
     * 创建缓存目录
     * @param $dir 缓存目录
     * @return $this
     */
    public function dir($dir='')
    {
        if(is_dir($dir) || mkdir($dir,0755,true))
        {
            $this->dir=$dir;
        }

        return $this;
    }

    /**
     * 获取缓存文件
     * @param $name 缓存名称
     */
    public function getFile($name)
    {
        $this->file=$this->dir.'/'.md5($name).'.php';
    }

    /**
     * 设置缓存内容
     * @param $name 缓存名称
     * @param $value 缓存值
     * @param int $expire 缓存过期时间
     */
    public function set($name,$value,$expire=3600)
    {
        $this->getFile($name);
        $expire=sprintf("%010d",$expire);
        $content="<?php\n//".$expire.gzcompress($value)."\n?>";
        return file_put_contents($this->file,$content);
    }

    /**
     * 获取缓存内容
     * @param $name 缓存名称
     */
    public function get($name)
    {
        $this->getFile($name);
        if(!is_file($this->file))
        {
            return null;
        }
        $content=file_get_contents($this->file);
        $expire=substr($content,8,10);
        if($expire>0 && filemtime($this->file)+$expire < time())
        {
            $this->del($name);
            return false;
        }
        return gzuncompress(substr($content,18));
    }

    /**
     * 删除缓存
     * @param $name 缓存名称
     */
    public function del($name)
    {
        $this->getFile($name);
        return is_file($this->file) && unlink($this->file);
    }

    /**
     * 删除所有缓存
     */
    public function flush()
    {
        foreach(glob($this->dir.'/*') as $k=>$v)
        {
            if(is_dir($v))
            {
                $this->flush($v);
            }else{
                unlink($v);
            }
        }
    }
}