<?
function theme_on() {
global $cfg,$lang,$language;

$link = $_SERVER['REQUEST_URI'];
$link = str_replace("&","&amp;",$link);
$link = str_replace("?lng=".$_GET['lng'],"",$link);
$link = str_replace("&amp;lng=".$_GET['lng'],"",$link);
$ext = explode(".",$link);
if(!isset($_GET['module'])) $sb = '?lng='; else $sb='&amp;lng=';
if(strstr($link,".php") && !strstr($link,"index.php")) {
	$linkt = explode(",",$link);
	$link = $linkt[0];
	$sb=',';
}

include 'lib/boxes/top.php';

?>

<div style="width: 950px; margin: auto;">
<img id="top_08" src="themes/<?=$cfg['theme'];?>/gfx/top_08.jpg" width="949" height="13" alt="" />

<table width="950" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td width="703">

<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"><tr><td>

<noscript>
    <object data="themes/<?=$cfg['theme'];?>/gfx/baner.swf"
            width="703" height="184" type="application/x-shockwave-flash">
     <param name="allowScriptAccess" value="sameDomain" />
     <param name="movie" value="themes/<?=$cfg['theme'];?>/gfx/baner.swf" />
     <param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />
    </object>
</noscript>
<script type="text/javascript">
//<!--
AC_RunFlContentX ("src","themes/<?=$cfg['theme'];?>/gfx/baner.swf","quality","high","bgcolor","#ffffff","width","703","height","184","name","flash","align","middle","allowscriptaccess","sameDomain","wmode","opaque");
//-->
</script>

<?
}

function theme_off() {
global $cfg,$lang;
?>
</td></tr></table>

	</td>
    <td valign="top">

<table width="100%" cellpadding="0" cellspacing="0"><tr><td>

<table width="230" align="right" border="0" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>
			<img src="themes/<?=$cfg['theme'];?>/gfx/h_efs.png" width="230" alt="" /></td>
	</tr>
	<tr valign="top">
		<td align="left" style="background-image: url('themes/<?=$cfg['theme'];?>/gfx/right_02.png');">

<div id="Data" style="font-size: 10px; font-weight: bold; padding-top: 0px; padding-bottom: 4px;" align="center"></div>

<? new FreeSpace(55); ?>
		</td>
  </tr>
	<tr valign="top">
		<td style="background-image: url('themes/<?=$cfg['theme'];?>/gfx/right_02.png');">
		  <img src="themes/<?=$cfg['theme'];?>/gfx/right_04.png" width="230" height="9" alt="" />
		</td>
	</tr>
</table>

</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>

<table width="230" align="right" border="0" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>
			<img src="themes/<?=$cfg['theme'];?>/gfx/right_00.png" width="230" alt="" /></td>
	</tr>
	<tr valign="top">
		<td align="left" style="background-image: url('themes/<?=$cfg['theme'];?>/gfx/right_02.png');"><br />
<? include 'lib/boxes/articles_short1.php'; ?>
		</td>
  </tr>
	<tr valign="top">
		<td style="background-image: url('themes/<?=$cfg['theme'];?>/gfx/right_02.png');">
		  <img src="themes/<?=$cfg['theme'];?>/gfx/right_04.png" width="230" height="9" alt="" />
		</td>
	</tr>
</table>

</td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td align="center">

<table width="230" align="right" border="0" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>
			<img src="themes/<?=$cfg['theme'];?>/gfx/right_01.png" width="230" alt="" /></td>
	</tr>
	<tr valign="top">
		<td align="left" style="background-image: url('themes/<?=$cfg['theme'];?>/gfx/right_02.png');"><br />
<? include 'lib/boxes/partners.php'; ?>
		</td>
  </tr>
	<tr valign="top">
		<td style="background-image: url('themes/<?=$cfg['theme'];?>/gfx/right_02.png');">
		  <img src="themes/<?=$cfg['theme'];?>/gfx/right_04.png" width="230" height="9" alt="" />
		</td>
	</tr>
</table>

</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>

<table width="230" align="right" border="0" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>
			<img src="themes/<?=$cfg['theme'];?>/gfx/h_forum.png" width="230" alt="" /></td>
	</tr>
	<tr valign="top">
		<td align="left" style="background-image: url('themes/<?=$cfg['theme'];?>/gfx/right_02.png');">
		
<? new FreeSpace(54); ?>
		</td>
  </tr>
	<tr valign="top">
		<td style="background-image: url('themes/<?=$cfg['theme'];?>/gfx/right_02.png');">
		  <img src="themes/<?=$cfg['theme'];?>/gfx/right_04.png" width="230" height="9" alt="" />
		</td>
	</tr>
</table>

</td></tr>
<!--<tr><td>&nbsp;</td></tr>

<tr><td align="center">

<table width="230" align="right" border="0" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/h_praca_sps.png" alt="" /></td>
	</tr>
	
	<tr valign="top">
		<td style="background-image: url('themes/<?=$cfg['theme'];?>/gfx/right_07.png');"><? new FreeSpace(42); ?></td>
	</tr>
	
	<tr>
		<td>
			<img src="themes/<?=$cfg['theme'];?>/gfx/right_09.png" width="230" height="9" alt="" /></td>
	</tr>
	
</table>

</td></tr>
-->
</table>
    </td>
  </tr>
  <tr>
  	<td colspan="2">
<table width="950" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<img src="themes/<?=$cfg['theme'];?>/gfx/footer_01.png" width="950" height="19" alt="" /></td>
	</tr>
	<tr>
		<td width="950" height="18" bgcolor="#FFFFFF"><table width="100%" cellpadding="0" cellspacing="0"><tr><td class="footer">Studio Profilaktyki Spo³ecznej &copy; 2008<? $y = date("Y"); if($y!=2008) echo ' - '.$y; ?></td><td align="right" class="footer">Programowanie &amp; CMS: <a href="http://www.vismedia.pl" target="_blank" class="footer">VisMedia</a></td></tr></table>
		</td>
	</tr>
</table>
  	</td>
  </tr>
</table>

</div>

<?
}

?>