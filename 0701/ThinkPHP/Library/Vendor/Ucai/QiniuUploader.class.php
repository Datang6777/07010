<?php
/**
 * Created by PhpStorm.
 * User: ll
 * Date: 2016/7/13
 * Time: 11:29
 */
namespace Vendor\Ucai;
require_once ROOT_PATH."/qiniu/autoload.php";
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

define("QINIU_ACCESS_KEY","BcCV8JT8_bLwzhjLp-O6_LpeR-VmBRYilFZgtkrP");
define("QINIU_SECRET_KEY","MzvPZff2unCN4pcv6aOTVAEImzrgJL0DPkCVQZ9E");
define("QINIU_BUCKET","datang");
class QiniuUploader{
    private  $token;
    private $uploadMgr;
    function __construct()
    {
        //������֤���� Authorize
        $auth = new Auth(QINIU_ACCESS_KEY, QINIU_SECRET_KEY);

        // �ռ���  http://developer.qiniu.com/docs/v6/api/overview/concepts.html#bucket
        $bucket = QINIU_BUCKET;

        // �����ϴ�Token
        $this->token = $auth->uploadToken($bucket);
    }
    public function getToken()
    {
        //������֤���� Authorize
        $auth = new Auth(QINIU_ACCESS_KEY, QINIU_SECRET_KEY);

        // �ռ���  http://developer.qiniu.com/docs/v6/api/overview/concepts.html#bucket
        $bucket = QINIU_BUCKET;

        $policy = array(
            //�ϴ����֮�󣬰���Ϣ������
            'returnUrl' => 'http://localhost/07010/0701/Home/User/qiniuok',
            'returnBody' => '{"fname": $(fname),  "size": $(fsize),  "key": $(key)}',

        );
        $upToken = $auth->uploadToken($bucket, null, 3600, $policy);
        echo  $upToken;
        exit;
    }
    public function upload($filename)
    {
        $this->uploadMgr = new UploadManager();
        $key = basename($filename);
        list($ret,$err) = $this->uploadMgr->putFile($this->token,$key,$filename);
        if($err)
        {
            var_dump($err);
        }else{
            return "http://oa8gaccno.bkt.clouddn.com"."/".$ret['key'];
        }
    }
}

