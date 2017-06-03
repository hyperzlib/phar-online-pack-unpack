<?php
if(!isset($argv[1])){
	$p = popen(sprintf('nohup php %s start &', __FILE__), 'w');
} else {
	while(true){
		echo @file_get_contents('http://tools.mctpa.net:8080/tools/phar/api.php?mode=cron');
		sleep(3600);
	}
}
