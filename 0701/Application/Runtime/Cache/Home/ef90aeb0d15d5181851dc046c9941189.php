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
<div class="header">
    <div class="head-content">
        <div class="logo">DaTang</div>
        <div class="search">
            <form action="" method="post">
                <input type="text" name="search" placeholder="PHP"><input type="button" value="搜 索">
            </form>
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
<!-- banner -->
<div class="banner shadow two-nav">
    首页 > <a href="list.html">神技能</a> > PHP是最火的语言吗?
</div>
<!-- banner end -->
<!-- content -->
<div class="content clear">
    <!-- content left -->
    <div class="list-right clear">
        <div class="right shadow f-right no-bor">
            <p class="title">
                <span>相关文章/Article</span>
            </p>
            <div class="cont-box">
                <ul>
                    <li>
                        <span class ="top">top</span>
                        <a href="#">DIV + CSS布局的技巧分享</a>
                    </li>
                    <li>
                        <span class ="hot">hot</span>
                        <a href="#">DIV + CSS布局的技巧分享</a>
                    </li>
                    <li>
                        <span class ="new">new</span>
                        <a href="#">DIV + CSS布局的技巧分享</a>
                    </li>
                    <li><a href="#">DIV + CSS布局的技巧分享</a></li>
                    <li><a href="#">DIV + CSS布局的技巧分享</a></li>
                    <li><a href="#">DIV + CSS布局的技巧分享</a></li>
                    <li><a href="#">DIV + CSS布局的技巧分享</a></li>
                    <li><a href="#">DIV + CSS布局的技巧分享</a></li>
                    <li><a href="#">DIV + CSS布局的技巧分享</a></li>

                </ul>
            </div>
        </div>

        <div class="left shadow f-right">
            <p class="title">
                <span>标签云/Tags</span>
            </p>
            <div class="cont-box">
                <?php include 'public/tags.php'; ?>
            </div>
        </div>

    </div>


    <!-- content left end -->
    <!-- content center -->

    <div class="center shadow list-center">

        <div class="cont-box">

            <p class="show-title">
                <a href="#"><?php echo ($article['title']); ?></a>
            </p>
            <p class="show-state">
                更新时间 :<?php echo (date("Y-m-d",$article['update_time'])); ?> 作者 : <?php echo ($article['author']); ?> 分类 :  <?php echo ($article['cate']); ?> 浏览 :
                <?php echo ($article['clicks']); ?>
            </p>
            <p class="show-content">
                <?php echo ($article['content']); ?>
            </p>

            <div class="show-page">
                <p>上一篇 : 没有了</p>
                <p>
                    下一篇 : <a href="#">对方不想跟你说话,并向你推荐了世界上最好的语言 --- PHP</a>
                </p>
            </div>
        </div>
    </div>
    <!-- content center end -->

</div>
<!-- content end -->
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