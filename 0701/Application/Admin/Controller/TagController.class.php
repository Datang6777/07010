<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/29
 * Time: 14:32
 */


namespace Admin\Controller;
use Think\Controller;
class TagController extends Controller{
    public function index()
    {
        $handle = D('tag');
        $taglist = $handle->getTagslist();
        $this->assign('taglist',$taglist);
        $this->display();
    }
    public function add()
    {
        $handle = D('tag');
        $taglist = $handle->getTagslist();
        $this->assign('taglist',$taglist);
        $this->display();
    }
    public function update()
    {
        $tid = intval($_GET['tid']);
        $handle = D('tag');
        $catadata = $handle->getTagByTid($tid);
        $taglist = $handle->getTagslist();
        $this->assign('taglist',$taglist);
        $catadata['checkedyes'] = $catadata['is_show']?"checked":"";
        $catadata['checkedno']  = $catadata['is_show']?"":"checked";

        $this->assign('cat',$catadata);
        $this->display();
    }

    public function add_submit()
    {
        $cate = M('tags');
        $data['tag_name']  = I('post.tag_name');
        $data['clicks']    = I('post.clicks');
        $data['ord']       = I('post.order');
        $data['is_show']   = I('post.shown');
        $ret = $cate->add($data);
        if($ret)
        {
            redirect(U('admin/tag/index'));

        }else{
            echo '添加失败';
        }

    }
    public function update_submit()
    {
        $cate = M("tags");
        $data['tag_name'] = I('post.tag_name');
        $data['clicks']   = I('post.clicks');
        $data['ord']      = I('post.order',0);
        $data['is_show']  = I('post.shown');
        $ret = $cate->where('tid='.intval(I('post.tid')))->save($data);
        if($ret)
        {
            redirect(U('admin/tag/index'));
        }else{
            echo '修改失败';
        }
        exit;
    }
    public function delete()
    {
        $tid = I('get.tid');
        $cate = M('tags');
        $ret = $cate->where('tid='.intval($tid))->delete();
        if($ret)
        {
            redirect(U('admin/tag/index'));
        }else{
            echo '删除失败';
        }
        exit;
    }
}