<?php
/*------------------------------------------------------------*/
error_reporting(E_ALL | E_NOTICE | E_STRICT );
/*------------------------------------------------------------*/
date_default_timezone_set("UTC");
/*------------------------------------------------------------*/
define('M_DIR', "/var/www/vhosts/M.theora.com");
define('TAS_DIR', "/var/www/vhosts/tas.theora.com");
require_once(TAS_DIR."/conf/dbCredentials.php");
require_once(TAS_DIR."/conf/reCaptchaKeys.php");
require_once(TAS_DIR."/libs/recaptchalib.php");
define('M_DBNAME', 'timewatch');
/*------------------------------------------------------------*/
