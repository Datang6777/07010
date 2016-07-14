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

<form action="<?php echo U('Admin/User/upload');?>" enctype="multipart/form-data" method="POST">
	<label for="photo">头像</label>
	<input id="photo" type="file" name="photo"/>
	<input type="submit" value="提交">
</form>
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