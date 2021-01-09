<?php
header('Cache-Control: no-cache');
require_once('smarty/Smarty.class.php');

class fckBrowser
{
	var $tpl;
	
	function fckBrowser ()
	{
		$this->tpl = new Smarty();
		$this->tpl->template_dir = 'tpl';
		$this->tpl->compile_dir = 'tpl/c';
		
		$this->display();
	}

	function display ()
	{
		$this->tpl->display('browser.tpl');
	}
}

$mfb = new fckBrowser();
?>
