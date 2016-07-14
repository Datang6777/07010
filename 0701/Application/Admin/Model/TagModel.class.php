<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/29
 * Time: 14:36
 */


namespace Admin\Model;
use Think\Model;
class TagModel extends Model{
    protected $tags_model;
    function __construct()
    {
        $this->tags_model = M("tags");
    }
    function getTagsList($is_show = 0)
    {
        $map = array();
        if($is_show)
        {
            $map['is_show'] = 1;
        }
        return $this->tags_model->where($map)->order("ord desc,tid desc")->select();
    }
    function getTagByTid($tid)
    {
        return $this->tags_model->where("tid=".intval($tid))->find();
    }
    
}