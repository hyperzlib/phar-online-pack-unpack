<!DOCTYPE html>
<html><head lang="zh"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>MC技术联盟——<?php echo $page['title'];?></title>
	<meta name="keywords" content="mc技术联盟,工具箱">
	<meta name="description" content="在这里有许多有用的小工具" />
    <!--<link rel="stylesheet" href="/Public/css/style.css"/>-->
    <script src="js/jquery.min.js"></script>
    <meta name="toTop" content="true">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
	<!--<link rel='stylesheet' id='bootstrap-css'  href='css/a/bootstrap.min.css' type='text/css' media='all' />-->
	<link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
	<link rel='stylesheet' id='fontawesome-css'  href='css/a/font-awesome.min.css' type='text/css' media='all' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script language="JavaScript">
        function searchShow(e){
            var search = $(e).parent().find($('.search-text'));
            if(search.hasClass('uk-hidden')){
                search.removeClass('uk-hidden');
            }else{
                search.addClass('uk-hidden')
            }
            return false;
        }
    </script>
	<!--[if lt IE 9]>
  <script src="css/a/modernizr.js"></script>
  <script src="css/a/respond.min.js"></script>
  <script src="css/a/html5shiv.js"></script>
	<![endif]-->



</head>
<body class="archive tag tag-34 tag-34">
<header id="zan-header">
	<!--标题-->
	<div class="header" >
      <h1 style="text-align:center;font-family: 'Microsoft Yahei';"><?php echo $page['title'];?></h1>
    </div>
    <!-- 导航 -->
    <div class="navbar navbar-inverse">
      <div class="container clearfix">
        <div class="navbar-header">
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">下拉框</span>
            <span class="fa fa-reorder fa-lg"></span>
          </button>
        </div>
        <nav class="navbar-collapse collapse">
			<ul id="menu-navbar" class="nav navbar-nav">
				<li id="nvabar-item-index"><a href=".">首页</a></li>
                <li id="nvabar-item-index"><a href="http://mcleague.xicp.net/">论坛</a></li>
				<li id="nvabar-item-index"><a href="http://mcleague.xicp.net/">其他工具</a></li>
			</ul>
		</nav>
      </div>
    </div>
    <!-- 导航结束 -->

</header>
<div id="main_page" class="container">
