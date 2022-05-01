<?php
/*------------------------------------------------------------*/
class TimeWatchLogin extends Mcontroller {
	/*------------------------------------------------------------*/
	public function enterSession() {
		if ( isset($_REQUEST['LogOut']) ) {
			Mlogin::logout();
			return(false);
		}
		if ( Mlogin::is() )
				return(true);
		$loginName = @$_REQUEST['loginName'];
		$passwd = @$_REQUEST['passwd'];
		if ( ! $loginName || ! $passwd )
			return(false);
		if ( ($loginRec = $this->dbEnter($loginName, $passwd)) != null ) {
			Mlogin::login($loginRec['id'], $loginName, $loginRec['loginType']);
			return(true);
		}
		$this->Mview->tell("Incorrect password for $loginName", array(
			'silent' => true,
			'rememberForNextPage' => true,
		));
		return(false);
	}
	/*------------------------------------------------------------*/
	public function dbEnter($loginName, $passwd) {
		$fields = "id, loginName,loginType, passwd";
		$str = $this->Mmodel->str($loginName);
		$sql = "select $fields from users where loginName = '$str'";
		$loginRecs = $this->Mmodel->getRows($sql);
		foreach ( $loginRecs as $loginRec ) {
			$dbPasswd = $loginRec['passwd'];
			if ( $passwd == $dbPasswd || sha1($passwd) == $dbPasswd) {
				return($loginRec);
			}
		}
		return(null);
	}
	/*------------------------------------------------------------*/
	public function logOut() {
		Mlogin::logout();
	}
	/*------------------------------------------------------------*/
	public static function loginName() { return(Mlogin::get("MloginName")); }
	public static function loginType() { return(Mlogin::get("MloginType")); }
	public static function loginId() { return(Mlogin::get("MloginId")); }
	/*------------------------------------------------------------*/
}
/*------------------------------------------------------------*/
