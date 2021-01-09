<?

include 'languages/'.$language.'.php';

echo '<div class="header_main">'.$lang['control_panel'].'</div>';

session_start();

echo '<br />';

echo '<table width="95%" align="center" class="last_log">
';
if($_SESSION["ctime"]!='' && $_SESSION["cip"]!='') {
	echo '<tr valign="top"><td colspan="2" style="height: 1px; background-image: url(\'themes/'.$cfg['theme'].'/gfx/separator.gif\')"></td></tr><tr><td>'.$lang['last_login'].': &nbsp; </td><td align="right">'.date("d.m.Y - H:i",$_SESSION["ctime"]).', &nbsp;IP: '.$_SESSION["cip"].'</td></tr>';
	$ll=1;
}
if($_SESSION["uctime"]!='' && $_SESSION["ucip"]!='') {
	echo '<tr><td>'.$lang['last_ulogin'].': &nbsp; </td><td align="right">'.date("d.m.Y - H:i",$_SESSION["uctime"]).', &nbsp;IP: '.$_SESSION["ucip"].'</td></tr>';
	$ll=1;
}
if($ll!=1) echo '<tr><td colspan="2" align="center">'.$lang['1st'].'</td></tr>';
echo '<tr valign="top"><td colspan="2" style="height: 1px; background-image: url(\'themes/'.$cfg['theme'].'/gfx/separator.gif\')"></td></tr></table>';


echo '<br /><br />';
	
?>