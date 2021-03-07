<?php
/*------------------------------------------------------------*/
class TimeWatch extends Mcontroller {
	/*------------------------------*/
	protected $loginName;
	protected $loginId;
	protected $loginType;
	/*------------------------------*/
	protected $project;
	/*------------------------------*/
	protected $Mmemcache;
	/*------------------------------*/
	private $startTime;
	/*------------------------------------------------------------*/
	public function __construct() {
		parent::__construct();

		$timeWatchLogin = new TimeWatchLogin;
		$this->loginId = TimeWatchLogin::loginId();
		$this->loginName = TimeWatchLogin::loginName();
		$this->loginType = TimeWatchLogin::loginType();
		$this->project = @$_COOKIE['project'];

		$this->Mmemcache = new Mmemcache;
		Mutils::setenv("debugLevel", 1);
	}
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	protected function permit() {
		$ok = Mrecaptcha::ok();
		if ( ! $ok )
			return(false);
		$action = $this->action;
		if ( in_array($action, array('index', 'register', 'forgotpass', 'registration', ) ) )
			return(true);
		$loginId = $this->loginId;
		if ( $loginId )
			return(true);
		 return(false);
	}
	/*------------------------------*/
	protected function before() {
		ini_set('max_execution_time', 10);
		ini_set("memory_limit", "5M");

		$this->startTime = microtime(true);
		$this->Mview->assign(array(
			'controller' => $this->controller,
			'action' => $this->action,
		));
		if ( $this->showMargins()) {
			$this->Mview->showTpl("head.tpl");
			$this->Mview->showTpl("header.tpl");
			$this->Mview->assign("RE_CAPTACH_SITE_KEY", RE_CAPTACH_SITE_KEY);
			if ( $this->loginId ) {
				$menu = new Menu();
				$menu->index($this->project);
			}
			$this->Mview->showMsgs();
		}
	}
	/*------------------------------*/
	protected function after() {
		if ( ! $this->showMargins())
			return;
		$this->Mview->runningTime($this->startTime);
		$this->Mview->showTpl("footer.tpl");
		$this->Mview->showTpl("foot.tpl");
	}
	/*------------------------------------------------------------*/
	public function index() {
		if ( $this->loginId )
			$this->show();
		else
			$this->Mview->showTpl("login.tpl");
	}
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	public function show() {
		if ( ! $this->loginId )
			return;
		$month = @$_REQUEST['month'];
		if ( ! $month )
			$month = date("Y-m");
		$project = @$_REQUEST['project'];
		if ( ! $project )
			$project = $this->project;
		if ( $project )
			$projectCond = "project = '$project'";
		else
			$projectCond = "true";
		$userCond = $this->userCond();
		$conds = "$userCond and month = '$month' and $projectCond";
		$sql = "select * from timewatch where $conds order by timeIn";
		$rows = $this->Mmodel->getRows($sql);
		foreach ($rows as $key => $row ) {
			$rows[$key]['weekday'] = date("D", strtotime($row['timeIn']));
			$rows[$key]['timeInFmt'] = $this->timeFmt($row['timeIn']);
			$rows[$key]['timeOutFmt'] = $this->timeFmt($row['timeOut']);
			$rows[$key]['timeIn2Fmt'] = $this->timeFmt($row['timeIn2']);
			$rows[$key]['timeOut2Fmt'] = $this->timeFmt($row['timeOut2']);
			$rows[$key]['timeIn3Fmt'] = $this->timeFmt($row['timeIn3']);
			$rows[$key]['timeOut3Fmt'] = $this->timeFmt($row['timeOut3']);

			$totalTime = $this->totalTime($row);
			$rows[$key]['totalTime'] = $totalTime;
			$rows[$key]['totalTimeFmt'] = $this->totalTimeFmt($totalTime);
		}
		$totalTime = array_sum(Mutils::arrayColumn($rows, "totalTime"));
		$totalTimeFmt = $this->totalTimeFmt($totalTime);
		$this->Mview->showTpl("timewatch/show.tpl", array(
			'rows' => $rows,
			'month' => $month,
			'project' => $project,
			'today' => date("Y-m-d"),
			'yesterday' => date("Y-m-d", time() - 24*60*60),
			'totalTimeFmt' => $totalTimeFmt,
		));
	}
	/*------------------------------------------------------------*/
	public function summary() {
		if ( ! $this->loginId )
			return;
		$userCond = $this->userCond();

		$project = @$_REQUEST['project'];
		if ( $project )
			$projectCond = "project = '$project'";
		else
			$projectCond = "true";
		$conds = "$userCond and $projectCond";
	
		$fields = "month, project";
		$orderBy = "order by month, project";
		$sql = "select distinct $fields from timewatch where $conds $orderBy";
		$monthProjectPairs = $this->Mmodel->getRows($sql);

		$summary = array();
		foreach ( $monthProjectPairs as $key => $monthProjectPair ) {
			$month = $monthProjectPair['month'];
			$project = $monthProjectPair['project'];
			$conds = "month = '$month' and project = '$project'";
			$sql = "select * from timewatch where $conds order by timeIn";
			$rows = $this->Mmodel->getRows($sql);
			foreach ($rows as $key => $row ) {
				$totalTime = $this->totalTime($row);
				$rows[$key]['totalTime'] = $totalTime;
			}
			$minutes = Mutils::arrayColumn($rows, 'totalTime');
			$minutes = array_sum($minutes);
			$summary[] = array(
				'month' => $month,
				'project' => $project,
				'totalTime' => $minutes,
				'time' => $this->totalTimeFmt($minutes),
			);
		}
		$totals = Mutils::arrayColumn($summary, 'totalTime');
		$totalTime = array_sum($totals);
		$totalTimeFmt = $this->totalTimeFmt($totalTime);
		$this->Mview->showTpl("timewatch/summary.tpl", array(
			'rows' => $summary,
			'totalTime' => $totalTimeFmt,
		));
	}
	/*------------------------------------------------------------*/
	public function setProject() {
		$project = $_REQUEST['project'];
		if ( $project == 'none' )
			$this->Mview->setCookie('project', null, -1);
		else
			$this->Mview->setCookie('project', $project);
		$this->redir();
	}
	/*------------------------------------------------------------*/
	public function newProject() {
		$this->Mview->showTpl("timewatch/newProject.tpl", array(
		));
	}
	/*------------------------------------------------------------*/
	public function in() {
		if ( ! $this->loginId )
			return;
		$month = date("Y-m");
		$today = date("Y-m-d");
		$now = date("Y-m-d H:i:s");
		$user = $this->loginName;
		$sql = "select * from timewatch where user = '$user' and date = '$today'";
		$row = $this->Mmodel->getRow($sql);
		if ( $row ) {
			if ( $row['timeIn3'] ) {
				$this->Mview->error("timeIn3 already taken");
				$this->redir();
				return;
			}
			elseif ( $row['timeIn2'] )
				$fname = 'timeIn3';
			elseif ( $row['timeIn'] )
				$fname = 'timeIn2';
			else
				$fname = 'timeIn';

			$this->Mmodel->dbUpdate("timewatch", $row['id'], array(
				$fname => $now,
			));
		} else {
			$this->Mmodel->dbInsert("timewatch", array(
				'user' => $user,
				'project' => $this->project,
				'month' => $month,
				'date' => $today,
				'timeIn' => $now,
			));
		}
		$this->redir();
	}
	/*------------------------------------------------------------*/
	public function out() {
		if ( ! $this->loginId )
			return;
		$today = date("Y-m-d");
		$now = date("Y-m-d H:i:s");
		$user = $this->loginName;
		$sql = "select * from timewatch where user = '$user' and date = '$today'";
		$row = $this->Mmodel->getRow($sql);
		if ( ! $row ) {
			$this->Mview->error("No entry for today");
			$this->redir();
			return;
		}

		if ( $row['timeIn3'] )
			$fname = 'timeOut3'; // possibly running over previous
		elseif ( $row['timeIn2'] )
			$fname = 'timeOut2';
		else
			$fname = 'timeOut';

		$row[$fname] = $now;
		$totalTime = $this->totalTime($row);

		$this->Mmodel->dbUpdate("timewatch", $row['id'], array(
			$fname => $now,
			'totalTime' => $totalTime,
		));
		$this->redir();
	}
	/*------------------------------------------------------------*/
	public function edit() {
		$row = $this->Mmodel->getById("timewatch", $_REQUEST['id']);
		$row['timeIn'] = $this->timeFmt($row['timeIn']);
		$row['timeOut'] = $this->timeFmt($row['timeOut']);
		$row['timeIn2'] = $this->timeFmt($row['timeIn2']);
		$row['timeOut2'] = $this->timeFmt($row['timeOut2']);
		$row['timeIn3'] = $this->timeFmt($row['timeIn3']);
		$row['timeOut3'] = $this->timeFmt($row['timeIn3']);
		$this->Mview->showTpl("timewatch/edit.tpl", array(
			'row' => $row,
		));
	}
	/*------------------------------------------------------------*/
	public function update() {
		$id = $_REQUEST['id'];
		$row = $_REQUEST;
		$date = $row['date'];
		$dbRow = $this->Mmodel->getById("timewatch", $row['id']);
		$fnames = $this->Mmodel->columns("timewatch");
		foreach ( $fnames as $fname ) {
			$substr = substr($fname, 0, 6);
			if ( $substr != "timeIn" && $substr != "timeOu" )
				continue;
			if ( $row[$fname] == "null" ) {
				// typed 'null'
				$row[$fname] = null;
			} else {
				$time = $this->timeScan($row[$fname]);
				if ( $time === false ) {
					Mview::print_r($row[$fname], "row[$fname]", basename(__FILE__), __LINE__);
					return;
				}
				if ( $time )
					$row[$fname] = "$date $time";
			}
		}
		$this->Mmodel->dbUpdate("timewatch", $id, $row);
		$this->redir();
	}
	/*------------------------------------------------------------*/
	public function export() {
		if ( ! $this->loginId )
			return;
		$month = $_REQUEST['month'];
		$project = $_REQUEST['project'];
		$userCond = $this->userCond();
		$conds = "$userCond and month = '$month' and project = '$project'";
		$fields = array(
			'null as weekday',
			'date',
			'timeIn',
			'timeOut',
			'timeIn2',
			'timeOut2',
			'timeIn3',
			'timeOut3',
		);
		$fieldList = implode(", ", $fields);
		$sql = "select $fieldList from timewatch where $conds order by date";
		$rows = $this->Mmodel->getRows($sql);
		foreach ($rows as $key => $row ) {
			$rows[$key]['weekday'] = date("D", strtotime($row['timeIn']));
			$rows[$key]['timeIn'] = $this->timeFmt($row['timeIn']);
			$rows[$key]['timeOut'] = $this->timeFmt($row['timeOut']);
			$rows[$key]['timeIn2'] = $this->timeFmt($row['timeIn2']);
			$rows[$key]['timeOut2'] = $this->timeFmt($row['timeOut2']);
			$rows[$key]['timeIn3'] = $this->timeFmt($row['timeIn3']);
			$rows[$key]['timeOut3'] = $this->timeFmt($row['timeOut3']);

			$minutes = $this->totalTime($row);
			$rows[$key]['minutes'] = $minutes;
			$rows[$key]['totalTime'] = $this->totalTimeFmt($minutes);
		}
		$totalMinutes = Mutils::arrayColumn($rows, "minutes");
		$totalMinutes = array_sum($totalMinutes);
		$totalTime = $this->totalTimeFmt($totalMinutes);

		$rows[] = array(
			'Total:',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			$totalMinutes,
			$totalTime,
		);
		$user = $this->loginName;
		$this->exportToExcel($rows, "timewatch.$user.$project.$month");
	}
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	public function forgotPass() {
		$email = $_REQUEST['email'];
		if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->Mview->msg("register: '$email': Not an email");
			return;
		}
		$str = $this->Mmodel->str($email);
		$sql = "select * from users where loginName = '$str'";
		$loginRow = $this->Mmodel->getRow($sql);
		if ( ! $loginRow ) {
			$this->Mview->error("No such email");
			return;
		}
		$rnd = rand(100, 1000);
		$sha1 = sha1($rnd);
		$passwd = substr($sha1, 17, 6);
		$dbPasswd = sha1($passwd);
		$this->Mmodel->dbUpdate("users", $loginRow['id'], array(
			'passwd' => $dbPasswd,
		));
		require_once(M_DIR."/MmailJet.class.php");
		$m = new MmailJet;
		$httpCode = null;

		$message = $this->Mview->render("forgotPassEmail.tpl", array(
			'passwd' => $passwd,
		));
		$m->mail($email, "New password @ timewatch.theora.com", $message, $httpCode);
		if ( $httpCode == 200 )
			$this->Mview->msg("New password sent to email");
		else
			$this->Mview->error("Email error");
	}
	/*------------------------------------------------------------*/
	public function register() {
		$email = $_REQUEST['email'];
		if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->Mview->msg("register: '$email': Not an email");
			return;
		}
		require_once(M_DIR."/MmailJet.class.php");
		$m = new MmailJet;
		$httpCode = null;

		$key = sha1(rand(1000, 1000000));
		$cr = sha1($email);
		$mkey = "RegisterEmail-$key";
		$ttl = 900;
		$this->Mmemcache->set($mkey, $email, $ttl);
		$message = $this->Mview->render("registerEmail.tpl", array(
			'key' => $key,
			'cr' => $cr,
		));
		$m->mail($email, "Create Account @ timewatch.theora.com", $message, $httpCode);
		if ( $httpCode == 200 )
			$this->Mview->msg("Please click the link in the email to complete the registration");
		else
			$this->Mview->error("Email error");
	}
	/*------------------------------*/
	public function registration() {
		$key = @$_REQUEST['key'];
		$cr = @$_REQUEST['cr'];
		if ( ! $key || ! $cr ) {
			$this->Mview->error("No key&cr");
			return;
		}
		$mkey = "RegisterEmail-$key";
		$email = $this->Mmemcache->get($mkey);
		if ( ! $email ) {
			$this->Mview->error("Expired");
			return;
		}
		$crcr = sha1($email);
		if ( $cr != $crcr ) {
			$this->Mview->error("Wrong email");
			return;
		}
		$str = $this->Mmodel->str($email);
		$sql = "select loginName from users where loginName = '$str'";
		$dbEmail = $this->Mmodel->getString($sql);
		if ( $dbEmail ) {
			$this->Mview->error("Email $email exists");
			return;
		}
		$rnd = rand(100, 1000);
		$sha1 = sha1($rnd);
		$passwd = substr($sha1, 17, 6);
		$dbPasswd = sha1($passwd);
		$id = $this->Mmodel->dbInsert("users", array(
			'loginName' => $email,
			'passwd' => $dbPasswd,
		));
		if ( ! $id ) {
			$this->Mview->error("insert failed");
			return;
		}
		$this->Mview->tell("registration successful", array(
			'url' => "http://timewatch.theora.com",
		));
		$this->Mview->msg("password is $passwd");
	}
	/*------------------------------------------------------------*/
	public function changePasswd() {
		$this->Mview->showTpl("admin/changePasswd.tpl");
	}
	/*------------------------------*/
	public function updatePasswd() {
		$loginName = $this->loginName;
		$oldPasswd = @$_REQUEST['oldPasswd'];
		$newPasswd = @$_REQUEST['newPasswd'];
		$newPasswd2 = @$_REQUEST['newPasswd2'];
		if ( ! $oldPasswd || ! $newPasswd || ! $newPasswd2 ) {
			$this->Mview->error("updatePasswd: please fill in all 3 fields");
			return;
		}
		if ( $newPasswd != $newPasswd2 ) {
			$this->Mview->error("updatePasswd: new passwords are not the same");
			return;
		}
		$sql = "select * from users where loginName = '$loginName'";
		$loginRow = $this->Mmodel->getRow($sql);
		if ( ! $loginRow ) {
			$this->Mview->error("updatePasswd: no login row");
			return;
		}
		$dbPasswd = $loginRow['passwd'];
		if ( $dbPasswd != $oldPasswd && $dbPasswd != sha1($oldPasswd) ) {
			$this->Mview->error("updatePasswd: old password incorrect");
			return;
		}
		$newDbPasswd = sha1($newPasswd);
		$this->Mmodel->dbUpdate("users", $loginRow['id'], array(
			'passwd' => $newDbPasswd,
		));
		$this->Mview->msg("Password changed");
	}
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	private function totalTimeFmt($totalMinutes) {
		$minutes = $totalMinutes % 60 ;
		$hours = ( $totalMinutes - $minutes ) / 60 ;
		$totalTimeFmt = sprintf("%d:%02d", $hours, $minutes);
		return($totalTimeFmt);
	}
	/*------------------------------------------------------------*/
	private function timeFmt($datetime) {
		$timeFmt = substr($datetime, 11, 8);
		$zero = "00:00:00";
		if ( $timeFmt == $zero )
			return("");
		$timeFmt = substr($timeFmt, 0, 5);
		return($timeFmt);
	}
	/*------------------------------------------------------------*/
	private function timeScan($str) {
		if ( ! $str )
			return(null);
		$hm = explode(":", $str);
		if ( count($hm) != 2 )
			return(false);
		$h = $hm[0];
		$m = $hm[1];
		if ( ! is_numeric($h) || ! is_numeric($m) )
			return(false);
		if ( $h < 0 || $h > 23 || $m < 0 || $m > 59 )
			return(false);
		$datetime = "$str:00";
		return($datetime);
	}
	/*------------------------------------------------------------*/
	// totalTime in minutes
	private function totalTime($row) {
		$totalTime = 0;
		$t1 = $this->minuteDiff($row['timeOut'], $row['timeIn']);
		$t2 = $this->minuteDiff($row['timeOut2'], $row['timeIn2']);
		$t3 = $this->minuteDiff($row['timeOut3'], $row['timeIn3']);
		$totalTime = $t1 + $t2 + $t3;
		$today = date("Y-m-d");
		if ( $row['date'] != $today )
			return($totalTime);
		$now = date("Y-m-d H:i:s");
		if ( $row['timeIn'] && ! $row['timeOut'] )
			$totalTime += $this->minuteDiff($now, $row['timeIn']);
		elseif ( $row['timeIn2'] && ! $row['timeOut2'] )
			$totalTime += $this->minuteDiff($now, $row['timeIn2']);
		elseif ( $row['timeIn3'] && ! $row['timeOut3'] )
			$totalTime += $this->minuteDiff($now, $row['timeIn3']);
		return($totalTime);
	}
	/*------------------------------*/
	private function minuteDiff($timeOut, $timeIn) {
		$nullTime = "0000-00-00 00:00:00";
		if ( ! $timeOut || ! $timeIn ||
				$timeIn == $nullTime || $timeOut  == $nullTime )
			return(0);
		$outSecs = strtotime($timeOut);
		$inSecs = strtotime($timeIn);

		$secsDiff = $outSecs - $inSecs ;
		$minuteDiff = round($secsDiff/60);
		return($minuteDiff);
	}
	/*------------------------------------------------------------*/
	private function showMargins() {
		$nots = array(
			'timeWatch' => array(
				'export',
			),
		);
		$controller = $this->controller;
		$action = $this->action;
		foreach( $nots as $notClassName => $notClass )
			foreach( $notClass as $notAction )
				if ( strcasecmp($notClassName, $controller) == 0
						&& 
						( strcasecmp($notAction, $action) == 0 || $notAction == 'any' )
					) {
						return(false);
					}
		return(true);
	}
	/*------------------------------------------------------------*/
	private function userCond() {
		$user = $this->loginName;
		$userCond = "user = '$user'";
		return($userCond);
	}
	/*------------------------------------------------------------*/
	private function projectCond() {
		$project = $this->project;
		if ( $project )
			$projectCond = "project = '$project'";
		else
			$projectCond = "true";
		return($projectCond);
	}
	/*------------------------------------------------------------*/
	private function stdConds() {
		$userCond = $this->userCond();
		$projectCond = $this->projectCond();
		$stdConds = "$userCond and $projectCond";
		return($stdConds);
	}
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	private function redir() {
		$this->redirect("/");
	}
	/*------------------------------------------------------------*/
}
