var progressbar = $('#progress');

var filename;
var jar;
var fileinfo;
var filelist = new Array();

$('#addfile').click(function() {
    if (fileid <= 100) {
        $('#lefile').click();
    } else {
        alert('Allow max 100 files!');
    }
});

function changefile(id, mode = false, file = null) {
    addfile(id + 1);
    if (mode == false) {
        filename = $('#lefile').val();
    } else {
        filename = file.name;
    }
    if (filename != '' && filename.match(/(\.phar|\.zip)$/gi)) {
        $('#file' + id + ' #filename').text(filename.match(/[^\/\\\\]+$/gi)[0]);
        fileid++;
        addfile(fileid);
        $('#file' + id).show(1000);
        doajax(id, mode, file);
    } else if (!filename.match(/(\.phar|\.zip)$/gi)) {
        alert('Please select .zip or .phar file.');
    }
}

function addfile(id) { //写入新文件区域
    $('#filelist').append('<tr id="file' + id + '" style="display:none">\
			<td id="id">' + id + '</td>\
			<td id="filename"></td>\
			<td id="progress">\
				<div class="progress">\
					<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progressbar">\
						<span class="sr-only"></span>\
					</div>\
				</div>\
			</td>\
			<td id="status"><p class="bg-info">Uploading...</p></td>\
		</tr>');
}

$('#lefile').change(function() {
	var files = $(this)[0].files;
    for (i = 0; i < files.length; i++) {
        changefile(fileid, true, files[i]);
        if (fileid > 100) {
            alert('Allow max 100 files!');
            break;
        }
    }
});

function doajax(id, mode = false, file = null) {
    function onprogress(evt) {
        var loaded = evt.loaded; //已经上传大小情况  
        var tot = evt.total; //附件总大小  
        var per = Math.floor(100 * loaded / tot); //已经上传的百分比
        $('#file' + id + ' #progressbar').attr('aria-valuenow', per);
        $('#file' + id + ' #progressbar').attr('style', 'width: ' + per + '%');
        if (per < 100) {
            $('#file' + id + ' #status').text('Uploading：' + per + '%');
        } else {
            $('#file' + id + ' #status').html('<i class="fa fa-spinner fa-spin fa-2x"></i> Processing...');
        }
    }
    var formdata = new FormData();
    if (mode = false) {
        formdata.append("file", $("input")[id - 1].files[0]);
    } else {
        formdata.append("file", file);
    }

    var request = $.ajax({
        type: "POST",
        url: "api.php?mode=upload",
        data: formdata, //这里上传的数据使用了formData 对象
        processData: false, //必须false才会自动加上正确的Content-Type
        contentType: false,

        //这里我们先拿到jQuery产生的XMLHttpRequest对象，为其增加 progress 事件绑定，然后再返回交给ajax使用
        xhr: function() {
            var xhr = $.ajaxSettings.xhr();
            if (onprogress && xhr.upload) {
                xhr.upload.addEventListener("progress", onprogress, false);　
                return xhr;
            }
        },

        //上传成功后回调
        success: function(result) {
            console.log(result);
            eval('data = ' + result);
			if(data.progress == false){
				$('#file' + id + ' #status').html('<a href="' + data.url + '" class="btn btn-success" target="_blank">Download</a>');
				filelist[id-1] = data.url;
				$('#downloadall').show();
			} else {
				$('#file' + id + ' #progressbar').attr('class', 'progress-bar progress-bar-success progress-bar-striped active');
				var threadid;
				threadid = setInterval(function(){
					$.ajax({
						type:'GET',
						url: 'progress/' + (data.id) + '.html?time=' + Date.parse(new Date()),
						success:function(val,status,xhr){
							if(val!='true'){
								$('#file' + id + ' #progressbar').attr('aria-valuenow', val);
								$('#file' + id + ' #progressbar').attr('style', 'width: ' + val + '%');
							} else {
								$('#file' + id + ' #progressbar').attr('aria-valuenow', '100');
								$('#file' + id + ' #progressbar').attr('style', 'width: 100%');
								$('#file' + id + ' #status').html('<a href="' + data.url + '" class="btn btn-success" target="_blank">Download</a>');
								filelist[id-1] = data.url;
								$('#downloadall').show();
								clearInterval(threadid);
							}
						},
						error: function(){
							$('#file' + id + ' #status').html('<p class="bg-danger">Upload failed!</p>');
							clearInterval(threadid);
						}
					});
				}, 1000);
			}
        },

        //上传失败后回调
        error: function() {
			$('#file' + id + ' #status').html('<p class="bg-danger">Upload failed!</p>');
        }

    });
}

var url='';
var ll=0;
$('#downloadall').click(function(){
	if(ll==filelist.length && url != ''){
		window.open(url);
	} else {
		var query = '0='+encodeURIComponent(filelist[0]);
		for(i=1;i<filelist.length;i+=1){
			query = query+'&'+i+'='+encodeURIComponent(filelist[i]);
		}
		$('#downloadtext').html('<i class="fa fa-spinner fa-spin fa-2x"></i> Compress to zip...');
		$.post('api.php?mode=makezip', query, function(data){
			$('#downloadtext').html('');
			url = data.url;
			ll = filelist.length;
			window.open(data.url);
		}, "json");
		}
});

document.addEventListener("dragenter", function(e) {
    dropbox.style.borderColor = 'gray';
}, false);
document.addEventListener("dragleave", function(e) {
    dropbox.style.borderColor = 'silver';
}, false);
dropbox.addEventListener("dragenter", function(e) {
    dropbox.style.borderColor = 'gray';
    dropbox.style.backgroundColor = 'white';
}, false);
dropbox.addEventListener("dragleave", function(e) {
    dropbox.style.backgroundColor = 'transparent';
}, false);
dropbox.addEventListener("dragenter", function(e) {
    e.stopPropagation();
    e.preventDefault();
}, false);
dropbox.addEventListener("dragover", function(e) {
    e.stopPropagation();
    e.preventDefault();
}, false);
dropbox.addEventListener("drop", function(e) {
    e.stopPropagation();
    e.preventDefault();
    var files = e.dataTransfer.files;
    for (i = 0; i < files.length; i++) {
        changefile(fileid, true, files[i]);
        if (fileid > 100) {
            alert('Allow max 100 files!');
            break;
        }
    }
}, false);