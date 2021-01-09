<?

###############################
#           visCMS            #
############-------############
#          VISMEDIA           #
#       www.vismedia.pl       #
#      biuro@vismedia.pl      #
###############################

## MODULE: ARTICLES ##

include 'languages/'.$language.'/trainings.php';

$level->AddLevel($lang['trainings'],'?module=trainings');

$vars = explode(',',$_GET['act']);
$var_1 = $vars[0];
$var_2 = $vars[1];
$var_3 = $vars[2];

$cfg['trapath']='../'.$cfg['trapath'];

if(is_numeric($var_2) || $var_2=='') {

###################################### 

$var_2=sqlfilter($var_2,6);

if(auth()!=3)
switch(@$var_1) {

   case '':
   browse(0);
   break;
   
   case 'category':
   if($var_2!='')
     category($var_2);
   break;

   case 'add_category':
   add_category($var_2);
   break;

   case 'edit_category':
   if($var_2!='')
     edit_category($var_2);
   break;
   
   case 'delete_category':
   if($var_2!='')
     delete_category($var_2);
   break;

   case 'show':
   show($var_2,$var_3);
   break;

   case 'add':
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

   case 'active':
   if($var_2!='')
     training_active($var_2,$var_3);
   break;

   case 'deactive':
   if($var_2!='')
     training_deactive($var_2,$var_3);
   break;
   
   case 'top':
   if($var_2!='')
     @top($var_2,$var_3);
   break;
   
   case 'up':
   if($var_2!='')
     @up($var_2,$var_3);
   break;
   
   case 'down':
   if($var_2!='')
     @down($var_2,$var_3);
   break;
   
   case 'bottom':
   if($var_2!='')
     @bottom($var_2,$var_3);
   break;
   
   case 'category_up':
   if($var_2!='')
     @category_up($var_2,$var_3);
   break;
   
   case 'category_down':
   if($var_2!='')
     @category_down($var_2,$var_3);
   break;
   
   case 'SortByDate':
     SortByDate();
   break;

   }

######################################

}

function browse($p) {
global $cfg,$lang,$language,$level,$links;

if($p>0) {

$sql = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lang_id) = dbrow($sql);

$sqlHd = sql("SELECT name FROM viscms_trainings_categories WHERE language_id='".$lang_id."' AND ident=".$p);
list($HdName) = dbrow($sqlHd);

$level->AddLevel($HdName,'');

}

// poziom
$level->AddIcon("add2","?module=trainings&amp;act=add_category",$lang['trainings_category_add']);
$level->AddIcon("add","?module=trainings&amp;act=add",$lang['trainings_add']);
$level->AddIcon("show","?module=trainings&amp;act=show,0",$lang['trainings_browse_all']);
$level->ShowHead();

// linki
$links->AddLink($lang['trainings_category_add'],"?module=trainings&amp;act=add_category");
$links->AddLink($lang['trainings_add'],"?module=trainings&amp;act=add");
$links->AddLink($lang['trainings_browse'],"?module=trainings&amp;act=show,0");

echo '<script language="javascript">
function confirmSubmit() {
var agree=confirm("'.$lang['confirm_submit'].'\n\n'.$lang['trainings_confirm_del1'].'");
if (agree)
	return true ;
else
	return false ;
}
</script>';

$sql = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lang_id) = dbrow($sql);

$links->Show();

$sqlmnr = sql("SELECT id FROM viscms_trainings_categories WHERE language_id='".$lang_id."' AND parent=0");
if(mysql_num_rows($sqlmnr)>0) {

// tworzenie nowej tabeli
$table = new Table('TableClass','TableClassHd',7,3);
$table->NewCell($lang['trainings_category'],350,'left','left','bottom','top');
$table->NewCell($lang['trainings_num'],120,'center','center','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');
$table->NewCell($lang['order'],60,'center','center','bottom','top');


$sql = sql('SELECT ident, name, position FROM viscms_trainings_categories WHERE language_id="'.$lang_id.'" AND parent='.$p.' ORDER BY position DESC');
while (list($id,$category,$position) = dbrow($sql)) {
	
	$sql2 = sql('SELECT COUNT(id) FROM viscms_trainings_to_categories WHERE category_id = '.$id);
	list($count) = dbrow($sql2);
/*
	$sqlS = sql("SELECT ident FROM viscms_trainings_categories WHERE language_id=".$lang_id." AND parent=".$id);
	while(list($cid) = dbrow($sqlS)) {
		$sql2 = sql('SELECT COUNT(id) FROM viscms_trainings_to_categories WHERE category_id = '.$cid);
		while(list($cc) = dbrow($sql2)) $count+=$cc;
	}*/
	
	$sqlA = sql("SELECT id FROM viscms_trainings_to_categories WHERE category_id=".$id);
	
$sql2 = sql("SELECT position FROM viscms_trainings_categories WHERE parent=0 ORDER BY position DESC LIMIT 1");
list($max) = dbrow($sql2);
$sql2 = sql("SELECT position FROM viscms_trainings_categories WHERE parent=0 ORDER BY position ASC LIMIT 1");
list($min) = dbrow($sql2);

// tworzenie pola select
$select = new Select($id);
$select->Add(strtolower($lang['edit']),'?module=trainings&amp;act=edit_category,'.$id);
$select->Add(strtolower($lang['delete']),'?module=trainings&amp;act=delete_category,'.$id,' onclick="return confirmSubmit();"');
$select->Add(strtolower($lang['trainings_menage']),'?module=trainings&amp;act=show,'.$id);
$select->Add(strtolower($lang['trainings_add']),'?module=trainings&amp;act=add,'.$id);
$select->Add(strtolower($lang['trainings_subcategories_menage']),'?module=trainings&amp;act=category,'.$id);
$select->Add(strtolower($lang['trainings_subcategories_add']),'?module=trainings&amp;act=add_category,'.$id);
$actions=$select->Ret();

$arrows = new Arrows();
$arrows->Up($position,$max,'?module=trainings&cat='.$p.'&act=category_up,'.$id.',0');
$arrows->Down($position,$min,'?module=trainings&cat='.$p.'&act=category_down,'.$id.',0');
$UpAndDown = $arrows->Ret();


$category = '<a href="?module=trainings&amp;act=show,'.$id.'" class="LinksOnGrey">'.$category.'</a>';

$sqlSubCat = sql('SELECT ident, name, position FROM viscms_trainings_categories WHERE language_id="'.$lang_id.'" AND parent="'.$id.'" ORDER BY position DESC');
while (list($Sid,$Scategory) = dbrow($sqlSubCat)) {
  $category .= '<div style="padding-left: 15px;">&bull; <a href="?module=trainings&amp;act=show,'.$Sid.'" class="LinksOnGrey">'.$Scategory.'</a></div>';
}

// wylistowanie wartosci
$values = array($category,$count,$actions,$UpAndDown);
$table->CellValue($values);

 }

$table->Show(); // pokaz tabele
    
$links->Show(); // pokaz linki

} else {
	echo '<div class="message">'.$lang['trainings_category_not_found'].'</div>';
	echo '<div align="center"><a href="?module=trainings&amp;act=add_category">'.$lang['trainings_category_add'].'</a></div>';
	echo '<p align="center"><br/><a href="?module=trainings&amp;act=show,0"><b>'.$lang['trainings_browse'].'</b></a></p>';
	echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
  }
}

function category($p) {
global $cfg,$lang,$language,$level,$links;

$btc = 0;

$sql = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lang_id) = dbrow($sql);

$sqlHd = sql("SELECT name FROM viscms_trainings_categories WHERE language_id='".$lang_id."' AND ident=".$p);
list($HdName) = dbrow($sqlHd);

$level->AddLevel($HdName,'');

// poziom
$level->AddIcon("add","?module=trainings&amp;act=add,".$p,$lang['trainings_add']);
$level->AddIcon("show","?module=trainings&amp;act=show,".$p,$lang['trainings_browse']);
$level->ShowHead();

// linki
$links->AddLink($lang['trainings_category_subcategories_add'],"?module=trainings&amp;act=add_category,".$p);
$links->AddLink($lang['trainings_add'],"?module=trainings&amp;act=add,".$p);
$links->AddLink($lang['trainings_browse'],"?module=trainings&amp;act=show,".$p);
$links->AddLink($lang['trainings_browse_all'],"?module=trainings&amp;act=show");

echo '<script language="javascript">
function confirmSubmit() {
var agree=confirm("'.$lang['confirm_submit'].'\n\n'.$lang['trainings_confirm_del2'].'");
if (agree)
	return true ;
else
	return false ;
}
</script>';

$links->Show();

$sqlmnr = sql("SELECT id FROM viscms_trainings_categories WHERE language_id='".$lang_id."' AND parent=".$p);
if(mysql_num_rows($sqlmnr)>0) {

// tworzenie nowej tabeli
$table = new Table('TableClass','TableClassHd',7,3);
$table->NewCell($lang['trainings_category'],350,'left','left','bottom','top');
$table->NewCell($lang['trainings_num'],120,'center','center','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');
$table->NewCell($lang['order'],60,'center','center','bottom','top');

$sql2 = sql("SELECT position FROM viscms_trainings_categories WHERE parent=".$p." ORDER BY position DESC LIMIT 1");
list($max) = dbrow($sql2);
$sql2 = sql("SELECT position FROM viscms_trainings_categories WHERE parent=".$p." ORDER BY position ASC LIMIT 1");
list($min) = dbrow($sql2);

$sql = sql('SELECT ident, name, position FROM viscms_trainings_categories WHERE language_id="'.$lang_id.'" AND parent='.$p.' ORDER BY position DESC');
while (list($id,$category,$position) = dbrow($sql)) {
	
	$sql2 = sql('SELECT COUNT(id) FROM viscms_trainings_to_categories WHERE category_id = '.$id);
	list($count) = dbrow($sql2);

// tworzenie pola select
$select = new Select($id);
$select->Add(strtolower($lang['edit']),'?module=trainings&amp;act=edit_category,'.$id);
$select->Add(strtolower($lang['delete']),'?module=trainings&amp;act=delete_category,'.$id,' onclick="return confirmSubmit();"');
$select->Add(strtolower($lang['trainings_menage']),'?module=trainings&amp;act=show,'.$id);
$select->Add(strtolower($lang['trainings_add']),'?module=trainings&amp;act=add,'.$id);
$actions=$select->Ret();

// gora/dol
$arrows = new Arrows();
$arrows->Up($position,$max,'?module=trainings&cat='.$p.'&act=category_up,'.$id.','.$p);
$arrows->Down($position,$min,'?module=trainings&cat='.$p.'&act=category_down,'.$id.','.$p);
$UpAndDown = $arrows->Ret();

$category = '<a href="?module=trainings&amp;act=show,'.$id.'" class="LinksOnGrey">'.$category.'</a>';

// wylistowanie wartosci
$values = array($category,$count,$actions,$UpAndDown);
$table->CellValue($values);
 }

$table->Show(); // pokaz tabele
    
$links->Show(); // pokaz linki

} else {
	echo '<div class="message">'.$lang['trainings_category_not_found'].'</div>';
	echo '<div align="center"><a href="?module=trainings&amp;act=add_category,'.$p.'">'.$lang['trainings_category_subcategories_add'].'</a></div>';
	echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
  }
}

function add_category($p) {
global $cfg,$lang,$language,$_POST,$var_1,$var_2,$i;

if($p>0) {
  $sqlV = sql("SELECT parent FROM viscms_trainings_categories WHERE ident='".$p."'");
  if(list($parent)=dbrow($sqlV)) {
    if($parent==0) $ok=1;
  }
} else $ok=1;

if($ok==1) {

if($_POST['step'] == '1') {
	
$t=0;

$sql2 = sql("SELECT position FROM viscms_trainings_categories ORDER BY position DESC LIMIT 1");
list($max) = dbrow($sql2);
$max++;

$sql2 = sql("SELECT ident FROM viscms_trainings_categories ORDER BY ident DESC LIMIT 1");
list($ident) = dbrow($sql2);
$ident++;

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	$_POST['name_lang-'.$lid] = sqlfilter($_POST['name_lang-'.$lid],4);
	$_POST['description_lang-'.$lid] = sqlfilter($_POST['description_lang-'.$lid],7);
	$sql = sql("INSERT INTO viscms_trainings_categories (name,description,language_id,ident,parent,position) VALUES ('".$_POST['name_lang-'.$lid]."','".$_POST['description_lang-'.$lid]."','".$lid."','".$ident."','".$p."','".$max."')");
	if($sql==true) $t=1; else { $t=0; break; }
}
if($t==1) {
  $msg = '<div class="message">'.$lang['trainings_category_added'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['trainings_category_not_added'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  if($p=='') header("Location: ?module=trainings");
  else header("Location: ?module=trainings&act=category,".$p);
}

else {

@form1c($p);

  }
  
}

}

function edit_category($p) {
global $cfg,$var_1,$name,$description,$idc,$author,$lang,$_POST,$i;

if($_POST['step'] == '1') {

$t=1;

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	$_POST['name_lang-'.$lid] = sqlfilter($_POST['name_lang-'.$lid],4);
	$_POST['description_lang-'.$lid] = sqlfilter($_POST['description_lang-'.$lid],7);
	$sql = sql("UPDATE viscms_trainings_categories SET name = '".$_POST['name_lang-'.$lid]."', description = '".$_POST['description_lang-'.$lid]."' WHERE language_id=".$lid." AND ident=".$p);
	if($sql==true) $z++;
}
if(mysql_num_rows($sqlLang)==$z) {
  $msg = '<div class="message">'.$lang['trainings_category_edited'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['trainings_category_not_edited'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  $sqlC = sql("SELECT parent FROM viscms_trainings_categories WHERE ident=".$p);
  list($par)=dbrow($sqlC);
  if($par==0)
  	header("Location: ?module=trainings");
  else
  	header("Location: ?module=trainings&act=category,".$par);
}

else {

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	
	$sql = sql('SELECT name,description FROM viscms_trainings_categories WHERE ident='.$p.' AND language_id='.$lid);
	while(list($c,$d) = dbrow($sql)) {
		$name[$lid] = str_replace('"',"&quot;",$c);
		$description[$lid] = str_replace("<br />","\n",$d);
	}
}
   form1c($p);
   
  }
}

function form1c($p) {
global $cfg,$lang,$language,$level,$var_1,$name,$description,$author;

if($var_1=='edit_category') {
	$action = '?module=trainings&amp;act=edit_category,'.$p;
	$header = $lang['trainings_category_edit'];
} elseif($var_1=='add_category') {
	if($p!='') {
		$header = $lang['trainings_category_subcategories_add'];
		$action = '?module=trainings&amp;act=add_category,'.$p;
	} else {
		$action = '?module=trainings&amp;act=add_category';
		$header = $lang['trainings_category_add'];
	}
}

$level->AddLevel($header,'');
	
$level->ShowHead();

echo '<br />';

$form = new Form($action,'post');
$form->SetWidths('20%','80%');
$form->FCK();
$form->MultiLanguage(1);
$form->AddTextInput($lang['trainings_category_name'],'name',$name);
$form->AddFCK($lang['trainings_category_description'],'description',$description);
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();

echo '<p align="center"><a href="?module=trainings"><b>'.$lang['trainings_back'].'</b></a></p>';
}

function delete_category($p) {
	global $cfg,$lang;
	
	$sql = sql("SELECT parent FROM viscms_trainings_categories WHERE ident=".$p);
	list($par) = dbrow($sql);
	
	$sql = sql("SELECT ident FROM viscms_trainings_categories WHERE parent=".$p);
	while(list($ident) = dbrow($sql)) {
		$sqlx0x = sql("SELECT training_id FROM viscms_trainings_to_categories WHERE category_id=".$ident);
		while(list($id)=dbrow($sqlx0x)) {
			
			$sqlD = sql("DELETE FROM viscms_trainings_to_categories WHERE training_id=".$id);
			
			$sqlx0y = sql("SELECT attachment FROM viscms_trainings WHERE id=".$id);
			if(list($file)=dbrow($sqlx0y)) @unlink($cfg['trapath'].$file);
			
			$sqlD = sql("DELETE FROM viscms_trainings WHERE id=".$id);
		}
		$sqlx2 = sql("DELETE FROM viscms_trainings_categories WHERE ident=".$ident);
	}
	
	$sqlx0x = sql("SELECT training_id FROM viscms_trainings_to_categories WHERE category_id=".$p);
	while(list($id)=dbrow($sqlx0x)) {
			
		$sqlD = sql("DELETE FROM viscms_trainings_to_categories WHERE training_id=".$id);
	
		$sqlx0y = sql("SELECT attachment FROM viscms_trainings WHERE training_id=".$id);
		while(list($file)=dbrow($sqlx0y)) @unlink($cfg['trapath'].$file);
			
			$sqlD = sql("DELETE FROM viscms_trainings WHERE id=".$id);
	}
	
	if($sql==true) {
		$sqlx = sql("DELETE FROM viscms_trainings_categories WHERE ident=".$p);
	}

	if($sqlx==true) {
    $msg = '<div class="message">'.$lang['trainings_category_deleted'].'</div>';
    generateFile();
  }
	else $msg = '<div class="message">'.$lang['trainings_category_not_deleted'].'</div>';
	setcookie('msg',$msg,time()+60);
  	if($par!='') header("Location: ?module=trainings");
  	else header("Location: ?module=trainings&act=category,".$par);
	
}

function show($p,$q) {
global $cfg,$lang,$language,$level,$links;

$btc = 0;

if($q=='') $q=1;
$str = ($q-1)*$cfg['tralimitrows'];

$sqlLang = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lng) = dbrow($sqlLang);

echo '<script language="javascript">
function confirmSubmit() {
var agree=confirm("'.$lang['confirm_submit'].'");
if (agree)
	return true ;
else
	return false ;
}
</script>';

if($p!=0) {
	$clause = ", viscms_trainings_to_categories B WHERE A.id=B.training_id AND B.category_id=".$p;
	if($_GET['active']=='ACT') {
		$clause .= " AND active=1";
		$page_act = '&amp;active=ACT';
	}
	elseif($_GET['active']=='DEACT') {
		$clause .= " AND active=0";
		$page_act = '&amp;active=DEACT';
	}
	$sqlA = sql("SELECT name,parent FROM viscms_trainings_categories WHERE ident=".$p." AND language_id=".$lng);
	list($catname,$parent)=dbrow($sqlA);
	$sqlA = sql("SELECT name FROM viscms_trainings_categories WHERE ident=".$parent." AND language_id=".$lng);
	if(list($catname2)=dbrow($sqlA))
  $level->AddLevel($catname2,'?module=trainings&amp;act=category,'.$parent);
}
else {
	$p=0;
	$catname = $lang['trainings_all'];
	if($_GET['active']=='ACT') {
		$clause = " WHERE active=1";
		$page_act = '&amp;active=ACT';
	}
	elseif($_GET['active']=='DEACT') {
		$clause = " WHERE active=0";
		$page_act = '&amp;active=DEACT';
	}
}

$level->AddLevel($catname,'');

// poziom
$level->AddIcon("add","?module=trainings&amp;act=add",$lang['trainings_add']);
$level->ShowHead();

// linki
$links->AddLink($lang['trainings_add'],"?module=trainings&amp;act=add,".$p);

$sql = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lang_id) = dbrow($sql);

if($_GET['active']=='ACT') {
  $links->AddLink($lang['trainings_show_all'],'?module=trainings&act=show,'.$p);
  $links->AddLink($lang['trainings_show_deactive'],'?module=trainings&act=show,'.$p.'&amp;active=DEACT');
} elseif($_GET['active']=='DEACT') {
  $links->AddLink($lang['trainings_show_all'],'?module=trainings&act=show,'.$p);
  $links->AddLink($lang['trainings_show_active'],'?module=trainings&act=show,'.$p.'&amp;active=ACT');
} else {
  $links->AddLink($lang['trainings_show_active'],'?module=trainings&act=show,'.$p.'&amp;active=ACT');
  $links->AddLink($lang['trainings_show_deactive'],'?module=trainings&act=show,'.$p.'&amp;active=DEACT');
}

$links->Show();

$sqlmnr = sql("SELECT A.id FROM viscms_trainings A".$clause." LIMIT ".$str.",".$cfg['tralimitrows']);
if(mysql_num_rows($sqlmnr)>0) {

// tworzenie nowej tabeli
$table = new Table('TableClass','TableClassHd',7,3);
$table->NewCell($lang['trainings_title'],310,'left','left','bottom','top');
$table->NewCell($lang['show'],45,'center','center','bottom','top');
$table->NewCell($lang['trainings_lng'],100,'center','center','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');
$table->NewCell($lang['order'],60,'center','center','bottom','top');


$sql2 = sql("SELECT A.position FROM viscms_trainings A".$clause." ORDER BY A.position DESC LIMIT 1");
list($max) = dbrow($sql2);
$sql2 = sql("SELECT A.position FROM viscms_trainings A".$clause." ORDER BY A.position ASC LIMIT 1");
list($min) = dbrow($sql2);

$sql = sql('SELECT A.id,A.title,A.date1,A.date2,A.position,A.language_id,A.active FROM viscms_trainings A'.$clause.' ORDER BY A.position DESC LIMIT '.$str.','.$cfg['tralimitrows']);
while (list($id,$title,$date1,$date2,$position,$lang_id,$active) = dbrow($sql)) {
	
	$sqlLang = sql("SELECT name FROM viscms_languages WHERE id='".$lang_id."'");
	list($lng) = dbrow($sqlLang);
	
	if($date1>0 && $date2>0) $date = date("d.m.Y",$date1).'-'.date("d.m.Y",$date2);
	elseif($date1>0) $date = date("d.m.Y",$date1);
	
	$title .= '<br /><span class="date">'.$date.'</span>';
    
// tworzenie pola pokaz
if($active==1) $show = $table->ShowCheck($active,'?module=trainings&amp;act=deactive,'.$id.','.$p);
else $show = $table->ShowCheck($active,'?module=trainings&amp;act=active,'.$id.','.$p);

// tworzenie pola select
$select = new Select($id);
$select->Add(strtolower($lang['edit']),'?module=trainings&amp;act=edit,'.$id);
$select->Add(strtolower($lang['delete']),'?module=trainings&amp;act=delete,'.$id,' onclick="return confirmSubmit();"');

if($active==1) $select->Add(strtolower($lang['trainings_deactivate']),'?module=trainings&amp;act=deactive,'.$id.','.$p);
else $select->Add(strtolower($lang['trainings_activate']),'?module=trainings&amp;act=active,'.$id.','.$p);

$actions=$select->Ret();

// gora/dol
$arrows = new Arrows();
$arrows->Up($position,$max,'?module=trainings&cat='.$p.'&act=up,'.$id.','.$p);
$arrows->Down($position,$min,'?module=trainings&cat='.$p.'&act=down,'.$id.','.$p);
$UpAndDown = $arrows->Ret();

// wylistowanie wartosci
$values = array($title,$show,$lng,$actions,$UpAndDown);
$table->CellValue($values);

}
    
$table->Show(); // pokaz tabele
    
$links->Show(); // pokaz linki

$pages = new Pages($q, "?module=trainings&act=show,".$p, $cfg['tralimitrows']);
$pages->Sql("SELECT A.id FROM viscms_trainings A".$clause);
$pages->Show();

} else {
	echo '<div class="message">'.$lang['trainings_not_found'].'</div>';
	echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
  }
}

function add($p) {
global $cfg,$lang,$language,$title,$var_1,$i,$mid;

if($_POST['step'] == '1') {

$k=0;
$t=1;

$sql2 = sql("SELECT position FROM viscms_trainings ORDER BY position DESC LIMIT 1");
list($max) = dbrow($sql2);
$max++;

if($_POST['date1']!='') {
  list($dt1a,$dt1b,$dt1c) = explode(".",$_POST['date1']);
  $dt1 = mktime(12,0,0,$dt1b,$dt1a,$dt1c);
} else $dt1=0;

if($_POST['date2']!='') {
  list($dt2a,$dt2b,$dt2c) = explode(".",$_POST['date2']);
  $dt2 = mktime(12,0,0,$dt2b,$dt2a,$dt2c);
} else $dt2=0;

if(($dt1>0 && $dt2==0) || ($dt1==$dt2)) {
  $date1 = $dt1;
} elseif($dt2>0 && $dt1==0) {
  $date1 = $dt2;
} elseif($dt1>$dt2) {
  $date1 = $dt2;
  $date2 = $dt1;
} else {
  $date1 = $dt1;
  $date2 = $dt2;
}

$title = str_replace("\\","",sqlfilter($_POST['title'],4));

$sql = sql("INSERT INTO viscms_trainings (title,info,place,date1,date2,position,language_id,active,date_info,date_info_color) VALUES ('".sqlfilter($_POST['title'],4)."','".sqlfilter($_POST['info'],7)."','".sqlfilter($_POST['place'],4)."','".$date1."','".$date2."',".$max.",".$_POST['lng'].",'".$_POST['active']."','".sqlfilter($_POST['date_info'],4)."','".sqlfilter($_POST['date_info_color'],5)."')");
$mid=mysql_insert_id();

if($_FILES['attachment']['name']!='') {
	$f=ftp('attachment');
}

for($i=1;$i<=$cfg['tracategories'];$i++) {

	if($_POST['category-'.$i]>0) {
	$sqlCAT = sql("INSERT INTO viscms_trainings_to_categories (training_id,category_id) VALUES ('".$mid."','".$_POST['category-'.$i]."')");
	if($cat=='') $cat=$_POST['category-'.$i];
	}

}

if($sql==true) {
  $msg = '<div class="message">'.$lang['trainings_added'].'</div>';
  generateFile();
  } else {
  $msg = '<div class="message">'.$lang['trainings_not_added'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=trainings&act=show,".$cat);
}

else {

@form($p);

  }

}

function edit($p) {
global $cfg,$var_1,$title,$info,$date1,$date2,$lang_id,$cat_id,$attachment,$active,$lang,$mid,$cat_id,$place,$date_info,$date_info_color;

if($_POST['step'] == '1') {
	
	$mid=$p;

$k=$z=0;
$t=1;

$title = str_replace("\\","",sqlfilter($_POST['title'],4));

$sqlD = sql("SELECT attachment FROM viscms_trainings WHERE id=".$p);
list($dfile)=dbrow($sqlD);

if($_POST['del']==1) {
  @unlink($cfg['trapath'].$dfile);
}

if($_FILES['attachment']['name']!='') {
  @unlink($cfg['trapath'].$dfile);
  ftp('attachment');
}

if($_POST['date1']!='') {
  list($dt1a,$dt1b,$dt1c) = explode(".",$_POST['date1']);
  $dt1 = mktime(12,0,0,$dt1b,$dt1a,$dt1c);
} else $dt1=0;

if($_POST['date2']!='') {
  list($dt2a,$dt2b,$dt2c) = explode(".",$_POST['date2']);
  $dt2 = mktime(12,0,0,$dt2b,$dt2a,$dt2c);
} else $dt2=0;

if(($dt1>0 && $dt2==0) || ($dt1==$dt2)) {
  $date1 = $dt1;
} elseif($dt2>0 && $dt1==0) {
  $date1 = $dt2;
} elseif($dt1>$dt2) {
  $date1 = $dt2;
  $date2 = $dt1;
} else {
  $date1 = $dt1;
  $date2 = $dt2;
}

	$sql = sql("UPDATE viscms_trainings SET title = '".sqlfilter($_POST['title'],4)."', info = '".sqlfilter($_POST['info'],7)."', place = '".sqlfilter($_POST['place'],4)."', date1 = '".$date1."', date2 = '".$date2."', date_info = '".sqlfilter($_POST['date_info'],4)."', date_info_color = '".sqlfilter($_POST['date_info_color'],5)."', language_id = ".$_POST['lng'].", active='".$_POST['active']."' WHERE id=".$p);
	
$sqlCATdel = sql("DELETE FROM viscms_trainings_to_categories WHERE training_id=".$p);
for($i=1;$i<=$cfg['tracategories'];$i++) {

	if($_POST['category-'.$i]>0) {
	$sqlCAT = sql("INSERT INTO viscms_trainings_to_categories (training_id,category_id) VALUES ('".$p."','".$_POST['category-'.$i]."')");
	if($cat=='') $cat=$_POST['category-'.$i];
	}

}
	
if($sql==true)  {
  $msg = '<div class="message">'.$lang['trainings_edited'].'</div>';
  generateFile();
  } else {
  $msg = '<div class="message">'.$lang['trainings_not_edited'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=trainings&act=show,".$cat);
}

else {

$sql = sql('SELECT title,place,info,date1,date2,date_info,date_info_color,language_id,attachment,active FROM viscms_trainings WHERE id='.$p);
if(list($title,$place,$info,$date1,$date2,$date_info,$date_info_color,$lang_id,$attachment,$active) = dbrow($sql)) {
   $title = str_replace('"',"&quot;",$title);
	 if($date1==0) $date1='';
	 else $date1=date("d.m.Y",$date1);
	 if($date2==0) $date2='';
	 else $date2=date("d.m.Y",$date2);
	 
		$sqlCategories = sql("SELECT category_id FROM viscms_trainings_to_categories WHERE training_id=".$p);
		while(list($Cid)=dbrow($sqlCategories)) {
			$i++;
			$cat_id[$i]=$Cid;
		}
	
   form($cat_id,$p);
}
   
  }
}

function form($c,$p) {
global $cfg,$lang,$language,$level,$var_1,$title,$info,$date1,$date2,$lang_id,$cat_id,$attachment,$active,$place,$date_info,$date_info_color;

$sqlLang = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lng) = dbrow($sqlLang);
$lang_id=$lng;

if($var_1=='edit') {
	$action = '?module=trainings&amp;act=edit,'.$p;
	$header = $lang['trainings_edit'];
	$clause = " WHERE id!=".$p;
	$sact[$active] = ' selected="selected"';
	$sql = sql("SELECT A.ident,A.name FROM viscms_trainings_categories A, viscms_trainings B WHERE A.ident=B.category_id AND B.id='".$p."' AND A.language_id='".$lang_id."'");
  if(list($Cid,$Cname)=dbrow($sql)) {
    $level->AddLevel(limitWords($Cname,3),'?module=trainings&act=show,'.$Cid);
  }
}
elseif($var_1=='add') {
	$action = '?module=trainings&amp;act=add';
	$header = $lang['trainings_add'];
	$sact[1] = ' selected="selected"';
}

$level->AddLevel($header);
$level->ShowHead();
echo '<br />';

// jezyk
$lng_fields = array();
$sqlLang = sql("SELECT id,code,name FROM viscms_languages ORDER BY code ASC");
while(list($lid,$lc,$ln) = dbrow($sqlLang)) {
	array_push($lng_fields,array($ln,$lid));
}
  
  $default=$lang_id;
  
  if($lang_id=='') $lang_id=$default;

// kategoria
$category_t = '<table width="100%">';
for($i=1;$i<=$cfg['tracategories'];$i++) {
			
$category_t .= '<tr><td align="right" style="width: 20px;">'.$i.'.</td><td align="left"><select name="category-'.$i.'" style="width: 100%;">
<option value="0">------------------------------------------------------------</option>';
			
$sqlCat = sql("SELECT ident,name FROM viscms_trainings_categories WHERE parent=0 AND language_id=".$lng." ORDER BY position DESC");
while(list($cid,$cname) = dbrow($sqlCat)) {
	if($var_1=='add' && $c==$cid && $i==1) $s = ' selected';
	elseif($var_1=='edit' && $cat_id[$i]==$cid) $s = ' selected';
	else $s='';
	$category_t .= '<option value="'.$cid.'"'.$s.'>'.$cname.'</option>';
	$sqlCatx = sql("SELECT ident,name FROM viscms_trainings_categories WHERE parent=".$cid." AND language_id=".$lng." ORDER BY position DESC");
	while(list($csid,$csname) = dbrow($sqlCatx)) {
		if($var_1=='add' && $c==$csid && $i==1) $s = ' selected';
		elseif($var_1=='edit' && $cat_id[$i]==$csid) $s = ' selected';
		else $s='';
		$category_t .= '<option value="'.$csid.'"'.$s.'>-- '.$csname.'</option>';	
	}
}
$category_t .= '</select></td></tr>';
			
		}
		
$category_t .= '</table>';


// status
$status_fields = array();
array_push($status_fields,array($lang['trainings_active'],1));
array_push($status_fields,array($lang['trainings_deactive'],0));

  $default=0;
  
  if($active=='') $active=$default;
  
echo '<script language="JavaScript">
function CheckDate(date1,date2)
{
var test = /\d{2}[\.]\d{2}[\.]\d{4}/;
var result = date1.match(test);
var result2 = date2.match(test);

if (result == null)
{
	if(date1!="") {
		alert("'.$lang['trainings_error_date_nc'].'");
		return false;
	}
	return true;
}

if (result2 == null)
{
	if(date2!="") {
		alert("'.$lang['trainings_error_date_nc'].'");
		return false;
	}
	return true;
}
return true;
}


</script>';

$form = new Form($action,'post',"multipart/form-data","form",'onsubmit="return CheckDate(this.date1.value,this.date2.value);"');
$form->SetWidths('20%','80%');
$form->FCK();
$form->AddTextInput($lang['trainings_title'],'title',$title);
$form->AddTextInput($lang['trainings_place'],'place',$place);
$form->AddTextInputWithCalendar($lang['trainings_date1'],'date1',$date1);
$form->AddTextInputWithCalendar($lang['trainings_date2'],'date2',$date2);
$form->AddTextInput($lang['trainings_date_info'],'date_info',$date_info);
$form->AddColorField($lang['trainings_date_info_color'],'date_info_color',$date_info_color);
$form->AddSelect($lang['trainings_lng'],'lng',$lng_fields,$lang_id,'style="width: 100%"');
$form->AddAnyField($lang['trainings_category'],$category_t);
$form->AddFCK($lang['trainings_info'],'info',$info);
$form->AddFileInput($lang['trainings_attachment'],'attachment',92,$form->FileInputDel('del',$cfg['trapath'],$attachment));
$form->AddSelect($lang['trainings_status'],'active',$status_fields,$active,'style="width: 100%"');
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();

echo '<p align="center"><a href="?module=trainings"><b>'.$lang['trainings_back'].'</b></a></p>';
}

function delete($p) {
	global $cfg,$lang;
	
	$sqlX = sql("SELECT attachment FROM viscms_trainings WHERE id=".$p);
	if(list($att)=dbrow($sqlX)) {
    @unlink($cfg['trapath'].$att);
  }
  
	$sqlX = sql("SELECT category_id FROM viscms_trainings_to_categories WHERE training_id=".$p);
	list($cat)=dbrow($sqlX);

	$sql = sql("DELETE FROM viscms_trainings WHERE id=".$p);
	$sql = sql("DELETE FROM viscms_trainings_to_categories WHERE training_id=".$p);

	if($sql==true) {
    $msg = '<div class="message">'.$lang['trainings_deleted'].'</div>';
    generateFile();
  }
	else $msg = '<div class="message">'.$lang['trainings_not_deleted'].'</div>';
	setcookie('msg',$msg,time()+60);
  	header("Location: ?module=trainings&act=show,".$cat);
	
}

function training_active($p,$q) {
global $cfg,$lang;

	$sql = sql("UPDATE viscms_trainings SET active=1 WHERE id=".$p);
	
if($sql==true)  {
  $msg = '<div class="message">'.$lang['trainings_activated'].'</div>';
  generateFile();
  } else {
  $msg = '<div class="message">'.$lang['trainings_not_activated'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=trainings&act=show,".$q);
}

function training_deactive($p,$q) {
global $cfg,$lang,$var_2;

	$sql = sql("UPDATE viscms_trainings SET active=0 WHERE id=".$p);
	
if($sql==true)  {
  $msg = '<div class="message">'.$lang['trainings_deactivated'].'</div>';
  generateFile();
  } else {
  $msg = '<div class="message">'.$lang['trainings_not_deactivated'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=trainings&act=show,".$q);
}

function up($p,$c) {
	global $cfg;
	
	$i=0;
	
	$sql = sql("SELECT position FROM viscms_trainings WHERE id=".$p."");
	list($pos) = dbrow($sql);
	
	if($c!=0) {
		$clause = " AND A.id=B.training_id AND B.category_id=".$c;
		$clause1 = ", viscms_trainings_to_categories B";
	}
	
	$sql2 = sql("SELECT A.position FROM viscms_trainings A".$clause1." WHERE A.position>".$pos.$clause." ORDER BY A.position ASC LIMIT 1");
	list($new_pos) = dbrow($sql2);
	
	$sql3 = sql("SELECT id,position FROM viscms_trainings WHERE position>".$pos." AND position<=".$new_pos."");
	while(list($idx,$posx) = dbrow($sql3)) {
		$ident[$i] = $idx;
		$position[$i] = $posx-1;
		$i++;
	}
	
	for($i=0;$i<sizeof($ident);$i++) {
		$sql4 = sql("UPDATE viscms_trainings SET position = ".$position[$i]." WHERE id=".$ident[$i]."");
	}
	
	$sql5 = sql("UPDATE viscms_trainings SET position = ".$new_pos." WHERE id=".$p."");
	
	header("Location: ?module=trainings&act=show,".$c);
	
}

function down($p,$c) {
	global $cfg;
	
	$i=0;
	
	$sql = sql("SELECT position FROM viscms_trainings WHERE id=".$p."");
	list($pos) = dbrow($sql);
	
	if($c!=0) {
		$clause = " AND A.id=B.training_id AND B.category_id=".$c;
		$clause1 = ", viscms_trainings_to_categories B";
	}
	
	$sql2 = sql("SELECT A.position FROM viscms_trainings A".$clause1." WHERE A.position<".$pos.$clause." ORDER BY A.position DESC LIMIT 1");
	list($new_pos) = dbrow($sql2);
	
	$sql3 = sql("SELECT id,position FROM viscms_trainings WHERE position<".$pos." AND position>=".$new_pos."");
	while(list($idx,$posx) = dbrow($sql3)) {
		$ident[$i] = $idx;
		$position[$i] = $posx+1;
		$i++;
	}
	
	for($i=0;$i<sizeof($ident);$i++) {
		$sql4 = sql("UPDATE viscms_trainings SET position = ".$position[$i]." WHERE id=".$ident[$i]);
	}
	
	$sql5 = sql("UPDATE viscms_trainings SET position = ".$new_pos." WHERE id=".$p);
	
	header("Location: ?module=trainings&act=show,".$c);
	
}

function category_up($p,$c) {
	global $cfg;
	
	$i=0;
	
	$sql = sql("SELECT position FROM viscms_trainings_categories WHERE ident=".$p."");
	list($pos) = dbrow($sql);
	
	if($c!=0) {
		$clause = " AND parent=".$c;
		$goto = "&act=category,".$c;
	} else $clause = " AND parent=0";
	
	$sql2 = sql("SELECT position FROM viscms_trainings_categories WHERE position>".$pos.$clause." ORDER BY position ASC LIMIT 1");
	list($new_pos) = dbrow($sql2);
	
	$sql3 = sql("SELECT ident,position FROM viscms_trainings_categories WHERE position>".$pos." AND position<=".$new_pos);
	while(list($idx,$posx) = dbrow($sql3)) {
		$ident[$i] = $idx;
		$position[$i] = $posx-1;
		$i++;
	}
	
	for($i=0;$i<sizeof($ident);$i++) {
		$sql4 = sql("UPDATE viscms_trainings_categories SET position = ".$position[$i]." WHERE ident=".$ident[$i]."");
	}
	
	$sql5 = sql("UPDATE viscms_trainings_categories SET position = ".$new_pos." WHERE ident=".$p);
	
	header("Location: ?module=trainings".$goto);
	
}

function category_down($p,$c) {
	global $cfg;
	
	$i=0;
	
	$sql = sql("SELECT position FROM viscms_trainings_categories WHERE ident=".$p);
	list($pos) = dbrow($sql);
	
	if($c!=0) {
		$clause = " AND parent=".$c;
		$goto = "&act=category,".$c;
	} else $clause = " AND parent=0";
	
	$sql2 = sql("SELECT position FROM viscms_trainings_categories WHERE position<".$pos.$clause." ORDER BY position DESC LIMIT 1");
	list($new_pos) = dbrow($sql2);
	
	$sql3 = sql("SELECT ident,position FROM viscms_trainings_categories WHERE position<".$pos." AND position>=".$new_pos);
	while(list($idx,$posx) = dbrow($sql3)) {
		$ident[$i] = $idx;
		$position[$i] = $posx+1;
		$i++;
	}
	
	for($i=0;$i<sizeof($ident);$i++) {
		$sql4 = sql("UPDATE viscms_trainings_categories SET position = ".$position[$i]." WHERE ident=".$ident[$i]);
	}
	
	$sql5 = sql("UPDATE viscms_trainings_categories SET position = ".$new_pos." WHERE ident=".$p);
	
	header("Location: ?module=trainings".$goto);
	
}

function ftp($file) {
	global $cfg,$mid,$i,$title;

	$name = $_FILES[$file]['name'];
	$ext = explode ('.', $name);
	$ext=strtolower($ext[sizeof($ext)-1]);
	$newname = substr(mod_rewrite(str_replace("&quot;","",$title)),0,128).'_id'.$mid.'.'.$ext;
	
	$a=move_uploaded_file($_FILES[$file]['tmp_name'], $cfg['trapath'].$newname);
	if($a==true) {
		$sqlATT = sql("UPDATE viscms_trainings SET attachment='".$newname."' WHERE id='".$mid."'");
		if($sqlATT==true) return mysql_insert_id();
	}
}

function generateFile() {
	global $cfg;
	
	$file = "../files/calendar.txt";
	$fp = fopen($file,"w+");
	
	// 1 dzien miesiaca
	$month_today = date("m");
	$year_today = date("y");
	$firstday = mktime(12,0,0,$month_today,1,$year_today);
	$date = $firstday;
	
	// ostatni dzien
	$sql = sql("SELECT date1 FROM viscms_trainings WHERE active=1 ORDER BY date1 DESC LIMIT 0,1");
	list($dt1)=dbrow($sql);
	$sql = sql("SELECT date2 FROM viscms_trainings WHERE active=1 ORDER BY date2 DESC LIMIT 0,1");
	list($dt2)=dbrow($sql);
	
	if($dt1>$dt2) $lastday=$dt1;
	else $lastday=$dt2;
	
	while($date<=$lastday) {
    list($d,$m,$y)=explode(".",date("d.m.Y",$date));
    $dtt=$y.$m.$d;
    
    $sql = sql("SELECT B.category_id FROM viscms_trainings A, viscms_trainings_to_categories B WHERE A.id=B.training_id AND ( (A.date2=0 AND A.date1<='".($date+7200)."' AND A.date1>='".($date-7200)."') OR (A.date2!=0 AND A.date1<='".($date+7200)."' AND A.date2>='".($date-7200)."') ) AND A.active=1 AND B.category_id<100 GROUP BY B.category_id");
	  while(list($cid)=dbrow($sql)) {

	    $sql2 = sql("SELECT A.title FROM viscms_trainings A, viscms_trainings_to_categories B WHERE A.id=B.training_id AND ( (A.date2=0 AND A.date1<='".($date+7200)."' AND A.date1>='".($date-7200)."') OR (A.date2!=0 AND A.date1<='".($date+7200)."' AND A.date2>='".($date-7200)."') ) AND A.active=1 AND B.category_id='".$cid."'");
	    while(list($ttitle)=dbrow($sql2)) {
	       if($x!=0) $title .= "][";
	       $title .= $ttitle;
	       $x++;
	    }
	    $x=0;
	  
	    fputs($fp,$cid."|".$dtt."|".$title."\n");
	    $title='';
	  }
    $date+=86400;
  }
	
  fclose($fp);
}

function SortByDate() {
  global $cfg,$lang;
  
  $position=1;
  
  $sql = sql("SELECT id FROM viscms_trainings ORDER BY date1 DESC");
  while(list($id)=dbrow($sql)) {
  
    $sqlU = sql("UPDATE viscms_trainings SET position = '".$position."' WHERE id='".$id."'");
    $position++;
  
  }
  
  header("Location: index.php?module=trainings");

}

?>