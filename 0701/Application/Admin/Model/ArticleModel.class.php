<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/29
 * Time: 14:33
 */

namespace Admin\Model;
use Think\Model;
class ArticleModel extends Model{
    protected $article_model;
    function __construct()
    {
        $this->article_model=M('article');

    }
    function getArticleList($is_show = 0)
    {
        //where("is_show=1")
        //where($map);
//        $map =array();
//        if($is_show)
//        {
//            $map['is_show'] = 1;
//        }

        $map = new \stdClass();
       if($is_show) {
           $map->is_show = 1;
       }

       // $map['is_show'] = array("eq", 1);
        return $this->article_model->where($map)->order("ord desc,aid desc")->select();
    }
    function getArticleByAid($aid)
    {
        return $this->article_model->where("aid=".intval($aid))->find();
    }


    function addArticle($data)
    {
        $ret = $this->article_model->add($data);
        if($ret)
        {
            redirect(U('admin/article/index'));
        }else{
            echo 'Ìí¼ÓÊ§°Ü';
        }
    }
}