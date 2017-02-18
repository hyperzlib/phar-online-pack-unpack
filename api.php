<?php
set_time_limit(0);
if(isset($_GET)){
	if($_GET['mode']=='upload'){  //上传模式
		$id = md5($_FILES["file"]["name"].microtime());
		file_put_contents('upload.log',json_encode(array('id'=>$id,'name'=>$_FILES["file"]["name"]))."\n",FILE_APPEND);
		if(preg_match('/\.phar$/', $_FILES["file"]["name"])){ //解包
			copy($_FILES["file"]["tmp_name"], 'cache/'.$id.'.phar');
			$filepath = 'cache/'.$id.'.phar';
			$phar = new Phar($filepath);
			$phar = $phar->convertToData(Phar::ZIP);
			$phar->decompressFiles();
			echo json_encode(array('id'=>$id,'url'=>'api.php?mode=download&type=zip&id='.$id.'&filename='.urlencode(preg_replace('/\.phar$/','.zip', $_FILES["file"]["name"])),'progress'=>false));
			@unlink($filepath);
		} elseif(preg_match('/\.zip$/', $_FILES["file"]["name"])){//异步打包
			copy($_FILES["file"]["tmp_name"], 'cache/'.$id.'.zip');
			$filepath = 'cache/'.$id.'.zip';
			mkdir('cache/'.$id);
			echo json_encode(array('id'=>$id,'url'=>'api.php?mode=download&type=phar&id='.$id.'&filename='.urlencode(preg_replace('/\.zip$/','.phar', $_FILES["file"]["name"])),'progress'=>true));
			$size = ob_get_length();
			header("Content-Length: $size");
			header('Connection: close');
			ob_end_flush();
			ob_flush();
			flush();
			ignore_user_abort(true);
			$zip = new ZipArchive;
			$zip->open($filepath);
			$zip->extractTo('cache/'.$id.'/');
			$zip->close();
			@unlink($filepath);
			$phar = new Phar('cache/'.$id.'.phar');
			$script = '<?php if(file_exists("phar://" . __FILE__ . "/src/pocketmine/PocketMine.php")){require("phar://" . __FILE__ . "/src/pocketmine/PocketMine.php");} else {echo "This Phar file is created by MCTL Phar Convertor.";}__HALT_COMPILER();';
			$folderPath = 'cache/'.$id;
			$count = 0;
			foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderPath)) as $file){
				$count ++;
			}
			$phar->setStub($script);
			$phar->setSignatureAlgorithm(Phar::SHA1);
			$phar->startBuffering();
			$percent = 0;
			$num = 0;
			file_put_contents('progress/'.$id.'.html', strval($percent));
			foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderPath)) as $file){
				$path = rtrim(str_replace(["\\", $folderPath], ["/", ""], $file), "/");
				if($path{0} === "." or strpos($path, "/.") !== false){
					continue;
				}
				$phar->addFile($file, $path);
				$num ++;
				$cent = round(($num/$count)*100);
				if($cent > $percent){
					$percent = $cent;
					file_put_contents('progress/'.$id.'.html', strval($percent));
				}
			}
			$phar->stopBuffering();
			file_put_contents('progress/'.$id.'.html', 'true');
		}
	} elseif($_GET['mode']=='download'){
		$file = 'cache/'.$_GET['id'].'.'.$_GET['type'];
		if(file_exists($file)){
			header('Content-Type:application/zip'); //发送指定文件MIME类型的头信息
			header('Content-Disposition:attachment; filename="'.$_GET['filename'].'"'); //发送描述文件的头信息，附件和文件名
			header('Content-Length:'.filesize($file)); //发送指定文件大小的信息，单位字节
			readfile($file);
		} else {
			echo 'File Not Found.';
		}
	} elseif($_GET['mode']=='makezip'){
		$id = md5(microtime()+rand(0,100));
		$zip = new ZipArchive;
		$zip->open('cache/'.$id.'.zip',ZipArchive::CREATE);
		$files = array();
		foreach($_POST as $file){
			$file = str_replace('api.php?','',$file);
			$query = array();
			$str1 = explode('&', $file);
			foreach($str1 as $str2){
				$str2 = explode('=',$str2);
				$query[urldecode($str2[0])] = isset($str2[1])?urldecode($str2[1]):'';
			}
			$files[] = $query;
		}
		$count = 0;
		foreach($files as $file){
			$zip->addFile('cache/'.$file['id'].'.'.$file['type'], $file['filename']);
			$count++;
		}
		$zip->close();
		echo json_encode(array('id'=>$id,'url'=>'api.php?mode=download&type=zip&id='.$id.'&filename='.urlencode(preg_replace('/\.zip$/','', $files[0]['filename']).'等'.$count.'个文件.zip')));
	}
} else {
	header('Location: .');
}
