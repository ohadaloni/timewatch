<?php
/*------------------------------------------------------------*/
class ShowSource extends TimeWatch {
	/*------------------------------------------------------------*/
	public function index() {
		$files = $this->files();
		$file = @$_REQUEST['file'];
		if ( $file ) {
			$source = highlight_file($file, true);
		}
		$this->Mview->showTpl("showSource/showSource.tpl",  array(
			'files' => $files,
			'source' => @$source,

		));
	}
	/*------------------------------------------------------------*/
	private function files() {
		$files = `echo *.php tpl/*.tpl`;
		$files = preg_split('/\s+/', $files);
		array_pop($files);
		return($files);
	}
	/*------------------------------------------------------------*/
}
/*------------------------------------------------------------*/
