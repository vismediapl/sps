<?

function auth() {
global $cfg,$error,$language,$login,$firstname,$surname,$uid,$lang,$_POST;

session_start();

$login = $_SESSION["user"];
$pass = $_SESSION["pass_user"];

$language_=$language;

unset($_SESSION['error']);

$PHPSESSID = $_COOKIE['PHPSESSID'];

$sql = sql("SELECT id,login,password,language_id,firstname,surname FROM viscms_members WHERE login='".$login."' AND password='".$pass."' AND active>0");
if(list($uid,$login,$password,$lng,$firstname,$surname) = dbrow($sql)) {
	$sqlLang=sql("SELECT code FROM viscms_languages WHERE id=".$lng);
	list($language)=dbrow($sqlLang);
     setcookie ('PHPSESSID', $PHPSESSID, time()+1800, '/', '', 0);
     return 1;
  } else {
  	 $language = str_replace(" ","",$language_);
  	 include "languages/".$language.".php";
    	$error = '<p align="center" class="message"><b>'.$lang['uncorrect_login'].'</b></p>';

		session_register("error");

    	return 0;
}

}

function owner_auth() {
global $cfg,$error,$language,$login,$firstname,$surname,$oid,$login,$lang;

session_start();

$login = $_SESSION["owner"];
$pass = $_SESSION["pass_owner"];

$language_=$language;

unset($_SESSION['error']);

$PHPSESSID = $_COOKIE['PHPSESSID'];

$sql = sql("SELECT id,login,password,language_id,firstname,surname FROM viscms_party_owners WHERE login='".$login."' AND password='".$pass."' AND active>0");
if(list($oid,$login,$password,$lng,$firstname,$surname) = dbrow($sql)) {
	$sqlLang=sql("SELECT code FROM viscms_languages WHERE id=".$lng);
	list($language)=dbrow($sqlLang);
     setcookie ('PHPSESSID', $PHPSESSID, time()+1800, '/', '', 0);
     return 1;
  } else {
  	 $language = str_replace(" ","",$language_);
  	 include "languages/".$language.".php";
    	$error = '<p align="center" class="message"><b>'.$lang['uncorrect_login'].'</b></p>';
    	
    	session_register("error");
    	
    	return 0;
}

}

?>