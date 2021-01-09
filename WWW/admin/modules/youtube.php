<?

###############################
#           visCMS            #
############-------############
#          VISMEDIA           #
#       www.vismedia.pl       #
#      biuro@vismedia.pl      #
###############################

## MODULE: YOUTUBE ##

include 'languages/'.$language.'/youtube.php';

$level->AddLevel($lang['youtube'],'?module=youtube');

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
   if($var_2!='')
     add($var_2);
   break;

   case 'edit':
   if($var_2!='')
     edit($var_2);
   break;
   
   case 'delete':
   if($var_2!='')
     delete($var_2);
   break;
   
   case 'show':
   if($var_2!='')
     show($var_2);
   break;

   case 'add_box':
   add_box();
   break;

   case 'edit_box':
   if($var_2!='') edit_box($var_2);
   break;
   
   case 'delete_box':
   if($var_2!='') delete_box($var_2);
   break;

   case 'add_more':
   if($var_2!='')
     add_more($var_2);
   break;

   }

######################################

}

function browse() {
global $cfg,$lang,$language,$level,$links;

// poziom
$level->AddIcon("add2","?module=youtube&amp;act=add_box",$lang['youtube_add_box']);
$level->ShowHead();

// linki
$links->AddLink($lang['youtube_add_box'],"?module=youtube&amp;act=add_box");

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

$text = $lang['youtube_info1'].': <b>&lt;?new YouTube(ID);?&gt;</b>, '.$lang['youtube_info2'].' <b>&lt;?new YouTube(1);?&gt;</b>'; 

$sqlmnr = sql("SELECT id FROM viscms_youtube");
if(mysql_num_rows($sqlmnr)>0) {

// tworzenie nowej tabeli
$table = new Table('TableClass','TableClassHd',7,3);
$table->QuoteBeforeTable($text);
$table->NewCell($lang['youtube_name'],410,'left','left','bottom','top');
$table->NewCell($lang['youtube'],120,'center','center','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');

$sqlLang = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lang_id)=dbrow($sqlLang);

$sql = sql('SELECT ident,name FROM viscms_youtube WHERE language_id="'.$lang_id.'" GROUP BY ident ORDER BY id ASC');
while (list($id,$name) = dbrow($sql)) {

// tworzenie pola select
$select = new Select($id);
$select->Add(strtolower($lang['manage']),'?module=youtube&amp;act=show,'.$id);
$select->Add(strtolower($lang['edit']),'?module=youtube&amp;act=edit_box,'.$id);
$select->Add(strtolower($lang['delete']),'?module=youtube&amp;act=delete_box,'.$id,' onclick="return confirmSubmit();"');
$actions=$select->Ret();

$name = '<a href="?module=youtube&amp;act=show,'.$id.'" class="LinksOnGrey">'.$name.' (ID#: '.$id.')</a>';
$manage = '<a href="?module=youtube&amp;act=show,'.$id.'" class="LinksOnGrey">'.$lang['manage'].'</a>';

// wylistowanie wartosci
$values = array($name,$manage,$actions);
$table->CellValue($values);

 }

$table->Show(); // pokaz tabele
    
$links->Show(); // pokaz linki

} else {
	echo '<div class="message">'.$lang['youtube_not_found'].'</div>';
	echo '<div align="center"><a href="?module=youtube&amp;act=add_box">'.$lang['youtube_add_box'].'</a></div>';
	echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
  }
}

function show($p) {
global $cfg,$lang,$language,$links,$level;

$btc = 0;

$sqlLang = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lang_id)=dbrow($sqlLang);

$sqlmnr = sql("SELECT name FROM viscms_youtube WHERE ident=".$p." AND language_id=".$lang_id);
if(list($catname)=dbrow($sqlmnr)) {

$level->AddLevel(limitWords($catname,3));

$level->AddIcon("add",'?module=youtube&amp;act=add_more,'.$p, $lang['youtube_add_more']);
$level->ShowHead();

$links->AddLink($lang['youtube_add_more'],'?module=youtube&amp;act=add_more,'.$p);

$links->Show();

echo '<script language="javascript">
function confirmSubmit() {
var agree=confirm("'.$lang['confirm_submit'].'");
if (agree)
	return true ;
else
	return false ;
}
</script>';

// tworzenie nowej tabeli
$table = new Table('TableClass','TableClassHd',7,3);
$table->NewCell($lang['youtube_lang'],120,'left','left','bottom','top');
$table->NewCell($lang['youtube'],420,'center','center','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');

$sql = sql('SELECT A.id,A.name,B.name,A.width_a,A.height_a,A.url,A.content,A.`limit`,A.showed FROM viscms_youtube A, viscms_languages B WHERE A.language_id=B.id AND A.ident='.$p.' ORDER BY B.id ASC');
while (list($id,$name,$lng,$width,$height,$url,$content,$limit,$showed) = dbrow($sql)) {

// tworzenie pola select
$select = new Select($id);
	
	$w=$width;
	$h=$height;

if($url=='' || $url=='http://') {
	$yt = $lang['youtube_na'];
	$select->Add(strtolower($lang['youtube_add']),'?module=youtube&amp;act=add,'.$id);
	$sc='';
}
else {
	if($width>250) {
		$ratio=250/$width;
		$width=250;
		$height=floor($height*$ratio);
	}
	
	if($limit==0 || $limit>$showed) $status = $lang['youtube_status'].': <span style="color: #008000">'.$lang['youtube_active'].'</span><br />';
	else $status = $lang['youtube_status'].': <span style="color: #FF0000">'.$lang['youtube_unactive'].'</span><br />';
	if($limit==0) $limit=$lang['youtube_unlimited'];
	$in=array('http://www.youtube.com/v/','http://pl.youtube.com/v/','http://youtube.com/v/','http://www.youtube.com/watch?v=','http://pl.youtube.com/watch?v=','http://youtube.com/watch?v=');
	$url=str_replace($in,'',$url);
	$sc=$status.'('.$lang['youtube_showed'].': '.$showed.'/'.$limit.')<br />';
	
  $select->Add(strtolower($lang['edit']),'?module=youtube&amp;act=edit,'.$id);  
  $select->Add(strtolower($lang['delete']),'?module=youtube&amp;act=delete,'.$id, ' onclick="return confirmSubmit();"');
	
	$yt = '<span style="font-size: 3px;">&nbsp;</span><br /><object width="'.$width.'" height="'.$height.'"><param name="movie" value="http://www.youtube.com/v/'.$url.'&rel=1&color1=0xd6d6d6&color2=0xf0f0f0&border=0"></param><param name="wmode" value="transparent"></param><embed src="http://www.youtube.com/v/'.$url.'&rel=1&color1=0xd6d6d6&color2=0xf0f0f0&border=0" type="application/x-shockwave-flash" wmode="transparent" width="'.$width.'" height="'.$height.'"></embed></object><br />('.$w.' x '.$h.')<br />'.$sc.'<span style="font-size: 3px;">&nbsp;</span>';
}

$actions=$select->Ret();

// wylistowanie wartosci
$values = array($lng,$yt,$actions);
$table->CellValue($values);

 }

$table->Show(); // pokaz tabele
    
$links->Show(); // pokaz linki
    
    }
	echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
}

function add($p) {
global $cfg,$lang,$language,$_POST,$var_1,$var_2,$mid;

if($_POST['step'] == '1') {

$sql = sql("UPDATE viscms_youtube SET width_a='".intval($_POST['width'])."',height_a='".intval($_POST['height'])."', url='".sqlfilter($_POST['url'],4)."',content='".sqlfilter($_POST['content'],7)."',`limit`='".intval($_POST['limit'])."' WHERE id=".$p);

$sqlId=sql("SELECT ident FROM viscms_youtube WHERE id=".$p);
list($ident)=dbrow($sqlId);


if($sql==true) {
  $msg = '<div class="message">'.$lang['youtube_added'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['youtube_not_added'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=youtube&act=show,".$ident);
}

else {

@form1($p);

  }

}

function edit($p) {
global $cfg,$var_1,$lang,$type,$url,$goto,$width,$height,$mid,$limit,$content;

if($_POST['step'] == '1') {

$sql = sql("UPDATE viscms_youtube SET width_a='".intval($_POST['width'])."',height_a='".intval($_POST['height'])."', url='".sqlfilter($_POST['url'],4)."',content='".sqlfilter($_POST['content'],7)."',`limit`='".intval($_POST['limit'])."' WHERE id=".$p);

$sqlId=sql("SELECT ident FROM viscms_youtube WHERE id=".$p);
list($ident)=dbrow($sqlId);

if($sql==true) {
  $msg = '<div class="message">'.$lang['youtube_edited'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['youtube_not_edited'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=youtube&act=show,".$ident);
}

else {
	
	$sql = sql('SELECT url,width_a,height_a,`limit`,content FROM viscms_youtube WHERE id='.$p);
	if(list($url,$width,$height,$limit,$content) = dbrow($sql)) {
		form1($p);
	}
   
  }
}

function form1($p) {
global $cfg,$lang,$language,$var_1,$type,$url,$goto,$width,$height,$limit,$content,$level,$links;

if($var_1=='edit') {
	$action = '?module=youtube&amp;act=edit,'.$p;
	$header = $lang['youtube_edit'];
} elseif($var_1=='add') {
	$action = '?module=youtube&amp;act=add,'.$p;
	$header = $lang['youtube_add'];
}
	
$sqlK=sql("SELECT width,height FROM viscms_youtube WHERE id=".$p);
list($maxW,$maxH)=dbrow($sqlK);

if($limit=='') $limit='0';
if($url=='') $url='http://';

$level->AddLevel(limitWords($catname,3));
$level->ShowHead();

echo '<br />

<script type="text/javascript">
function checkdimensions(p,q)
{

if (p > '.$maxW.')
{
alert("'.$lang['youtube_widthalert'].': '.$maxW.'px");
return false;
}
elseif (q > '.$maxH.')
{
alert("'.$lang['youtube_heightalert'].': '.$maxH.'px");
return false;
}
return true;
}

function checkwidth()
{
	if(document.form.width.value > '.$maxW.') {

		alert("'.$lang['youtube_widthalert'].': '.$maxW.'px");
		
	}
}
function checkheight()
{
	if(document.form.height.value > '.$maxH.') {

		alert("'.$lang['youtube_heightalert'].': '.$maxH.'px");
		
	}
}
</script>';

$form = new Form($action,'post',"multipart/form-data","form",'onsubmit="return checkdimensions(this.width.value,this.height.value);"');
$form->SetWidths('20%','80%');
$form->AddTextInput($lang['youtube_url'],'url',$url);

$dim_t = '<input type="text" name="width" value="'.$width.'" onblur="checkwidth()" /> x <input type="text" name="height" value="'.$height.'" onblur="checkheight()" /><br />('.strtolower($lang['youtube_width']).' x '.strtolower($lang['youtube_height']).')';

$form->AddAnyField($lang['youtube_dimensions'].' [px]',$dim_t);

$form->AddTextInput($lang['youtube_limit'],'limit',$limit,'',' ('.$lang['youtube_limit_info'].')');
$form->FCK();
$form->AddFCK($lang['youtube_content'],'content',$content);
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show(); 

echo '<p align="center"><a href="?module=youtube"><b>'.$lang['youtube_back'].'</b></a></p>';
}

function delete($p) {
	global $cfg,$lang;
	
$sql = sql("UPDATE viscms_youtube SET url='',width_a='',height_a='',content='',`limit`=0,showed=0 WHERE id=".$p);

if($sql==true) $msg = '<div class="message">'.$lang['youtube_deleted'].'</div>';
else $msg = '<div class="message">'.$lang['youtube_not_deleted'].'</div>';
	setcookie('msg',$msg,time()+60);
$sqlId=sql("SELECT ident FROM viscms_youtube WHERE id=".$p);
list($ident)=dbrow($sqlId);
header("Location: ?module=youtube&act=show,".$ident);
	
}

function add_box() {
global $cfg,$lang,$language,$_POST,$var_1,$var_2,$mid;

if($_POST['step'] == '1') {

$t=1;
$i=0;

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	$i++;
	$_POST['name_lang-'.$lid] = strip_tags($_POST['name_lang-'.$lid]);
	$sql = sql("INSERT INTO viscms_youtube (name,language_id,ident,width,height) VALUES ('".sqlfilter($_POST['name_lang-'.$lid],4)."','".$lid."','".$ident."','".intval($_POST['width'])."','".intval($_POST['height'])."')");
	if($sql==true) $t=1; else { $t=0; break; }
	if($i==1) $ident=mysql_insert_id();
	$last=mysql_insert_id();
	$sql = sql("UPDATE viscms_youtube SET ident=".$ident." WHERE id=".$last);
	if($sql==true) $t=1; else { $t=0; break; }
}
if($t==1) {
  $msg = '<div class="message">'.$lang['youtube_added_box'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['youtube_not_added_box'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=youtube");
}

else {

@form2($p);

  }

}

function edit_box($p) {
global $cfg,$var_1,$lang,$name,$width,$height;

if($_POST['step'] == '1') {
	
$t=1;

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	$_POST['name_lang-'.$lid] = strip_tags($_POST['name_lang-'.$lid]);
	$sql = sql("UPDATE viscms_youtube SET name = '".sqlfilter($_POST['name_lang-'.$lid],4)."', width = '".intval($_POST['width'])."', height = '".intval($_POST['height'])."' WHERE ident=".$p." AND language_id=".$lid);
	if($sql==true) $t=1; else { $t=0; break; }
}
if($t==1) {
  $msg = '<div class="message">'.$lang['youtube_edited_box'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['youtube_not_edited_box'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=youtube");
}

else {

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	
	$sql = sql('SELECT name,width,height FROM viscms_youtube WHERE ident='.$p.' AND language_id='.$lid);
	while(list($c,$w,$h) = dbrow($sql)) {
		$name[$lid] = $c;
		$width = $w;
		$height = $h;
	}
}
   form2($p);
}
}

function form2($p) {
global $cfg,$lang,$language,$var_1,$name,$width,$height,$level;

if($var_1=='edit_box') {
	$action = '?module=youtube&amp;act=edit_box,'.$p;
	$header = $lang['youtube_edit_box'];
} elseif($var_1=='add_box') {
	$action = '?module=youtube&amp;act=add_box';
	$header = $lang['youtube_add_box'];
}
	
$level->AddLevel($header,'');
	
$level->ShowHead();

echo '<br/>';

$form = new Form($action,'post');
$form->SetWidths('20%','80%');
$form->MultiLanguage(1);
$form->AddTextInput($lang['youtube_name'],'name',$name);
$form->MultiLanguage(0);
$form->AddTextInput($lang['youtube_width'].' [px]','width',$width);
$form->AddTextInput($lang['youtube_height'].' [px]','height',$height);
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();

echo '<p align="center"><a href="?module=youtube"><b>'.$lang['youtube_back'].'</b></a></p>';
}

function delete_box($p) {
	global $cfg,$lang;
	
$sql = sql("DELETE FROM viscms_youtube WHERE ident=".$p);

if($sql==true) $msg = '<div class="message">'.$lang['youtube_deleted_box'].'</div>';
else $msg = '<div class="message">'.$lang['youtube_not_deleted_box'].'</div>';
	setcookie('msg',$msg,time()+60);
  	header("Location: ?module=youtube");
	
}

function add_more($p) {
global $cfg,$lang,$language;

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	
	$sqlGET=sql("SELECT name,ident,width,height FROM viscms_youtube WHERE language_id=".$lid." AND ident=".$p." ORDER BY id ASC");
	list($name,$ident,$width,$height) = dbrow($sqlGET);
	$sql = sql("INSERT INTO viscms_youtube (name,language_id,ident,width,height) VALUES ('".sqlfilter($name,4)."','".$lid."','".$ident."','".$width."','".$height."')");
	
}
  header("Location: ?module=youtube&act=show,".$p);

}

?>