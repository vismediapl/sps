<?php
header('Cache-Control: no-cache');
header('Content-Type: text/plain');
require_once('config.php');
require_once('smarty/Smarty.class.php');

class fckBrowserConnector
{
	var $tpl;
	var $config;
	
	function fckBrowserConnector ()
	{
		global $config;
		$this->config = $config;
		
		$this->tpl = new Smarty();
		$this->tpl->template_dir = 'tpl';
		$this->tpl->compile_dir = 'tpl/c';
		$this->tpl->assign('config', $this->config);
		
		$this->callAction();
	}
	
	function callAction ()
	{
		if (isset($_GET['action']))
		{
			if (is_callable(array($this, 'action_'.$_GET['action'])))
				call_user_func(array($this, 'action_'.$_GET['action']));
			else
				$this->returnError('Brak kontrolera do podanej akcji.');
		}
		else
			$this->returnError('Nie podano identyfikatora akcji.');
	}
	
	function returnError ($message)
	{
		if (isset($_GET['ajax']) && $_GET['ajax'] == '1')
			$this->ajaxError($message);
		else
		{
			$this->tpl->assign('error', $message);
			$this->tpl->display('error.tpl');
			exit();
		}
	}
	
	function ajaxError ($message)
	{
		die('1'.$message);
	}
	
	function ajaxDone ($message, $fchar = '0')
	{
		die($fchar.$message);
	}
	
	function removeDirectory ($dir)
	{
		if (!isset($GLOBALS['tmp_rdc'])) $GLOBALS['tmp_rdc'] = true;
		if ($handle = opendir($dir))
		{
			while (false !== ($item = readdir($handle)))
			{
				if ($item != "." && $item != "..")
				{
					if (is_dir($dir.'/'.$item))
						$this->removeDirectory($dir.'/'.$item);
					else
					{
						if (unlink($dir.'/'.$item) === false)
							$GLOBALS['tmp_rdc'] = false;
					}
				}
			}
			closedir($handle);
			if (rmdir($dir) === false)
				$GLOBALS['tmp_rdc'] = false;
		}
	}
	
	function is_safeName ($name)
	{
		$unsafe = '\/:*?"<>|';
		return !(preg_match('/['.preg_quote($unsafe, '/').']/', $name));
	}
	
	/* ----- */
	
	function action_getFiles ()
	{
		if (!isset($_GET['folder']))
			$this->returnError('Brak informacji o katalogu.');
		
		$path = $this->config['root'].$this->config['path'].$_GET['folder'];
		
		if (!file_exists($path))
			$this->returnError('Ścieżka &quot;'.$path.'&quot; nie istnieje.');
		else
		{
			$path .= '/';
			$files = array();
			if ($handle = opendir($path))
			{
				while (false !== ($file = readdir($handle)))
				{
					if ($file != "." && $file != ".." && $file[0] != ".")
					{
						if (is_file($path.$file) === true)
							$files[] = array('path' => $_GET['folder'].'/'.$file, 'name' => $file);
					}
				}
				closedir($handle);
			}
			$this->tpl->assign('files', $files);
			$this->tpl->display('files.tpl');
			exit();
		}
	}
	
	function action_getFolders ()
	{
		if (!isset($_GET['folder']))
			$this->returnError('Brak informacji o katalogu.');
		
		$path = $this->config['root'].$this->config['path'].$_GET['folder'];
		if (!file_exists($path))
			$this->returnError('Ścieżka &quot;'.$path.'&quot; nie istnieje.');
		else
		{
			$this->tpl->assign('folder', $path);
			$path .= '/';
			$dirs = array();
			if ($handle = opendir($path))
			{
				while (false !== ($file = readdir($handle)))
				{
					if ($file != "." && $file != "..")
					{
						if (is_dir($path.$file) === true)
							$dirs[] = array('path' =>  $_GET['folder'].'/'.$file, 'name' => $file);
					}
					elseif (!empty($_GET['folder']) && $file == '..')
						$dirs[] = array('path' => substr($_GET['folder'], 0, strrpos($_GET['folder'], '/')));
				}
				closedir($handle);
			}
			$this->tpl->assign('dirs', $dirs);
			$this->tpl->display('dirs.tpl');
			exit();
		}
	}
	
	function action_renameFolder ()
	{
		if (!isset($_GET['folder']))
			$this->ajaxError('Brak informacji o katalogu.');
		
		if (!isset($_GET['newName']) || empty($_GET['newName']))
			$this->ajaxError('Nie podano nowej nazwy dla katalogu.');
		
		$_GET['newName'] = urldecode($_GET['newName']);
		$_GET['newName'] = str_replace("'", '', iconv('utf-8', 'ascii//TRANSLIT', $_GET['newName']));
		
		if (!$this->is_safeName($_GET['newName']))
			$this->ajaxError('Podana nazwa katalogu zawiera nieprawidłowe znaki:'."\n".'\ / : * ? " < > |.');
		
		$path = $this->config['root'].$this->config['path'].$_GET['folder'];
		$pathinfo = pathinfo($path);
		$npat = $pathinfo['dirname'].'/'.$_GET['newName'];
		
		if (!file_exists($path))
			$this->ajaxError('Ścieżka "'.$path.'" nie istnieje.');
		
		if (file_exists($npat))
			$this->ajaxError('Katalog "'.$_GET['newName'].'" już istnieje.');
		
		if (rename($path, $npat) === true)
			$this->ajaxDone(substr($_GET['folder'], 0, strrpos($_GET['folder'], '/')));
		else
			$this->ajaxError('Katalog o nazwie "'.$_GET['newName'].'" już istnieje.');
	}
	
	function action_createFolder ()
	{
		if (!isset($_GET['folder']))
			$this->ajaxError('Brak informacji o katalogu.');
		
		if (!isset($_GET['newName']) || empty($_GET['newName']))
			$this->ajaxError('Nie podano nazwy dla nowego katalogu.');
		
		$_GET['newName'] = urldecode($_GET['newName']);
		$_GET['newName'] = str_replace("'", '', iconv('utf-8', 'ascii//TRANSLIT', $_GET['newName']));
		
		if (!$this->is_safeName($_GET['newName']))
			$this->ajaxError('Podana nazwa katalogu zawiera nieprawidłowe znaki:'."\n".'\ / : * ? " < > |.');
		
		$path = $this->config['root'].$this->config['path'].$_GET['folder'].'/'.$_GET['newName'];
		if (mkdir($path) === true)
			$this->ajaxDone($_GET['folder'].'/'.$_GET['newName'], '+');
		else
			$this->ajaxError('Katalog o nazwie "'.$_GET['newName'].'" już istnieje.');
	}
	
	function action_deleteFolder ()
	{
		if (!isset($_GET['folder']))
			$this->ajaxError('Brak informacji o katalogu.');
		
		if (!isset($_GET['delete']) || empty($_GET['delete']))
			$this->ajaxError('Nie podano nazwy katalogu do usunięcia.');
		
		$path = $this->config['root'].$this->config['path'].$_GET['delete'];
		if (!file_exists($path))
			$this->ajaxError('Katalog o nazwie "'.$_GET['delete'].'" nie istnieje.');
		
		$this->removeDirectory($path);
		
		if (isset($GLOBALS['tmp_rdc']) && $GLOBALS['tmp_rdc'] === true)
			$this->ajaxDone($_GET['folder']);
		else
			$this->ajaxError('Wystąpił błąd podczas usuwania katalogu.');
	}
	
	function action_renameFile ()
	{
		if (!isset($_GET['folder']))
			$this->ajaxError('Brak informacji o katalogu.');

		if (!isset($_GET['file']))
			$this->ajaxError('Brak informacji o pliku źródłowym.');

		if (!isset($_GET['newName']) || empty($_GET['newName']))
			$this->ajaxError('Nie podano nowej nazwy dla pliku.');
		
		$_GET['newName'] = urldecode($_GET['newName']);
		$_GET['newName'] = str_replace("'", '', iconv('utf-8', 'ascii//TRANSLIT', $_GET['newName']));
		
		if (!$this->is_safeName($_GET['newName']))
			$this->ajaxError('Podana nazwa pliku zawiera nieprawidłowe znaki:'."\n".'\ / : * ? " < > |.');

		$path = $this->config['root'].$this->config['path'].$_GET['file'];
		$pathinfo = pathinfo($path);
		$npat = $pathinfo['dirname'].'/'.$_GET['newName'];
		$pathinfo2 = pathinfo($npat);
		$tmpp = $_GET['newName'];
		if (!isset($pathinfo2['extension']) && isset($pathinfo['extension']))
		{
			$npat .= '.'.$pathinfo['extension'];
			$tmpp .= '.'.$pathinfo['extension'];
		}
			
		if (isset($pathinfo2['extension']) && isset($pathinfo['extension']) && $pathinfo2['extension'] != $pathinfo['extension'])
		{
			$npat = substr($npat, 0, strrpos($npat, '.')).'.'.$pathinfo['extension'];
			$tmpp = substr($tmpp, 0, strrpos($tmpp, '.')).'.'.$pathinfo['extension'];
		}
		
		if (!file_exists($path))
			$this->ajaxError('Plik o nazwie "'.$_GET['file'].'" nie istnieje.');
		
		if (file_exists($npat))
			$this->ajaxError('Plik o nazwie "'.$tmpp.'" już istnieje.');
		
		if (rename($path, $npat) === true)
			$this->ajaxDone($_GET['folder']);
		else
			$this->ajaxError('Wystąpił błąd podczas zmiany nazwy pliku "'.$_GET['file'].'".');
	}
	
	function action_deleteFile ()
	{
		if (!isset($_GET['folder']))
			$this->ajaxError('Brak informacji o katalogu.');
		
		if (!isset($_GET['delete']) || empty($_GET['delete']))
			$this->ajaxError('Nie podano nazwy pliku do usunięcia.');
		
		$path = $this->config['root'].$this->config['path'].$_GET['delete'];
		if (!file_exists($path))
			$this->ajaxError('Plik o nazwie "'.$_GET['delete'].'" nie istnieje.');
		
		if (unlink($path) === true)
			$this->ajaxDone($_GET['folder']);
		else
			$this->ajaxError('Wystąpił błąd podczas usuwania pliku.');
	}
	
	function action_clearFileCache ()
	{
		if (!isset($_GET['folder']))
			$this->ajaxError('Brak informacji o katalogu.');
		
		$path = $this->config['root'].$this->config['path'].$_GET['folder'].'/';

		if ($handle = opendir($path))
		{
			while (false !== ($file = readdir($handle)))
			{
				if ($file != "." && $file != "..")
				{
					if (is_file($path.$file) && $file[0] == '.')
						unlink($path.$file);
				}
			}
			closedir($handle);
		}
		
		$this->ajaxDone($_GET['folder']);
	}
}

$fbc = new fckBrowserConnector();
?>
