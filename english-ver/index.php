<?php

$page = array();
$page['title'] = 'Make phar/Unhar';
include('head.php');
?>

<script language="javascript">
var fileid=1;
</script>
<div name="image" id="dropbox" style="min-width:300px;min-height:100px;border:3px dashed silver;"><br />
<form method="post" class="form-horizontal" enctype="multipart/form-data" id="uploadform" onsubmit="return false;">
	<div class="form-inline">
		<input id="lefile" type="file" name="file" style="display:none" multiple="multiple" />
		&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" id="addfile"><i class="fa fa-plus"></i> | Add file</a> 
		<label>Or rag file to upload here(Allow .zip|.phar file)</label>
		<a class="btn btn-primary" id="downloadall" style="display: none;"><i class="fa fa-download"></i> | Download All</a><label id="downloadtext"></label>
	</div>
	<br />
	<br />
</form>
<table class="table table-hover">
	<thead>
		<tr>
			<td>#</td>
			<td>File name</td>
			<td style="width:30%">Progress</td>
			<td>Status</td>
		</tr>
	</thead>
	<tbody id="filelist">
		<tr id="file1" style="display:none">
			<td id="id">1</td>
			<td id="filename"></td>
			<td id="progress">
				<div class="progress">
					<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progressbar">
						<span class="sr-only"></span>
					</div>
				</div>
			</td>
			<td id="status"><p class="bg-info">Uploading...</p></td>
		</tr>
	</tbody>
	<script type="text/javascript" src="js/main.js"></script>
</table>
<br />
</div>
<?php
include('foot.php');