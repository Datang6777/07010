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
        $this->success("�˳��ɹ�");
        exit;
    }

    public function login_submit(){
        $value = I('post.uname');
        $handle = D('User');
        $userinfo = null;
//        $vcode = I('post.vcode');
//        session_start();
//        if($vcode != $_SESSION['vcode']) {
//            $this->error("��֤�����");
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
            $this->success("��¼�ɹ�",U('Index/info'));
        } else{
            $this->error("��¼ʧ�ܣ�");
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
            $this->error("��֤�����");
            exit;
        }
        if(!$uname || !$email || !$mobile)
        {
            $this->error("���ǲ����ĸ�������д�ˣ��ף�",'',10);
            exit;
        }
        $password = I('post.password');
        $password1 = I('post.password1');
        if($password!=$password1)
        {
            $this->error("���������������һ��Ŷ��",'',10);
            exit;
        }
        $gender = I('post.gender');

        $user_handle = D("User");
        $ret = $user_handle->addUser($uname, $password, $email, $mobile,$gender,$regip);
        if($ret)
        {
            $this->success("ע��ɹ���");
        }
        else{
            $this->error("ע��ʧ�ܣ�");
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
        //ȡ���ļ��ĸ�������Ϣ
        $parts = pathinfo($_FILES['photo']['name']);
        //ȡ���ļ�����չ��
        $ext = $parts['extension'];
        //�������ڣ�ȷ��ǰ��һ��
        $date = date("Ymd");
        //�ϴ����ļ����ڵ�Ŀ¼
        $basepath = ROOT_PATH.DIRECTORY_SEPARATOR."Uploads".DIRECTORY_SEPARATOR.$date;
        //���Ŀ¼�������򴴽�Ŀ¼
        if(!is_dir($basepath)) {
            mkdir($basepath); //mkdir -p
        }
        //�����ļ���
        $filename = rand(10000000,99999999).".".$ext;
        $destfile = $basepath.DIRECTORY_SEPARATOR.$filename;
        //����ʱ�ļ�������ʽ�ϴ�Ŀ¼
        move_uploaded_file($_FILES['photo']['tmp_name'],$destfile);

        //���� Vendor�е��ϴ���װ
        $uploader = new Ucai\QiniuUploader();
        $logo = $uploader->upload($destfile);
        $ret = 0;
        if($logo) {
            $user = D('User');
            //���µ����ݿ�
            $ret = $user->updateLogo(cookie('uid'), $logo);
        }
        if($ret)
        {
            $this->success("���³ɹ�");
        }
        else
        {
            $this->error("����ʧ��");
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
        //ȡ���ļ��ĸ�������Ϣ
        $parts = pathinfo($_FILES['photo']['name']);
        //ȡ���ļ�����չ��
        $ext = $parts['extension'];
        //�������ڣ�ȷ��ǰ��һ��
        $date = date("Ymd");
        //�ϴ����ļ����ڵ�Ŀ¼
        $basepath = ROOT_PATH.DIRECTORY_SEPARATOR."Uploads".DIRECTORY_SEPARATOR.$date;
        //���Ŀ¼�������򴴽�Ŀ¼
        if(!is_dir($basepath)) {
            mkdir($basepath); //mkdir -p
        }
        //�����ļ���
        $filename = rand(10000000,99999999).".".$ext;
        $destfile = $basepath.DIRECTORY_SEPARATOR.$filename;
        //����ʱ�ļ�������ʽ�ϴ�Ŀ¼
        move_uploaded_file($_FILES['photo']['tmp_name'],$destfile);
        //�����ϴ����URL
        $logo = "/07010/0701/Uploads/".$date."/".$filename;
        $user = D('User');
        //���µ����ݿ�
        $ret = $user->updateLogo(cookie('uid'),$logo);
        if($ret)
        {
            $this->success("���³ɹ�");
        }
        else
        {
            $this->error("����ʧ��");
        }
        exit;
    }

    function uploadlogotp()
    {
        $this->display();
    }

    function uploadtp()
    {

        $upload = new \Think\Upload();// ʵ�����ϴ���
        $upload->maxSize   =     3145728 ;// ���ø����ϴ���С
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// ���ø����ϴ�����
        $upload->rootPath  =     './Uploads/'; // ���ø����ϴ���Ŀ¼
        $upload->savePath  =     ''; // ���ø����ϴ����ӣ�Ŀ¼(Y-m-d)
        // �ϴ��ļ�
        $info   =   $upload->upload();

        print_r($info);
        $ret = false;
        if(!empty($info)) {
            //�����ϴ����URL
            $logo = "/Uploads/" . $info['photo']['savepath'] . "/" . $info['photo']['savename'];
            $user = D('User');
            //���µ����ݿ�
            $ret = $user->updateLogo(cookie('uid'), $logo);
        }
        if(!$ret) {// �ϴ�������ʾ������Ϣ
            $this->error($upload->getError());
        }else{// �ϴ��ɹ�
            $this->success('�ϴ��ɹ���','',10);
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
        //���µ����ݿ�
        $ret = $user->updateLogo(cookie('uid'),$logo);
        if($ret)
        {
            $this->success("���³ɹ�");
        }
        else
        {
            $this->error("����ʧ��");
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
