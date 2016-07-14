<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
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
<div class="divmain">
    <h1>标签管理</h1>
<hr />
<a href="<?php echo U('admin/tag/add');?>">添加</a>
<hr />
<table border="1" width="90%">
    <tr>
        <td>编号</td>
        <td>标签名</td>
        <td>点击量</td>
        <td>排序号</td>
        <td>显示</td>
        <td>操作</td>
    </tr>
    <?php if(is_array($taglist)): $i = 0; $__LIST__ = $taglist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tag): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($tag['tid']); ?></td>
            <td><?php echo ($tag['tag_name']); ?></td>
            <td><?php echo ($tag['clicks']); ?></td>
            <td><?php echo ($tag['ord']); ?></td>
            <td><?php echo ($tag['is_show']?"是":"否"); ?></td>
            <td>
                <a href="<?php echo U('admin/tag/update',array('tid'=>$tag['tid']));?>">修改</a>
                <a href="<?php echo U('admin/tag/delete',array('tid'=>$tag['tid']));?>">删除</a>
            </td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>

</table>