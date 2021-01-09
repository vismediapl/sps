<?

###############################
#           VIS-CMS           #
############-------############
#          VISMEDIA           #
#       www.vismedia.pl       #
#      biuro@vismedia.pl      #
###############################


## MODULE: contractors ##

include 'languages/'.$language.'/contractors.php';

$level->AddLevel($lang['contractors'],'?module=contractors');

$vars = explode(',',$_GET['act']);
$var_1 = $vars[0];
$var_2 = $vars[1];
$var_3 = $vars[2];

###################################### 

switch(@$var_1) {

   case '':
   browse();
   break;

   case 'edit':
   if($var_2!='')
   edit($var_2);
   break;

   }

######################################

function browse() {
global $cfg,$lang,$language,$level;

$btc = 0;

$level->ShowHead();

echo '<br /><script language="javascript">
function confirmSubmit() {
var agree=confirm("'.$lang['confirm_submit'].'");
if (agree)
	return true ;
else
	return false ;
}
</script>';

$districts = array(
'dolno¶l±skie',
'kujawsko-pomorskie',
'lubelskie',
'lubuskie',
'³ódzkie',
'ma³opolskie',
'mazowieckie','opolskie',
'podkarpackie',
'podlaskie',
'pomorskie',
'¶l±skie',
'¶wiêtokrzyskie',
'warmiñsko-mazurskie',
'wielkopolskie',
'zachodnio-pomorskie'
);

$table = new Table('TableClass','TableClassHd',7,3);
$table->NewCell($lang['contractors_district'],550,'left','left','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');

for($i=0;$i<count($districts);$i++) {
	
	$name=$districts[$i];
	$id=mod_rewrite($districts[$i]);
	
// tworzenie pola select
$select = new Select($id);
$select->Add(strtolower($lang['edit']),'?module=contractors&amp;act=edit,'.$id);
$actions=$select->Ret();

$dname = '<a href="?module=contractors&amp;act=edit,'.$id.'" class="LinksOnGrey">'.$name.'</a>';

// wylistowanie wartosci
$values = array($dname,$actions);
$table->CellValue($values);

 }

$table->Show(); // pokaz tabele

	echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
}

function edit($p) {
global $cfg,$var_1,$text,$lang,$level;

if($_POST['step'] == '1') {
	
	$k=0;

$sqlLang = sql("SELECT id FROM viscms_languages ORDER BY id ASC");
while(list($lid)=dbrow($sqlLang)) {

$sql = sql("UPDATE viscms_contractors SET text = '".$_POST['text_lang-'.$lid]."' WHERE id='".$p."' AND language_id=".$lid);
if($sql==true) $k++;

}

if($k==mysql_num_rows($sqlLang)) {
  $msg = '<div class="message">'.$lang['contractors_edited'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['contractors_not_edited'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=contractors");
}

else {
	
$sql = sql('SELECT text,language_id FROM viscms_contractors WHERE id="'.addslashes($p).'"');
while(list($t,$lid) = dbrow($sql)) {
	$text[$lid]=$t;
}
	
form1($p);
}
}

function form1($p) {
global $cfg,$lang,$language,$var_1,$text,$level;

$level->AddLevel($lang['contractors_edit']);
$level->ShowHead();

echo '<br/>';

$form = new Form($action,'post');
$form->SetWidths('20%','80%');
$form->MultiLanguage(1);
$form->FCK();
$form->AddFCK($lang['contractors_text'],'text',$text);
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();

echo '<p align="center"><a href="?module=contractors"><b>'.$lang['contractors_back'].'</b></a></p>';
}

?>