<?php
/**
 * Created by PhpStorm.
 * User: sks
 * Date: 2016/7/11
 * Time: 16:12
 */

namespace Home\Model;
use Think\Model;

class UserModel extends  Model{
    protected $handle;

    function __construct()
    {
        $this->handle = M('BlogUser');  //qz_blog_user qz_=prefix  blog_user BlogUser
    }

    function getPassword($password,$salt)
    {
        return md5($password."#xdskkjad&*^^(*#".$salt);
    }
    function addUser($uname, $password, $email,$mobile,$gender,$regip)
    {
        $ctime = time();
        $salt = rand(100000,999999);
        $password = $this->getPassword($password,$salt);

        $data = array(
            "uname"=>$uname,
            "passwd"=>$password,
            "email"=>$email,
            "mobile"=>$mobile,
            "gender"=>$gender,
            "regip"=>$regip,
            "ctime"=>$ctime,
            "salt"=>$salt
        );

        return $this->handle->data($data)->add();
    }
    function checkPassword($uid,$pass)
    {
        $userinfo = $this->getUserByUid($uid);
        $salt = $userinfo['salt'];
        $dbpass = $userinfo['passwd'];

        if($dbpass == $this->getPassword($pass,$salt))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function changePassword($uid,$newpass)
    {
        $data['uid']=$uid;
        $salt = rand(100000,999999);
        $data['passwd']=$this->getPassword($newpass,$salt);
        $data['salt'] = $salt;
        $map['uid']=array("eq",$uid);
        return $this->handle->where($map)->data($data)->save();
    }
    function updateLogo($uid,$logo)
    {
        $data['logo']=$logo;
        $map['uid']=array("eq",$uid);
        return $this->handle->where($map)->data($data)->save();
    }
    function getUserByUid($uid)
    {
        return $this->handle->where("uid=".intval($uid))->find();
    }
    function getUserByEmail($email)
    {
        $map['email'] = array('eq', $email);
        return $this->handle->where($map)->find();
    }
    function getUserByMobile($mobile)
    {
        $map['mobile'] = array('eq', $mobile);
        return $this->handle->where($map)->find();
    }
    function getUserByName($uname)
    {
        $map['uname'] = array('eq', $uname);
        return $this->handle->where($map)->find();
    }

}