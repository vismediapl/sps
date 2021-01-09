<?php
if (isset ($_POST['TConnection']) && $_POST['DBType'] == 'MySQL') {
   $CType = 'mysql_'.($_POST['PConnect']?'p':'').'connect';
   $CType ($_POST['DBHost'], $_POST['DBUser'], $_POST['DBPass']);
   if (!mysql_select_db ($_POST['DBName'])) $Info[] = array ($L['install_conectionerror'], 0);
   else $Info[] = array ($L['install_conectionsuccess'], 1);
   }
$TConnection = 1;
$Available = function_exists ('mysql_query');
if (isset ($_POST['Action']) && $_POST['Action'] == 'upgrade') $COptions = array (
	'DBHost' => array ($DBHost, 1),
	'DBUser' => array ($DBUser, 1),
	'DBPass' => array ($DBPass, 2),
	'DBName' => array ($DBName, 1),
	'DBPrefix' => array ($DBPrefix, 1),
	'PConnect' => array (0, 0)
	);
else $COptions = array (
	'DBHost' => array ('localhost', 1),
	'DBUser' => array ('', 1),
	'DBPass' => array ('', 2),
	'DBName' => array ('', 1),
	'DBPrefix' => array ('estats_', 1),
	'PConnect' => array (0, 0)
	);
$UnChanged = array ('DBHost', 'DBUser', 'DBPass' ,'DBName', 'DBPrefix');
$About = array (
	'pl' => 'Moduł wykorzystuje bazę danych MySQL w wersji co najmniej 3.23.<br />
Umożliwia bardzo szybkie zbieranie oraz przetwarzanie danych.',
	'en' => 'This module uses MySQL database, version 3.23 and above.<br />
Allows very fast collecting and processing data.'
	);
?>