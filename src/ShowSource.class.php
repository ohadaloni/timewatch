<?php
/*------------------------------------------------------------*/
class ShowSource extends TimeWatch {
	/*------------------------------------------------------------*/
	public function index() {
		$files = $this->fileList();
		$file = @$_REQUEST['file'];
		if ( $file ) {
			$source = highlight_file($file, true);
		}
		$this->Mview->showTpl("showSource/showSource.tpl", array(
			'files' => $files,
			'fileName' => $file,
			'source' => @$source,

		));
	}
	/*------------------------------------------------------------*/
	private function fileList() {
		$files = `echo *.php tpl/*.tpl`;
		$files = preg_split('/\s+/', $files);
		array_pop($files);
		return($files);
	}
	/*------------------------------------------------------------*/
}
/*------------------------------------------------------------*/
