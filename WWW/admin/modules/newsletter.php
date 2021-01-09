<?

###############################
#           visCMS            #
############-------############
#          VISMEDIA           #
#       www.vismedia.pl       #
#      biuro@vismedia.pl      #
###############################

## MODULE: NEWSLETTER ##

include 'languages/'.$language.'/newsletter.php';

$level->AddLevel($lang['newsletter'],'?module=newsletter');

$vars = explode(',',$_GET['act']);
$var_1 = $vars[0];
$var_2 = $vars[1];
$var_3 = $vars[2];

if(is_numeric($var_2) || $var_2=='') {

######################################

$var_2 = sqlfilter($var_2,6);

if(auth()!=3)
switch(@$var_1) {

   case '':
   browse(1);
   break;
   
   case 'page':
   browse($var_2);
   break;
   
   case 'send':
   send($var_2);
   break;
   
   case 'delete':
   delete($var_2);
   break;
   
   case 'add':
   add();
   break;
   
   case 'edit':
   edit($var_2);
   break;
   
   case 'users':
   users($var_2);
   break;
   
   case 'users_active':
   users_active($var_2);
   break;
   
   case 'users_deactive':
   users_deactive($var_2);
   break;
   
   case 'users_delete':
   users_delete($var_2);
   break;
   
   case 'users_add':
   users_add($var_2);
   break;
   
   case 'users_edit':
   users_edit($var_2);
   break;

   }

######################################

}

function browse($q) {
global $cfg,$lang,$language,$level,$links;

$btc = 0;

if($q=='') $q=1;
$str = ($q-1)*$cfg['nsllimitrows'];

echo '<script language="javascript">
function confirmSubmit() {
var agree=confirm("'.$lang['confirm_submit'].'");
if (agree)
	return true ;
else
	return false ;
}
</script>';

// poziom
$level->AddIcon("add","?module=newsletter&amp;act=add",$lang['newsletter_add']);
$level->AddIcon("show","?module=newsletter&amp;act=users",$lang['newsletter_users_manage']);
$level->ShowHead();

// linki
$links->AddLink($lang['newsletter_add'],"?module=newsletter&amp;act=add");
$links->AddLink($lang['newsletter_users_manage'],"?module=newsletter&amp;act=users");

	if($_GET['sent']==1) {
		$clause = " WHERE sent!=''";
		$page_act = '&amp;sent=1';
		$links->AddLink($lang['newsletter_show_all'],"?module=newsletter");
		$links->AddLink($lang['newsletter_show_nsent'],"?module=newsletter&amp;sent=0");
	}
	elseif($_GET['sent']=='0') {
		$clause = " WHERE sent=''";
		$page_act = '&amp;sent=0';
		$links->AddLink($lang['newsletter_show_all'],"?module=newsletter");
		$links->AddLink($lang['newsletter_show_sent'],"?module=newsletter&amp;sent=1");
	} elseif($_GET['sent']=='') {
		$links->AddLink($lang['newsletter_show_sent'],"?module=newsletter&amp;sent=1");
		$links->AddLink($lang['newsletter_show_nsent'],"?module=newsletter&amp;sent=0");
}

$links->Show();

$sqlmnr = sql("SELECT id FROM viscms_newsletter".$clause." LIMIT ".$str.",".$cfg['nsllimitrows']);
if(mysql_num_rows($sqlmnr)>0) {

// tworzenie nowej tabeli
$table = new Table('TableClass','TableClassHd',7,3);
$table->NewCell($lang['newsletter_subject'],410,'left','left','bottom','top');
$table->NewCell($lang['newsletter_lng'],130,'center','center','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');

$sql = sql('SELECT id,subject,sent,language_id FROM viscms_newsletter'.$clause.' ORDER BY id DESC LIMIT '.$str.','.$cfg['nsllimitrows']);
while (list($id,$title,$time,$lang_id) = dbrow($sql)) {
	
	$sqlLang = sql("SELECT name FROM viscms_languages WHERE id='".$lang_id."'");
	list($lng) = dbrow($sqlLang);
	
// tworzenie pola select
$select = new Select($id);
$select->Add(strtolower($lang['edit']),'?module=newsletter&amp;act=edit,'.$id);
$select->Add(strtolower($lang['delete']),'?module=newsletter&amp;act=delete,'.$id,' onclick="return confirmSubmit();"');

$message = '<b>'.$title.'</b><br /><span class="date">'.$lang['newsletter_status'].': ';

if($time>0) {
	$message .= '<font color="#008000">'.$lang['newsletter_sent'].' '.date("Y-m-d H:i",$time).'</font> &nbsp; [ <a href="?module=newsletter&amp;act=send,'.$id.'" class="LinksOnGrey">'.strtolower($lang['newsletter_send_omt']).'</a> ]';
	$select->Add(strtolower($lang['newsletter_send_omt']),'?module=newsletter&amp;act=send,'.$id);
}
else {
	$message .= '<font color="#FF0000">'.$lang['newsletter_nsent'].'</font> &nbsp; [ <a href="?module=newsletter&amp;act=send,'.$id.'" class="LinksOnGrey">'.strtolower($lang['newsletter_send']).'</a> ]';
	$select->Add(strtolower($lang['newsletter_send']),'?module=newsletter&amp;act=send,'.$id);
};
$message .= '</span>';

$actions=$select->Ret();

// wylistowanie wartosci
$values = array($message,$lng,$actions);
$table->CellValue($values);

 }

$table->Show(); // pokaz tabele

$links->Show();

$pages = new Pages($q, "?module=newsletter&amp;act=page", $cfg['nsllimitrows']);
$pages->Sql("SELECT id FROM viscms_newsletter");
$pages->Show();

} else {
	echo '<div class="message">'.$lang['newsletter_not_found'].'<br /><a href="?module=newsletter&amp;act=add">'.$lang['newsletter_add'].'</a></div>';
	echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
  }
}

function send($p) {
global $cfg,$lang;

$t=0;

$sql = sql("SELECT subject,content,language_id FROM viscms_newsletter WHERE id=".$p);
if(list($subject,$content,$lang_id)=dbrow($sql)) {
	
$in=array('&#8222;','&#8221;','&#8211;');
$out=array('"','"','-');
	$content.="\n\n".$lang['newsletter_info1']."\n".$lang['newsletter_info2'].":\n".$cfg['address'].'/newsletter-delete-';
	$sqlUSERS = sql("SELECT id,email,code FROM viscms_newsletter_users WHERE language_id=".$lang_id." AND time>0");
	while(list($uid,$email,$code)=dbrow($sqlUSERS)) {
		$contentU=$content.$uid.'-'.$code.'.php';
		$m=mail($email,$subject,str_replace($in,$out,$contentU),'From: '.$cfg['nslemailname'].' <'.$cfg['nslemail'].'>');
		if($m==true) $t++;
	}
}

if($t==mysql_num_rows($sqlUSERS))
	$sqlX = sql("UPDATE viscms_newsletter SET sent='".time()."' WHERE id=".$p);
	
if($sqlX==true)  {
  $msg = '<div class="message">'.$lang['newsletter_hb_sent'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['newsletter_hb_not_sent'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=newsletter");

}

function delete($p) {
global $cfg,$lang;

$sql = sql("DELETE FROM viscms_newsletter WHERE id=".$p);
	
if($sql==true)  {
  $msg = '<div class="message">'.$lang['newsletter_deleted'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['newsletter_not_deleted'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=newsletter");
}

function add() {
global $cfg,$lang,$language,$_POST,$var_1,$var_2,$i;

if($_POST['step'] == '1') {

	$sql = sql("INSERT INTO viscms_newsletter (subject,language_id,content) VALUES ('".sqlfilter($_POST['subject'],4)."','".$_POST['lng']."','".sqlfilter($_POST['content'],4)."')");
	$mid=mysql_insert_id();
	
if($_POST['submit']==' '.$lang['save'].' ') {
	if($sql==true) {
  $msg = '<div class="message">'.$lang['newsletter_saved'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['newsletter_not_saved'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=newsletter");
} elseif($_POST['submit']==' '.$lang['send'].' ') if($sql==true) send($mid);

}

else {

@form1($p);

  }

}

function edit($p) {
global $cfg,$var_1,$email,$lang_id,$lang,$subject,$content;

if($_POST['step'] == '1') {

  	$sql = sql("UPDATE viscms_newsletter SET subject = '".sqlfilter($_POST['subject'],4)."', content = '".sqlfilter($_POST['content'],4)."', language_id=".$_POST['lng']." WHERE id=".$p);
	
if($_POST['submit']==' '.$lang['save'].' ') {
	if($sql==true) {
  $msg = '<div class="message">'.$lang['newsletter_saved'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['newsletter_not_saved'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=newsletter");
} elseif($_POST['submit']==' '.$lang['send'].' ') if($sql==true) send($p);

}

else {
	
	$sql = sql('SELECT subject,content,language_id FROM viscms_newsletter WHERE id='.$p);
	if(list($subject,$content,$lang_id) = dbrow($sql)) {
   		form1($p);
	}
   
  }
}

function form1($p) {
global $cfg,$lang,$language,$language_id,$var_1,$email,$lang_id,$subject,$content,$level;

if($var_1=='edit') {
	$action = '?module=newsletter&amp;act=edit,'.$p;
	$header = $lang['newsletter_edit'];
} elseif($var_1=='add') {
		$header = $lang['newsletter_add'];
		$action = '?module=newsletter&amp;act=add';
}

$level->AddLevel($header);
$level->ShowHead();

echo '<br/>';

// jezyk
$lng_fields = array();
$sqlLang = sql("SELECT id,code,name FROM viscms_languages ORDER BY code ASC");
while(list($lid,$lc,$ln) = dbrow($sqlLang)) {
	array_push($lng_fields,array($ln,$lid));
}
  
  $default=$language_id;
  
  if($lang_id=='') $lang_id=$default;
  
$text = '<b>'.$lang['notice'].'</b> '.$lang['newsletter_notice'];

$text2 = '<div align="center" style="padding: 5px;"><input type="image" src="themes/'.$cfg['theme'].'/gfx/language/'.$language.'/input_save.gif" style="border: 0px;" name="submit" value=" '.$lang['save'].' " /> <input type="image" src="themes/'.$cfg['theme'].'/gfx/language/'.$language.'/input_send.gif" style="border: 0px;" name="submit" value=" '.$lang['send'].' " /></div>';

$form = new Form($action,'post');
$form->SetWidths('20%','80%');
$form->AddTextInput($lang['newsletter_subject'],'subject',$subject);
$form->AddTextarea($lang['newsletter_content'],'content',$content,'rows="15" style="width: 100%;"');
$form->AddSelect($lang['newsletter_lng'],'lng',$lng_fields,$lang_id,'style="width: 100%"');
$form->QuoteAfterTable($text);
$form->AddAnyFieldAfterTable($text2);
$form->AddHidden('step',1);
$form->Show();

echo '<p align="center"><a href="?module=newsletter"><b>'.$lang['newsletter_back'].'</b></a></p>';
}

function users($q) {
global $cfg,$lang,$language,$links,$level;

$btc = 0;

if($q=='') $q=1;
$str = ($q-1)*$cfg['nsllimitrows'];

echo '<script language="javascript">
function confirmSubmit() {
var agree=confirm("'.$lang['confirm_submit'].'");
if (agree)
	return true ;
else
	return false ;
}
</script>';

	if($_GET['active']=='ACT') {
		$clause = " WHERE time!=''";
		$page_act = '&amp;active=ACT';
	}
	elseif($_GET['active']=='DEACT') {
		$clause = " WHERE time=''";
		$page_act = '&amp;active=DEACT';
	}

$sqlA = sql("SELECT id FROM viscms_newsletter_users WHERE time!=''");
$count_A=mysql_num_rows($sqlA);
$sqlD = sql("SELECT id FROM viscms_newsletter_users WHERE time=''");
$count_D=mysql_num_rows($sqlD);

$level->AddLevel($lang['newsletter_users']);

// poziom
$level->AddIcon("add","?module=newsletter&act=users_add",$lang['newsletter_users_add']);
$level->ShowHead();

// linki
$links->AddLink($lang['newsletter_users_add'],"?module=newsletter&act=users_add");

if($_GET['active']=='ACT') {
  $links->AddLink($lang['newsletter_show_all'],"?module=newsletter&act=users");
  $links->AddLink($lang['newsletter_show_deactive'],"?module=newsletter&act=users&amp;active=DEACT");
} elseif($_GET['active']=='DEACT') {
  $links->AddLink($lang['newsletter_show_all'],"?module=newsletter&act=users");
  $links->AddLink($lang['newsletter_show_active'],"?module=newsletter&act=users&amp;active=ACT");
} else {
  $links->AddLink($lang['newsletter_show_active'],"?module=newsletter&act=users&amp;active=ACT");
  $links->AddLink($lang['newsletter_show_deactive'],"?module=newsletter&act=users&amp;active=DEACT");
}

$links->Show();

echo '<b>'.$lang['newsletter_users_count'].'</b>: '.($count_A+$count_D).' (<i>'.$lang['newsletter_users_count_A'].': '.$count_A.', '.$lang['newsletter_users_count_D'].': '.$count_D.'</i>)<br />&nbsp;';

$sqlmnr = sql("SELECT id FROM viscms_newsletter_users".$clause." LIMIT ".$str.",".$cfg['nsllimitrows']);
if(mysql_num_rows($sqlmnr)>0) {

// tworzenie nowej tabeli
$table = new Table('TableClass','TableClassHd',7,3);
$table->NewCell($lang['newsletter_users_email'],300,'left','left','bottom','top');
$table->NewCell($lang['newsletter_date'],105,'center','center','bottom','top');
$table->NewCell($lang['newsletter_lng'],120,'center','center','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');

$sql = sql('SELECT id,email,time,language_id FROM viscms_newsletter_users'.$clause.' ORDER BY email ASC LIMIT '.$str.','.$cfg['nsllimitrows']);
while (list($id,$email,$time,$lang_id) = dbrow($sql)) {
	
	$sqlLang = sql("SELECT name FROM viscms_languages WHERE id='".$lang_id."'");
	list($lng) = dbrow($sqlLang);
	
	$user = '<b>'.$email.'</b><br /><span class="date">'.$lang['newsletter_status'].': ';

if($time>0) {
	$user .= '<font color="#008000">'.$lang['newsletter_active'].'</font> &nbsp; [ <a href="?module=newsletter&amp;act=users_deactive,'.$id.'" class="activate">'.$lang['newsletter_deactivate'].'</a> ]';
	$date = date("Y-m-d H:i",$time);
}
else {
	$user .= '<font color="#FF0000">'.$lang['newsletter_deactive'].'</font> &nbsp; [ <a href="?module=newsletter&amp;act=users_active,'.$id.'" class="activate">'.$lang['newsletter_activate'].'</a> ]';
	$date = '-';
}

$user .= '</span>';

// tworzenie pola select
$select = new Select($id);
$select->Add(strtolower($lang['edit']),'?module=newsletter&act=users_edit,'.$id);
$select->Add(strtolower($lang['delete']),'?module=newsletter&act=users_delete,'.$id,' onclick="return confirmSubmit();"');
$actions=$select->Ret();

// wylistowanie wartosci
$values = array($user,$date,$lng,$actions);
$table->CellValue($values);

 }
 
$table->Show(); // pokaz tabele
    
$links->Show(); // pokaz linki

$pages = new Pages($q, "?module=newsletter&amp;act=users", $cfg['nsllimitrows']);
$pages->Sql("SELECT id FROM viscms_newsletter_users".$clause);
$pages->AddExt($page_act);
$pages->Show();

} else {
	echo '<div class="message">'.$lang['newsletter_users_not_found'].'</div>';
	echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
  }
}

function users_active($p) {
global $cfg,$lang;

	$sql = sql("UPDATE viscms_newsletter_users SET time='".time()."' WHERE id=".$p);
	
if($sql==true)  {
  $msg = '<div class="message">'.$lang['newsletter_users_activated'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['newsletter_users_not_activated'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=newsletter&act=users");
}

function users_deactive($p,$q) {
global $cfg,$lang,$var_2;

	$sql = sql("UPDATE viscms_newsletter_users SET time='' WHERE id=".$p);
	
if($sql==true)  {
  $msg = '<div class="message">'.$lang['newsletter_users_deactivated'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['newsletter_users_not_deactivated'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=newsletter&act=users");
}

function users_delete($p) {
global $cfg,$lang;

$sql = sql("DELETE FROM viscms_newsletter_users WHERE id=".$p);
	
if($sql==true)  {
  $msg = '<div class="message">'.$lang['newsletter_users_deleted'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['newsletter_users_not_deleted'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=newsletter&act=users");
}

function users_add() {
global $cfg,$lang,$language,$_POST,$var_1,$var_2,$i;

if($_POST['step'] == '1') {
	
  if(checkEmail($_POST['email'])==true) {
  	
  	$sqlCH = sql("SELECT id FROM viscms_newsletter_users WHERE email='".$_POST['email']."' AND language_id=".$_POST['lng']);
  	if(mysql_num_rows($sqlCH)==0) {
  	
  	$string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$shuffle = str_shuffle($string);
	$code = substr($shuffle, 0, 16);
  	
	$sql = sql("INSERT INTO viscms_newsletter_users (email,language_id,code,time) VALUES ('".sqlfilter($_POST['email'],4)."','".$_POST['lng']."','".$code."','".time()."')");
	
  	} else $emailNV = '<div class="message">'.$lang['newsletter_email_is_exists'].'</div>';

  } else $emailNV = '<div class="message">'.$lang['newsletter_email_not_valid'].'</div>';

if($sql==true) {
  $msg = '<div class="message">'.$lang['newsletter_users_added'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['newsletter_users_not_added'].'</div>'.$emailNV;
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=newsletter&act=users");
}

else {

@form1u($p);

  }

}

function users_edit($p) {
global $cfg,$var_1,$email,$lang_id,$lang,$_POST,$i;

if($_POST['step'] == '1') {

  if(checkEmail($_POST['email'])==true) {
  	
  	$sqlCH = sql("SELECT id FROM viscms_newsletter_users WHERE email='".$_POST['email']."' AND id!=".$p." AND language_id=".$_POST['lng']);
  	if(mysql_num_rows($sqlCH)==0) {
  		
  	$sql = sql("UPDATE viscms_newsletter_users SET email = '".sqlfilter($_POST['email'],4)."', language_id=".$_POST['lng']." WHERE id=".$p);
	
  	} else $emailNV = '<div class="message">'.$lang['newsletter_email_is_exists'].'</div>';

  } else $emailNV = '<div class="message">'.$lang['newsletter_email_not_valid'].'</div>';

if($sql==true) {
  $msg = '<div class="message">'.$lang['newsletter_users_edited'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['newsletter_users_not_edited'].'</div>'.$emailNV;
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=newsletter&act=users");
}

else {
	
	$sql = sql('SELECT email,language_id FROM viscms_newsletter_users WHERE id='.$p);
	if(list($email,$lang_id) = dbrow($sql)) {
   		form1u($p);
	}
   
  }
}

function form1u($p) {
global $cfg,$lang,$language,$language_id,$var_1,$email,$lang_id,$level;

if($var_1=='users_edit') {
	$action = '?module=newsletter&amp;act=users_edit,'.$p;
	$header = $lang['newsletter_users_edit'];
} elseif($var_1=='users_add') {
		$header = $lang['newsletter_users_add'];
		$action = '?module=newsletter&amp;act=users_add';
}

$level->AddLevel($header);
$level->ShowHead();

echo '<script language="JavaScript">
function CheckEmail(email)
{
var test = /^[_.0-9A-Za-z-]+@([0-9A-Za-z][0-9A-Za-z-]+.)+[A-Za-z]{2,4}$/;
var result = email.match(test);

if (result == null)
{
alert("'.$lang['newsletter_email_not_valid'].'");
return false;
}
return true;
}
</script>';

echo '<br/>';

// jezyk
$lng_fields = array();
$sqlLang = sql("SELECT id,code,name FROM viscms_languages ORDER BY code ASC");
while(list($lid,$lc,$ln) = dbrow($sqlLang)) {
	array_push($lng_fields,array($ln,$lid));
}
  
$default=$language_id;
  
if($lang_id=='') $lang_id=$default;

$form = new Form($action,'post',"multipart/form-data","form","return CheckEmail(this.email.value);");
$form->SetWidths('20%','80%');
$form->FCK();
$form->AddTextInput($lang['newsletter_users_email'],'email',$email);
$form->AddSelect($lang['newsletter_lng'],'lng',$lng_fields,$lang_id,'style="width: 100%"');
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();

echo '<p align="center"><a href="?module=newsletter"><b>'.$lang['newsletter_back'].'</b></a></p>';
}

?>