<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>博客首页</title>
    <link rel="stylesheet" type="text/css" href="/07010/0701/Public/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/07010/0701/Public/css/global.css">
    <script type="text/javascript" src="/07010/0701/Public/js/Jquery.min.js"></script>
    <script type="text/javascript" src="/07010/0701/Public/js/koala.min.1.5.js"></script>
</head>
<body>
<!--header-->
<style type="text/css">
    .divlogin{
        border: 0;
        margin-left: 520px;
        margin-top: -35px;
        width: 140px;
        height: 34px;
        background-color:#0080ff;
        color:#fff;
        cursor: pointer;
    }
    .divlogin a{
        color:white;
        margin-top: 10px;
        margin-left: 15px;
        margin-right: 15px;
    }
</style>
<div class="header">
    <div class="head-content">
        <div class="logo">DaTang</div>
        <div class="search">
            <form action="" method="post">
                <input type="text" name="search" placeholder="PHP"><input type="button" value="搜 索">
            </form>
            <?php if( $uid > 0 ): ?><div class="divlogin">
                    <a href="<?php echo U('home/User/info');?>"><?php echo ($uname); ?></a>
                    &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo U('Home/User/logout');?>">退出</a>
                </div>
                <?php else: ?>
            <div class="divlogin">
                <a href ="<?php echo U('home/User/login');?>">登陆</a>
                &nbsp;&nbsp;&nbsp;<a href ="<?php echo U('Home/User/reg');?>">注册</a>
            </div><?php endif; ?>
        </div>
    </div>
</div>
<!-- header end -->
<!-- nav -->
<div class="nav">
    <div class="nav-content">
        <ul class="menu">
            <li><a href="<?php echo U('home/index/test');?>">首　页</a></li>
            <?php if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$n): $mod = ($i % 2 );++$i;?><li>
                <a href="<?php echo U('home/index/mylist',array('cid'=>$n['cid']));?>"><?php echo ($n['cate_name']); ?></a>
                <?php if(isset($n['son'])): ?>
                <ul class="nav-menu">
                    <?php foreach($n['son'] as $son): ?>
                    <li><a href="<?php echo U('home/index/mylist',array('cid'=>$son['cid']));?>"><?php echo ($son['cate_name']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
</div>
<!-- nav end -->
<form action="<?php echo U('Home/User/upload');?>" enctype="multipart/form-data" method="POST">
	<label for="photo">头像</label>
	<input id="photo" type="file" name="photo"/>
	<input type="submit" value="提交">
</form>
<!-- footer -->
<div class="footer">
    <div class="foot-content">
        <a href="#">关于我们</a>　|　
        <a href="#">联系我们</a>　|　
        <a href="#">版权声明</a>　|　
        <a href="#">友情链接</a>
        <span><a href="mailto:datang866@163.com">Email : datang866@163.com</a>　　&copy;DaTang</span>
    </div>
</div>
<!-- footer end -->
<!-- to top -->
<div id="to-top" style="display:none">Top</div>
<!-- to top end -->
<script type="text/javascript">
    Qfast.add('widgets', { path: "/07010/0701/Public/js/terminator2.2.min.js", type: "js", requires: ['fx'] });
    Qfast(false, 'widgets', function () {
        K.tabs({
            id: 'fsD1',   //焦点图包裹id
            conId: "D1pic1",  //** 大图域包裹id
            tabId:"D1fBt",
            tabTn:"a",
            conCn: '.fcon', //** 大图域配置class
            auto: 1,   //自动播放 1或0
            effect: 'fade',   //效果配置
            eType: 'click', //** 鼠标事件
            pageBt:true,//是否有按钮切换页码
            bns: ['.prev', '.next'],//** 前后按钮配置class
            interval: 3000  //** 停顿时间
        })
    })
</script>
<script type="text/javascript" src="/07010/0701/Public/js/menu.js"></script>
</body>
</html>