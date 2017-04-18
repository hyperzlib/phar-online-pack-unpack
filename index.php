<?php

$page = array();
$page['title'] = '打包/解包Phar';
include('head.php');
?>

<script language="javascript">
var fileid=1;
</script>
<div name="image" id="dropbox" style="min-width:300px;min-height:100px;border:3px dashed silver;"><br />
<form method="post" class="form-horizontal" enctype="multipart/form-data" id="uploadform" onsubmit="return false;">
	<div class="form-inline">
		<input id="lefile" type="file" name="file" style="display:none" multiple="multiple" />
		&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" id="addfile"><i class="fa fa-plus"></i> | 添加文件</a> 
		<label>或拖动文件到此处上传</label>
		<a class="btn btn-primary" id="downloadall" style="display: none;"><i class="fa fa-download"></i> | 全部下载</a><label id="downloadtext"></label>
	</div>
	<br />
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" checked="false" name="high-speed" id="high-speed"></input><label for="high-speed">高速打包模式（不稳定）</label>
	<br />
	<br />
</form>
<table class="table table-hover">
	<thead>
		<tr>
			<td>#</td>
			<td>文件名</td>
			<td style="width:30%">进度</td>
			<td>状态</td>
		</tr>
	</thead>
	<tbody id="filelist">
		<tr id="file1" style="display:none">
			<td id="id">1</td>
			<td id="filename">文件名</td>
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
	<script type="text/javascript" src="js/main.js"></script>
</table>
<br />
</div>
<?php
include('foot.php');