<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/5/20
 * File: CacheAbstract.php
 */
namespace minephp\cache;

/**
 *  缓存抽像类
 * Class CacheInterface
 * @package minephp\cache
 */
abstract class CacheAbstract
{
    abstract public function connect();
    abstract public function get($name);
    abstract public function set($name,$value,$expire);
    abstract public function del($name);
    abstract public function flush();
}