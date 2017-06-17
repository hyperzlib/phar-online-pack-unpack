<?php
if(preg_match("/cli/i", php_sapi_name())){
	if(!isset($argv[1])){
		$p = popen(sprintf('nohup php %s start &', __FILE__), 'w');
	} else {
		while(true){
			echo @file_get_contents('http://127.0.0.1/api.php?mode=cron');
			sleep(3600);
		}
	}
} else {
	$ch = curl_init();
	if(!isset($_GET['start'])){
		curl_setopt($ch, CURLOPT_URL, $_SERVER['HTTP_HOST'].':'.$_SERVER["SERVER_PORT"].str_replace('index.php','',$_SERVER['PHP_SELF']).'/autoclean.php?start');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT,2);//激活自动断开时间
		curl_exec($ch);
		curl_close($ch);
	} else {
		set_time_limit(0);
		curl_setopt($ch, CURLOPT_URL, $_SERVER['HTTP_HOST'].':'.$_SERVER["SERVER_PORT"].str_replace('index.php','',$_SERVER['PHP_SELF']).'/api.php?mode=cron');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		while(true){
			curl_exec($ch);
			file_put_contents('.time', time());
			sleep(60);
		}
	}
}