<?

###############################
#           visCMS            #
############-------############
#          VISMEDIA           #
#       www.vismedia.pl       #
#      biuro@vismedia.pl      #
###############################

## MODULE: ARTICLES ##

include 'languages/'.$language.'/articles.php';

$level->AddLevel($lang['articles'],'?module=articles');

$vars = explode(',',$_GET['act']);
$var_1 = $vars[0];
$var_2 = $vars[1];
$var_3 = $vars[2];

$cfg['artpath']='../'.$cfg['artpath'];

if(is_numeric($var_2) || $var_2=='') {

###################################### 

$var_2=sqlfilter($var_2,6);

if(auth()!=3)
switch(@$var_1) {

   case '':
   browse();
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
     article_active($var_2,$var_3);
   break;

   case 'deactive':
   if($var_2!='')
     article_deactive($var_2,$var_3);
   break;

   case 'comments':
   if($var_2!='')
     comments($var_2,$var_3);
   break;

   case 'comments_ACT':
   if($var_2!='')
     comments($var_2,$var_3,'a');
   break;

   case 'comments_DEACT':
   if($var_2!='')
     comments($var_2,$var_3,'d');
   break;

   case 'comments_active':
   if($var_2!='')
     comments_active($var_2);
   break;

   case 'comments_deactive':
   if($var_2!='')
     comments_deactive($var_2);
   break;

   case 'comments_edit':
   if($var_2!='')
     comments_edit($var_2);
   break;

   case 'comments_delete':
   if($var_2!='')
     comments_delete($var_2);
   break;
   
   case 'up':
   if($var_2!='')
     @up($var_2,$var_3);
   break;
   
   case 'down':
   if($var_2!='')
     @down($var_2,$var_3);
   break;
   
   case 'category_up':
   if($var_2!='')
     @category_up($var_2,$var_3);
   break;
   
   case 'category_down':
   if($var_2!='')
     @category_down($var_2,$var_3);
   break;

   case 'commentofday':
   if($var_2!='')
     commentofday($var_2);
   break;

   case 'commentofday_d':
   commentofday(0);
   break;

   }

######################################

}

function browse() {
global $cfg,$lang,$language,$level,$links;

// poziom
$level->AddIcon("add2","?module=articles&amp;act=add_category",$lang['articles_category_add']);
$level->AddIcon("add","?module=articles&amp;act=add",$lang['articles_add']);
$level->AddIcon("show","?module=articles&amp;act=show,0",$lang['articles_browse_all']);
$level->ShowHead();

// linki
$links->AddLink($lang['articles_category_add'],"?module=articles&amp;act=add_category");
$links->AddLink($lang['articles_add'],"?module=articles&amp;act=add");
$links->AddLink($lang['articles_browse'],"?module=articles&amp;act=show,0");

echo '<script language="javascript">
function confirmSubmit() {
var agree=confirm("'.$lang['confirm_submit'].'\n\n'.$lang['articles_confirm_del1'].'");
if (agree)
	return true ;
else
	return false ;
}
</script>';

$sql = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lang_id) = dbrow($sql);

$links->Show();

$sqlmnr = sql("SELECT id FROM viscms_articles_categories WHERE language_id='".$lang_id."' AND parent=0");
if(mysql_num_rows($sqlmnr)>0) {

// tworzenie nowej tabeli
$table = new Table('TableClass','TableClassHd',7,3);
$table->NewCell($lang['articles_category'],350,'left','left','bottom','top');
$table->NewCell($lang['articles_num'],120,'center','center','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');
$table->NewCell($lang['order'],60,'center','center','bottom','top');


$sql = sql('SELECT ident, name, position FROM viscms_articles_categories WHERE language_id="'.$lang_id.'" AND parent=0 ORDER BY position DESC');
while (list($id,$category,$position) = dbrow($sql)) {
	
	$sql2 = sql('SELECT COUNT(id) FROM viscms_articles WHERE category_id = '.$id);
	list($count) = dbrow($sql2);
	
	$sqlS = sql("SELECT ident FROM viscms_articles_categories WHERE language_id=".$lang_id." AND parent=".$id);
	while(list($cid) = dbrow($sqlS)) {
		$sql2 = sql('SELECT COUNT(id) FROM viscms_articles WHERE category_id = '.$cid.' AND language_id="'.$lang_id.'"');
		while(list($cc) = dbrow($sql2)) $count+=$cc;
	}
	
	$sqlA = sql("SELECT id FROM viscms_articles WHERE category_id=".$id);
	
$sql2 = sql("SELECT position FROM viscms_articles_categories WHERE parent=0 ORDER BY position DESC LIMIT 1");
list($max) = dbrow($sql2);
$sql2 = sql("SELECT position FROM viscms_articles_categories WHERE parent=0 ORDER BY position ASC LIMIT 1");
list($min) = dbrow($sql2);

// tworzenie pola select
$select = new Select($id);
$select->Add(strtolower($lang['edit']),'?module=articles&amp;act=edit_category,'.$id);
$select->Add(strtolower($lang['delete']),'?module=articles&amp;act=delete_category,'.$id,' onclick="return confirmSubmit();"');
$select->Add(strtolower($lang['articles_menage']),'?module=articles&amp;act=show,'.$id);
$select->Add(strtolower($lang['articles_add']),'?module=articles&amp;act=add,'.$id);
$select->Add(strtolower($lang['articles_subcategories_menage']),'?module=articles&amp;act=category,'.$id);
$select->Add(strtolower($lang['articles_subcategories_add']),'?module=articles&amp;act=add_category,'.$id);
$actions=$select->Ret();

$arrows = new Arrows();
$arrows->Up($position,$max,'?module=articles&cat='.$p.'&act=category_up,'.$id.',0');
$arrows->Down($position,$min,'?module=articles&cat='.$p.'&act=category_down,'.$id.',0');
$UpAndDown = $arrows->Ret();


$category = '<a href="?module=articles&amp;act=show,'.$id.'" class="LinksOnGrey">'.$category.'</a>';

$sqlSubCat = sql('SELECT ident, name, position FROM viscms_articles_categories WHERE language_id="'.$lang_id.'" AND parent="'.$id.'" ORDER BY position DESC');
while (list($Sid,$Scategory) = dbrow($sqlSubCat)) {
  $category .= '<div style="padding-left: 15px;">&bull; <a href="?module=articles&amp;act=show,'.$Sid.'" class="LinksOnGrey">'.$Scategory.'</a></div>';
}

// wylistowanie wartosci
$values = array($category,$count,$actions,$UpAndDown);
$table->CellValue($values);

 }

$table->Show(); // pokaz tabele
    
$links->Show(); // pokaz linki

} else {
	echo '<div class="message">'.$lang['articles_category_not_found'].'</div>';
	echo '<div align="center"><a href="?module=articles&amp;act=add_category">'.$lang['articles_category_add'].'</a></div>';
	echo '<p align="center"><br/><a href="?module=articles&amp;act=show,0"><b>'.$lang['articles_browse'].'</b></a></p>';
	echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
  }
}

function category($p) {
global $cfg,$lang,$language,$level,$links;

$btc = 0;

$sql = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lang_id) = dbrow($sql);

$sqlHd = sql("SELECT name FROM viscms_articles_categories WHERE language_id='".$lang_id."' AND ident=".$p);
list($HdName) = dbrow($sqlHd);

$level->AddLevel($HdName,'');

// poziom
$level->AddIcon("add","?module=articles&amp;act=add,".$p,$lang['articles_add']);
$level->AddIcon("show","?module=articles&amp;act=show,".$p,$lang['articles_browse']);
$level->ShowHead();

// linki
$links->AddLink($lang['articles_category_subcategories_add'],"?module=articles&amp;act=add_category,".$p);
$links->AddLink($lang['articles_add'],"?module=articles&amp;act=add,".$p);
$links->AddLink($lang['articles_browse'],"?module=articles&amp;act=show,".$p);
$links->AddLink($lang['articles_browse_all'],"?module=articles&amp;act=show");

echo '<script language="javascript">
function confirmSubmit() {
var agree=confirm("'.$lang['confirm_submit'].'\n\n'.$lang['articles_confirm_del2'].'");
if (agree)
	return true ;
else
	return false ;
}
</script>';

$links->Show();

$sqlmnr = sql("SELECT id FROM viscms_articles_categories WHERE language_id='".$lang_id."' AND parent=".$p);
if(mysql_num_rows($sqlmnr)>0) {

// tworzenie nowej tabeli
$table = new Table('TableClass','TableClassHd',7,3);
$table->NewCell($lang['articles_category'],350,'left','left','bottom','top');
$table->NewCell($lang['articles_num'],120,'center','center','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');
$table->NewCell($lang['order'],60,'center','center','bottom','top');

$sql2 = sql("SELECT position FROM viscms_articles_categories WHERE parent=".$p." ORDER BY position DESC LIMIT 1");
list($max) = dbrow($sql2);
$sql2 = sql("SELECT position FROM viscms_articles_categories WHERE parent=".$p." ORDER BY position ASC LIMIT 1");
list($min) = dbrow($sql2);

$sql = sql('SELECT ident, name, position FROM viscms_articles_categories WHERE language_id="'.$lang_id.'" AND parent='.$p.' ORDER BY position DESC');
while (list($id,$category,$position) = dbrow($sql)) {
	
	$sql2 = sql('SELECT COUNT(id) FROM viscms_articles WHERE category_id = '.$id);
	list($count) = dbrow($sql2);

// tworzenie pola select
$select = new Select($id);
$select->Add(strtolower($lang['edit']),'?module=articles&amp;act=edit_category,'.$id);
$select->Add(strtolower($lang['delete']),'?module=articles&amp;act=delete_category,'.$id,' onclick="return confirmSubmit();"');
$select->Add(strtolower($lang['articles_menage']),'?module=articles&amp;act=show,'.$id);
$select->Add(strtolower($lang['articles_add']),'?module=articles&amp;act=add,'.$id);
$actions=$select->Ret();

// gora/dol
$arrows = new Arrows();
$arrows->Up($position,$max,'?module=articles&cat='.$p.'&act=category_up,'.$id.',0');
$arrows->Down($position,$min,'?module=articles&cat='.$p.'&act=category_down,'.$id.',0');
$UpAndDown = $arrows->Ret();

$category = '<a href="?module=articles&amp;act=show,'.$id.'" class="LinksOnGrey">'.$category.'</a>';

// wylistowanie wartosci
$values = array($category,$count,$actions,$UpAndDown);
$table->CellValue($values);
 }

$table->Show(); // pokaz tabele
    
$links->Show(); // pokaz linki

} else {
	echo '<div class="message">'.$lang['articles_category_not_found'].'</div>';
	echo '<div align="center"><a href="?module=articles&amp;act=add_category,'.$p.'">'.$lang['articles_category_subcategories_add'].'</a></div>';
	echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
  }
}

function add_category($p) {
global $cfg,$lang,$language,$_POST,$var_1,$var_2,$i;

if($p>0) {
  $sqlV = sql("SELECT parent FROM viscms_articles_categories WHERE ident='".$p."'");
  if(list($parent)=dbrow($sqlV)) {
    if($parent==0) $ok=1;
  }
} else $ok=1;

if($ok==1) {

if($_POST['step'] == '1') {
	
$t=0;

$sql2 = sql("SELECT position FROM viscms_articles_categories ORDER BY position DESC LIMIT 1");
list($max) = dbrow($sql2);
$max++;

$sql2 = sql("SELECT ident FROM viscms_articles_categories ORDER BY ident DESC LIMIT 1");
list($ident) = dbrow($sql2);
$ident++;

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	$_POST['name_lang-'.$lid] = sqlfilter($_POST['name_lang-'.$lid],4);
	$_POST['description_lang-'.$lid] = sqlfilter($_POST['description_lang-'.$lid],7);
	$sql = sql("INSERT INTO viscms_articles_categories (name,description,language_id,ident,parent,position) VALUES ('".$_POST['name_lang-'.$lid]."','".$_POST['description_lang-'.$lid]."','".$lid."','".$ident."','".$p."','".$max."')");
	if($sql==true) $t=1; else { $t=0; break; }
}
if($t==1) {
  $msg = '<div class="message">'.$lang['articles_category_added'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['articles_category_not_added'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  if($p=='') header("Location: ?module=articles");
  else header("Location: ?module=articles&act=category,".$p);
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
	$sql = sql("UPDATE viscms_articles_categories SET name = '".$_POST['name_lang-'.$lid]."', description = '".$_POST['description_lang-'.$lid]."' WHERE language_id=".$lid." AND ident=".$p);
	if($sql==true) $z++;
}
if(mysql_num_rows($sqlLang)==$z) {
  $msg = '<div class="message">'.$lang['articles_category_edited'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['articles_category_not_edited'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  $sqlC = sql("SELECT parent FROM viscms_articles_categories WHERE ident=".$p);
  list($par)=dbrow($sqlC);
  if($par==0)
  	header("Location: ?module=articles");
  else
  	header("Location: ?module=articles&act=category,".$par);
}

else {

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	
	$sql = sql('SELECT name,description FROM viscms_articles_categories WHERE ident='.$p.' AND language_id='.$lid);
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
	$action = '?module=articles&amp;act=edit_category,'.$p;
	$header = $lang['articles_category_edit'];
} elseif($var_1=='add_category') {
	if($p!='') {
		$header = $lang['articles_category_subcategories_add'];
		$action = '?module=articles&amp;act=add_category,'.$p;
	} else {
		$action = '?module=articles&amp;act=add_category';
		$header = $lang['articles_category_add'];
	}
}

$level->AddLevel($header,'');
	
$level->ShowHead();

echo '<br />';

$form = new Form($action,'post');
$form->SetWidths('20%','80%');
$form->FCK();
$form->MultiLanguage(1);
$form->AddTextInput($lang['articles_category_name'],'name',$name);
$form->AddFCK($lang['articles_category_description'],'description',$description);
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();

echo '<p align="center"><a href="?module=articles"><b>'.$lang['articles_back'].'</b></a></p>';
}

function delete_category($p) {
	global $cfg,$lang;
	
	$sql = sql("SELECT parent FROM viscms_articles_categories WHERE ident=".$p);
	list($par) = dbrow($sql);
	
	$sql = sql("SELECT ident FROM viscms_articles_categories WHERE parent=".$p);
	while(list($ident) = dbrow($sql)) {
		$sqlx0x = sql("SELECT id FROM viscms_articles WHERE category_id=".$ident);
		while(list($id)=dbrow($sqlx0x)) {
			$sqlx0y = sql("SELECT file FROM viscms_articles_attachments WHERE article_id=".$id);
			while(list($file)=dbrow($sqlx0y)) @unlink($cfg['artpath'].$file);
			$sqlx0 = sql("DELETE FROM viscms_articles_attachments WHERE article_id=".$id);
			$sqlx0z = sql("DELETE FROM viscms_articles_comments WHERE article_id=".$id);
		}
		$sqlx1 = sql("DELETE FROM viscms_articles WHERE category_id=".$ident);
		$sqlx2 = sql("DELETE FROM viscms_articles_categories WHERE ident=".$ident);
	}
	
	$sqlx0x = sql("SELECT id FROM viscms_articles WHERE category_id=".$p);
	while(list($id)=dbrow($sqlx0x)) {
		$sqlx0y = sql("SELECT file FROM viscms_articles_attachments WHERE article_id=".$id);
		while(list($file)=dbrow($sqlx0y)) @unlink($cfg['artpath'].$file);
		$sqlx0 = sql("DELETE FROM viscms_articles_attachments WHERE article_id=".$id);
		$sqlx0z = sql("DELETE FROM viscms_articles_comments WHERE article_id=".$id);
	}
	
	$sql = sql("DELETE FROM viscms_articles WHERE category_id=".$p);
	if($sql==true) {
		$sqlx = sql("DELETE FROM viscms_articles_categories WHERE ident=".$p);
	}

	if($sqlx==true) $msg = '<div class="message">'.$lang['articles_category_deleted'].'</div>';
	else $msg = '<div class="message">'.$lang['articles_category_not_deleted'].'</div>';
	setcookie('msg',$msg,time()+60);
  	if($par=='' || $par==0) header("Location: ?module=articles");
  	else header("Location: ?module=articles&act=category,".$par);
	
}

function show($p,$q) {
global $cfg,$lang,$language,$level,$links;

$btc = 0;

if($q=='') $q=1;
$str = ($q-1)*$cfg['artlimitrows3'];

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
	$clause = " WHERE category_id=".$p;
	if($_GET['active']=='ACT') {
		$clause .= " AND active=1";
		$page_act = '&amp;active=ACT';
	}
	elseif($_GET['active']=='DEACT') {
		$clause .= " AND active=0";
		$page_act = '&amp;active=DEACT';
	}
	$sqlA = sql("SELECT name,parent FROM viscms_articles_categories WHERE ident=".$p." AND language_id=".$lng);
	list($catname,$parent)=dbrow($sqlA);
	$sqlA = sql("SELECT name FROM viscms_articles_categories WHERE ident=".$parent." AND language_id=".$lng);
	if(list($catname2)=dbrow($sqlA))
  $level->AddLevel($catname2,'?module=articles&amp;act=category,'.$parent);
}
else {
	$p=0;
	$catname = $lang['articles_all'];
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
$level->AddIcon("add","?module=articles&amp;act=add",$lang['articles_add']);
$level->ShowHead();

// linki
$links->AddLink($lang['articles_add'],"?module=articles&amp;act=add,".$p);

$sql = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lang_id) = dbrow($sql);

if($_GET['active']=='ACT') {
  $links->AddLink($lang['articles_show_all'],'?module=articles&act=show,'.$p);
  $links->AddLink($lang['articles_show_deactive'],'?module=articles&act=show,'.$p.'&amp;active=DEACT');
} elseif($_GET['active']=='DEACT') {
  $links->AddLink($lang['articles_show_all'],'?module=articles&act=show,'.$p);
  $links->AddLink($lang['articles_show_active'],'?module=articles&act=show,'.$p.'&amp;active=ACT');
} else {
  $links->AddLink($lang['articles_show_active'],'?module=articles&act=show,'.$p.'&amp;active=ACT');
  $links->AddLink($lang['articles_show_deactive'],'?module=articles&act=show,'.$p.'&amp;active=DEACT');
}

$links->Show();

$sqlmnr = sql("SELECT id FROM viscms_articles".$clause." LIMIT ".$str.",".$cfg['artlimitrows3']);
if(mysql_num_rows($sqlmnr)>0) {

// tworzenie nowej tabeli
$table = new Table('TableClass','TableClassHd',7,3);
$table->NewCell($lang['articles_title'],310,'left','left','bottom','top');
$table->NewCell($lang['show'],45,'center','center','bottom','top');
$table->NewCell($lang['articles_lng'],100,'center','center','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');
$table->NewCell($lang['order'],60,'center','center','bottom','top');


$sql2 = sql("SELECT position FROM viscms_articles".$clause." ORDER BY position DESC LIMIT 1");
list($max) = dbrow($sql2);
$sql2 = sql("SELECT position FROM viscms_articles".$clause." ORDER BY position ASC LIMIT 1");
list($min) = dbrow($sql2);

$sql = sql('SELECT id,title,date,position,language_id,active FROM viscms_articles'.$clause.' ORDER BY position DESC LIMIT '.$str.','.$cfg['artlimitrows3']);
while (list($id,$title,$date,$position,$lang_id,$active) = dbrow($sql)) {
	
	$sqlLang = sql("SELECT name FROM viscms_languages WHERE id='".$lang_id."'");
	list($lng) = dbrow($sqlLang);
	
	$date = date("d.m.Y H:i",$date);
	
	$sqlComments = sql('SELECT count(id) FROM viscms_articles_comments WHERE article_id="'.$id.'"');
	list($comments)=dbrow($sqlComments);
	
	$title .= '<br /><span class="date">'.$date.' ('.$lang['articles_comments'].': '.intval($comments).')</span>';
    
// tworzenie pola pokaz
if($active==1) $show = $table->ShowCheck($active,'?module=articles&amp;act=deactive,'.$id.','.$p);
else $show = $table->ShowCheck($active,'?module=articles&amp;act=active,'.$id.','.$p);

// tworzenie pola select
$select = new Select($id);
$select->Add(strtolower($lang['edit']),'?module=articles&amp;act=edit,'.$id);
$select->Add(strtolower($lang['delete']),'?module=articles&amp;act=delete,'.$id,' onclick="return confirmSubmit();"');

if($active==1) $select->Add(strtolower($lang['articles_deactivate']),'?module=articles&amp;act=deactive,'.$id.','.$p);
else $select->Add(strtolower($lang['articles_activate']),'?module=articles&amp;act=active,'.$id.','.$p);

$select->Add(strtolower($lang['articles_comments_manage']),'?module=articles&amp;act=comments,'.$id);

$actions=$select->Ret();

// gora/dol
$arrows = new Arrows();
$arrows->Up($position,$max,'?module=articles&cat='.$p.'&act=up,'.$id.','.$p);
$arrows->Down($position,$min,'?module=articles&cat='.$p.'&act=down,'.$id.','.$p);
$UpAndDown = $arrows->Ret();

// wylistowanie wartosci
$values = array($title,$show,$lng,$actions,$UpAndDown);
$table->CellValue($values);

}
    
$table->Show(); // pokaz tabele
    
$links->Show(); // pokaz linki

$pages = new Pages($q, "?module=articles&act=show,".$p, $cfg['artlimitrows3']);
$pages->Sql("SELECT id FROM viscms_articles".$clause);
$pages->Show();

} else {
	echo '<div class="message">'.$lang['articles_not_found'].'</div>';
	echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
  }
}

function add($p) {
global $cfg,$lang,$language,$_POST,$var_1,$i,$mid;

if($_POST['step'] == '1') {

$k=0;
$t=1;

$sql2 = sql("SELECT position FROM viscms_articles ORDER BY position DESC LIMIT 1");
list($max) = dbrow($sql2);
$max++;

for($i=1;$i<=$cfg['artsimilar'];$i++) {
	$sim[$i-1]=$_POST['similar-'.$i];
}

$sim = array_unique($sim);

for($i=0;$i<sizeof($sim);$i++) {
	if($sim[$i]!='0') {
		if($similar!='') $similar.=',';
		$similar.=$sim[$i];
	}
}

$sql = sql("INSERT INTO viscms_articles (title,intro,moretext,date,author,position,language_id,category_id,similar,active) VALUES ('".sqlfilter($_POST['title'],4)."','".sqlfilter($_POST['intro'],7)."','".sqlfilter($_POST['moretext'],7)."','".time()."','".sqlfilter($_POST['author'],4)."',".$max.",".$_POST['lng'].",'".$_POST['category']."','".$similar."','".$_POST['active']."')");
$mid=mysql_insert_id();

if($_POST['active']==1) {
$sqlC=sql("SELECT name FROM viscms_articles_categories WHERE ident = ".$_POST['category']." AND language_id=".$_POST['lng']);
list($category)=dbrow($sqlC);

$rss = new RSS("../rss.xml");
$rss->ToDb('article',$mid,sqlfilter($_POST['title'],4),sqlfilter($_POST['intro'],7),time(),$category,$_POST['lng'],$_POST['author']);
$rss->Generate();
}

for($i=1;$i<=$cfg['artattach'];$i++) {
	if($_POST['name-attachment-'.$i]!='') {
		$f=ftp('attachment-'.$i);
			if(is_numeric($f)) {
				if($attach!='') $attach .= ',';
				$attach .= $f;
			}
		}
}

for($i=1;$i<=$cfg['artsources'];$i++) {
	
	if($_POST['name-source-'.$i]!='') {
	if($_POST['url-source-'.$i]=='http://') $_POST['url-source-'.$i]='';
	$_POST['url-source-'.$i]=str_replace('http://http://','http://',$_POST['url-source-'.$i]);
	
	$sqlSRC = sql("INSERT INTO viscms_articles_sources (name,url,article_id) VALUES ('".sqlfilter($_POST['name-source-'.$i],4)."', '".sqlfilter($_POST['url-source-'.$i],3)."','".$mid."')");
	}
	
}

$sqlATT = sql("UPDATE viscms_articles SET attachments='".$attach."' WHERE id=".$mid);

if($sql==true) {
  $msg = '<div class="message">'.$lang['articles_added'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['articles_not_added'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=articles&act=show,".$_POST['category']);
}

else {

@form($p);

  }

}

function edit($p) {
global $cfg,$var_1,$title,$author,$intro,$moretext,$lang_id,$lang,$_POST,$source,$source_link,$i,$mid,$cat_id,$similar,$attach,$active;

if($_POST['step'] == '1') {
	
	$mid=$p;

$k=$z=0;
$t=1;

for($i=1;$i<=$cfg['artsimilar'];$i++) {
	$sim[$i-1]=$_POST['similar-'.$i];
}

$sim = array_unique($sim);

for($i=0;$i<sizeof($sim);$i++) {
	if($sim[$i]!='0') {
		if($similar!='') $similar.=',';
		$similar.=$sim[$i];
	}
}

for($i=1;$i<=$cfg['artattach'];$i++) {
	if($_POST['attach-'.$i]!='') {
			if($_POST['attach-'.$i]!=$_POST['del-'.$i]) {
				if($attach!='') $attach .= ',';
				$attach .= $_POST['attach-'.$i];
			} else {
				$sqlD = sql("SELECT file FROM viscms_articles_attachments WHERE id=".$_POST['del-'.$i]);
				if(list($dfile)=dbrow($sqlD)) {
					@unlink($cfg['artpath'].$dfile);
					$sqlD = sql("DELETE FROM viscms_articles_attachments WHERE id=".$_POST['del-'.$i]);
				}
			}
		}	
	if($_POST['name-attachment-'.$i]!='') {
		$f=ftp('attachment-'.$i);
			if(is_numeric($f)) {
				if($attach!='') $attach .= ',';
				$attach .= $f;
			}
		}
}

if($_POST['chtime']==1) $sql = sql("UPDATE viscms_articles SET date = '".time()."' WHERE id=".$p);

	$sql = sql("UPDATE viscms_articles SET title = '".sqlfilter($_POST['title'],4)."', intro = '".sqlfilter($_POST['intro'],7)."', moretext = '".sqlfilter($_POST['moretext'],7)."', author = '".sqlfilter($_POST['author'],4)."', language_id = ".$_POST['lng'].", category_id='".$_POST['category']."', similar='".$similar."', attachments='".$attach."', active='".$_POST['active']."' WHERE id=".$p);
	
if($_POST['active']==1) {
$sqlC=sql("SELECT name FROM viscms_articles_categories WHERE ident = ".$_POST['category']." AND language_id=".$_POST['lng']);
list($category)=dbrow($sqlC);

$rss = new RSS("../rss.xml");
$rss->Delete('article',$p);
$rss->ToDb('article',$p,sqlfilter($_POST['title'],4),sqlfilter($_POST['intro'],7),time(),$category,$_POST['lng'],$_POST['author']);
$rss->Generate();
}
	
	$sqlSRCdel = sql("DELETE FROM viscms_articles_sources WHERE article_id=".$p);
	
for($i=1;$i<=$cfg['artsources'];$i++) {
	
	if($_POST['name-source-'.$i]!='') {
	if($_POST['url-source-'.$i]=='http://') $_POST['url-source-'.$i]='';
	$_POST['url-source-'.$i]=str_replace('http://http://','http://',$_POST['url-source-'.$i]);
	
	$sqlSRC = sql("INSERT INTO viscms_articles_sources (name,url,article_id) VALUES ('".sqlfilter($_POST['name-source-'.$i],4)."', '".sqlfilter($_POST['url-source-'.$i],3)."','".$p."')");
	}
	
}
	
if($sql==true)  {
  $msg = '<div class="message">'.$lang['articles_edited'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['articles_not_edited'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=articles&act=show,".$_POST['category']);
}

else {

$sql = sql('SELECT title,author,intro,moretext,language_id,category_id,similar,attachments,active FROM viscms_articles WHERE id='.$p);
if(list($title,$author,$intro,$moretext,$lang_id,$cat_id,$similar,$attach,$active) = dbrow($sql)) {
   $title = str_replace('"',"&quot;",$title);
   
$i=0;
		$sqlSrc = sql('SELECT name,url FROM viscms_articles_sources WHERE article_id='.$p.' LIMIT 0,'.$cfg['artsources']);
		while(list($SRCn,$SRCu)=dbrow($sqlSrc)) {
			$i++;
			$source[$i]=$SRCn;
			$source_link[$i]=$SRCu;
		}
	
   form($cat_id,$p);
}
   
  }
}

function form($c,$p) {
global $cfg,$lang,$language,$level,$var_1,$title,$author,$intro,$moretext,$lang_id,$source,$source_link,$cat_id,$similar,$attach,$active;

$category=$cat_id;

$sqlLang = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lng) = dbrow($sqlLang);
$lang_id=$lng;

if($var_1=='edit') {
	$action = '?module=articles&amp;act=edit,'.$p;
	$header = $lang['articles_edit'];
	$attach=explode(",",$attach);
	$similar=explode(",",$similar);
	$clause = " WHERE id!=".$p;
	$sact[$active] = ' selected="selected"';
	$sql = sql("SELECT A.ident,A.name FROM viscms_articles_categories A, viscms_articles B WHERE A.ident=B.category_id AND B.id='".$p."' AND A.language_id='".$lang_id."'");
  if(list($Cid,$Cname)=dbrow($sql)) {
    $level->AddLevel(limitWords($Cname,3),'?module=articles&act=show,'.$Cid);
  }
}
elseif($var_1=='add') {
	$action = '?module=articles&amp;act=add';
	$header = $lang['articles_add'];
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
$category_fields = array();
array_push($category_fields,array(strtoupper($lang['articles_category_na']),0));

$sqlCat = sql("SELECT ident,name FROM viscms_articles_categories WHERE parent=0 AND language_id=".$lng." ORDER BY position DESC");
while(list($cid,$cname) = dbrow($sqlCat)) {
  array_push($category_fields,array($cname,$cid));
	$sqlCatx = sql("SELECT ident,name FROM viscms_articles_categories WHERE parent=".$cid." AND language_id=".$lng." ORDER BY position DESC");
	while(list($csid,$csname) = dbrow($sqlCatx)) {
	  array_push($category_fields,array('-- '.$csname,$csid));
	}
}
  
  $default=1;
  
  if($category=='') $category=$default;
  
// zrodlo
$source_t = '<table cellpadding="2" cellspacing="3" width="100%"><tr><td width="2%"></td><td width="49%">&nbsp;&nbsp;'.$lang['articles_source_name'].'</td><td width="49%">&nbsp;&nbsp;'.$lang['articles_source_link'].'</td></tr>';
	
	for($i=1;$i<=$cfg['artsources'];$i++) {
		if($source_link[$i]=='') $source_link[$i] = 'http://';
			$source_t .= '<tr><td align="right">'.$i.'.</td><td align="left"><input type="text" name="name-source-'.$i.'" value="'.$source[$i].'" style="width: 100%;" /></td><td><input type="text" name="url-source-'.$i.'" style="width: 100%;" value="'.$source_link[$i].'" /></td></tr>';
	}

$source_t .= '</table>';



// za³±czniki
$attachments_t = '<table cellpadding="2" cellspacing="3" width="100%"><tr><td width="2%"></td><td width="49%">'.$lang['articles_attachments_name'].'</td><td width="49%">'.$lang['articles_attachments_file'].'</td></tr>';
	
	for($i=1;$i<=$cfg['artattach'];$i++) {
		$sqlATT = sql("SELECT name,file FROM viscms_articles_attachments WHERE id='".$attach[$i-1]."'");
		if(list($atname,$atfile)=dbrow($sqlATT)) {

		$atname_o='';
		
		for($j=0;$j<20;$j++) {
			$atname_o.=$atname[$j];
		}
		if($atname[19]!='') $atname_o.='...';

			$attachments_t .= '<tr><td align="right">'.$i.'.</td><td align="left"><a href="'.$cfg['artpath'].$atfile.'" target="_blank" title="'.$atname.'">'.$atname_o.'</a><input type="hidden" name="attach-'.$i.'" value="'.$attach[$i-1].'" /></td><td><input type="checkbox" name="del-'.$i.'" value="'.$attach[$i-1].'" /> &nbsp;'.$lang['delete'].'</td></tr>';
		} else $attachments_t .= '<tr><td align="right">'.$i.'.</td><td align="left"><input type="text" name="name-attachment-'.$i.'" style="width: 100%;" /></td><td><input type="file" name="attachment-'.$i.'" size="25" /></td></tr>';
	}

		$attachments_t .= '</table>';

// powi±zane newsy
$similar_t = '<table cellpadding="2" cellspacing="3" width="100%">';

	for($i=1;$i<=$cfg['artsimilar'];$i++) {
		$similar_t .= '<tr><td align="right" width="2%">'.$i.'.</td><td align="left" width="98%"><select name="similar-'.$i.'" style="width: 100%;">
<option value="0">------------------------------------------------------------</option>';
		
	
	$sqlSM2 = sql("SELECT id,title FROM viscms_articles WHERE active=1 ORDER BY date DESC LIMIT 0,".$cfg['artsim1']);
	while(list($aid,$atitle)=dbrow($sqlSM2)) {
		
		if($similar[$i-1]=='A_'.$aid) $s = ' selected="selected"';
		else $s='';
		
		$title_o='';
		
		for($j=0;$j<50;$j++) {
			$title_o.=$atitle[$j];
		}
		if($atitle[49]!='') $title_o.='...';
		
		$similar_t .= '
<option value="A_'.$aid.'"'.$s.'> - '.$title_o.' (ID#: '.$aid.')</option>';
		
	}

		$similar_t .= '</select></td></tr>';
	}

		$similar_t .= '</table>';

// status
$status_fields = array();
array_push($status_fields,array($lang['articles_active'],1));
array_push($status_fields,array($lang['articles_deactive'],0));

  $default=0;
  
  if($active=='') $active=$default;

$form = new Form($action,'post');
$form->SetWidths('20%','80%');
$form->FCK();
$form->AddTextInput($lang['articles_title'],'title',$title);
$form->AddSelect($lang['articles_lng'],'lng',$lng_fields,$lang_id,'style="width: 100%"');
$form->AddSelect($lang['articles_category'],'category',$category_fields,$category,'style="width: 100%"');
$form->AddFCK($lang['articles_intro'],'intro',$intro);
$form->AddFCK($lang['articles_moretext'],'moretext',$moretext);
$form->AddAnyField($lang['articles_source'],$source_t);

if($var_1=='edit') {
  $form->AddCheckboxInput($lang['articles_change_date'],'chtime',array(array($lang['yes'],1)),1);
} else {
	session_start();
	$login = $_SESSION["admin"];
	$sql = sql("SELECT firstname, surname FROM viscms_admins WHERE login='".$login."'");
	if(list($firstname,$surname) = dbrow($sql)) {
		if($firstname!='' || $surname!='')
			$author = $firstname.' '.$surname;
		else $author = $login;
	}
}

$form->AddTextInput($lang['articles_author'],'author',$author);
$form->AddAnyField($lang['articles_attachments'],$attachments_t);
$form->AddAnyField($lang['articles_similar'],$similar_t);
$form->AddSelect($lang['articles_status'],'active',$status_fields,$active,'style="width: 100%"');
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();

echo '<p align="center"><a href="?module=articles"><b>'.$lang['articles_back'].'</b></a></p>';
}

function delete($p) {
	global $cfg,$lang;

	$rss = new RSS("../rss.xml");
	$rss->Delete('article',$p);
	$rss->Generate();
	
	$sqlX = sql("SELECT category_id FROM viscms_articles WHERE id=".$p);
	list($cat)=dbrow($sqlX);

	$sql = sql("DELETE FROM viscms_articles_comments WHERE article_id=".$p);
	$sql = sql("DELETE FROM viscms_articles_sources WHERE article_id=".$p);
	$sql = sql("DELETE FROM viscms_articles WHERE id=".$p);
	
	$sqlx0y = sql("SELECT file FROM viscms_articles_attachments WHERE article_id=".$p);
	while(list($file)=dbrow($sqlx0y)) @unlink($cfg['artpath'].$file);
	$sqlx0 = sql("DELETE FROM viscms_articles_attachments WHERE article_id=".$p);

	if($sql==true) $msg = '<div class="message">'.$lang['articles_deleted'].'</div>';
	else $msg = '<div class="message">'.$lang['articles_not_deleted'].'</div>';
	setcookie('msg',$msg,time()+60);
  	header("Location: ?module=articles&act=show,".$cat);
	
}

function comments($p,$q,$act='all') {
global $cfg,$lang,$language,$level,$links;

if($q=='') $q=1;
$str = ($q-1)*$cfg['artlimitcomment'];

$sql = sql("SELECT id,title FROM viscms_articles WHERE id='".$p."'");
if(list($Aid,$Atitle)=dbrow($sql)) {
  $level->AddLevel(limitWords($Atitle,3),'?module=articles&act=edit,'.$Aid);
}

$level->AddLevel($lang['articles_comments'],'');

echo '<script language="javascript">
function confirmSubmit() {
var agree=confirm("'.$lang['confirm_submit'].'");
if (agree)
	return true ;
else
	return false ;
}
</script>';

$clause = " WHERE article_id='".$p."'";

if($act=='d') $clause .= " AND active=0";
elseif($act=='a') $clause .= " AND active=1";



$level->ShowHead();

// linki
if($act=='a') {
  $links->AddLink($lang['articles_comments_show_all'],"?module=articles&act=comments,".$p);
  $links->AddLink($lang['articles_comments_show_deactive'],"?module=articles&act=comments_DEACT,".$p);
} elseif($act=='d') {
  $links->AddLink($lang['articles_comments_show_all'],"?module=articles&act=comments,".$p);
  $links->AddLink($lang['articles_comments_show_active'],"?module=articles&act=comments_ACT,".$p);
} else {
  $links->AddLink($lang['articles_comments_show_active'],"?module=articles&act=comments_ACT,".$p);
  $links->AddLink($lang['articles_comments_show_deactive'],"?module=articles&act=comments_DEACT,".$p);
}

$sql = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lang_id) = dbrow($sql);

$links->Show();

$sqlmnr = sql("SELECT id FROM viscms_articles_comments".$clause." LIMIT ".$str.",".$cfg['artlimitcomment']);
if(mysql_num_rows($sqlmnr)>0) {

$table = new Table('TableClass','TableClassHd',7,3);
$table->NewCell($lang['articles_comment'],500,'left','left','bottom','top');
$table->NewCell($lang['show'],45,'center','center','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');

$sqlCmt = sql('SELECT type,type_id FROM viscms_commentofday WHERE language_id='.$lang_id);
list($com_type,$com_type_id)=dbrow($sqlCmt);

$sql = sql('SELECT id,author,date,content,ip,active FROM viscms_articles_comments'.$clause.' ORDER BY date DESC LIMIT '.$str.','.$cfg['artlimitcomment']);
while (list($id,$author,$date,$content,$ip,$active) = dbrow($sql)) {
	
	$date = date("d.m.Y H:i",$date);

/*	
	if($com_type=='articles' && $com_type_id==$id) {
		$a1='<b>';
		$a2='</b>';
	} else {
		$a1='<a href="?module=articles&amp;act=commentofday,'.$id.'">';
		$a2='</a>';
	}
*/

if($active==1) $show = $table->ShowCheck($active,'?module=articles&act=comments_deactive,'.$id);
else $show = $table->ShowCheck($active,'?module=articles&act=comments_active,'.$id);

// tworzenie pola select
$select = new Select($id);

if($active==1) $select->Add(strtolower($lang['articles_deactivate']),'?module=articles&act=comments_deactive,'.$id);
else $select->Add(strtolower($lang['articles_activate']),'?module=articles&act=comments_active,'.$id);

$select->Add(strtolower($lang['edit']),'?module=articles&act=comments_edit,'.$id);
$select->Add(strtolower($lang['delete']),'?module=articles&act=comments_delete,'.$id,' onclick="return confirmSubmit();"');

$actions=$select->Ret();

$comment = '<span class="date">'.$author.' (IP: '.$ip.'), '.$date.'</span><br />'.strip_tags($content);

// wylistowanie wartosci
$values = array($comment,$show,$actions);
$table->CellValue($values);

}

$table->Show(); // pokaz tabele
    
$links->Show(); // pokaz linki

$pages = new Pages($q, "?module=articles&act=comments,".$p, $cfg['artlimitcomment']);
$pages->Sql("SELECT id FROM viscms_articles_comments".$clause);
$pages->Show();

} else {
	echo '<div class="message">'.$lang['articles_comments_not_found'].'</div>';
  }
	echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
}

function article_active($p,$q) {
global $cfg,$lang;

	$rss = new RSS("../rss.xml");

$sql=sql("SELECT A.id,A.title,A.intro,A.date,B.name,A.author,A.language_id FROM viscms_articles A, viscms_articles_categories B WHERE A.category_id=B.ident AND A.language_id=B.language_id AND A.id=".$p);
if(list($id,$title,$intro,$date,$category,$author,$language_id)=dbrow($sql)) {
	$rss->ToDb('article',$id,$title,$intro,$date,$category,$language_id,$author);
}

	$rss->Generate();

	$sql = sql("UPDATE viscms_articles SET active=1 WHERE id=".$p);
	
if($sql==true)  {
  $msg = '<div class="message">'.$lang['articles_activated'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['articles_not_activated'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=articles&act=show,".$q);
}

function article_deactive($p,$q) {
global $cfg,$lang,$var_2;

	$rss = new RSS("../rss.xml");
	$rss->Delete('article',$p);
	$rss->Generate();

	$sql = sql("UPDATE viscms_articles SET active=0 WHERE id=".$p);
	
if($sql==true)  {
  $msg = '<div class="message">'.$lang['articles_deactivated'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['articles_not_deactivated'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=articles&act=show,".$q);
}

function comments_active($p) {
global $cfg,$lang;

	$sql = sql("UPDATE viscms_articles_comments SET active=1 WHERE id=".$p);
	$sql2 = sql("SELECT article_id FROM viscms_articles_comments WHERE id=".$p);
	list($id) = dbrow($sql2);
	
if($sql==true)  {
  $msg = '<div class="message">'.$lang['articles_comments_activated'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['articles_comments_not_activated'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=articles&act=comments,".$id);
}

function comments_deactive($p) {
global $cfg,$lang;

	$sql = sql("UPDATE viscms_articles_comments SET active=0 WHERE id=".$p);
	$sql2 = sql("SELECT article_id FROM viscms_articles_comments WHERE id=".$p);
	list($id) = dbrow($sql2);
	
if($sql==true)  {
  $msg = '<div class="message">'.$lang['articles_comments_deactivated'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['articles_comments_not_deactivated'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=articles&act=comments,".$id);
}

function comments_edit($p) {
global $cfg,$lang,$level;

$sqlD = sql("SELECT author,content,active,article_id FROM viscms_articles_comments WHERE id=".$p);
list($author,$content,$active,$id)=dbrow($sqlD);

if($_POST['step']==1) {
	
	$sql = sql("UPDATE viscms_articles_comments SET author='".sqlfilter($_POST['author'],4)."', content='".sqlfilter($_POST['content'],7)."', active='".$_POST['active']."' WHERE id=".$p);
	
if($sql==true)  {
  $msg = '<div class="message">'.$lang['articles_comments_edited'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['articles_comments_not_edited'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=articles&act=comments,".$id);
} else {

$sql = sql("SELECT A.id,A.title FROM viscms_articles A, viscms_articles_comments B WHERE B.article_id=A.id AND B.id='".$p."'");
if(list($Aid,$Atitle)=dbrow($sql)) {
  $level->AddLevel(limitWords($Atitle,3),'?module=articles&act=edit,'.$Aid);
}
	
$header = $lang['articles_comments_edit'];

$s[$active]=' selected="selected"';
	
$level->AddLevel($header);
$level->ShowHead();

echo '<br/>';

// status
$status_fields = array();
array_push($status_fields,array($lang['articles_active'],1));
array_push($status_fields,array($lang['articles_deactive'],0));

  $default=0;
  
  if($active=='') $active=$default;

$form = new Form($action,'post');
$form->SetWidths('20%','80%');
$form->FCK();
$form->AddFCK($lang['articles_comments_content'],'content',$content,'Basic',100);
$form->AddTextInput($lang['articles_author'],'author',$author);// status
$form->AddSelect($lang['articles_status'],'active',$status_fields,$active,'style="width: 100%"');
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();

echo '<p align="center"><a href="?module=articles"><b>'.$lang['articles_back'].'</b></a></p>';
}

}

function comments_delete($p) {
global $cfg,$lang;

	$sql2 = sql("SELECT article_id FROM viscms_articles_comments WHERE id=".$p);
	list($id) = dbrow($sql2);
	$sql = sql("DELETE FROM viscms_articles_comments WHERE id=".$p);
	
if($sql==true)  {
  $msg = '<div class="message">'.$lang['articles_comments_deleted'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['articles_comments_not_deleted'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=articles&act=comments,".$id);
}

function up($p,$c) {
	global $cfg;
	
	$i=0;
	
	$sql = sql("SELECT position FROM viscms_articles WHERE id=".$p."");
	list($pos) = dbrow($sql);
	
	if($c!=0) {
		$clause = " AND category_id=".$c;
	}
	
	$sql2 = sql("SELECT position FROM viscms_articles WHERE position>".$pos.$clause." ORDER BY position ASC LIMIT 1");
	list($new_pos) = dbrow($sql2);
	
	$sql3 = sql("SELECT id,position FROM viscms_articles WHERE position>".$pos." AND position<=".$new_pos."");
	while(list($idx,$posx) = dbrow($sql3)) {
		$ident[$i] = $idx;
		$position[$i] = $posx-1;
		$i++;
	}
	
	for($i=0;$i<sizeof($ident);$i++) {
		$sql4 = sql("UPDATE viscms_articles SET position = ".$position[$i]." WHERE id=".$ident[$i]."");
	}
	
	$sql5 = sql("UPDATE viscms_articles SET position = ".$new_pos." WHERE id=".$p."");
	
	header("Location: ?module=articles&act=show,".$c);
	
}

function down($p,$c) {
	global $cfg;
	
	$i=0;
	
	$sql = sql("SELECT position FROM viscms_articles WHERE id=".$p."");
	list($pos) = dbrow($sql);
	
	if($c!=0) {
		$clause = " AND category_id=".$c;
	}
	
	$sql2 = sql("SELECT position FROM viscms_articles WHERE position<".$pos.$clause." ORDER BY position DESC LIMIT 1");
	list($new_pos) = dbrow($sql2);
	
	$sql3 = sql("SELECT id,position FROM viscms_articles WHERE position<".$pos." AND position>=".$new_pos."");
	while(list($idx,$posx) = dbrow($sql3)) {
		$ident[$i] = $idx;
		$position[$i] = $posx+1;
		$i++;
	}
	
	for($i=0;$i<sizeof($ident);$i++) {
		$sql4 = sql("UPDATE viscms_articles SET position = ".$position[$i]." WHERE id=".$ident[$i]);
	}
	
	$sql5 = sql("UPDATE viscms_articles SET position = ".$new_pos." WHERE id=".$p);
	
	header("Location: ?module=articles&act=show,".$c);
	
}

function category_up($p,$c) {
	global $cfg;
	
	$i=0;
	
	$sql = sql("SELECT position FROM viscms_articles_categories WHERE ident=".$p."");
	list($pos) = dbrow($sql);
	
	if($c!=0) {
		$clause = " AND parent=".$c;
		$goto = "&act=category,".$c;
	} else $clause = " AND parent=0";
	
	$sql2 = sql("SELECT position FROM viscms_articles_categories WHERE position>".$pos.$clause." ORDER BY position ASC LIMIT 1");
	list($new_pos) = dbrow($sql2);
	
	$sql3 = sql("SELECT ident,position FROM viscms_articles_categories WHERE position>".$pos." AND position<=".$new_pos);
	while(list($idx,$posx) = dbrow($sql3)) {
		$ident[$i] = $idx;
		$position[$i] = $posx-1;
		$i++;
	}
	
	for($i=0;$i<sizeof($ident);$i++) {
		$sql4 = sql("UPDATE viscms_articles_categories SET position = ".$position[$i]." WHERE ident=".$ident[$i]."");
	}
	
	$sql5 = sql("UPDATE viscms_articles_categories SET position = ".$new_pos." WHERE ident=".$p);
	
	header("Location: ?module=articles".$goto);
	
}

function category_down($p,$c) {
	global $cfg;
	
	$i=0;
	
	$sql = sql("SELECT position FROM viscms_articles_categories WHERE ident=".$p);
	list($pos) = dbrow($sql);
	
	if($c!=0) {
		$clause = " AND parent=".$c;
		$goto = "&act=category,".$c;
	} else $clause = " AND parent=0";
	
	$sql2 = sql("SELECT position FROM viscms_articles_categories WHERE position<".$pos.$clause." ORDER BY position DESC LIMIT 1");
	list($new_pos) = dbrow($sql2);
	
	$sql3 = sql("SELECT ident,position FROM viscms_articles_categories WHERE position<".$pos." AND position>=".$new_pos);
	while(list($idx,$posx) = dbrow($sql3)) {
		$ident[$i] = $idx;
		$position[$i] = $posx+1;
		$i++;
	}
	
	for($i=0;$i<sizeof($ident);$i++) {
		$sql4 = sql("UPDATE viscms_articles_categories SET position = ".$position[$i]." WHERE ident=".$ident[$i]);
	}
	
	$sql5 = sql("UPDATE viscms_articles_categories SET position = ".$new_pos." WHERE ident=".$p);
	
	header("Location: ?module=articles".$goto);
	
}

function ftp($file) {
	global $cfg,$mid,$i,$_POST;

	$name = $_FILES[$file]['name'];
	$ext = explode ('.', $name); 
	$ext=strtolower($ext[sizeof($ext)-1]);
	$newname='attach_'.$mid.'_'.$i.time().'.'.$ext;
	$a=move_uploaded_file($_FILES[$file]['tmp_name'], $cfg['artpath'].$newname);
	if($a==true) {
		$sqlATT = sql("INSERT INTO viscms_articles_attachments (name,file,article_id) VALUES('".sqlfilter($_POST['name-attachment-'.$i],4)."','".$newname."',".$mid.")");
		if($sqlATT==true) return mysql_insert_id();
	}
}

function commentofday($p) {
global $cfg,$lang,$language;

if($p!=0) {
$sqlCmt=sql("SELECT article_id,active FROM viscms_articles_comments WHERE id=".$p);
list($id,$active)=dbrow($sqlCmt);

if($active==1) {
$sqlLang=sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
if(list($lang_id)=dbrow($sqlLang)) {
	$sqlCheck=sql("SELECT language_id FROM viscms_commentofday WHERE language_id='".$lang_id."'");
	if(mysql_num_rows($sqlCheck)==0) {
		$sql=sql("INSERT INTO viscms_commentofday (language_id,type,type_id) VALUES(".$lang_id.",'articles',".$p.")");
	} else {
		$sql=sql("UPDATE viscms_commentofday SET type='articles', type_id=".$p." WHERE language_id=".$lang_id);
	}
}
}

if($sql==true)  {
  $msg = '<div class="message">'.$lang['articles_commentofdays_ok'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['articles_commentofdays_error'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=articles&act=comments,".$id);
 } else {
 $sqlLang=sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
	if(list($lang_id)=dbrow($sqlLang))
		$sql=sql("DELETE FROM viscms_commentofday WHERE language_id=".$lang_id);
	
if($sql==true)  {
  $msg = '<div class="message">'.$lang['articles_commentofdays_d_ok'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['articles_commentofdays_d_error'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=articles");
}

}

?>