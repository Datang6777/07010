<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/29
 * Time: 14:32
 */
namespace Admin\Controller;
use Think\Controller;
class CateController extends Controller{
    public function index()
    {
        $handle = D('cate');
        $catelist = $handle->getCatelist();
        $name_map=array();
        foreach($catelist as $item)
        {
            $name_map[$item['cid']] = $item['cate_name'];
        }
//        foreach($catelist as $key=>$item)
//        {
//            $catelist[$key]['pate_name']=$name_map[$item['pid']];
//        }
        foreach($catelist as &$citem)
        {
            $citem['pate_name'] = $name_map[$citem['pid']];
            $citem['is_show']   = intval($citem['is_show']);
        }
        $this->assign('catelist',$catelist);
        $this->display();
    }
    public function add()
    {
        $handle = D('cate');
        $catelist = $handle->getCatelist();
        $this->assign('catelist',$catelist);
        $this->display();
    }
    public function update()
    {
        $cid     = intval($_GET['cid']);
        $handle  = D('cate');
        $catedata=$handle->getCateByCid($cid);

        $pid = $catedata['pid'];

        $catelist= $handle->getCatelist();
        foreach($catelist as &$citem)
        {
            if($citem['cid'] == $pid)
            {
                $citem['selected'] = 'selected';
            }
        }
        $this->assign('catelist',$catelist);
        $catedata['checkedyes'] =$catedata['is_show']?"checked":"";
        $catedata['checkedno']  =$catedata['is_show']?"":"checked";

        $this->assign('cat',$catedata);
        $this->display();
    }
    public function add_submit()
    {

        $cate = M('cate');
        $data['cate_name'] = I('post.cate_name');
        $data['pid']       = I('post.pid');
        $data['ord']       = I('post.order',0);
        $data['is_show']   = I('post.shown');
        $ret = $cate->add($data);
        if($ret)
        {
            redirect(U('admin/cate/index'));
        }else{
            echo '添加失败';
        }
        exit;

    }
    public function update_submit()
    {
        $cate = M('cate');
        $data['cate_name'] = I('post.cate_name');
        $data['pid']       = I('post.pid');
        $data['ord']       = I('post.order',0);
        $data['is_show']   = I('post.shown');
        $ret = $cate->where('cid='.intval(I('post.cid')))->save($data);
        if($ret)
        {
            redirect(U('admin/cate/index'));
        }else{
            echo '修改失败';
        }
        exit;
    }
    public function delete(){
        $cid = I('get.cid');
        $cate = M('cate');
        $ret = $cate->where('cid='.intval($cid))->delete();
        if($ret)
        {
            redirect(U('admin/cate/index'));
        }else{
            echo '删除失败';
        }
        exit;
    }
}