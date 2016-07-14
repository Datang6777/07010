<?php
/**
 * Created by PhpStorm.
 * User: ll
 * Date: 2016/7/11
 * Time: 10:13
 */

namespace Admin\Controller;
use Think\Controller;
use Vendor\Ucai;

class UserController extends  Controller{
    public function __construct()
    {
        parent::__construct();

        $this->assign("uid",cookie('uid'));
        $this->assign("uname",cookie('uname'));
    }
    public function login()
    {
        $this->display();
    }

    public function reg()
    {
        $this->display();
    }

    public function logout()
    {
        cookie('uid', null);
        cookie('uname',null);
        $this->success("退出成功");
        exit;
    }

    public function login_submit(){
        $value = I('post.uname');
        $handle = D('User');
        $userinfo = null;
//        $vcode = I('post.vcode');
//        session_start();
//        if($vcode != $_SESSION['vcode']) {
//            $this->error("验证码错误！");
//            exit;
//        }
        if(strpos($value,"@")!==false) {
            $userinfo = $handle->getUserByEmail($value);
        } else if(preg_match("#1[3|4|5|7|8]\d{9}#",$value)>0) {
            $userinfo = $handle->getUserByMobile($value);
        } else{
            $userinfo = $handle->getUserByName($value);
        }
        $password = I('post.password');
        $uid = $userinfo['uid'];
        $ret = $handle->checkPassword($uid, $password);
        if($ret) {
            cookie('uname',$userinfo['uname']);
            cookie("uid",$uid);
            $this->success("登录成功",U('Index/info'));
        } else{
            $this->error("登录失败！");
        }
        exit;
    }
    function userinfo() {
        $this->display();

    }
    public function reg_submit()
    {
        $regip = get_client_ip();
        $uname = I('post.uname');
        $email = I('post.email');
        $mobile = I('post.mobile');
        $vcode = I('post.vcode');
        session_start();
        if($vcode != $_SESSION['vcode'])
        {
            $this->error("验证码错误！");
            exit;
        }
        if(!$uname || !$email || !$mobile)
        {
            $this->error("你是不是哪个忘记了写了，亲！",'',10);
            exit;
        }
        $password = I('post.password');
        $password1 = I('post.password1');
        if($password!=$password1)
        {
            $this->error("两次密码输入好像不一样哦！",'',10);
            exit;
        }
        $gender = I('post.gender');

        $user_handle = D("User");
        $ret = $user_handle->addUser($uname, $password, $email, $mobile,$gender,$regip);
        if($ret)
        {
            $this->success("注册成功！");
        }
        else{
            $this->error("注册失败！");
        }
        // print_r($_POST);
    }

    public function test()
    {
        $userhandle = D("User");
        $password = "wuxing";
        $uid = 1;
        $email = "wuxing@ucai.cn";
        $mobile="18910836103";
        $uname = "wuxing";
        // var_dump($userhandle->checkPassword($uid,$password));
        //  var_dump($userhandle->changePassword($uid,$password));
        //Uid
        var_dump($userhandle->getUserByUid($uid));
        //Email
        var_dump($userhandle->getUserByEmail($email));
        //Mobile
        var_dump($userhandle->getUserByMobile($mobile));
        //Uname
        var_dump($userhandle->getUserByName($uname));
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
    function uploadQiniu()
    {
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

        //调用 Vendor中的上传封装
        $uploader = new Ucai\QiniuUploader();
        $logo = $uploader->upload($destfile);
        $ret = 0;
        if($logo) {
            $user = D('User');
            //更新到数据库
            $ret = $user->updateLogo(cookie('uid'), $logo);
        }
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
        $logo = "/07010/0701/Uploads/".$date."/".$filename;
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

    function uploadlogotp()
    {
        $this->display();
    }

    function uploadtp()
    {

        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录(Y-m-d)
        // 上传文件
        $info   =   $upload->upload();

        print_r($info);
        $ret = false;
        if(!empty($info)) {
            //生成上传后的URL
            $logo = "/Uploads/" . $info['photo']['savepath'] . "/" . $info['photo']['savename'];
            $user = D('User');
            //更新到数据库
            $ret = $user->updateLogo(cookie('uid'), $logo);
        }
        if(!$ret) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $this->success('上传成功！','',10);
        }
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
