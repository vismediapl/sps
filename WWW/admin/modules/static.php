<?

###############################
#           visCMS            #
############-------############
#          VISMEDIA           #
#       www.vismedia.pl       #
#      biuro@vismedia.pl      #
###############################

## MODULE: STATIC ##

include 'languages/'.$language.'/static.php';

$level->AddLevel($lang['static'],'?module=static');

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
   browse();
   break;

   case 'add':
   add();
   break;

   case 'edit':
   if($var_2>0) edit($var_2);
   break;
   
   case 'delete':
   if($var_2>0) delete($var_2);
   break;

   }

######################################

}

function browse() {
global $cfg,$lang,$language,$msg,$level,$links;

$btc = 0;

// poziom
$level->AddIcon("add","?module=static&amp;act=add",$lang['static_add']);
$level->ShowHead();

// linki
$links->AddLink($lang['static_add'],"?module=static&amp;act=add");

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

$sqlmnr = sql("SELECT id FROM viscms_static");
if(mysql_num_rows($sqlmnr)>0) {

$table = new Table('TableClass','TableClassHd',7,3);
$table->NewCell($lang['static_title'],530,'left','left','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');

$sql = sql('SELECT ident, title FROM viscms_static WHERE language_id="'.$lang_id.'" ORDER BY title ASC');
while (list($id,$title) = dbrow($sql)) {
 
$title = $title.$not_ed.'<br/><span class="date"><u>'.$lang['static_link'].'</u>:<br />s'.$id.'_'.substr(mod_rewrite($title),0,240).'.html</span>';
    
// tworzenie pola select
$select = new Select($id);
$select->Add(strtolower($lang['edit']),'?module=static&amp;act=edit,'.$id);
$select->Add(strtolower($lang['delete']),'?module=static&amp;act=delete,'.$id,' onclick="return confirmSubmit();"');
$actions=$select->Ret();

// wylistowanie wartosci
$values = array($title,$actions);
$table->CellValue($values);

 }

$table->Show(); // pokaz tabele
    
$links->Show(); // pokaz linki

} else {
	echo '<div class="message">'.$lang['static_not_found'].'</div>';
	echo '<div align="center"><a href="?module=static&amp;act=add">'.$lang['static_add'].'</a></div>';
	echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
  }
}

function add() {
global $cfg,$lang,$language,$_POST,$var_1,$var_2,$msg;

if($_POST['step'] == '1') {

$k=0;
$t=1;

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	if($t==1) {
	$k++;
	$sql = sql("INSERT INTO viscms_static (ident,title,text,language_id) VALUES ('".$mid."','".sqlfilter($_POST['title_lang-'.$lid],4)."','".sqlfilter($_POST['text_lang-'.$lid],7)."',".$lid.")");
	if($sql==true) $t=1; else $t=0;
	if($k==1) {
		$mid = mysql_insert_id();
	}
		$sql = sql("UPDATE viscms_static SET ident = '".$mid."' WHERE id=".$mid);
	}
}
	
if($t==1) {
  $msg = '<div class="message">'.$lang['static_added'].'</div>';  
  saveLastUpdate();
  } else {
  $msg = '<div class="message">'.$lang['static_not_added'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=static");
}

else {

@form();

  }

}

function edit($p) {
global $cfg,$var_1,$title,$text,$lang,$_POST,$ttitle;

if($_POST['step'] == '1') {

$z=0;

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	$sql = sql("UPDATE viscms_static SET title = '".sqlfilter($_POST['title_lang-'.$lid],4)."', text = '".sqlfilter($_POST['text_lang-'.$lid],7)."' WHERE language_id=".$lid." AND ident=".$p);
	if($sql==true) $z++;
}
if(mysql_num_rows($sqlLang)==$z) {
  $msg = '<div class="message">'.$lang['static_edited'].'</div>';
  saveLastUpdate();
  } else {
  $msg = '<div class="message">'.$lang['static_not_edited'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=static");
}

else {

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	
	$sql = sql('SELECT title,text FROM viscms_static WHERE ident='.$p.' AND language_id='.$lid);
	while(list($t,$x) = dbrow($sql)) {
		$title[$lid] = $t;
		if($i==0) $ttitle=$t;
		$i++;
		$text[$lid] = $x;
	}
}
   form($p);
   
  }
}

function form($p) {
global $cfg,$level,$lang,$language,$var_1,$title,$text,$ttitle;

	
if($var_1=='edit') {
	$action = '?module=static&act=edit,'.$p;
	$header = $lang['static_edit'];
}
	
elseif($var_1=='add') {
	$action = '?module=static&act=add';
	$header = $lang['static_add'];
}

$level->AddLevel($header,'');
	
$level->ShowHead();

echo '<br />';

$form = new Form($action,'post');
$form->SetWidths('20%','80%');
$form->FCK();
$form->MultiLanguage(1);
$form->AddTextInput($lang['static_title'],'title',$title);
if($var_1=='edit') {
 $form->MultiLanguage(0);
 $form->AddTextInput($lang['static_link'],'link','s'.$p.'_'.substr(mod_rewrite($ttitle),0,240).'.html', 'style="width: 100%;" disabled="disabled"');
 $form->MultiLanguage(1);
}
$form->AddFCK($lang['static_text'],'text',$text);
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();

echo '<p align="center"><a href="?module=static"><b>'.$lang['static_back'].'</b></a></p>';
}

function delete($p) {
	global $cfg,$lang;
	
	$sql = sql("DELETE FROM viscms_static WHERE ident=".$p."");

	if($sql==true) {
		$msg = '<div class="message">'.$lang['static_deleted'].'</div>';
  		saveLastUpdate();
	}
	else $msg = '<div class="message">'.$lang['static_not_deleted'].'</div>';
	setcookie('msg',$msg,time()+60);
  	header("Location: ?module=static");
	
}

?>