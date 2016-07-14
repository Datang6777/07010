<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/29
 * Time: 14:36
 */


namespace Admin\Model;
use Think\Model;
class CateModel extends Model{
    protected $cate_model;
    function __construct()
    {
        $this->cate_model = M("cate");
    }
    function getCateList($is_show=0)
    {
        $map = array();
        if($is_show)
        {
            $map['is_show'] = 1;
        }
        return $this->cate_model->where($map)->order("ord desc,cid desc")->select();
    }
    function getCateByCid($cid)
    {
        return $this->cate_model->where("cid=".intval($cid))->find();
    }
}