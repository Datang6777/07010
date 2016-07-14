<?php
/**
 * Created by PhpStorm.
 * User: sks
 * Date: 2016/7/1
 * Time: 10:38
 */

namespace Home\Model;

use Think\Model;

class ArticleModel extends  Model{
    protected $article_handle;
    function __construct()
    {
        $this->article_handle = M('article');
    }

    public function getLatestNews()
    {
        //$sql = "SELECT aid,title,update_time FROM qz_article WHERE is_show = 1 ORDER BY update_time DESC,ord DESC,clicks DESC";

        $map['is_show'] = 1;
        $data = $this->article_handle->field("aid,title,update_time")->where($map)->order("update_time DESC,ord DESC,clicks DESC")->select();
        //query($sql);
        return $data;

    }

    public function getNewsByCid($cid)
    {
       $sql ="SELECT aid,title,top,good,content FROM qz_article WHERE is_show = 1 && cid = ".intval($cid);

        return $this->article_handle->query($sql);
    }

    public function getArticleByAid($aid)
    {
        $sql ="SELECT * FROM qz_article WHERE  aid = ".intval($aid);

        return $this->article_handle->query($sql);
    }
}