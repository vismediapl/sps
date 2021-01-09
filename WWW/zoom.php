<?php
echo '<?xml version="1.0" encoding="iso-8859-2" ?>';

$hua = explode(";",$_SERVER['HTTP_USER_AGENT']);
$language = $hua[3];

if(!file_exists("admin/languages/".$language.".php")) $language = 'pl';
include "admin/languages/".$language.".php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/
xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=iso-8859-2" />
<title><?=$lang['preview'];?></title>
</head>
<body marginheight="0" marginwidth="0" style="margin: 0;">
<?php

// pobieram dane oryginału
$z = $_GET['z'];

if($z) {
    // wyświetlam oryginał
    echo "<a href=\"javascript:window.close();\"><img
 src=\"$z\" border=\"0\" title=\"".$lang['close_window']."\" /></a>";
}

?>
</body>
</html>