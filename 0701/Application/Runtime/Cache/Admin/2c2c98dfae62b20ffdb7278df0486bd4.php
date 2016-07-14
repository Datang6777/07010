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
    <h1 style="background-color: #CCC;">系统管理</h1>