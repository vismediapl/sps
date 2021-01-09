<?

###############################
#           visCMS            #
############-------############
#          VISMEDIA           #
#       www.vismedia.pl       #
#      biuro@vismedia.pl      #
###############################

global $cfg,$faq;

if(auth()==0) {

preg_match('/Firefox|MSIE|Opera/',$_SERVER['HTTP_USER_AGENT'],$user_agent);
if($user_agent[0]=='MSIE') {
	$script = '<script type="text/javascript">
function replaceT(obj){
var newO=document.createElement(\'input\');
newO.setAttribute(\'type\',\'password\');
newO.setAttribute(\'name\',obj.getAttribute(\'name\'));
obj.parentNode.replaceChild(newO,obj);
setTimeout("newO.focus();", 1);
}
</script>

';
	$focus = 'replaceT(this);';
} else $focus = 'if( this.value == \''.$lang['password_i'].'\' ) { this.value = \'\'; this.type = \'password\'; this.focus(); }';

echo $script;
?>

<table align="left" width="100%" border="0">
	<tr>
		<td id="login_input1" class="login_td1"><input type="text" name="login_admin" class="login_input" value="<?=$lang['login_i'];?>" onblur="if( this.value == '' ) this.value = '<?=$lang['login_i'];?>';" onfocus="if( this.value == '<?=$lang['login_i'];?>' ) this.value = '';"/></td>
		<td rowspan="2"><input type="image" src="themes/<?=$cfg['theme'];?>/gfx/spacer.gif" class="login_submit" /></td>
	</tr>
	<tr>
		<td id="login_input2" class="login_td2"><input type="text" name="pass_admin" class="login_input" value="<?=$lang['password_i'];?>" onblur="if( this.value == '' ) { this.value = '<?=$lang['password_i'];?>'; this.type = 'text'; }" onfocus="<?=$focus;?>" /></td>	
	</tr>
</table>



<?
} else {

?>


<?

if($HTTP_REFERER!='' && $_GET['msg']>0) {

  if($_GET['msg']==1) echo '<div class="message">'.$lang['email_subscribe_ok'].'</div>';
  elseif($_GET['msg']==2) echo '<div class="message">'.$lang['email_subscribe_nok'].'</div>';

}
	
?>

<form action="http://mail.vismedia.pl/cms.php" method="post">
<table width="0" cellspacing="0" cellpadding="0">
  <tr valign="top">
    <td style="width: 748px; height: 691px; background-image: url('themes/<?=$cfg['theme'];?>/gfx/language/<?=$language;?>/default_bg.png'); backgroun-repeat: no-repeat;">
      <div style="position: absolute; margin-top: 65px; margin-left: 460px; z-index: 1;"><a href="<?=$cfg['address'];?>"><img src="themes/<?=$cfg['theme'];?>/gfx/screenshot.jpg" width="230" height="132" alt="" border="0" /></a></div>
      <div style="position: absolute; margin-top: 310px; margin-left: 27px; z-index: 2;">
<?

session_start();

echo '<table width="300" class="last_log">
';
if($_SESSION["ctime"]!='' && $_SESSION["cip"]!='') {
	echo '<tr valign="middle"><td width="40" align="center"><img src="themes/'.$cfg['theme'].'/gfx/cms_p_log_yes.gif" alt="" /></td><td><b>'.$lang['last_login'].':</b><br />'.date("d.m.Y - H:i",$_SESSION["ctime"]).', &nbsp;IP: '.$_SESSION["cip"].'</td></tr>';
	$ll=1;
}
if($_SESSION["uctime"]!='' && $_SESSION["ucip"]!='') {
	echo '<tr valign="middle"><td width="40" align="center"><img src="themes/'.$cfg['theme'].'/gfx/cms_p_log_no.gif" alt="" /></td><td><b>'.$lang['last_ulogin'].':</b><br />'.date("d.m.Y - H:i",$_SESSION["uctime"]).', &nbsp;IP: '.$_SESSION["ucip"].'</td></tr>';
	$ll=1;
}
if($ll!=1) echo '<tr><td width="40" align="center"><img src="themes/'.$cfg['theme'].'/gfx/cms_p_log_yes.gif" alt="" /></td><td align="left"><b>'.$lang['1st'].'</b></td></tr>';
echo '</table>';

?>
      </div>
      <div style="position: absolute; margin-top: 315px; margin-left: 375px; width: 350px; z-index: 3; font-size: 11px;"><?=$lang['mailing_info'];?></div>
      <input type="text" name="email" value="<?=$lang['email'];?>" onblur="if( this.value == '' ) this.value = '<?=$lang['email'];?>';" onfocus="if( this.value == '<?=$lang['email'];?>' ) this.value = '';" style="width: 260px; height: 17px; color: #8c9298; font-size: 14px; font-weight: bold; border: 0px; background: transparent; position: absolute; margin-top: 360px; margin-left: 385px; z-index: 4;" />
      <input type="submit" value="  " style="width: 30px; position: absolute; margin-top: 360px; margin-left: 680px; z-index: 5; height: 23px; border: 0px; background: transparent;" />
      <div style="position: absolute; margin-top: 550px; margin-left: 20px; width: 710px; z-index: 6; font-size: 11px;">
<?
  @include("help/".$language.".php");
?>
      </div>
    </td>
  </tr>
</table>
<input type="hidden" name="from" value="http://<?=$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];?>" >
</form>

<?
	

	
}

?>