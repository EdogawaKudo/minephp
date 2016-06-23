<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/6/20
 * File: DbAbstract.php
 */
namespace minephp\db;
abstract class DbAbstract
{
    abstract public function connect();
    abstract public function execute();
}