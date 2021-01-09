<?

function auth() {
global $cfg,$error,$language,$uid,$lang;

session_start();

$login = $_SESSION["admin"];
$pass = $_SESSION["pass_admin"];

$language_=$language;

unset($_SESSION['error']);

$PHPSESSID = $_COOKIE['PHPSESSID'];

$sql = sql("SELECT id,login,password,language_id,super FROM viscms_admins WHERE login='".$login."' AND password='".$pass."' AND super=1");

$sql2 = sql("SELECT id,login,password,language_id,super FROM viscms_admins WHERE login='".$login."' AND password='".$pass."' AND super=0");

if(mysql_num_rows($sql)==1 || mysql_num_rows($sql2)==1) {
  if(mysql_num_rows($sql)==1) {
  	list($uid,$login,$password,$language_id,$super) = dbrow($sql);
  	$sqlLang = sql("SELECT code FROM viscms_languages WHERE id=".$language_id);
  	list($language_) = dbrow($sqlLang);
  	 $language = getLanguage($language_);
     setcookie ('PHPSESSID', $PHPSESSID, time()+1800, '/', '', 0);
     return 2;
  } elseif(mysql_num_rows($sql2)==1) {
  	list($uid,$login,$password,$language_id,$super) = dbrow($sql2);
  	$sqlLang = sql("SELECT code FROM viscms_languages WHERE id=".$language_id);
  	list($language_) = dbrow($sqlLang);
  	 $language = getLanguage($language_);
     setcookie ('PHPSESSID', $PHPSESSID, time()+1800, '/', '', 0);
     return 1;
  }
} else {
  	 $language = str_replace(" ","",$language_);
    	$error = $lang['uncorrect_login'];
		session_register("error");
    	return 0;
}

}

?>