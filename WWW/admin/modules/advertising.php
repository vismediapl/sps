<?

###############################
#           visCMS            #
############-------############
#          VISMEDIA           #
#       www.vismedia.pl       #
#      biuro@vismedia.pl      #
###############################

## MODULE: ADVERTISING ##

include 'languages/'.$language.'/advertising.php';

$level->AddLevel($lang['advertising'],'?module=advertising');

$vars = explode(',',$_GET['act']);
$var_1 = $vars[0];
$var_2 = $vars[1];
$var_3 = $vars[2];

$cfg['adspath']='../'.$cfg['adspath'];

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
   	 $var_2=sqlfilter($var_2,6);
     add($var_2);
   break;

   case 'edit':
   if($var_2!='')
   	 $var_2=sqlfilter($var_2,6);
     edit($var_2);
   break;
   
   case 'delete':
   if($var_2!='')
   	 $var_2=sqlfilter($var_2,6);
     delete($var_2);
   break;
   
   case 'show':
   if($var_2!='')
   	 $var_2=sqlfilter($var_2,6);
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
$level->AddIcon("add2","?module=advertising&amp;act=add_box",$lang['advertising_add_box']);
$level->ShowHead();

// linki
$links->AddLink($lang['advertising_add_box'],"?module=advertising&amp;act=add_box");

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

$text = $lang['advertising_info1'].': <b>&lt;?new ads(ID);?&gt;</b>, '.$lang['advertising_info2'].' <b>&lt;?new ads(1);?&gt;</b>';

$sqlmnr = sql("SELECT id FROM viscms_advertising");
if(mysql_num_rows($sqlmnr)>0) {

// tworzenie nowej tabeli
$table = new Table('TableClass','TableClassHd',7,3);
$table->QuoteBeforeTable($text);
$table->NewCell($lang['advertising_name'],410,'left','left','bottom','top');
$table->NewCell($lang['advertising'],120,'center','center','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');

$sqlLang = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lang_id)=dbrow($sqlLang);

$sql = sql('SELECT ident,name FROM viscms_advertising WHERE language_id="'.$lang_id.'" GROUP BY ident ORDER BY id ASC');
while (list($id,$name) = dbrow($sql)) {

// tworzenie pola select
$select = new Select($id);
$select->Add(strtolower($lang['manage']),'?module=advertising&amp;act=show,'.$id);
$select->Add(strtolower($lang['edit']),'?module=advertising&amp;act=edit_box,'.$id);
$select->Add(strtolower($lang['delete']),'?module=advertising&amp;act=delete_box,'.$id,' onclick="return confirmSubmit();"');
$actions=$select->Ret();

$name = '<a href="?module=advertising&amp;act=show,'.$id.'" class="LinksOnGrey">'.$name.' (ID#: '.$id.')</a>';
$manage = '<a href="?module=advertising&amp;act=show,'.$id.'" class="LinksOnGrey">'.$lang['manage'].'</a>';

// wylistowanie wartosci
$values = array($name,$manage,$actions);
$table->CellValue($values);

 }

$table->Show(); // pokaz tabele
    
$links->Show(); // pokaz linki

} else {
	echo '<div class="message">'.$lang['advertising_not_found'].'</div>';
	echo '<div align="center"><a href="?module=advertising&amp;act=add_box">'.$lang['advertising_add_box'].'</a></div>';
	echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
  }
}

function show($p) {
global $cfg,$lang,$language,$links,$level;

$sqlLang = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lang_id)=dbrow($sqlLang);

$sqlmnr = sql("SELECT name FROM viscms_advertising WHERE ident=".$p." AND language_id=".$lang_id);
if(list($catname)=dbrow($sqlmnr)) {

$level->AddLevel(limitWords($catname,3));

$level->AddIcon("add",'?module=advertising&amp;act=add_more,'.$p, $lang['advertising_add_more']);
$level->ShowHead();

$links->AddLink($lang['advertising_add_more'],'?module=advertising&amp;act=add_more,'.$p);

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
$table->NewCell($lang['advertising_lang'],120,'left','left','bottom','top');
$table->NewCell($lang['advertising'],420,'center','center','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');

$sql = sql('SELECT A.id,A.name,B.name,A.width_a,A.height_a,A.type,A.url,A.goto,A.`limit`,A.showed,A.clicked FROM viscms_advertising A, viscms_languages B WHERE A.language_id=B.id AND A.ident='.$p.' ORDER BY B.id ASC');
while (list($id,$name,$lng,$width,$height,$type,$url,$goto,$limit,$showed,$clicked) = dbrow($sql)) {
	
	$w=$width;
	$h=$height;
	
// tworzenie pola select
$select = new Select($id);

if($type=='') {
	$ads = $lang['advertising_na'];
  $select->Add(strtolower($lang['advertising_add']),'?module=advertising&amp;act=add,'.$id);
	$sc='';
}
elseif($type=='image') {
	if($width>250) {
		$ratio=250/$width;
		$width=250;
		$height=floor($height*$ratio);
	}
	$url=str_replace('http://http://','http://',$url);
	if(!strstr($url,'http://')) $url='../'.$url;
	if($limit==0 || $limit>$showed) $status = $lang['advertising_status'].': <span style="color: #008000">'.$lang['advertising_active'].'</span><br />';
	else $status = $lang['advertising_status'].': <span style="color: #FF0000">'.$lang['advertising_unactive'].'</span><br />';
	if($limit==0) $limit=$lang['advertising_unlimited'];
	$sc=$status.'('.$lang['advertising_showed'].': '.$showed.'/'.$limit.', '.$lang['advertising_clicked'].': '.$clicked.')<br />';
	$ads = '<span style="font-size: 3px;">&nbsp;</span><br /><a href="'.$goto.'" target="_blank"><img src="'.$url.'" width="'.$width.'" height="'.$height.'" alt="'.$lang['advertising'].' ('.$lng.')" border="0" /></a><br />('.$w.' x '.$h.')<br />'.$sc.'<span style="font-size: 3px;">&nbsp;</span>';
	
  $select->Add(strtolower($lang['edit']),'?module=advertising&amp;act=edit,'.$id);  
  $select->Add(strtolower($lang['delete']),'?module=advertising&amp;act=delete,'.$id, ' onclick="return confirmSubmit();"');
}
elseif($type=='flash') {
	if($width>250) {
		$ratio=250/$width;
		$width=250;
		$height=floor($height*$ratio);
	}
	$url=str_replace('http://http://','http://',$url);
	if(!strstr($url,'http://')) $url='../'.$url;
	if($limit==0 || $limit>$showed) $status = $lang['advertising_status'].': <span style="color: #008000">'.$lang['advertising_active'].'</span><br />';
	else $status = $lang['advertising_status'].': <span style="color: #FF0000">'.$lang['advertising_unactive'].'</span><br />';
	if($limit==0) $limit=$lang['advertising_unlimited'];
	$sc=$status.'('.$lang['advertising_showed'].': '.$showed.'/'.$limit.', '.$lang['advertising_clicked'].': '.$lang['advertising_clicked_na'].')<br />';
	
	$ads = '<span style="font-size: 3px;">&nbsp;</span><br /><noscript>
    <object data="'.$url.'"
            width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash">
     <param name="allowScriptAccess" value="sameDomain" />
     <param name="movie" value="'.$url.'" />
     <param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />
    </object>
</noscript>
<script type="text/javascript">
//<!--
AC_RunFlContentX ("src","'.$url.'","quality","high","bgcolor","#ffffff","width","'.$width.'","height","'.$height.'","name","flash","align","middle","allowscriptaccess","sameDomain");
//-->
</script><br />('.$w.' x '.$h.')<br />'.$sc.'<span style="font-size: 3px;">&nbsp;</span>';

  $select->Add(strtolower($lang['edit']),'?module=advertising&amp;act=edit,'.$id);  
  $select->Add(strtolower($lang['delete']),'?module=advertising&amp;act=delete,'.$id, ' onclick="return confirmSubmit();"');

}

$actions=$select->Ret();

// wylistowanie wartosci
$values = array($lng,$ads,$actions);
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

if($_POST['loct']==1) {
	$_POST['url']=str_replace('http://http://','http://',$_POST['url']);
	if($_POST['url']=='http://') $_POST['url']='';
	$_POST['goto']=str_replace('http://http://','http://',$_POST['goto']);
	if($_POST['goto']=='http://') $_POST['goto']='';
	$ftp_acc=0;
} else {
	$exttab=explode(".",$_FILES['hdd']['name']);
		$ext=strtolower($exttab[sizeof($exttab)-1]);
		if($ext=='jpg' || $ext=='png' || $ext=='gif' || $ext=='swf')
			$ftp_acc=1;
			$mid=$p;
	$_POST['url']='';
	if($ext=='swf') $_POST['goto']='';
}

$sql = sql("UPDATE viscms_advertising SET type='".$_POST['type']."',width_a='".intval($_POST['width'])."',height_a='".intval($_POST['height'])."', url='".strip_tags($_POST['url'])."',goto='".sqlfilter($_POST['goto'],4)."',`limit`='".intval($_POST['limit'])."' WHERE id=".$p);

$sqlId=sql("SELECT ident FROM viscms_advertising WHERE id=".$p);
list($ident)=dbrow($sqlId);

if($ftp_acc==1) ftp('hdd');


if($sql==true) {
  $msg = '<div class="message">'.$lang['advertising_added'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['advertising_not_added'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=advertising&act=show,".$ident);
}

else {

@form1($p);

  }

}

function edit($p) {
global $cfg,$var_1,$lang,$type,$url,$goto,$width,$height,$mid,$limit;

if($_POST['step'] == '1') {

if($_POST['loct']==1) {
	$_POST['url']=str_replace('http://http://','http://',$_POST['url']);
	if($_POST['url']=='http://') $_POST['url']='';
	$_POST['goto']=str_replace('http://http://','http://',$_POST['goto']);
	if($_POST['goto']=='http://') $_POST['goto']='';
	$ftp_acc=0;
} else {
	$exttab=explode(".",$_FILES['hdd']['name']);
		$ext=strtolower($exttab[sizeof($exttab)-1]);
		if($ext=='jpg' || $ext=='png' || $ext=='gif' || $ext=='swf')
			$ftp_acc=1;
			$mid=$p;
	$_POST['url']='';
	if($ext=='swf') $_POST['goto']='';
}

$sql = sql("UPDATE viscms_advertising SET type='".$_POST['type']."',width_a='".intval($_POST['width'])."',height_a='".intval($_POST['height'])."', url='".strip_tags($_POST['url'])."',goto='".sqlfilter($_POST['goto'],4)."',`limit`='".intval($_POST['limit'])."' WHERE id=".$p);

$sqlId=sql("SELECT ident FROM viscms_advertising WHERE id=".$p);
list($ident)=dbrow($sqlId);

if($ftp_acc==1) ftp('hdd');

if($sql==true) {
  $msg = '<div class="message">'.$lang['advertising_edited'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['advertising_not_edited'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=advertising&act=show,".$ident);
}

else {
	
	$sql = sql('SELECT type,url,goto,width_a,height_a,`limit` FROM viscms_advertising WHERE id='.$p);
	if(list($type,$url,$goto,$width,$height,$limit) = dbrow($sql)) {
		form1($p);
	}
   
  }
}

function form1($p) {
global $cfg,$level,$lang,$language,$var_1,$type,$url,$goto,$width,$height,$limit;

if($var_1=='edit') {
	$action = '?module=advertising&amp;act=edit,'.$p;
	$header = $lang['advertising_edit'];
} elseif($var_1=='add') {
	$action = '?module=advertising&amp;act=add,'.$p;
	$header = $lang['advertising_add'];
}
	
$sqlK=sql("SELECT width,height FROM viscms_advertising WHERE id=".$p);
list($maxW,$maxH)=dbrow($sqlK);

if($limit=='') $limit='0';

$level->AddLevel($header);
$level->ShowHead();

echo '<br/>

<script type="text/javascript">
function hide_return(p)
{
	if(p == 1) {

		document.getElementById(\'tb1\').style.display = \'block\';
		document.getElementById(\'tb2\').style.display = \'none\';
		
	} else {  
    
		document.getElementById(\'tb1\').style.display = \'none\';
		document.getElementById(\'tb2\').style.display = \'block\';

	}
}
function hide_return2()
{
	if(document.form.type.value == \'image\') {

		document.getElementById(\'tb3\').style.display = \'block\';
		document.getElementById(\'tb4\').style.display = \'none\';
		
	} else {  
    
		document.getElementById(\'tb3\').style.display = \'none\';
		document.getElementById(\'tb4\').style.display = \'block\';

	}
}
function checkdimensions(p,q)
{

if (p > '.$maxW.')
{
alert("'.$lang['advertising_widthalert'].': '.$maxW.'px");
return false;
}
if (p < 1)
{
alert("'.$lang['advertising_widthalert0'].'");
return false;
}
if (q > '.$maxH.')
{
alert("'.$lang['advertising_heightalert'].': '.$maxH.'px");
return false;
}
if (q < 1)
{
alert("'.$lang['advertising_heightalert0'].'");
return false;
}
return true;
}

function checkwidth()
{
	if(document.form.width.value > '.$maxW.') {
		alert("'.$lang['advertising_widthalert'].': '.$maxW.'px");
	}
}
function checkheight()
{
	if(document.form.height.value > '.$maxH.') {
		alert("'.$lang['advertising_heightalert'].': '.$maxH.'px");
	}
}
</script>';

// typ
$type_fields = array();
$sqlType = sql("DESCRIBE viscms_advertising 'type'");
$qp = dbarray($sqlType);
$in = array("enum(",")","'");
$tp = str_replace($in,"",$qp[1]);
$tp = explode(",",$tp);

		for($i=0;$i<sizeof($tp);$i++) {
			if($tp[$i]!='') {
				array_push($type_fields,array($lang['advertising_type_'.$tp[$i]],$tp[$i]));
			}
		}
  
  $default='image';
  
  if($type=='') $type=$default;
  
$form = new Form($action,'post',"multipart/form-data","form",'onsubmit="return checkdimensions(this.width.value,this.height.value);"');
$form->SetWidths('20%','80%');
$form->AddSelect($lang['advertising_type'],'type',$type_fields,$type,'style="width: 100%" onchange="hide_return2()"');

if($_POST['loct']==2) {
	$c2 = ' checked="checked"';
	$b2 = 'block';
	$b1 = 'none';
}
else {
	$c1 = ' checked="checked"';
	$b2 = 'none';
	$b1 = 'block';
}

if($type=='image' || $type=='') {
	$b3 = 'block';
	$b4 = 'none';
}
else {
	
	$b3 = 'none';
	$b4 = 'block';
}

if($url=='') $url='http://';
if($goto=='') $goto='http://';

$location_t = '<input type="radio" name="loct" value="1" id="1"'.$c1.' onclick="hide_return(1)" /> <label for="1"> '.$lang['advertising_url'].'</label> &nbsp; &nbsp;<input type="radio" name="loct" value="2" id="2"'.$c2.' onClick="hide_return(2)" /> <label for="2"> '.$lang['advertising_hdd'].'</label><br />
<span id="tb1" style="display: '.$b1.';"><input type="url" value="'.$url.'" name="url" style="width: 100%;" /></span>
<span id="tb2" style="display: '.$b2.';"><input type="file" name="hdd" style="width: 100%;" size="92" /></span>';

$form->AddAnyField($lang['advertising_location'],$location_t);

$goto_t = '<span id="tb3" style="display: '.$b3.';"><input type="text" name="goto" value="'.$goto.'" style="width: 100%;" /></span>
			<span id="tb4" style="display: '.$b4.';">---</span>';

$form->AddAnyField($lang['advertising_goto'],$goto_t);

$dim_t = '<input type="text" name="width" value="'.$width.'" onblur="checkwidth()" /> x <input type="text" name="height" value="'.$height.'" onblur="checkheight()" /><br />('.strtolower($lang['advertising_width']).' x '.strtolower($lang['advertising_height']).')';

$form->AddAnyField($lang['advertising_dimensions'].' [px]',$dim_t);

$form->AddTextInput($lang['advertising_limit'],'limit',$limit,'',' ('.$lang['advertising_limit_info'].')');

$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();


echo '<p align="center"><a href="?module=advertising"><b>'.$lang['advertising_back'].'</b></a></p>';
}

function delete($p) {
	global $cfg,$lang;
	
$sql = sql("UPDATE viscms_advertising SET url='',goto='',type='',width_a='',height_a='',`limit`=0,showed=0,clicked=0 WHERE id=".$p);

if($sql==true) $msg = '<div class="message">'.$lang['advertising_deleted'].'</div>';
else $msg = '<div class="message">'.$lang['advertising_not_deleted'].'</div>';
	setcookie('msg',$msg,time()+60);
$sqlId=sql("SELECT ident FROM viscms_advertising WHERE id=".$p);
list($ident)=dbrow($sqlId);
header("Location: ?module=advertising&act=show,".$ident);
	
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
	$sql = sql("INSERT INTO viscms_advertising (name,language_id,ident,width,height) VALUES ('".sqlfilter($_POST['name_lang-'.$lid],4)."','".$lid."','".$ident."','".intval($_POST['width'])."','".intval($_POST['height'])."')");
	if($sql==true) $t=1; else { $t=0; break; }
	if($i==1) $ident=mysql_insert_id();
	$last=mysql_insert_id();
	$sql = sql("UPDATE viscms_advertising SET ident=".$ident." WHERE id=".$last);
	if($sql==true) $t=1; else { $t=0; break; }
}
if($t==1) {
  $msg = '<div class="message">'.$lang['advertising_added_box'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['advertising_not_added_box'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=advertising");
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
	$sql = sql("UPDATE viscms_advertising SET name = '".sqlfilter($_POST['name_lang-'.$lid],4)."', width = '".intval($_POST['width'])."', height = '".intval($_POST['height'])."' WHERE ident=".$p." AND language_id=".$lid);
	if($sql==true) $t=1; else { $t=0; break; }
}
if($t==1) {
  $msg = '<div class="message">'.$lang['advertising_edited_box'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['advertising_not_edited_box'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=advertising");
}

else {

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	
	$sql = sql('SELECT name,width,height FROM viscms_advertising WHERE ident='.$p.' AND language_id='.$lid);
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
global $cfg,$level,$lang,$language,$var_1,$name,$width,$height;

if($var_1=='edit_box') {
	$action = '?module=advertising&amp;act=edit_box,'.$p;
	$header = $lang['advertising_edit_box'];
} elseif($var_1=='add_box') {
	$action = '?module=advertising&amp;act=add_box';
	$header = $lang['advertising_add_box'];
}
	
$level->AddLevel($header,'');
	
$level->ShowHead();

echo '<br/>';

$form = new Form($action,'post');
$form->SetWidths('20%','80%');
$form->MultiLanguage(1);
$form->AddTextInput($lang['advertising_name'],'name',$name);
$form->MultiLanguage(0);
$form->AddTextInput($lang['advertising_width'].' [px]','width',$width);
$form->AddTextInput($lang['advertising_height'].' [px]','height',$height);
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();

echo '<p align="center"><a href="?module=advertising"><b>'.$lang['advertising_back'].'</b></a></p>';
}

function delete_box($p) {
	global $cfg,$lang;
	
$sql = sql("DELETE FROM viscms_advertising WHERE ident=".$p);

if($sql==true) $msg = '<div class="message">'.$lang['advertising_deleted_box'].'</div>';
else $msg = '<div class="message">'.$lang['advertising_not_deleted_box'].'</div>';
	setcookie('msg',$msg,time()+60);
  	header("Location: ?module=advertising");
	
}

function add_more($p) {
global $cfg,$lang,$language;

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	
	$sqlGET=sql("SELECT name,ident,width,height FROM viscms_advertising WHERE language_id=".$lid." AND ident=".$p." ORDER BY id ASC");
	list($name,$ident,$width,$height) = dbrow($sqlGET);
	$sql = sql("INSERT INTO viscms_advertising (name,language_id,ident,width,height) VALUES ('".sqlfilter($name,4)."','".$lid."','".$ident."','".$width."','".$height."')");
	
}
  header("Location: ?module=advertising&act=show,".$p);

}

function ftp($file) {
	global $cfg,$mid,$i,$_POST;

	$name = $_FILES[$file]['name'];
	$ext = explode ('.', $name); 
	$ext=strtolower($ext[sizeof($ext)-1]);
	$newname='ads_'.$mid.'_'.$i.time().'.'.$ext;
	$a=move_uploaded_file($_FILES[$file]['tmp_name'], $cfg['adspath'].$newname);
	if($a==true) {
		$cfg['adspath']=str_replace("../","",$cfg['adspath']);
		$sqlATT = sql("UPDATE viscms_advertising SET url='".$cfg['adspath'].$newname."' WHERE id=".$mid);
		if($sqlATT==true) return mysql_insert_id();
	}
}

?>