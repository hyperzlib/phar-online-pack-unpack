<?php
$baseurl = 'api.php?mode=view&id='.$_GET['id'];
if(file_exists('cache/'.$_GET['id'].'.phar')){
	$basedir = 'phar://cache/'.$_GET['id'] . '.phar/';
} else {
	header('Location: /');
}
if(isset($_GET['path'])){
	$dir = $basedir . $_GET['path'];
} else {
	$dir = $basedir;
}

$path = explode('/', str_replace(str_replace('\\', '/', $basedir), '', str_replace('\\', '/', $dir)));
$files = [];
if(is_dir($dir)){
	$page = array();
	$page['title'] = '浏览Phar';
	include('head.php');
	foreach(new RecursiveDirectoryIterator($dir) as $file){
		$files[] = str_replace(str_replace('\\', '/', $basedir), '', str_replace('\\', '/', $file));
	}
?>
<ol class="breadcrumb">
  <li><a href="<?php echo $baseurl; ?>">root</a></li>
<?php 
  $count = count($path);
  $url = '';
  $i = 1;
  foreach($path as $one){
	  $url .= '/' . $one;
	  if($i != $count){
		echo '  <li><a href="'.$baseurl.'&path='.ltrim($url, '/').'">'.$one.'</a></li>';
	  } else {
		echo '  <li class="active">'.$one.'</li>';
	  }
	  echo "\n";
	  $i++;
  }
  ?>
</ol>
<?php
foreach($files as $file){
	if(is_dir($basedir.$file)){
?><div class="col-md-2 col-sm-4 col-xs-6 col-lg-2">
	<?php
		echo '	<a href="'.$baseurl.'&path='.ltrim($file).'" class="btn btn-block btn-primary btn-raised">'.basename($file).'</a>';?>
</div><?php
	}
}
?>
<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
<br />
</div>
<style>
.wrap{
	margin-top: 5px;
	display: table-cell;
	vertical-align: middle;
}
</style>
<div class="btn-group btn-group-justified btn-group-vertical">
<?php
foreach($files as $file){
	if(!is_dir($basedir.$file)){
?><div class="col-md-2 col-sm-4 col-xs-6 col-lg-2">
	<?php
		echo '	<a href="'.$baseurl.'&path='.ltrim($file).'" class="btn btn-block btn-lg btn-default btn-raised"><div><i class="fa fa-file-code-o fa-4x"></i></div><div class="wrap">'.basename($file).'</div></a>';?>
</div><?php
	}
}
?>
</div>
<?php
	include('foot.php');
} elseif(preg_match('/(\.php|\.txt|\.md|\.json|\.yml|\.)$/', $dir) && !isset($_GET['download'])){
	$page = array();
	$page['title'] = '查看文件';
	include('head.php');
	?>
<div class="panel panel-primary">
  <div class="panel-heading"><?php echo basename($dir);?> | <a class="btn btn-default btn-raised" onclick="window.location.href=window.location.href+'&download';"><i class="fa fa-download"></i> 下载文件</a></div>
  <div class="panel-body">
  <ul class="list-group">
  <ol class="breadcrumb">
  <li><a href="<?php echo $baseurl; ?>">root</a></li>
	<?php 
	  $count = count($path);
	  $url = '';
	  $i = 1;
	  foreach($path as $one){
		  $url .= '/' . $one;
		  if($i != $count){
			echo '  <li><a href="'.$baseurl.'&path='.ltrim($url, '/').'">'.$one.'</a></li>';
		  } else {
			echo '  <li class="active">'.$one.'</li>';
		  }
		  echo "\n";
		  $i++;
	  }
	  ?>
	</ol><br />
	<style>
	code{
		background-color: #fff;
	}
	pre{
		background-color: #fff;
	}
	</style>
	<pre>
	<?php
	if(preg_match('/\.php$/', $dir)){
		echo rtrim(highlight_file($dir), '1');
	} else {
		readfile($dir);
	}
	?>
	</pre>
  </div>
</div>
	<?php
	include('foot.php');
} else {
	header('Content-Type:application/zip'); //发送指定文件MIME类型的头信息
	header('Content-Disposition:attachment; filename="'.basename($dir).'"'); //发送描述文件的头信息，附件和文件名
	header('Content-Length:'.filesize($dir)); //发送指定文件大小的信息，单位字节
	readfile($dir);
}
?>