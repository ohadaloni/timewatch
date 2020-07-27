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
		$menu = array(
			/*	'Tasks' => array(	*/
				/*	array(	*/
					/*	'name' => 'tasks',	*/
					/*	'title' => 'tasks',	*/
					/*	'url' => "/tasks",	*/
				/*	),	*/
			/*	),	*/
			'admin' => array(
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
			),
		);
		$loginName = TimeWatchLogin::loginName();
		if ( $loginName )
			$menu[$loginName] = array(
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
					'divider' => '-----------------------',
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
				array(
					'divider' => '-----------------------',
				),
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
		return($menu);
	}
	/*------------------------------------------------------------*/
}

