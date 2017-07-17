<?php
date_default_timezone_set('PRC');
?>
<!DOCTYPE html>
<html><head lang="zh"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>MC技术联盟——<?php echo $page['title'];?></title>
	<meta name="keywords" content="mc技术联盟,工具箱">
	<meta name="description" content="在这里有许多有用的小工具" />
    <script src="dist/js/jquery.min.js"></script>
    <meta name="toTop" content="true">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
	<!-- Loading Bootstrap -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">
	<link href="dist/css/bootstrap-material-design.css" rel="stylesheet">
	<link href="dist/css/ripples.min.css" rel="stylesheet">
	
	<link rel="stylesheet" href="dist/css/font-awesome.min.css" type="text/css" media="all" />
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
<body style="padding-top: 80px;">

<div class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="javascript:void(0)">Phar</a>
		</div>
		<div class="navbar-collapse collapse navbar-responsive-collapse">
			<ul class="nav navbar-nav">
				<li><a href="index.php">首页</a></li>
				<li><a href="http://mcleague.xicp.net">论坛</a></li>
			</ul>
		</div>
	</div>
</div>
<div class="container-fluid">
<div class="col-xs-12" id="main_page">
<div class="well bs-component" id="dropbox">