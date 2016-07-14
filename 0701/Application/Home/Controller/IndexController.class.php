<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->assign("uid",cookie('uid'));
        $this->assign("uname",cookie('uname'));
    }
    private function outputMenu()
    {
        $model = M('cate');
        $data  = $model->where("is_show=1")->order("ord DESC")->select();

        //$data    = $model->where("is_show=1")->field("cid,pid,cate_name")->limit(5)->order("ord DESC")->select();
        /*$data  = $model->select(array(
            'order'=>'ord desc',
            'where'=>'is_show=1',
            'field'=>'cid,pid,cate_name',
        ));*/
        $nav   = tree($data);

        $this->assign("nav",$nav);
    }
    public function test()
    {
        //$model = M('article');
        //$data  = $model->find(1);
        //print_r($data);

        //$model = M('tags_article');
        //$data  = $model->find(1);
        //print_r($data);
        //test();
        //echo STATIC_URL;
       // echo '<pre>';
        //print_r($_SERVER);
        //echo '</pre>';

        $this->outputMenu();
        $this->assign("static_url",STATIC_URL);

        $lastest = D('Article')->getLatestNews();
        $this->assign("new",$lastest);


        $get = D('Article')->getNewsByCid(11);
        $this->assign("get",$get);


        //标签处理
        $handle = D('Tag');
        $tags = $handle->getTagList();

        //取得每一个tag的计数（刚才那个select tid,count(*) as count xxx)
        $tags_article = $handle->getTagsArticle();
        $count_map = array();
        //建立tid和count的对应关系数组
        //tid count
        //1     6
        //2     2
        //3     6
        foreach($tags_article as $item)
        {
            $tid = $item['tid'];
            $count = $item['count'];
            $count_map[$tid] = $count;
        }
        //$tags_article[0] =>array("tid"=>1, "count"=>6)

        //$count_map[1] = 6
        //$count_map[2] = 2
        //$count_map[3] = 6
        //遍历标签，把某标签的count从映射数组里面取出来
        foreach($tags as &$titem)
        {
            $tid = $titem['tid'];
            /*foreach($tags_article as $item)
            {
                if($item['tid'] == $tid)
                {
                    $titem['count']=$item['count'];
                }
            }*/
            $titem['count'] = isset($count_map[$tid])?$count_map[$tid]:0;
        }
        //$this->assign("nums",$tags_article);
        $this->assign("tags",$tags);
        $this->display();

    }
    public function mylist()
    {
        $this->outputMenu();
        $cid = I('get.cid');
        //取得指定分类下的文章
        $articles = D('Article')->getNewsByCid($cid);
        $this->assign("articles",$articles);
        $this->display();
    }

    public function show()
    {
        $aid = I('get.aid');
        $handle = D('Article');
        $data = $handle->getArticleByAid($aid);

        $this->assign("article",$data[0]);
        $this->display();
    }
    public function upload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件

        $info   =   $upload->upload();
        if(!$info) {
           // 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $this->success('上传成功！');
        }
    }
}