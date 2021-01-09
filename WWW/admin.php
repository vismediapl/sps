<?

ob_start();

global $language;

include "config.php";
include "lib/inc/mysql.php";
include "lib/inc/functions.php";

$language = getLanguage($cfg['lng']);
include "languages/".$language.".php";
include "admin(2)/languages/".$language.".php";

include "admin(2)/lib/inc/auth.inc.php";

auth();

include "lib/tags/tags_html.php";
include "lib/tags/tags_head.php";
include "lib/tags/tags_body.php";

include "themes/".$cfg['theme']."/index.php";

html_on();
head();
body_on();
theme_on();

if(auth()==0) include 'admin(2)/modules/default.php';

else {
if(file_exists('admin(2)/modules/'.$_GET['module'].'.php')) {
	include 'admin(2)/modules/'.$_GET['module'].'.php';
} else include 'admin(2)/modules/default.php';
}

theme_off();
body_off();
html_off();

dbclose();

ob_end_flush();


?>
