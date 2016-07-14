<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/29
 * Time: 14:31
 */

namespace Admin\Controller;
use Think\Controller;

class ArticleController extends Controller{
    public function index()
    {
        //取得文章列表
        $handle = D('article');
        $articlelist = $handle->getArticlelist();

        //取得所有分类
        $handle = D('cate');
        $catelist = $handle->getCatelist();
        //建立分类id=>分类名字的映射
        $cate_map = array();
        foreach($catelist as $item)
        {
            $cid = $item['cid'];
            $cname =  $item['cate_name'];
            $cate_map[$cid] = $cname;
        }
        //原文章列表只保存了cid，但是我们在列表中，想显示出cate_name
        //所以遍历文章列表，将cate_name赋值做好
        foreach($articlelist as &$aitem)
        {
            $cid = $aitem['cid'];
            $aitem['cate_name'] = $cate_map[$cid];
        }
       // print_r($articlelist);
        $this->assign('articlelist',$articlelist);
        $this->display();
    }
    public function add()
    {
        $handle = D('article');
        $articlelist = $handle->getArticlelist();
        //直接将catelist，打到页面上
        $handle = D('cate');
        $catelist = $handle->getCatelist();
        $this->assign('catelist',$catelist);

        $this->assign('articlelist',$articlelist);
        $this->display();
    }
    public function update()
    {
        $aid         = intval($_GET['aid']);
        $handle      = D('article');
        $catedata    = $handle->getArticleByAid($aid);
        $articlelist = $handle->getArticlelist();
        $this->assign('articlelist',$articlelist);
        //直接将catelist，打到页面上
        $handle = D('cate');
        $catelist = $handle->getCatelist();
        $this->assign('catelist',$catelist);

        $catedata['checkedyes'] = $catedata['is_show']?"checked":"";
        $catedata['checkedno']  = $catedata['is_show']?"":"checked";
        $this->assign('cat',$catedata);
        $this->display();
    }

    public function add_submit()
    {
        $data['title']  = I('post.title');
        $data['author'] = I('post.author');
        $data['content']=I('post.content','','');
        $data['ord']    =I('post.order');
        $data['is_show']=I('post.shown');
        //获得客户端表单提交过来的cid
        $data['cid'] = I('post.cid');

        $handle = D('Article');

        $handle->addArticle($data);
        exit;
    }
    public function update_submit()
    {
        $cate = M('article');
        $data['title'] = I('post.title');
        $data['author'] = I('post.author');
        $data['content'] = I('post.content','','');
        $data['ord']     = I('post.order');
        $data['is_show'] = I('post.shown');
        //获得提交过来的cid
        $data['cid'] = I('post.cid');
        $ret = $cate->where('aid='.intval(I('post.aid')))->save($data);
        if($ret)
        {
            redirect(U('admin/article/index'));
        }else{
            echo '修改失败';
        }
   

    }
    public function delete()
    {
        $aid = I('get.aid');
        $cate = M('article');
        $ret = $cate->where('aid='.intval($aid))->delete();
        if($ret)
        {

            redirect(U('admin/article/index'));
        }
        else
        {
            echo '删除失败';
        }
        exit;
    }
    function uploadlogoqiniu()
    {
        $this->display("uploadqiniu");
    }
    function vcode()
    {
        $vcode = new Ucai\Verifycode();
        $vcode->main();
    }

    function uploadlogoqnqd()
    {
        $this->display("uploadqnqd");
    }
    function getToken()
    {
        $uploader = new Ucai\QiniuUploader();
        echo $uploader->getToken();
        exit;
    }
    function upload()
    {
        // print_r($_POST);
        // print_r($_FILES);
        // DIRECTORY_SEPARATOR
        //取得文件的各部分信息
        $parts = pathinfo($_FILES['photo']['name']);
        //取得文件的扩展名
        $ext = $parts['extension'];
        //保存日期，确保前后一致
        $date = date("Ymd");
        //上传后文件所在的目录
        $basepath = ROOT_PATH.DIRECTORY_SEPARATOR."Uploads".DIRECTORY_SEPARATOR.$date;
        //如果目录不存在则创建目录
        if(!is_dir($basepath)) {
            mkdir($basepath); //mkdir -p
        }
        //生成文件名
        $filename = rand(10000000,99999999).".".$ext;
        $destfile = $basepath.DIRECTORY_SEPARATOR.$filename;
        //则临时文件移至正式上传目录
        move_uploaded_file($_FILES['photo']['tmp_name'],$destfile);
        //生成上传后的URL
        $logo = "/Uploads/".$date."/".$filename;
        $user = D('User');
        //更新到数据库
        $ret = $user->updateLogo(cookie('uid'),$logo);
        if($ret)
        {
            $this->success("更新成功");
        }
        else
        {
            $this->error("更新失败");
        }
        exit;
    }



    function qiniuok()
    {
        // print_r($_REQUEST);

        $ret = $_REQUEST['upload_ret'];
        $ret = base64_decode($ret);
        $cbody = json_decode($ret, true);
        $domain = "oa8gs13bo.bkt.clouddn.com";
        $filename = $cbody['key'];
        $logo = "http://".$domain."/".$filename;

        $user = D('User');
        //更新到数据库
        $ret = $user->updateLogo(cookie('uid'),$logo);
        if($ret)
        {
            $this->success("更新成功");
        }
        else
        {
            $this->error("更新失败");
        }
        exit;

    }
    function info(){
        $user = M('BlogUser');
        $data = $user->where("uid=".cookie('uid'))->find();
        //var_dump($data);
        $this->assign('data',$data);
        $this->display();
    }
}