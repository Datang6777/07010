<?php
/**
 * Created by PhpStorm.
 * User: sks
 * Date: 2016/7/11
 * Time: 10:41
 */
namespace Home\Controller;

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

    public function login_submit()
    {
        // print_r($_POST);
        $value = I('post.uname');


        $handle = D('User');
        $userinfo = null;
        $vcode = I('post.vcode');
        session_start();
        if($vcode != $_SESSION['vcode'])
        {
            $this->error("验证码错误！");
            exit;
        }


        if(strpos($value,"@")!==false)
        {
            $userinfo = $handle->getUserByEmail($value);

        }
        else if(preg_match("#1[3|4|5|7|8]\d{9}#",$value)>0)
        {
            $userinfo = $handle->getUserByMobile($value);

        }
        else{
            $userinfo = $handle->getUserByName($value);

        }

        $password = I('post.password');
        $uid = $userinfo['uid'];


        $ret = $handle->checkPassword($uid, $password);
        if($ret)
        {
            cookie('uname',$userinfo['uname']);
            cookie("uid",$uid);
            // setcookie()
            $this->success("登录成功");
        }
        else
        {
            $this->error("登录失败！");
        }
        exit;
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
    function uploadlogoqiniu()
    {
        $this->display("uploadqiniu");
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

        $uploader = new Ucai\QiniuUploader();
        $logo = $uploader->upload($destfile);
        $ret = 0;
        if($logo)
        {
            $user = D('User');
            $ret = $user->updateLogo(cookie('uid'),$logo);
        }
        if($ret)
        {
            $this->success("更新成功");
        }else{
            $this->error("更新失败");
        }
    }
    function upload()
    {
        $parts = pathinfo($_FILES['photo']['name']);
        $ext = $parts['extension'];
        $date = date("Ymd");
        $basepath =ROOT_PATH.DIRECTORY_SEPARATOR."Uploads".DIRECTORY_SEPARATOR.$date;


        if(!is_dir($basepath))
        {
            mkdir($basepath);
        }
        $filename = rand(1000,9999).".".$ext;
        $destfile = $basepath.DIRECTORY_SEPARATOR.$filename;

        move_uploaded_file($_FILES['photo']['tmp_name'], $destfile);
        $logo = "/07010/0701/Uploads/".$date."/".$filename;
        $user =D('user');
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
        var_dump($userhandle->getUserByUname($uname));
    }

    function vcode()
    {
        $vcode = new Ucai\Verifycode();
        $vcode->main();
    }

    function info()
    {
        $user= M('Blog_user');
        $data = $user->where("uid=".cookie('uid'))->find();
        $this->assign('data',$data);
        $this->display();
    }

    function uploadlogotp()
    {
        $this->display();
    }
    function  uploadtp()
    {
        $upload = new \Think\Upload();
        $upload->maxSize = 3145728;
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
        $upload->rootPah = '/Uploads/';
        $upload->savePath = '';
        $info = $upload->upload();
        $ret = false;
        if (!empty($info)) {
            $logo = "/07010/0701/Uploads/" . $info['photo']['savepath'] . "/" . $info['photo']['savename'];
            $user = D('User');
            $ret = $user->updatelogo(cookie('uid'), $logo);
        }
        if (!$ret) {
            $this->error($upload->getError());
        } else {
            $this->success('上传成功!', '', 3);
        }
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

    function qiniuok()
    {
            $ret =$_REQUEST['upload_ret'];
            $ret= base64_decode($ret);
            $cbody =json_decode($ret,true);
//        $this->getToken();
            $domain = "oa8gaccno.bkt.clouddn.com";
            $filename = $cbody['key'];
            $logo = "http://".$domain."/".$filename;
            $user = D('User');
            $ret = $user->updateLogo(cookie('uid'),$logo);
            if($ret)
            {
                $this->success("更新成功");
            }
            else{
                $this->error("更新失败");
            }
            exit;
    }

}