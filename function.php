<?php
function extractphar($id){
	$filepath = 'cache/'.$id.'.phar';
	$phar = new Phar($filepath);
	$phar = $phar->convertToData(Phar::ZIP);
	$phar->decompressFiles();
	return true;
}

function makephar($id){
	$filepath = 'cache/'.$id.'.zip';
	ignore_user_abort(true);
	set_time_limit(0);
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
		$path = rtrim(str_replace(array("\\", $folderPath), array("/", ""), $file), "/");
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