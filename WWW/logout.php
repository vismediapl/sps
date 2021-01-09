<?
ob_start();

session_start();
session_destroy();

$p=setcookie ('PHPSESSID', $PHPSESSID, time()-1800, '/', '', 1);

include "config.php";
include "lib/inc/mysql.php";
include "lib/inc/auth.inc.php";
include "lib/inc/functions.php";
include "lib/inc/calendar.class.php";
include "lib/inc/classes.php";

$language = getLanguage($cfg['lng']);

$sqlLANG = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($language_id) = dbrow($sqlLANG);

include "languages/".$language.".php";

include "lib/tags/tags_html.php";
include "lib/tags/tags_head.php";
include "lib/tags/tags_body.php";

include "themes/".$cfg['theme']."/index.php";

html_on();
head();
body_on();
theme_on();

if($p==true)
{
echo '<br/>
<div class="message"><b>'.$lang['logout_ok'].'</b></div>
<br/>
<META HTTP-EQUIV="refresh" CONTENT="30; URL=index.php">';
}

theme_off();
body_off();
html_off();

dbclose();

ob_end_flush();

?>