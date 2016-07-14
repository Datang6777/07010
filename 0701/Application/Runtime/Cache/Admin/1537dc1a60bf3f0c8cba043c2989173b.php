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
    <h1>分类管理</h1>
<hr />
<a href="<?php echo U('admin/cate/add');?>">添加</a>
<hr />
<table border="1" width="80%">
    <tr>
        <td>编号</td>
        <td>父类别</td>
        <td>分类名称</td>
        <td>排序号</td>
        <td>显示</td>
        <td>操作</td>
    </tr>
    <?php if(is_array($catelist)): $i = 0; $__LIST__ = $catelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($cate['cid']); ?></td>
            <td><?php echo ($cate['pate_name']); ?></td>
            <td><?php echo ($cate['cate_name']); ?></td>
            <td><?php echo ($cate['ord']); ?></td>
            <td><?php echo ($cate['is_show']?"是":"否"); ?></td>
            <td>
                <a href="<?php echo U('admin/cate/update',array('cid'=>$cate['cid']));?>">修改</a>
                <a href="<?php echo U('admin/cate/delete',array('cid'=>$cate['cid']));?>">删除</a>
            </td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>

</table>