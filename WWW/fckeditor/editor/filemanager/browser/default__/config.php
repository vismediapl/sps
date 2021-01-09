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

// Katalog gÅ?Ã³wny serwera
$config['root'] = $cfg['root'];

// Å?cieÅ¼ka do katalogu z plikami, bez koÅ?czÄ?cego znaku '/'
$pathconf = $cfg['userpath'];
$pathconf_tb = explode("/",$pathconf);
$pathconf='';
for($i=0;$i<(sizeof($pathconf_tb)-1);$i++) {
	$pathconf.='/'.$pathconf_tb[$i];
}

$config['path'] = $pathconf;

// Dozwolone rozszerzenia plikÃ³w (podczas wyÅ?wietlania i uploadu)
$config['allow'] = array('gif', 'jpg', 'jpeg', 'png', 'bmp');

// Czy moÅ¼na usuwaÄ? pliki z poziomu przeglÄ?darki?
$config['canDelete'] = true;

// Czy moÅ¼na zmieniaÄ? nazwÄ? plikÃ³w z poziomu przeglÄ?darki?
$config['canRename'] = true;

// Czy moÅ¼na tworzyÄ? podkatalogi?
$config['canMkDir'] = true;

// Klucz bez ktÃ³rego skrypt nie zostanie wykonany
$config['key'] = 'FCKE/MFB/ALLOW';
?>
