<?php
/**
 * Created by PhpStorm.
 * User: sks
 * Date: 2016/7/1
 * Time: 11:32
 */

namespace Home\Model;
use Think\Model;

class TagModel extends  Model{
    protected $tags_handle;
    protected $tags_article_handle;

    function __construct()
    {
        $this->tags_handle = M("Tags");
        $this->tags_article_handle = M("TagsArticle");

    }
   public function getTagList()
   {
       $sql = "SELECT tid,tag_name FROM qz_tags WHERE is_show = 1 ORDER BY ord DESC,clicks DESC";
       return M('')->query($sql);
   }

    public function getTagsArticle()
    {
        $sql = "SELECT tid,count(*) as count FROM qz_tags_article GROUP BY tid";
        return M('')->query($sql);
    }
}