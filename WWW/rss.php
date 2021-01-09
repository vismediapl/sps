<?

ob_start();

session_start();
session_destroy();

$p=setcookie ('PHPSESSID', $PHPSESSID, time()-1800, '/', '', 1);

global $language,$language_f;

include "config.php";
include "lib/inc/mysql.php";
include "lib/inc/functions.php";
include "lib/inc/classes.php";
include "lib/inc/rss.class.php";

$rss = new RSS();
$rss->Generate();
echo 'Proszê czekaæ...';

preg_match('/Firefox|MSIE|Opera/',$_SERVER['HTTP_USER_AGENT'],$user_agent);
if($user_agent[0]!='MSIE') {

echo '<meta http-equiv="refresh" content="0;url=rss.xml"/>';

} else {
	$ver1=explode("MSIE ",$_SERVER['HTTP_USER_AGENT']);
	$ver2=explode(";",$ver1[1]);
	$version = $ver2[0];
	if($version<7) {
		
		header("Location: index.php?module=rss&act=show,1");
	}
	else echo '<meta http-equiv="refresh" content="0;url=rss.xml"/>';
}

dbclose();

ob_end_flush();

?>
