<?

###############################
#           visCMS            #
############-------############
#          VISMEDIA           #
#       www.vismedia.pl       #
#      biuro@vismedia.pl      #
###############################

## MODULE: ADMINS ##

include 'languages/'.$language.'/admins.php';

$level->AddLevel($lang['admins'],'?module=admins');

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

   case 'add':
   if(auth()==2) add();
   break;

   case 'edit':
   if(auth()==2 && $var_2!=1) edit($var_2);
   break;
   
   case 'delete':
   if(auth()==2) delete($var_2);
   break;

   }

######################################

}

function browse() {
global $cfg,$lang,$language,$msg,$level,$links;

// poziom
$level->AddIcon("add","?module=admins&amp;act=add",$lang['admins_add']);
$level->ShowHead();

// linki
$links->AddLink($lang['admins_add'],"?module=admins&amp;act=add");
$links->AddLink($lang['admins_chpass2'],"?module=chpass");

echo '<script language="javascript">
function confirmSubmit() {
var agree=confirm("'.$lang['confirm_submit'].'");
if (agree)
	return true ;
else
	return false ;
}
</script>';

$links->Show();

$sql = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lang_id) = dbrow($sql);

$sqlmnr = sql("SELECT id FROM viscms_admins");
if(mysql_num_rows($sqlmnr)>0) {

// tworzenie nowej tabeli
$table = new Table('TableClass','TableClassHd',7,3);
$table->NewCell($lang['admins_login'],350,'left','left','bottom','top');
$table->NewCell($lang['admins_permission'],190,'center','center','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');

$sql = sql('SELECT id,login,super,email FROM viscms_admins ORDER BY login ASC');
while (list($id,$login,$super,$email) = dbrow($sql)) {

$admin = $login.'<br /><span class="date">'.$email.'</span>';
	
// tworzenie pola select
if($id!=1) {
$select = new Select($id);
$select->Add(strtolower($lang['edit']),'?module=admins&amp;act=edit,'.$id);
$select->Add(strtolower($lang['delete']),'?module=admins&amp;act=delete,'.$id,' onclick="return confirmSubmit();"');
$actions=$select->Ret();
} else $actions='-';
	
	if($super==1) { 
		$permission = $lang['admins_access_full'];
	}
	else $permission = $lang['admins_access_notfull'];

// wylistowanie wartosci
$values = array($admin,$permission,$actions);
$table->CellValue($values);

 }

$table->Show(); // pokaz tabele

$links->Show();

} else {
	echo '<div class="message">'.$lang['admins_not_found'].'</div>';
	echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
  }
}

function add() {
global $cfg,$lang,$language,$_POST,$var_1,$var_2,$msg;

if($_POST['step']==1) {
	
  if(checkEmail($_POST['email'])==true) {
  	
  	if(is_numeric($_POST['gg']) || $_POST['gg']==false) {
  		
  		$in=array("("," ","-",")","[","]");
  		
  		$_POST['phone'] = str_replace($in,"",$_POST['phone']);
  		if(is_numeric($_POST['phone']) || $_POST['phone']==false) {
  			
  			$sqlx = sql("SELECT login,email FROM viscms_admins WHERE email='".sqlfilter($_POST['email'],5)."' OR login='".sqlfilter($_POST['login'],5)."'");
  			if(mysql_num_rows($sqlx)==0) {
  				
	$sql = sql("INSERT INTO viscms_admins (login,password,firstname,surname,firm,email,phone,gg,skype,tlen,super,language_id) VALUES ('".sqlfilter($_POST['login'],5)."','".md5($_POST['newpassword'])."','".sqlfilter($_POST['firstname'],4)."','".sqlfilter($_POST['surname'],4)."','".sqlfilter($_POST['firm'],4)."','".sqlfilter($_POST['email'],5)."','".sqlfilter($_POST['phone'],4)."','".sqlfilter($_POST['gg'],4)."','".sqlfilter($_POST['skype'],4)."','".sqlfilter($_POST['tlen'],4)."','".$_POST['super']."','".$_POST['langua']."')");
  			} else $email_is_exists = '<div class="message">'.$lang['admins_email_login_exists'].'</div>';
	
  		} else $telnotvalid = '<div class="message">'.$lang['admins_tel_not_valid'].'</div>';
	
  	} else $ggnotvalid = '<div class="message">'.$lang['admins_gg_not_valid'].'</div>';

  } else $emailnotvalid = '<div class="message">'.$lang['admins_email_not_valid'].'</div>';
	
if($sql==true) {
  $msg = '<div class="message">'.$lang['admins_added'].'</div>';  
  } else {
  $msg = '<div class="message">'.$lang['admins_not_added'].'</div>';
  $msg .= $emailnotvalid.$email_is_exists.$ggnotvalid.$telnotvalid;
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=admins");
}

else {

@form();

  }

}

function edit($p) {
global $cfg,$var_1,$id,$login,$firstname,$surname,$firm,$email,$phone,$gg,$skype,$tlen,$langua,$super,$lang,$_POST;

if($_POST['step'] == '1') {

  if(checkEmail($_POST['email'])==true) {
  	
  	if(is_numeric($_POST['gg']) || $_POST['gg']==false) {
  		
  		$in=array("("," ","-",")","[","]");
  		
  		$_POST['phone'] = str_replace($in,"",$_POST['phone']);
  		if(is_numeric($_POST['phone']) || $_POST['phone']==false) {
  			
  			$sqlx = sql("SELECT login,email FROM viscms_admins WHERE (email='".sqlfilter($_POST['email'])."' OR login='".sqlfilter($_POST['login'])."') AND id!=".$p);
  			if(mysql_num_rows($sqlx)==0) {

		if($_POST['newpassword']!='')
			$sqlPASS = sql("UPDATE viscms_admins SET password='".md5($_POST['newpassword'])."' WHERE id=".$p);
  				
	$sql = sql("UPDATE viscms_admins SET login='".sqlfilter($_POST['login'],5)."',firstname='".sqlfilter($_POST['firstname'],4)."',surname='".sqlfilter($_POST['surname'],4)."',firm='".sqlfilter($_POST['firm'],4)."',email='".sqlfilter($_POST['email'],5)."',phone='".sqlfilter($_POST['phone'],5)."',gg='".sqlfilter($_POST['gg'],5)."',skype='".sqlfilter($_POST['skype'],4)."',tlen='".sqlfilter($_POST['tlen'],4)."',super='".$_POST['super']."',language_id='".$_POST['langua']."' WHERE id=".$p);
	
  			} else $email_is_exists = '<div class="message">'.$lang['email_login_exists'].'</div>';
	
  		} else $telnotvalid = '<div class="message">'.$lang['tel_not_valid'].'</div>';
	
  	} else $ggnotvalid = '<div class="message">'.$lang['gg_not_valid'].'</div>';

  } else $emailnotvalid = '<div class="message">'.$lang['email_not_valid'].'</div>';

if($sql==true)  {
  $msg = '<div class="message">'.$lang['admins_edited'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['admins_not_edited'].'</div>';
  $msg .= $emailnotvalid.$email_is_exists.$ggnotvalid.$telnotvalid;
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=admins");
}

else {
	
	$sql = sql('SELECT id,login,firstname,surname,firm,email,phone,gg,skype,tlen,language_id,super FROM viscms_admins WHERE id='.$p);
	while(list($id,$login,$firstname,$surname,$firm,$email,$phone,$gg,$skype,$tlen,$langua,$super) = dbrow($sql)) {
   		form($p);
	}
  }
}

function form($p) {
	global $cfg,$lang,$language,$level,$uid,$id,$login,$firstname,$surname,$firm,$email,$phone,$gg,$skype,$tlen,$langua,$super,$var_1;
	
if($var_1=='edit') {
	$header = $lang['admins_edit'];
	$action='?module=admins&amp;act=edit,'.$p;
	$edit_info = '<i>'.$lang['admins_newpass_info'].'</i>';
	$lng=$langua;
}
	
if($var_1=='add') {
	$header = $lang['admins_add1'];
	$action='?module=admins&amp;act=add';
	$lng=$language;
	$sqlLang = sql("SELECT id,code,name FROM viscms_languages WHERE code='".$language."'");
  if(list($lid,$lc,$ln) = dbrow($sqlLang)) {
	  $lng=$lid;
  }
	$super=0;
}

if($gg==0) $gg='';

$level->AddLevel($header);
$level->ShowHead();

echo '<br />
<script language="JavaScript">
function CheckEmail(email)
{
var test = /^[_.0-9A-Za-z-]+@([0-9A-Za-z][0-9A-Za-z-]+.)+[A-Za-z]{2,4}$/;
var result = email.match(test);

if (result == null)
{
alert("'.$lang['admins_register_error_email_nc'].'");
return false;
}
return true;
}

</script>';

$permissions_value = array();
array_push($permissions_value,array($lang['admins_access_notfull'],0));
array_push($permissions_value,array($lang['admins_access_full'],1));
array_push($permissions_value,array($lang['admins_access_contractors'],2));

// jezyk
$lng_fields = array();
$sqlLang = sql("SELECT id,code,name FROM viscms_languages ORDER BY code ASC");
while(list($lid,$lc,$ln) = dbrow($sqlLang)) {
	array_push($lng_fields,array($ln,$lid));
}

$form = new Form($action,'post',"multipart/form-data","form",'onsubmit="return CheckEmail(this.email.value);"');
$form->SetWidths('20%','80%');
$form->AddTextInput($lang['login'],'login',$login);
$form->AddPasswordInput($lang['admins_pass'],'newpassword','','',$edit_info);
$form->AddRadioInput($lang['admins_permission'],'super',$permissions_value,$super);
$form->AddTextInput($lang['admins_email'],'email',$email);
$form->AddTextInput($lang['admins_firstname'],'firstname',$firstname);
$form->AddTextInput($lang['admins_surname'],'surname',$surname);
$form->AddTextInput($lang['admins_firm'],'firm',$firm);
$form->AddTextInput($lang['admins_phone'],'phone',$phone);
$form->AddTextInput($lang['admins_gg'],'gg',$gg);
$form->AddTextInput($lang['admins_skype'],'skype',$skype);
$form->AddTextInput($lang['admins_tlen'],'tlen',$tlen);
$form->AddSelect($lang['admins_lang'],'langua',$lng_fields,$lng,'style="width: 100%"');
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();
	
}

function delete($p) {
	global $cfg,$lang;
	
	$sql = sql("DELETE FROM viscms_admins WHERE id=".$p."");

	if($sql==true) $msg = '<div class="message">'.$lang['admins_deleted'].'</div>';
	else $msg = '<div class="message">'.$lang['admins_not_deleted'].'</div>';
	setcookie('msg',$msg,time()+60);
  	header("Location: ?module=admins");
	
}

?>