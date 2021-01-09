<?

function theme_on() {
global $cfg,$lang,$language,$main,$module,$sub;

$link = $_SERVER['REQUEST_URI'];
$link = str_replace("&","&amp;",$link);
$link = str_replace("?lng=".$_GET['lng'],"",$link);
$link = str_replace("&amp;lng=".$_GET['lng'],"",$link);
$ext = explode(".",$link);
if(!isset($_GET['module'])) $sb = '?'; else $sb='&amp;';

?>

<a name="top"></a>

<table width="100%" cellpadding="0" cellspacing="0" style="background-image: url('themes/<?=$cfg['theme'];?>/gfx/bg.gif'); background-repeat: repeat-x;" border="0">
	<tr>
		<td>&nbsp;</td>
		<td style="width: 986px;">
		
<table id="Table_01" style="width: 994px; height: 946px;" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="3" style="background-image: url('themes/<?=$cfg['theme'];?>/gfx/cms_p_01.gif'); background-repeat: no-repeat; height: 30px; width: 994px;">
	   	<table width="100%" cellpadding="0" cellspacing="">
	   		<tr>
		  		<td align="left" width="70%" style="padding-left: 15px;"><span class="last_log_as_txt"><?=$lang['logon_as'];?>: </span><span class="last_log_as"><?=$_SESSION["admin"];?></span></td>
		  		<td align="right" width="30%"><a href="../logout.php"><img src="themes/<?=$cfg['theme'];?>/gfx/language/<?=$language;?>/cms_p_logout.gif" alt="" border="0" /></a></td>
			 </tr>
		  </table>		  
    </td>
	</tr>
	<tr>
		<td colspan="3" style="background-image: url('themes/<?=$cfg['theme'];?>/gfx/language/<?=$language;?>/cms_p_02.gif'); background-repeat: no-repeat; height: 129px; width: 994px;" align="right" valign="top">
      <div class="version_top">visCMS v<?=$cfg['version'];?></div>
    </td>
	</tr>
	<tr>
		<td colspan="3">
			<img src="themes/<?=$cfg['theme'];?>/gfx/cms_p_03.gif" width="994" height="33" alt=""></td>
	</tr>
	<tr>
		<td colspan="3">
			<img src="themes/<?=$cfg['theme'];?>/gfx/cms_p_04.gif" width="994" height="14" alt=""></td>
	</tr>
	<tr valign="top">
		<td style="background-image: url('themes/<?=$cfg['theme'];?>/gfx/cms_p_05b.gif'); background-repeat: repeat-y; height: 699px; width: 234px;">
		  <table width="100%" cellpadding="0" cellspacing="0"><tr><td style="background-image: url('themes/<?=$cfg['theme'];?>/gfx/cms_p_05.gif'); background-repeat: no-repeat; height: 699px; width: 234px;">
		<?php include("lib/inc/menulist_exe.php"); ?>
			<br /><br />
      </td></tr></table>
    </td>
		<td style="width: 746px; background-color: #fff;">

		
<?php $div = HiddenTooLong(735); ?>
<div style="width: <?=$div;?>; overflow: hidden;">
<?
}

function theme_off() {
global $cfg,$lang;
?>
</div>

		</td>
		<td style="background-image: url('themes/<?=$cfg['theme'];?>/gfx/cms_p_07b.gif'); background-repeat: repeat-y;"  width="14">
			<img src="themes/<?=$cfg['theme'];?>/gfx/cms_p_07.gif" width="14" height="699" alt=""></td>
	</tr>
	<tr>
		<td colspan="3">
			<img src="themes/<?=$cfg['theme'];?>/gfx/cms_p_08.gif" width="994" height="13" alt=""></td>
	</tr>
	<tr>
		<td colspan="3" style="background-image: url('themes/<?=$cfg['theme'];?>/gfx/cms_p_09.gif'); height: 28px; padding-left: 234px;" class="footer2">
      <table cellspacing="0" cellpadding="0" width="100%" class="footer2">
        <tr>
          <td><?=$lang['all_rights_reserved'];?> &copy; 2008<? if(date("Y")!=2008) echo '-'.date("Y");?> <a href="http://www.vismedia.pl" class="footer2">VISMEDIA www.vismedia.pl</a></td>
          <td align="center">visCMS v. <?=$cfg['version'];?> | <a href="#top" class="footer2"><?=$lang['top'];?> ^</a> | <a href="http://www.vismedia.pl/kontakt.html" class="footer2"><?=$lang['contact'];?></a></td>
        </tr>
      </table>
    </td>
	</tr>
</table>

		</td>
		<td>&nbsp;</td>
	</tr>
</table>

<?
}

function theme_start_on() {
global $cfg,$lang,$language,$main,$module,$sub;

?>

<style type="text/css">
body {
	background: #333333;
}
</style>

<?

preg_match('/Firefox|MSIE|Opera/',$_SERVER['HTTP_USER_AGENT'],$user_agent);
if($user_agent[0]=='Opera') {
	$zindex=3;
} else $zindex=1;

?>

<div id="login" style="width: 100%; height: 500px; background-image: url('themes/<?=$cfg['theme'];?>/gfx/panel_bg_main.gif'); background-repeat: repeat-x; z-index: <?=$zindex;?>;">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
		<td>&nbsp;</td>
		<td style="width: 900px; height: 500px; background-image: url('themes/<?=$cfg['theme'];?>/gfx/panel_bg.png'); background-repeat: no-repeat;">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td style="height: 300px;" valign="top"><div class="table_login1">visCMS v<?=$cfg['version'];?></div></td>
	</tr>
	<tr>
		<td>
<?
}

function theme_start_off() {
global $cfg,$lang;
?>
		</td>
	</tr>
	<tr>
		<td style="height: 100px; padding-left: 220px; padding-top: 2px;" valign="top"><div class="table_login2"><?=$lang['all_rights_reserved'];?> &copy; 2008<? if(date("Y")!=2008) echo '-'.date("Y");?> <a href="http://www.vismedia.pl" class="table_login2">VISMEDIA www.vismedia.pl</a></div></td>
	</tr>
</table>
		</td>
		<td>&nbsp;</td>
	</tr>
</table>

</div>

<?
}



?>