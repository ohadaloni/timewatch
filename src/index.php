<?php
/*------------------------------------------------------------*/
date_default_timezone_set("Asia/Jerusalem");
require_once("timeWatchConfig.php");
require_once(M_DIR."/mfiles.php");
require_once("timeWatchFiles.php");
require_once("TimeWatch.class.php");
/*------------------------------------------------------------*/
global $Mview;
global $Mmodel;
$Mview = new Mview;
$Mmodel = new Mmodel;
$Mview->holdOutput();
/*------------------------------------------------------------*/
$timeWatch = new TimeWatch;
$timeWatchLogin = new TimeWatchLogin;
if ( isset($_REQUEST['logOut']) ) {
	$timeWatch = new TimeWatch;
	$timeWatchLogin->logOut();
}
$timeWatch->control();
$Mview->flushOutput();
/*------------------------------------------------------------*/
/*------------------------------------------------------------*/
