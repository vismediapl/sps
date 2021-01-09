<?php
function e_connection_string () {
         $CString = array ();
         if ($_POST['DBHost'] && $_POST['DBPort']) $CString[] = 'host='.$_POST['DBHost'].' port='.$_POST['DBPort'];
         else if ($_POST['DBHost'] && $_POST['DBHost'] != 'localhost') $CString[] = 'host='.$_POST['DBHost'];
         if ($_POST['DBName']) $CString[] = 'dbname='.$_POST['DBName'];
         if ($_POST['DBUser']) $CString[] = 'user='.$_POST['DBUser'];
         if ($_POST['DBPass']) $CString[] = 'password='.$_POST['DBPass'];
         return (implode (' ', $CString));
         }
if (isset ($_POST['TConnection']) && $_POST['DBType'] == 'PGSQL') {
   if (pg_connect (e_connection_string ())) $Info[] = array ($L['install_conectionsuccess'], 1);
   else $Info[] = array ($L['install_conectionerror'], 0);
   }
$TConnection = 1;
$Available = function_exists ('pg_query');
$COptions = array (
	'DBHost' => array ('localhost', 1),
	'DBUser' => array ('', 1),
	'DBPass' => array ('', 2),
	'DBName' => array ('', 1),
	'DBPrefix' => array ('estats_', 1),
	'DBPort' => array (5432, 1),
	'PConnect' => array (0, 0)
	);
$About = array (
	'pl' => 'Moduł wykorzystuje bazę danych PostgreSQL (testowany na wersji 8.1).<br />
Umożliwia bardzo szybkie zbieranie danych oraz ich przetwarzanie.',
	'en' => 'This module uses PostgreSQL database (tested on 8.1 version).<br />
Allows very fast collecting and processing data.'
	);
?>