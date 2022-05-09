<?php
/*------------------------------------------------------------*/
require_once("timeWatchConfig.php");
require_once(M_DIR."/mfiles.php");
require_once("timeWatchFiles.php");
require_once("TimeWatch.class.php");
/*------------------------------------------------------------*/
$startTime = microtime(true);
/*------------------------------------------------------------*/
$ua = @$_SERVER['HTTP_USER_AGENT'];
if (
	! $ua
	|| stristr($ua, "bot")
	|| stristr($ua, "crawl")
	|| stristr($ua, "spider")
	) {
	http_response_code(204);
	exit;
}
/*------------------------------------------------------------*/
global $Mview;
global $Mmodel;
$Mview = new Mview;
$Mmodel = new Mmodel;
$Mview->holdOutput();
/*------------------------------------------------------------*/
$timeWatchLogin = new TimeWatchLogin;
if ( isset($_REQUEST['logOut']) ) {
	$timeWatchLogin->logOut();
} else {
	$timeWatchLogin->enterSession();
}
$timeWatch = new TimeWatch;
$timeWatch->setStartTime($startTime);
$timeWatch->control();
$Mview->flushOutput();
/*------------------------------------------------------------*/
/*------------------------------------------------------------*/
