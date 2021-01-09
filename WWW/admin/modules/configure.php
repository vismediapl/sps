<?

###############################
#           visCMS            #
############-------############
#          VISMEDIA           #
#       www.vismedia.pl       #
#      biuro@vismedia.pl      #
###############################

## MODULE: CONFIGURE ##

include 'languages/'.$language.'/configure.php';

$level->AddLevel($lang['configure'],'?module=configure');

$vars = explode(',',$_GET['act']);
$var_1 = $vars[0];
$var_2 = $vars[1];
$var_3 = $vars[2];

if(is_numeric($var_2) || $var_2=='') {

######################################

$var_2 = sqlfilter($var_2,6);

switch(@$var_1) {

   case '':
   if(auth()==2)
   browse();
   break;

   }

######################################

}

function browse() {
global $cfg,$lang,$msg,$level;

$categories = array('art','tra','nsl','cus','ads');

if($_POST['step'] == '1') {

$sqlOP = sql("SELECT `option` FROM viscms_config ORDER BY `option` ASC");
while(list($option) = dbrow($sqlOP)) {	
	$sql = sql("UPDATE viscms_config SET value = '".sqlfilter($_POST[$option],4)."' WHERE `option` = '".$option."'");
}
	
if($sql==true) {
  $msg = '<div class="message">'.$lang['configure_saved'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['configure_not_saved'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=configure");
 
}

else {

$level->ShowHead();

echo '<br />';

$action = '?module=configure';

$general = '<table width="100%" align="center" cellpadding="0" cellspacing="3">
	<tr valign="top">
		<td style="width: 250px;">'.$lang['configure_address'].'</td>
		<td><input type="text" name="address" value="'.$cfg['address'].'" style="width: 100%;" /></td>
	</tr>
	<tr valign="top">
		<td>'.$lang['configure_lng'].'</td>
		<td><select name="lng" style="width: 100%;">';

$sqlLang = sql("SELECT code,name FROM viscms_languages ORDER BY code ASC");
while(list($lc,$ln) = dbrow($sqlLang)) {
	if($cfg['lng']==$lc) $s = ' selected'; else $s='';
	$general .= '<option value="'.$lc.'"'.$s.'>'.$ln.'</option>';
}
		$general .= '</select></td>
	</tr>
	<tr valign="top">
		<td>'.$lang['configure_userpath'].'</td>
		<td><input type="text" name="userpath" value="'.$cfg['userpath'].'" style="width: 100%;" /></td>
	</tr>
	<tr valign="top">
		<td>'.$lang['configure_backuppath'].'</td>
		<td><input type="text" name="backuppath" value="'.$cfg['backuppath'].'" style="width: 100%;" /></td>
	</tr>
</table>
';

$form = new Form($action,'post');
$form->SetWidths('20%','80%');
$form->SetBold(1);
$form->AddAnyField($lang['configure_general'],$general);
for($i=0;$i<sizeof($categories);$i++) {

$text = '<table width="100%" align="center" cellpadding="0" cellspacing="3">
';

$sql = sql("SELECT `option` FROM viscms_config WHERE `option` LIKE CONVERT('".$categories[$i]."%' USING latin2) ORDER BY `option`");
while(list($option) = dbrow($sql)) {

	$text .= '	<tr valign="top">
		<td style="width: 250px;">'.$lang['configure_'.$option].'</td>
		<td><input type="text" name="'.$option.'" value="'.$cfg[$option].'" style="width: 100%;" /></td>
	</tr>
';
  
}

$text .= '</table>';

if(mysql_num_rows($sql)!=0)
	$form->AddAnyField($lang['configure_header_'.$categories[$i]],$text);
	
}
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();
   
  }
}

?>