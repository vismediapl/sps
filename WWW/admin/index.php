<?

ob_start();

global $language,$main,$module,$sub,$link_sub;

include "../config.php";
$cfg['theme']='default';
include "../lib/inc/mysql.php";
include "../lib/inc/functions.php";
include "../lib/inc/rss.class.php";
include "lib/inc/form.class.php";
include "lib/inc/admin.class.php";
include "lib/inc/backup.class.php";

$language = getLanguage($cfg['lng']);
include "../languages/".$language.".php";
include "languages/".$language.".php";
include "languages/".$language."/menulist.php";

include "lib/inc/auth.inc.php";

auth();

include "lib/tags/tags_html.php";
include "lib/tags/tags_head.php";
include "lib/tags/tags_body.php";

include "lib/inc/menulist.php";
include "themes/".$cfg['theme']."/index.php";

html_on();
head();
body_on();

if(auth()==0) {
	
session_start();

$error = $_SESSION['error'];

if($_SESSION["admin"]!='')
	echo '<div class="error_msg" style="z-index: 2;">'.$error.'</div>';
unset($_SESSION['error']);
unset($_SESSION["admin"]);
	
	echo "<form method=\"post\" action=\"../login.php\">\n";
	theme_start_on();
	include 'modules/default.php';
	theme_start_off();
	echo "</form>\n";
}

else {
theme_on();
$level = new Levels(); // ustawianie poziomow
$level->AddLevel($lang['homepage'],"index.php");
$links = new HeaderLinks(); // ustawianie linkow naglowkowych
if(file_exists('modules/'.$_GET['module'].'.php')) {
	include 'modules/'.$_GET['module'].'.php';
} else include 'modules/default.php';
$level->Show();
theme_off();
}

body_off();
html_off();

dbclose();

ob_end_flush();

?>