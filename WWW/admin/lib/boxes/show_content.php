<?

ob_start();

global $language,$main,$module,$sub,$link_sub;

include "../../../config.php";
include "../../../lib/inc/mysql.php";
include "../../../lib/inc/functions.php";

$language = getLanguage($cfg['lng']);
include "../../../languages/".$language.".php";
include "../../languages/".$language.".php";
include "../../languages/".$language."/menulist.php";

include "../inc/auth.inc.php";

auth();

include "../tags/tags_body.php";


body_on();

if(auth()==0) {
echo '';
}

else {
 
$sql = sql('SELECT content,width,height FROM viscms_freespace WHERE id='.intval($_GET['id']));
while (list($content,$width,$height) = dbrow($sql)) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-2" />
<meta name="Copyright" content="VISMEDIA => www.vismedia.pl" />
<meta name="Author" content="VISMEDIA => www.vismedia.pl" />

</head>
<style type="text/css">
body {
	margin-left: 0px;
	margin-right: 0px;
	margin-top: 0px;
	margin-bottom: 0px;
	font-family: Verdana;
	color: #000000;
	font-size: 10px;
}
</style>
<table cellpadding="0" cellspacing="0" style="width: <?=$width;?>px; height: <?=$height;?>px;">
	<tr valign="top">
		<td>
		<?=$content;?>
		</td>
	</tr>
</table>
<?
}
	
}

body_off();

dbclose();

ob_end_flush();


?>
