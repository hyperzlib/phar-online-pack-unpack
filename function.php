<?php
function extractphar($id){
	set_time_limit(60);
	$filepath = 'cache/'.$id.'.phar';
	$phar = new Phar($filepath);
	//$phar->decompressFiles();
	$phar = $phar->convertToData(Phar::ZIP);
	return true;
}

function makephar($id, $highspeed = false){
	set_time_limit(120);
	$filepath = 'cache/'.$id.'.zip';
	ignore_user_abort(true);
	set_time_limit(0);
	$zip = new ZipArchive();
	$zip->open($filepath);
	$zip->extractTo('cache/'.$id.'/');
	$zip->close();
	@unlink($filepath);
	
	//生成phar
	$phar = new Phar('cache/'.$id.'.phar');
	$script = '<?php if(file_exists("phar://" . __FILE__ . "/src/pocketmine/PocketMine.php")){require("phar://" . __FILE__ . "/src/pocketmine/PocketMine.php");} else {echo "This Phar file is created by MCTL Phar Convertor.";}__HALT_COMPILER();';
	$folderPath = 'cache/'.$id;
	$count = 0;
	//开始自动定位
	foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderPath)) as $file){
		$count ++;
		$file = str_replace('\\', '/', $file);
		$filename = basename($file);
		if($filename == '..' || $filename == '.'){
			continue;
		}
		if($filename == 'plugin.yml'){
			$folderPath = dirname($file);
			break;
		} elseif($filename == 'PocketMine.php'){
			$folderPath = dirname(dirname($file));
			break;
		}
	}
	$folderPath = str_replace(str_replace('\\', '/', dirname(__FILE__)), '', str_replace('\\', '/', $folderPath));
	$phar->setStub($script);
	$phar->setSignatureAlgorithm(Phar::SHA1);
	if(!$highspeed){
		$phar->startBuffering();
		$percent = 0;
		$num = 0;
		file_put_contents('progress/'.$id.'.html', strval($percent));
		foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderPath)) as $file){
			$path = ltrim(rtrim(str_replace(array("\\", $folderPath), array("/", ""), $file), "/"), $id.'/');
			if($path{0} === "." or strpos($path, "/.") !== false){
				continue;
			}
			$phar->addFile($file, $path);
			$num ++;
			$cent = round(($num/$count)*100);
			$percent = $cent;
			file_put_contents('progress/'.$id.'.json', json_encode(['p' => strval($percent), 't' => time()]));
		}
		$phar->stopBuffering();
		$phar->compressFiles(Phar::GZ);
		file_put_contents('progress/'.$id.'.json', json_encode(['p' => 'true', 't' => time()]));
	} else {
		file_put_contents('progress/'.$id.'.json', json_encode(['p' => '0', 't' => time()]));
		$phar->buildFromDirectory($folderPath);
		$phar->compressFiles(Phar::GZ);
		file_put_contents('progress/'.$id.'.json', json_encode(['p' => 'true', 't' => time()]));
	}
	deldir('cache/'.$id.'/');
}

function makezip($id, $post){
	$zip = new ZipArchive;
	$zip->open('cache/'.$id.'.zip',ZipArchive::CREATE);
	$files = array();
	foreach($post as $file){
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
	return array('count'=>$count,'file'=>$files[0]['filename']);
}

function deldir($dir){
	//先删除目录下的文件：
	$dh=opendir($dir);
	while($file=readdir($dh)){
		if($file!="."&&$file!=".."){
			$fullpath=$dir."/".$file;
			if(!is_dir($fullpath)){
				unlink($fullpath);
			}else{
				deldir($fullpath);
			}
		}
	}
	closedir($dh);
	//删除当前文件夹：
	if(rmdir($dir)){
		return true;
	}else{
		return false;
	}
}