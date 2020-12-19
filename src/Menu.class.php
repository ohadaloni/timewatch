<?php
/*------------------------------------------------------------*/
class Menu extends Mcontroller {
	/*------------------------------------------------------------*/
	public function index($project = null) {
			$this->Mview->showTpl("menuDriver.tpl", array(
				'menu' => $this->dd($project),
			));
	}
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	private function dd($thisProject) {
		$loginName = TimeWatchLogin::loginName();
		if ( $loginName ) {
			$sql = "select distinct project from timewatch where  user = '$loginName'";
			$projects = $this->Mmodel->getStrings($sql);
			if ( $thisProject )
				$projectMenuTitle = "project: $thisProject";
			else
				$projectMenuTitle = "project";
			$projectMenu = array();
			foreach ( $projects as $project ) {
				if ( $project == $thisProject )
					continue;
				$projectMenu[] = array(
					'name' => $project,
					'title' => $project,
					'url' => "/timeWatch/setProject?project=$project",
				);
			}
			if ( $projectMenu )
				$projectMenu[] = array(
					'divider' => '-----------------------',
			);
			$projectMenu[] = array(
				'name' => 'newProject',
				'title' => 'newProject',
				'url' => "/timeWatch/newProject",
			);
			$projectMenu[] = array(
				'name' => 'none',
				'title' => 'none',
				'url' => "/timeWatch/setProject?project=none",
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

		}
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


		if ( $loginName )
			$menu = array(
				'timeWatch' => $timeWatchMenu,
				$projectMenuTitle => $projectMenu,
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
