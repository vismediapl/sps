<?php
if (isset ($_POST['TConnection']) && $_POST['DBType'] == 'MySQLi') {
   if (!mysqli_connect ($_POST['DBHost'], $_POST['DBUser'], $_POST['DBPass'], $_POST['DBName'])) $Info[] = array ($L['install_conectionerror'], 0);
   else $Info[] = array ($L['install_conectionsuccess'], 1);
   }
$TConnection = 1;
$Available = function_exists ('mysqli_query');
if (isset ($_POST['Action']) && $_POST['Action'] == 'upgrade') $COptions = array (
	'DBHost' => array ($DBHost, 1),
	'DBUser' => array ($DBUser, 1),
	'DBPass' => array ($DBPass, 2),
	'DBName' => array ($DBName, 1),
	'DBPrefix' => array ($DBPrefix, 1)
	);
else $COptions = array (
	'DBHost' => array ('localhost', 1),
	'DBUser' => array ('', 1),
	'DBPass' => array ('', 2),
	'DBName' => array ('', 1),
	'DBPrefix' => array ('estats_', 1)
	);
$UnChanged = array ('DBHost', 'DBUser', 'DBPass' ,'DBName', 'DBPrefix');
$About = array (
	'pl' => 'Moduł wykorzystuje bazę danych MySQL w wersji co najmniej 4.1.3.<br />
Umożliwia bardzo szybkie zbieranie oraz przetwarzanie danych.',
	'en' => 'This module uses MySQL database, version 4.1.3 and above.<br />
Allows very fast collecting and processing data.'
	);
?>