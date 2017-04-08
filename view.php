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
<ul class="list-group">
<?php
foreach($files as $file){
	if(is_dir($basedir.$file)){
		echo '	<a href="'.$baseurl.'&path='.ltrim($file).'" class="list-group-item active">'.basename($file).'</a>';
	} else {
		echo '	<a href="'.$baseurl.'&path='.ltrim($file).'" class="list-group-item">'.basename($file).'</a>';
	}
}
?>
</ul>
<?php
} elseif(preg_match('/(\.php|\.txt|\.md|\.json|\.)$/', $dir)){
	$page = array();
	$page['title'] = '查看文件';
	include('head.php');
	?>
<div class="panel panel-primary">
  <div class="panel-heading"><?php echo basename($dir);?></div>
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
	<?php
	if(preg_match('/\.php$/', $dir)){
		echo rtrim(highlight_file($dir), '1');
	} else {
		readfile($dir);
	}
	?>
	  </div>
</div>
	<?php
} else {
	header('Content-Type:application/zip'); //发送指定文件MIME类型的头信息
	header('Content-Disposition:attachment; filename="'.basename($dir).'"'); //发送描述文件的头信息，附件和文件名
	header('Content-Length:'.filesize($dir)); //发送指定文件大小的信息，单位字节
	readfile($dir);
}
?>