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

<!-- banner -->
<div class="banner shadow">

    <!-- player -->
    <div id="fsD1" class="focus" >
        <div id="D1pic1" class="fPic">
            <div class="fcon" style="display: none;">
                <a target="_blank" href="#"><img src="/07010/0701/Public/images/01.jpg" style="opacity: 1; "></a>
                <span class="shadow"><a target="_blank" href="#">这里展示轮播图的效果</a></span>
            </div>

            <div class="fcon" style="display: none;">
                <a target="_blank" href="#"><img src="/07010/0701/Public/images/02.jpg" style="opacity: 1; "></a>
                <span class="shadow"><a target="_blank" href="#">佟大为登封面表情搞怪 成熟男人也是天真男孩</a></span>
            </div>

            <div class="fcon" style="display: none;">
                <a target="_blank" href="#"><img src="/07010/0701/Public/images/03.jpg" style="opacity: 1; "></a>
                <span class="shadow"><a target="_blank" href="#">21岁出柜超模巴厘自曝搞笑全裸照</a></span>
            </div>

            <div class="fcon" style="display: none;">
                <a target="_blank" href="#"><img src="/07010/0701/Public/images/04.jpg" style="opacity: 1; "></a>
                <span class="shadow"><a target="_blank" href="#">金喜善出道21年 皮肤白皙越长越“嫩”！</a></span>
            </div>
        </div>
        <div class="fbg">
            <div class="D1fBt" id="D1fBt">
                <a href="javascript:void(0)" hidefocus="true" target="_self" class=""><i>1</i></a>
                <a href="javascript:void(0)" hidefocus="true" target="_self" class=""><i>2</i></a>
                <a href="javascript:void(0)" hidefocus="true" target="_self" class="current"><i>3</i></a>
                <a href="javascript:void(0)" hidefocus="true" target="_self" class=""><i>4</i></a>
            </div>
        </div>
        <span class="prev"></span>
        <span class="next"></span>
    </div>
    <!-- player end -->

</div>
<!-- banner end -->

<!-- floor -->
<div class="banner shadow two-nav">
    <span class="floor">F1</span> - 前端的优雅
</div>
<!-- floor end -->

<!-- content -->
<div class="content clear">
    <!-- content left -->
    <div class="left shadow">
        <p class="title">
            <span>标签云/Tags</span>
        </p>
        <div class="cont-box">
            <?php if(is_array($tags)): $i = 0; $__LIST__ = $tags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?><a href="list.php?tid=<?php echo ($t['tid']); ?>">
                   <?php echo ($t['tag_name']); ?>
                    &nbsp;&nbsp;<small>&nbsp;<?php echo ($t['count']); ?></small>
                </a><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <!-- content left end -->
    <!-- content center -->
    <div class="center shadow">
        <p class="title">
            <span>最新更新/News</span>
        </p>
        <div class="cont-box">
            <ul>

                <?php if(is_array($new)): foreach($new as $key=>$vo): ?><li><a href="<?php echo U('home/index/show');?>?aid=<?php echo ($vo["aid"]); ?>"><?php echo (getSubTitle($vo["title"])); ?></a><span>
                        <?php echo (date("Y-m-d",$vo["update_time"])); ?></span>
                    </li><?php endforeach; endif; ?>
            </ul>

            <p class="more"><a href="<?php echo U('home/index/show');?>">More>>></a></p>
        </div>
    </div>
    <!-- content center end -->
    <!-- content right -->
    <div class="right shadow">
        <p class="title">
            <span>神技能/Get</span>
        </p>
        <div class="cont-box">

            <ul>
                <?php if(is_array($get)): $i = 0; $__LIST__ = $get;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$g): $mod = ($i % 2 );++$i;?><li>

                    <?php if($g['top'] == 1): ?><span class ="top">top</span><?php endif; ?>
                    <?php if($g['good'] == 1): ?><span class ="hot">hot</span><?php endif; ?>
                    <a href="show.php?aid=<?php echo ($g['aid']); ?>">
                        <?php echo (getSubTitle($g['title'],15)); ?></a>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>

            <p class="more"><a href="list.html">More>>></a></p>
        </div>
    </div>
    <!-- content right end -->
</div>
<!-- content end -->

<!-- floor -->
<div class="banner shadow two-nav">
    <span class="floor">F2</span> - 编程语言的魅力
</div>
<!-- floor end -->

<!-- content -->
<div class="content clear">
    <!-- content left -->
    <div class="left shadow">
        <p class="title">
            <span>标签云/Tags</span>
        </p>
        <div class="cont-box">
            <a href="javascript:void(0)">PHP</a>
            <a href="javascript:void(0)">HTML</a>
            <a href="javascript:void(0)">CSS</a>
            <a href="javascript:void(0)">Linux</a>
            <a href="javascript:void(0)">MySQL</a>
            <a href="javascript:void(0)">Node.js</a>
            <a href="javascript:void(0)">Javascript</a>
            <a href="javascript:void(0)">JQuery</a>
            <a href="javascript:void(0)">图片轮播</a>
            <a href="javascript:void(0)">网页欣赏</a>
            <a href="javascript:void(0)">PhotoShop</a>
            <a href="javascript:void(0)">UI</a>
            <a href="javascript:void(0)">UE</a>
        </div>


    </div>
    <!-- content left end -->
    <!-- content center -->
    <div class="center shadow">
        <p class="title">
            <span>最新更新/News</span>
        </p>
        <div class="cont-box">
            <ul>
                <li><a href="#">PHP是最火的语言吗?</a><span>2016-05-11</span></li>
                <li><a href="#">PHP是最火的语言吗?</a><span>2016-05-11</span></li>
                <li><a href="#">PHP是最火的语言吗?</a><span>2016-05-11</span></li>
                <li><a href="#">PHP是最火的语言吗?</a><span>2016-05-11</span></li>
                <li><a href="#">PHP是最火的语言吗?</a><span>2016-05-11</span></li>
                <li><a href="#">PHP是最火的语言吗?</a><span>2016-05-11</span></li>
                <li><a href="#">PHP是最火的语言吗?</a><span>2016-05-11</span></li>
                <li><a href="#">PHP是最火的语言吗?</a><span>2016-05-11</span></li>
                <li><a href="#">PHP是最火的语言吗?</a><span>2016-05-11</span></li>
                <li><a href="#">PHP是最火的语言吗?</a><span>2016-05-11</span></li>
                <li><a href="#">PHP是最火的语言吗?</a><span>2016-05-11</span></li>
            </ul>

            <p class="more"><a href="list.html">More>>></a></p>
        </div>
    </div>
    <!-- content center end -->
    <!-- content right -->
    <div class="right shadow">
        <p class="title">
            <span>神技能/Get</span>
        </p>
        <div class="cont-box">
            <ul>
                <li>
                    <span class ="top">top</span
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
                <li><a href="#">DIV + CSS布局的技巧分享</a></li>
            </ul>

            <p class="more"><a href="list.html">More>>></a></p>
        </div>
    </div>
    <!-- content right end -->
</div>
<!-- content end -->

<!-- floor -->
<div class="banner shadow two-nav">
    <span class="floor">F3</span> - 网页欣赏
</div>
<!-- floor end -->
<!-- content -->
<div class="content clear">
    <!-- photo  -->
    <div class="photo">

        <div class="photo-list shadow">
            <img src="/07010/0701/Public/images/01.jpg">
        </div>
        <div class="photo-list shadow">
            <img src="/07010/0701/Public/images/01.jpg">
        </div>
        <div class="photo-list shadow">
            <img src="/07010/0701/Public/images/01.jpg">
        </div>
        <div class="photo-list shadow">
            <img src="/07010/0701/Public/images/01.jpg">
        </div>

    </div>
    <!-- photo  end -->
</div>
<!-- content end -->
<form action="/07010/0701/index.php/Home/Index/upload" enctype="multipart/form-data" method="post" >
    <input type="text" name="name" />
    <input type="file" name="photo" />
    <input type="submit" value="提交" >
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