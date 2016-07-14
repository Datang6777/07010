<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog管理后台</title>
    <link rel="stylesheet" href="/07010/0701/Public/css/reset.css">
    <link rel="stylesheet" href="/07010/0701/Public/css/admin/init.css">
    <style>
        body{
            margin: 0;
        }
        .divheader{
            background:#0080ff;
            color:white;
        }
        .nav{
            list-style-type:none;
            clear:both;
        }
        .nav li{
            float:right;
            width:100px;
            height:30px;

        }
        .divmain{
            clear:both;
            margin-left:100px;
        }
    </style>
    <script type="text/javascript" src="/07010/0701/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/07010/0701/Public/js/admin_menu.js"></script>
</head>
<body>
<div class="divheader">
    <div class="logo">
        Blog系统管理后台
    </div>
    <div class="user">
        您好,超级管理员 admin
    </div>
    <div class="divnav">
        <ul class="nav">
            <li><a href="<?php echo U('admin/cate/index');?>">分类管理</a></li>
            <li><a href="<?php echo U('admin/article/index');?>">文章管理</a></li>
            <li><a href="<?php echo U('admin/tag/index');?>">标签管理</a></li>
            <li><a href="<?php echo U('admin/system/index');?>">系统管理</a></li>
        </ul>
    </div>
</div>

            <?php if( $uid > 0 ): ?><div class="divlogin">
                    <a href="<?php echo U('Admin/User/info');?>"><?php echo ($uname); ?></a>
                    &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo U('Admin/User/logout');?>">退出</a>
                </div>
                <?php else: ?>
                <div class="divlogin">
                    <a href ="<?php echo U('Admin/User/login');?>">登陆</a>
                    &nbsp;&nbsp;&nbsp;<a href ="<?php echo U('Admin/User/reg');?>">注册</a>
                </div><?php endif; ?>

<!-- banner -->
<?php
header('Content-type:text/html;charset=utf-8'); ?>

<html>
<head>
    <link rel="stylesheet" href="">

</head>
<style type="text/css">
    .main{
        text-align: center;
    }
    .vcode{
        height:50px;
    }
    </style>
<body>

<center>
    <img src="" class="logo">
    <form action="<?php echo U('Admin/User/reg_submit');?>" method="POST">
        用户名 <input type="text" name="uname" placeholder="用户名"><br>
        密码 <input type="password" required  name="password" placeholder="密码"><br>
        确认密码 <input type="password" required  name="password1" placeholder="确认密码"><br>
        邮箱<input type="email" name="email" required   placeholder="邮箱"><br>
        手机号 <input type="text" pattern="1[3|4|5|7|8]\d{9}" name="mobile"  required  placeholder="请输入手机号"><br>
        性别<input type="radio" name="gender" value="男" checked="checked"/>男
        <input type="radio" name="gender" value="女"/>女
        <input type="radio" name="gender" value=""/>保密
        <input type="checkbox" name="" value="1" />我同意注册信息
        <div>
            <label for="vcode">验证码</label>
            <input type="text"  required id="vcode" name="vcode" value=""/>
            <img class="vcode"  src="<?php echo U('Admin/User/vcode');?>" />

        </div>
        <input type="reset" value="重置">
        <input type="submit" value="注册">
    </form>
</center>

</body>
</html>
<!-- content end -->
</div>
<script type="text/javascript">
    $(function(){
        $('.cate-list li:even').css({background:'#fff'});
        $('.cate-list li:odd').css({background:'#ddd'});


        //标签选择
        $('input[name=but]').on('click' , function(){
            var sval = $('select[name=tags] option:selected').val();
            var stext = $('select[name=tags] option:selected').text();

            var html = '<div class="tag-list">'+stext+' <input type="hidden" name="tids[]" value='+sval+'><span>X</span></div>';
            var i = 0;

            $('#tags input').each(function(){
                if($(this).val() == sval)
                {
                    i++;
                    return false;
                }
            });

            if(i == 0)
            {
                $('.clear').before(html);
            }else{
                alert('当前标签已经被选中!');
            }
        });

        $('#tags').on( 'click' , 'span' ,function(){
            $(this).parent().remove();
        });

    });




</script>
</body>
</html>