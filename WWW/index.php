<?

ob_start();

global $language,$SubEx;

include "config.php";
include "lib/inc/mysql.php";
include "lib/inc/functions.php";
include "lib/inc/classes.php";
include "lib/inc/calendar.class.php";
include "lib/inc/auth.inc.php";

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
if(file_exists('modules/'.$_GET['module'].'.php')) {
	include 'modules/'.$_GET['module'].'.php';
} else include 'modules/default.php';
theme_off();

// STATYSTYKI
define ('eCOUNT', 1);
@include ('stats/stats.php');

?>

<script type="text/javascript">
var ePath = 'stats/';
var eCount = 1;
</script>
<script type="text/javascript" src="stats/stats.js"></script>

<?

body_off();
html_off();

dbclose();

ob_end_flush();

?>