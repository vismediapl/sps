<?php

session_start();

include "../../../../../config.php";
include "../../../../../lib/inc/mysql.php";
include "../../../../../lib/inc/functions.php";
if($_SESSION['admin']!='') include "../../../../../admin/lib/inc/auth.inc.php";
elseif($_SESSION['user']!='') {
	include "../../../../../lib/inc/auth.inc.php";
	if(auth()==1 && $login!='') {
		$cfg['userpath']=$cfg['userpath'].'users/'.$login.'/';
	}
}

// Katalog g�?ówny serwera
$config['root'] = $cfg['root'];

// �?cieżka do katalogu z plikami, bez ko�?cz�?cego znaku '/'
$pathconf = $cfg['userpath'];
$pathconf_tb = explode("/",$pathconf);
$pathconf='';
for($i=0;$i<(sizeof($pathconf_tb)-1);$i++) {
	$pathconf.='/'.$pathconf_tb[$i];
}

$config['path'] = $pathconf;

// Dozwolone rozszerzenia plików (podczas wy�?wietlania i uploadu)
$config['allow'] = array('gif', 'jpg', 'jpeg', 'png', 'bmp');

// Czy można usuwa�? pliki z poziomu przegl�?darki?
$config['canDelete'] = true;

// Czy można zmienia�? nazw�? plików z poziomu przegl�?darki?
$config['canRename'] = true;

// Czy można tworzy�? podkatalogi?
$config['canMkDir'] = true;

// Klucz bez którego skrypt nie zostanie wykonany
$config['key'] = 'FCKE/MFB/ALLOW';
?>
