<?

###############################
#           visCMS            #
############-------############
#          VISMEDIA           #
#       www.vismedia.pl       #
#      biuro@vismedia.pl      #
###############################

## MODULE: CONTACT ##

include 'languages/'.$language.'/contact.php';

$level->AddLevel($lang['contact'],'?module=contact');

$vars = explode(',',$_GET['act']);
$var_1 = $vars[0];
$var_2 = $vars[1];
$var_3 = $vars[2];

if(is_numeric($var_2) || $var_2=='') {

###################################### 

if(auth()!=3)
switch(@$var_1) {

   case '':
   browse();
   break;

   }

######################################

}

function browse() {
global $cfg,$lang,$level,$msg;

if($_POST['step'] == '1') {

$k=0;
$em=0;

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	
	if(checkEmail($_POST['email_lang-'.$lid])==true) {
	$sqlC = sql("SELECT email FROM viscms_contact WHERE language_id=".$lid);
	if(mysql_num_rows($sqlC)==0) {
		$sql = sql("INSERT INTO viscms_contact (language_id,name,email,text) VALUES('".$lid."','".sqlfilter($_POST['name_lang-'.$lid],4)."','".sqlfilter($_POST['email_lang-'.$lid],4)."','".sqlfilter($_POST['content_lang-'.$lid],7)."')");
	} else {
		$sql = sql("UPDATE viscms_contact SET name = '".sqlfilter($_POST['name_lang-'.$lid],4)."', email = '".sqlfilter($_POST['email_lang-'.$lid],4)."', text = '".sqlfilter($_POST['content_lang-'.$lid],7)."' WHERE language_id=".$lid);
	}
	if($sql==true) $k++;
  } else $em++;
}
if(mysql_num_rows($sqlLang)==$k) {
	
  $msg = '<div class="message">'.$lang['contact_saved'].'</div>';
  } else {
  if($em>0) $msg = '<div class="message">'.$lang['contact_email_not_correct'].'</div>';
  $msg .= '<div class="message">'.$lang['contact_not_saved'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=contact");
 
}

else {

$level->ShowHead();

echo '<br/>';

$form = new Form($action,'post');

	
$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	
	$sql = sql('SELECT name,email,text FROM viscms_contact WHERE language_id='.$lid);
	if(list($name,$email,$text) = dbrow($sql)) {
		$n[$lid] = $name;
		$e[$lid] = $email;
		$t[$lid] = $text;
	}
	
}

$form->SetWidths('20%','80%');
$form->FCK();
$form->MultiLanguage(1);
$form->AddTextInput($lang['contact_showname'],'name',$n);
$form->AddTextInput($lang['contact_email'],'email',$e);
$form->AddFCK($lang['contact_content'],'content',$t);
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();

  }
}

?>