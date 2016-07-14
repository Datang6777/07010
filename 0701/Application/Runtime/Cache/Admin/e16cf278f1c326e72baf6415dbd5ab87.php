<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog管理后台</title>
    <link rel="stylesheet" href="/0701/Public/css/reset.css">
    <link rel="stylesheet" href="/0701/Public/css/admin/init.css">
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
    <script type="text/javascript" src="/0701/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/0701/Public/js/admin_menu.js"></script>
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
<form method="post" action="<?php echo U('admin/article/add_submit');?>">
    <div>
       <span>
           <label for="title">文章名</label>
       </span>
        <span>
            <input id="title" required name="title" value=""/>
        </span>
    </div>
    <div>
        <span>
            <label for="author">作　者</label>
        </span>
        <span>
            <input id="author" name="author" value=""/>
        </span>
    </div>
    <div>
        <span>
            <label for="content">内　容</label>
        </span>
        <span>
            <textarea  id="content" name="content" rows="10" cols="35" ></textarea>
        </span>
    </div>
    <div>
        <span>
            <label for="order">排序号</label>
        </span>
        <span>
            <input id="order" name="order" value="">
        </span>
    </div>
    <div>
        <span>
            <label for="parent">文章分类</label>
        </span>
        <span>
            <select id="parent" name="cid">
                <option value="0">无</option>
                <?php if(is_array($catelist)): $i = 0; $__LIST__ = $catelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cate['cid']); ?>"><?php echo ($cate['cate_name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </span>
    </div>
    <div>
        <span>
            <label for="shown1">是否显示</label>
        </span>
        <span>
            <input type="radio" id="shown1" name="shown" value="1">是
            <input type="radio" id="shown2" name="shown" value="0">否
        </span>
    </div>
    <div>
        <input type="submit" value="提交">
    </div>

</form>