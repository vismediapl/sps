<?

###############################
#           visCMS            #
############-------############
#          VISMEDIA           #
#       www.vismedia.pl       #
#      biuro@vismedia.pl      #
###############################

## MODULE: MESSAGES ##

include 'languages/'.$language.'/messages.php';

$level->AddLevel($lang['messages'],'?module=messages');

$vars = explode(',',$_GET['act']);
$var_1 = $vars[0];
$var_2 = $vars[1];
$var_3 = $vars[2];

if(is_numeric($var_2) || $var_2=='') {

###################################### 

if(auth()!=3)
switch(@$var_1) {

   case '':
   	if(auth()==2)
   		browse();
   break;

   }

######################################

}

function browse() {
global $cfg,$lang,$language,$level;

$types=array('admins');

if($_POST['step']==1) {
	
	$k=0;
	
$sqlLang = sql("SELECT id FROM viscms_languages ORDER BY id ASC");
while(list($lid) = dbrow($sqlLang)) {
	
for($i=0;$i<sizeof($types);$i++) {
	
	$sql = sql('SELECT text FROM viscms_messages WHERE type="'.$types[$i].'" AND language_id='.$lid);
	if(list($t) = dbrow($sql)) {
		$sqlA = sql("UPDATE viscms_messages SET text='".sqlfilter($_POST['text_'.$types[$i].'_lang-'.$lid])."' WHERE language_id=".$lid." AND type='".$types[$i]."'");
		if($sqlA==true) $k++;
	} else {
		$sqlA = sql("INSERT INTO viscms_messages (text,type,language_id) VALUES('".sqlfilter($_POST['text_'.$types[$i].'_lang-'.$lid])."','".$types[$i]."','".$lid."')");
		if($sqlA==true) $k++;
	}
	
}


}

if($k==(mysql_num_rows($sqlLang)*sizeof($types))) $msg = '<div class="message">'.$lang['messages_ok'].'</div>';
else $msg = '<div class="message">'.$lang['messages_error'].'</div>';
setcookie('msg',$msg,time()+60);
header("Location: ?module=messages");
	
} else {

$level->ShowHead();

echo '<br />';
	
$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {

	$sql = sql('SELECT text,type FROM viscms_messages WHERE language_id='.$lid);
	while(list($t,$tp) = dbrow($sql)) {
		if($tp=='admins') $text_admins[$lid]=$t;
		elseif($tp=='members') $text_members[$lid]=$t;
		elseif($tp=='owners') $text_owners[$lid]=$t;
	}

}

$form = new Form($action,'post');
$form->SetWidths('20%','80%');
$form->FCK();
$form->MultiLanguage(1);
$form->AddFCK($lang['messages_admins'],'text_admins',$text_admins);
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();


echo '<p align="center"><a href="?module=party"><b>'.$lang['party_back'].'</b></a></p>';

}

}


?>