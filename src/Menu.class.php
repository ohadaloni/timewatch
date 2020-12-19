<?php
/*------------------------------------------------------------*/
class Menu extends Mcontroller {
	/*------------------------------------------------------------*/
	public function index() {
			$this->Mview->showTpl("menuDriver.tpl", array(
				'menu' => $this->dd(),
			));
	}
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	private function dd() {
		$adminMenu = array(
			array(
				'name' => 'showSource',
				'title' => 'Show Source Code',
				'url' => "/showSource",
			),
			array(
				'name' => 'clone',
				'title' => 'Clone',
				'url' => "https://github.com/ohadaloni/timewatch",
				'target' => "clone",
			),
		);
		$userMenu = array(
			array(
				'name' => 'chpass',
				'title' => 'Change Password',
				'url' => "/timeWatch/changePasswd",
			),
			array(
				'name' => 'logout',
				'title' => 'Log Off',
				'url' => "/?logOut=logOut",
			),
		);

		$timeWatchMenu = array(
			array(
				'name' => 'timeIn',
				'title' => 'Time In',
				'url' => "/timewatch/in",
			),
			array(
				'name' => 'timeOut',
				'title' => 'Time Out',
				'url' => "/timewatch/out",
			),
			array(
				'name' => 'timewatchThisMonth',
				'title' => 'TimeWatch This Month',
				'url' => "/timewatch",
			),
			array(
				'name' => 'timeWatchSummary',
				'title' => 'TimeWatch Summary',
				'url' => "/timewatch/summary",
			),
		);

		$loginName = TimeWatchLogin::loginName();
		if ( $loginName )
			$menu = array(
				'timeWatch' => $timeWatchMenu,
				'admin' => $adminMenu,
				$loginName => $userMenu,
			);
		else
			$menu = array(
				'admin' => $adminMenu,
			);
		return($menu);
	}
	/*------------------------------------------------------------*/
}

