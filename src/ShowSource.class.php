<?php
/*------------------------------------------------------------*/
class ShowSource extends TimeWatch {
	/*------------------------------------------------------------*/
	public function index() {
		$V = "/var/www/vhosts";
		$files = $this->files();
		$file = @$_REQUEST['file'];
		if ( $file ) {
			$fpath = "$V/timewatch.theora.com/src/$file";
			$source = highlight_file($fpath, true);
		}
		$this->Mview->showTpl("showSource/showSource.tpl",  array(
			'files' => $files,
			'sourceFile' => @$sourceFile,
			'source' => @$source,

		));
	}
	/*------------------------------------------------------------*/
	private function files() {
		$dir = "/var/www/vhosts/timewatch.theora.com/src";
		$files = `cd $dir ; echo src/*.php`;
		$files = preg_split('/\s+/', $files);
		array_pop($files);
		return($files);
	}
	/*------------------------------------------------------------*/
}
/*------------------------------------------------------------*/
