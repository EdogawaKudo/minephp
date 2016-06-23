<?php
/**
 * Created by Code_Maize.
 * User: Administrator
 * Date: 2016/3/10
 * File: data.php
 */

/**
 * Class data
 */
class data
{
    /**
     * 递归返回子孙树多层级数组
     * @param $data 操作的数据
     * @param int $pid  父ID
     * @param string $html 格式化html
     * @param string $fieldPri 唯一键名
     * @param string $fieldPid 父级ID键名
     * @param $level   数据层级
     * @return array
     */
    static public function channelLevel($data,$pid=0,$html='&nbsp',$fieldPri='cid',$fieldPid='pid',$level=1)
    {
        $arr=array();
        if(empty($data)) return $arr;
        foreach($data as $k=>$v)
        {
            if($v[$fieldPid]==$pid)
            {
                $arr[$v[$fieldPri]]=$v;
                $arr[$v[$fieldPri]]['level']=$level;
                $arr[$v[$fieldPri]]['html']=str_repeat($html,$level-1);
                $arr[$v[$fieldPri]]['data']=self::channelLevel($data,$v[$fieldPri],$html,$fieldPri,$fieldPid,$level+1);
            }
        }
        return $arr;
    }

    /**
     * 递归返回子孙树平级数组
     * @param $data 操作的数据
     * @param int $pid  父ID
     * @param string $html 格式化html
     * @param string $fieldPri 唯一键名
     * @param string $fieldPid 父级ID键名
     * @param $level   数据层级
     * @return array
     */
    static public function channelList($data,$pid=0,$html='&nbsp',$fieldPri='cid',$fieldPid='pid',$level=1)
    {
        $arr=array();
        if(empty($data)) return $arr;
        foreach($data as $k=>$v)
        {
            if($v[$fieldPid]==$pid)
            {
                $v['level']=$level;
                $v['html']=str_repeat($html,$level-1);
                array_push($arr,$v);
                $tmp=self::channelList($data,$v[$fieldPri],$html,$fieldPri,$fieldPid,$level+1);
                $arr=array_merge($arr,$tmp);
            }
        }
        return $arr;
    }

    /**
     * 返回指定sid的所有父元素
     * @param $data 操作的数据
     * @param $sid  子ID
     * @param string $fieldPri 唯一键名
     * @param string $fieldPid 父级ID键名
     * @return array
     */
    static public function parentList($data,$sid,$fieldPri='cid',$fieldPid='pid')
    {
        $arr=array();
        if(empty($data)) return $arr;
        foreach($data as $k=>$v)
        {
            if($v[$fieldPri]==$sid)
            {
                array_push($arr,$v);
                $tmp=self::parentList($data,$v[$fieldPid],$fieldPri,$fieldPid);
                $arr=array_merge($arr,$tmp);
            }
        }
        return $arr;
    }

    /**
     * 判断sid是否是pid的子孙
     * @param $data 操作的数据
     * @param $sid 子ID
     * @param $pid 父ID
     * @param string $fieldPri 唯一键值
     * @param string $fieldPid  父级ID键名
     */
    static public function isChild($data,$sid,$pid,$fieldPri='cid',$fieldPid='pid')
    {
        $data=self::channelList($data,$pid);
        foreach($data as $k=>$v)
        {
            if($sid==$v[$fieldPri])
                return true;
        }
        return false;
    }

    /**
     * 指定的元素是否有子孙元素
     * @param $data 操作的数据
     * @param $sid  指定id
     * @param string $fieldPid 父ID
     */
    static public function hasChild($data,$id,$fieldPid='pid')
    {
        foreach($data as $k=>$v)
        {
            if($v[$fieldPid]==$id)
                return true;
        }
        return false;
    }
} 