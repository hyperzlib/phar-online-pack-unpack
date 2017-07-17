<?php
/*if(!file_exists('.time') || intval(file_get_contents('.time')) <= time() - 120){
	include('autoclean.php');
}*/
$page = array();
$page['title'] = '打包/解包Phar';
include('head.php');
?>

<script language="javascript">
var fileid=1;
</script>
<form method="post" class="form-horizontal" enctype="multipart/form-data" id="uploadform" onsubmit="return false;">
	<div class="form-inline">
		<input id="lefile" type="file" name="file" style="display:none" multiple="multiple" />
		&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary btn-raised withripple" id="addfile"><i class="fa fa-plus"></i> | 添加文件</a> 
		<label>或拖动文件到此处上传</label>
		<a class="btn btn-default btn-raised" id="downloadall" style="display: none;"><i class="fa fa-download"></i> | 全部下载</a><label id="downloadtext"></label>
	</div>
	<div class="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" id="high-speed" checked>  高速模式(无打包进度显示)</label></div>
	&nbsp;&nbsp;&nbsp;&nbsp;<small>文件将仅在服务器上保留10分钟，请尽快下载</small>
	<br />
	<br />
</form>
<table class="table table-hover">
	<thead>
		<tr>
			<td class="hidden-xs">#</td>
			<td style="min-width:30%; overflow:hidden">文件名</td>
			<td>进度</td>
			<td>状态</td>
		</tr>
	</thead>
	<tbody id="filelist">
		<tr id="file1" style="display:none">
			<td id="id" class="hidden-xs">1</td>
			<td id="filename" style="min-width:30%; overflow:hidden">文件名</td>
			<td id="progress">
				<div class="progress">
					<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progressbar">
						<span class="sr-only"></span>
					</div>
				</div>
			</td>
			<td id="status"><p class="bg-info">上传中……</p></td>
		</tr>
	</tbody>
	<script type="text/javascript" src="dist/js/main.js"></script>
</table>
<br />
<?php
include('foot.php');