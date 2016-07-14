<?php
namespace Vendor\Ucai;

class Verifycode
{
    function generateCode($code)
    {
        $font = ROOT_PATH.'//msyh.ttf';
        $w = 200;
        $h = 100;
        //在内存里创建一个绘图区域
        $img = imagecreate(200, 100);

        //分配一个背景颜色
        $bgcolor = imagecolorallocate($img, rand(150, 255), rand(150, 255), rand(150, 255));
        //填充背景，区域填充
        imagefilledrectangle($img, 0, 0, 200, 100, $bgcolor);

        //绘制干扰直线
        //再生成其它颜色
        $linecolor = imagecolorallocate($img, rand(0, 150), rand(0, 150), rand(0, 150));
        //在内存画布里绘制一条直线
        for ($i = 0; $i < 6; $i++) {
            imageline($img, rand(0, $w), rand(0, $h), rand(0, $w), rand(0, $w), $linecolor);
        }

//分配文本颜色
        $textcolor = imagecolorallocate($img, rand(0, 150), rand(0, 150), rand(0, 150));
//绘制验证码
        for ($i = 0; $i < mb_strlen($code, 'utf-8'); $i++) {
            $x = $w / mb_strlen($code, 'utf-8');
            //用truetype或者freetype字体绘制，支持更多效果
            imagettftext($img, 25, rand(-25, 25), $x * $i, 55 + rand(-10, 10), $textcolor, $font, mb_substr($code, $i, 1, 'utf-8'));
            // imagettftext($img,25,30,20,50,$textcolor,$font,'php');
        }

//绘制干扰雪花
        for ($i = 0; $i < 10; $i++) {
            //验证码code，用系统字体绘制
            imagestring($img, 5, rand(0, $w), rand(0, $h), '*', $textcolor);

        }

        //把图片输出到浏览器
        imagepng($img);

        //释放图片占用的内存空间
        imagedestroy($img);
    }

// generateCode('php');

    function getCode()
    {
        $str = "abcdefghijkmnpqrstuvwsy3456789";
        $code = "";
        for ($i = 0; $i < 5; $i++) {
            $code .= $str[rand(0, strlen($str) - 1)];
        }
        return $code;
    }

    function main()
    {
//开启session
        session_start();

        //  header('Content-Type:text/html;charset=utf-8');

        header('Content-Type:image/png');
        //智能验证码
// $code = getCode();
        $codearr = array('2加三=' => '5', '1年多少个月' => '12');
        $code = array_rand($codearr);
        $vcode = $codearr[$code];

//写入图片的是key
        $this->generateCode($code);
//需要用户提交的是value
        $_SESSION['vcode'] = $vcode;

    }
    /*
    // 普通验证码
    $code = getCode();
    //验证码保存到服务器端，不能发送给浏览器
    $_SESSION['vcode'] = $code;
    generateCode($code);
    */
}
?>