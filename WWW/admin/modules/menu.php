<?

###############################
#           visCMS            #
############-------############
#          VISMEDIA           #
#       www.vismedia.pl       #
#      biuro@vismedia.pl      #
###############################

## MODULE: MENU ##

include 'languages/'.$language.'/menu.php';

$level->AddLevel($lang['menu'],'?module=menu');

$vars = explode(',',$_GET['act']);
$var_1 = $vars[0];
$var_2 = $vars[1];
$var_3 = $vars[2];
$var_4 = $vars[3];

$cfg['menpath']='../'.$cfg['menpath'];

if(is_numeric($var_2) || $var_2=='' || $var_2=='all') {

######################################

if($var_2!='all') $var_2 = sqlfilter($var_2,6);

if(auth()!=3)
switch(@$var_1) {

   case '':
   browse(0);
   break;
   
   case 'select':
   browse($var_2);
   break;

   case 'add':
   if(auth()==2) add();
   break;

   case 'edit':
   if(auth()==2 && $var_2>0) edit($var_2);
   break;
   
   case 'delete':
   if(auth()==2 && $var_2>0) delete($var_2);
   break;
   
   case 'up':
   @up($var_2,$var_3,$var_4);
   break;
   
   case 'down':
   @down($var_2,$var_3,$var_4);
   break;

   case 'add_page':
   if(($var_2>0 && auth()==2) || $var_2>1) add_page($var_2,$var_3);
   break;
   
   case 'delete_page':
   if($var_2>0 && auth()==2) delete_page($var_2);
   break;

   }

######################################

}

function browse($p) {
global $cfg,$lang,$language,$level,$links;

$sqlLang = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lang_id)=dbrow($sqlLang);

echo '<script language="javascript">
function confirmSubmit(p) {
switch (p)
{
case 1: var agree=confirm("'.$lang['confirm_submit'].'\n\n'.$lang['menu_confirm_del1'].'"); break;
case 2: var agree=confirm("'.$lang['confirm_submit'].'\n\n'.$lang['menu_confirm_del2'].'"); break;
case 3: var agree=confirm("'.$lang['confirm_submit'].'"); break;
}
if (agree)
	return true ;
else
	return false ;
}
</script>

<form method="post" action="">
	
	<script type="text/javascript">
function select_lng(value)
{
if (value != 0) {
document.location.href = "?module=menu&lng=" + value;
}
}
</script>

<form method="post" action="">
	
	<script type="text/javascript">
function select_menu(value)
{
if (value != 0) {
document.location.href = "?module=menu&act=select," + value;
}
}
</script>';
	
if($p>0) $clause = "AND id=".$p;

$text = $lang['menu_info1'].': <b>&lt;?new MenuList(ID);?&gt;</b>, '.$lang['menu_info2'].' <b>&lt;?new MenuList(1);?&gt;</b>';

$sql = sql("SELECT ident,name FROM viscms_menu WHERE language_id='".$lang_id."'".$clause." ORDER BY name ASC");
if(mysql_num_rows($sql)>0) {

// tworzenie nowej tabeli
$table = new Table('TableClass','TableClassHd',7,3);

$table->QuoteBeforeTable($text);

// naglowki
if(intval($p)==0) {
 
  $table->NewCell($lang['menu_section'],550,'left','left','bottom','top');
  $table->NewCell($lang['action'],150,'center','center','bottom','top');

} else {
 
  $table->NewCell($lang['menu_site'],490,'left','left','bottom','top');
  $table->NewCell($lang['action'],150,'center','center','bottom','top');
  $table->NewCell($lang['order'],60,'center','center','bottom','top');
  
}



// wartosci
while (list($id,$name) = dbrow($sql)) {

if(intval($p)==0) {

$section = '<a href="?module=menu&amp;act=select,'.$id.'" class="LinksOnGrey">'.$name.'</a>';
 
// tworzenie pola select
$select = new Select($id);
$select->Add(strtolower($lang['manage']),'?module=menu&amp;act=select,'.$id);
$select->Add(strtolower($lang['edit']),'?module=menu&amp;act=edit,'.$id);
$select->Add(strtolower($lang['delete']),'?module=menu&amp;act=delete,'.$id,' onclick="return confirmSubmit(1);"');
$actions=$select->Ret();

// wylistowanie wartosci
$values = array($section,$actions);
$table->CellValue($values);

// poziom
$level->AddIcon("add2","?module=menu&amp;act=add",$lang['menu_add']);

// linki
$links->AddLink($lang['menu_add'],"?module=menu&amp;act=add_page,".$id);


} else {

$level->AddLevel(limitwords($name,3),'');
// poziom
$level->AddIcon("add","?module=menu&amp;act=add",$lang['menu_add_page']);

// linki
$links->AddLink($lang['menu_add_page'],"?module=menu&amp;act=add_page,".$id);

$sql2 = sql("SELECT position FROM viscms_menu_links WHERE menu_id='".$id."' AND parent=0 AND language_id=".$lang_id." ORDER BY position ASC LIMIT 1");
list($max) = dbrow($sql2);
$sql2 = sql("SELECT position FROM viscms_menu_links WHERE menu_id='".$id."' AND parent=0 AND language_id=".$lang_id." ORDER BY position DESC LIMIT 1");
list($min) = dbrow($sql2);


$sqlP = sql("SELECT id,name,position FROM viscms_menu_links WHERE menu_id='".$id."' AND parent=0 AND language_id=".$lang_id." ORDER BY position ASC");
while (list($Pid,$Pname,$position) = dbrow($sqlP)) {

// tworzenie pola select
$select = new Select($Pid);
$select->Add(strtolower($lang['menu_add_spage']),'?module=menu&amp;act=add_page,'.$id.','.$Pid);
$select->Add(strtolower($lang['delete']),'?module=menu&act=delete_page,'.$Pid,' onclick="return confirmSubmit(2);"');
$actions=$select->Ret();

// gora/dol
$arrows = new Arrows();
$arrows->Up($position,$max,'?module=menu&act=up,'.$Pid.','.$p);
$arrows->Down($position,$min,'?module=menu&act=down,'.$Pid.','.$p);
$UpAndDown = $arrows->Ret();

// wylistowanie wartosci
$values = array($Pname,$actions,$UpAndDown);
$table->CellValue($values);

$sql2 = sql("SELECT position FROM viscms_menu_links WHERE parent='".$Pid."' AND language_id=".$lang_id." ORDER BY position ASC LIMIT 1");
list($max2) = dbrow($sql2);
$sql2 = sql("SELECT position FROM viscms_menu_links WHERE parent='".$Pid."' AND language_id=".$lang_id." ORDER BY position DESC LIMIT 1");
list($min2) = dbrow($sql2);

$sqlPX = sql("SELECT id,name,position FROM viscms_menu_links WHERE parent='".$Pid."' AND language_id=".$lang_id." ORDER BY position ASC");
while (list($PXid,$PXname,$position) = dbrow($sqlPX)) {

// tworzenie pola select
$select2 = new Select($PXid);
$select2->Add(strtolower($lang['delete']),'?module=menu&act=delete_page,'.$PXid,' onclick="return confirmSubmit(3);"');
$actions2=$select2->Ret();

// gora/dol
$arrows = new Arrows();
$arrows->Up($position,$max2,'?module=menu&act=up,'.$PXid.','.$p.','.$Pid);
$arrows->Down($position,$min2,'?module=menu&act=down,'.$PXid.','.$p.','.$Pid);
$UpAndDown = $arrows->Ret();

$PXname = '<div style="padding-left: 30px;">'.$PXname.'</div>';

// wylistowanie wartosci
$values = array($PXname,$actions2,$UpAndDown);
$table->CellValue($values);


		}
		
	}


}

 }
	
$level->ShowHead();

$links->Show();
	
$table->Show();

$links->Show();
 
} else {
	echo '<div class="message">'.$lang['menu_not_found'].'</div>';
  echo '<div align="center"><a href="?module=menu&amp;act=add">'.$lang['menu_add'].'</a></div>';
  }
	echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
}

function add() {
global $cfg,$lang,$language,$_POST,$var_1,$var_2,$i;

if($_POST['step'] == '1') {
	
$k=0;

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	$_POST['name_lang-'.$lid] = $_POST['name_lang-'.$lid];
	$sql = sql("INSERT INTO viscms_menu (name,language_id,picture_limit) VALUES ('".sqlfilter($_POST['name_lang-'.$lid],4)."','".$lid."','".sqlfilter($_POST['picture_limit'],6)."')");
	$k++;
	if($k==1) $ident=mysql_insert_id();
	echo $ident;
	$last=mysql_insert_id();
	$sql = sql("UPDATE viscms_menu SET ident=".$ident." WHERE id=".$last);
}

if($sql==true) {
  $msg = '<div class="message">'.$lang['menu_added'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['menu_not_added'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=menu");
}

else {

@form1($p);

  }

}

function edit($p) {
global $cfg,$var_1,$name,$description,$idc,$lang_id,$lang,$_POST,$i,$picture_limit;

if($_POST['step'] == '1') {

$t=1;

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	$_POST['name_lang-'.$lid] = $_POST['name_lang-'.$lid];
	if($t==1) {
	$sql = sql("UPDATE viscms_menu SET name = '".sqlfilter($_POST['name_lang-'.$lid],4)."', picture_limit = '".sqlfilter($_POST['picture_limit'],6)."' WHERE language_id=".$lid." AND ident=".$p);
	if($sql==true) $t=1; else $t=0;
	} else break;
}
	
if($t==1) {
  $msg = '<div class="message">'.$lang['menu_edited'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['menu_not_edited'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=menu");
}

else {
	
	$i=0;

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	
	$sql = sql('SELECT name FROM viscms_menu WHERE ident='.$p.' AND language_id='.$lid);
	while(list($c,$pl) = dbrow($sql)) {
		$name[$lid] = $c;
		if($pl>0 && $i==0) {
			$picture_limit=$pl;
			$i++;
		}
	}
  }
		
   form1($p);
   
}
}

function form1($p) {
global $cfg,$lang,$language,$var_1,$var_2,$name,$lang_id,$picture_limit,$level;

if($var_1=='edit') {
	$action = '?module=menu&amp;act=edit,'.$p;
	$header = $lang['menu_edit'];
} elseif($var_1=='add') {
		$header = $lang['menu_add'];
		$action = '?module=menu&amp;act=add';
}

$level->AddLevel($header);
$level->ShowHead();

echo '<br/>';

$form = new Form($action,'post');
$form->SetWidths('20%','80%');
$form->MultiLanguage(1);
$form->AddTextInput($lang['menu_name'],'name',$name);
$form->MultiLanguage(0);
$form->AddTextInput($lang['menu_picture_limit'],'picture_limit',$picture_limit,'style="width: 100%;"',$lang['menu_picture_limit_info']);
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();

echo '<p align="center"><a href="?module=menu"><b>'.$lang['menu_back'].'</b></a></p>';
}

function delete($p) {
	global $cfg,$lang;

	$sql = sql("SELECT ident FROM viscms_menu_links WHERE menu_id=".$p);
	while(list($ident) = dbrow($sql)) {
		$sqlx1 = sql("DELETE FROM viscms_menu_links WHERE parent=".$ident);
		$sqlx2 = sql("DELETE FROM viscms_menu_links WHERE ident=".$ident);
	}

	$sqlx3 = sql("DELETE FROM viscms_menu WHERE ident=".$p);

	if($sqlx3==true) $msg = '<div class="message">'.$lang['menu_deleted'].'</div>';
	else $msg = '<div class="message">'.$lang['menu_not_deleted'].'</div>';
	setcookie('msg',$msg,time()+60);
  	header("Location: ?module=menu");
	
}

function down($p,$c) {
	global $cfg,$lang;
	
	$sql = sql("SELECT menu_id,picture,language_id FROM viscms_menu_links WHERE ident=".$p);
	while(list($mid,$picture,$lid)=dbrow($sql)) {
		if(auth()==2) {
			
			if($picture!='') {
				$xml_type=2;
			} else $xml_type=1;
	
	$i=0;

	if($c<1) $c=0;
	else $hc = '&act=select,'.$c;
	
	$sql = sql("SELECT position FROM viscms_menu_links WHERE ident=".$p." AND language_id='".$lid."'");
	list($pos) = dbrow($sql);
	
		if($pp>0) $clause = " AND parent=".$pp;
	
	$sql2 = sql("SELECT position FROM viscms_menu_links WHERE position>".$pos.$clause." AND menu_id=".$mid." AND language_id='".$lid."' ORDER BY position ASC LIMIT 1");
	list($new_pos) = dbrow($sql2);
	
	$sql3 = sql("SELECT ident,position FROM viscms_menu_links WHERE position>".$pos." AND position<=".$new_pos." AND language_id='".$lid."'");
	while(list($idx,$posx) = dbrow($sql3)) {
		$ident[$i] = $idx;
		$position[$i] = $posx-1;
		$i++;
	}
	
	for($i=0;$i<sizeof($ident);$i++) {
		$sql4 = sql("UPDATE viscms_menu_links SET position = ".$position[$i]." WHERE ident=".$ident[$i]." AND language_id='".$lid."'");
	}
	
	$sql5 = sql("UPDATE viscms_menu_links SET position = ".$new_pos." WHERE ident=".$p." AND language_id='".$lid."'");
	
	$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
		while(list($lid,$lc) = dbrow($sqlLang)) {
			xml_generate($mid,$xml_type,$lid);
	}
	
	header("Location: ?module=menu".$hc);
		}
	}
	
}

function up($p,$c,$pp=0) {
	global $cfg,$lang;
	
	$sql = sql("SELECT menu_id,picture,language_id FROM viscms_menu_links WHERE ident=".$p);
	while(list($mid,$picture,$lid)=dbrow($sql)) {
		if(auth()==2) {
			
			if($picture!='') {
				$xml_type=2;
			} else $xml_type=1;
	
	$i=0;

	if($c<1) $c=0;
	else $hc = '&act=select,'.$c;
	
	$sql = sql("SELECT position FROM viscms_menu_links WHERE ident=".$p." AND language_id='".$lid."'");
	list($pos) = dbrow($sql);
	
		if($pp>0) $clause = " AND parent=".$pp;
	
	$sql2 = sql("SELECT position FROM viscms_menu_links WHERE position<".$pos.$clause." AND menu_id=".$mid." AND language_id='".$lid."' ORDER BY position DESC LIMIT 1");
	list($new_pos) = dbrow($sql2);
	
	$sql3 = sql("SELECT ident,position FROM viscms_menu_links WHERE position<".$pos." AND position>=".$new_pos." AND language_id='".$lid."'");
	while(list($idx,$posx) = dbrow($sql3)) {
		$ident[$i] = $idx;
		$position[$i] = $posx+1;
		$i++;
	}
	
	for($i=0;$i<sizeof($ident);$i++) {
		$sql4 = sql("UPDATE viscms_menu_links SET position = ".$position[$i]." WHERE ident=".$ident[$i]." AND language_id='".$lid."'");
	}
	
	$sql5 = sql("UPDATE viscms_menu_links SET position = ".$new_pos." WHERE ident=".$p." AND language_id='".$lid."'");
	
	$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
		while(list($lid,$lc) = dbrow($sqlLang)) {
			xml_generate($mid,$xml_type,$lid);
	}
	
	header("Location: ?module=menu".$hc);
		}
	}
	
}

function add_page($p,$v) {
global $cfg,$lang,$language,$_POST,$var_1,$var_2,$i;

if($_POST['step'] == '1') {
	
if($v=='') $v=0;
$k=0;

$sqlMenuPct = sql("SELECT picture_limit FROM viscms_menu WHERE id='".$p."'");
list($picture_limit)=dbrow($sqlMenuPct);

$sqlIDENT = sql("SELECT position FROM viscms_menu_links ORDER BY position DESC");
list($position)=dbrow($sqlIDENT);

$position++;
$picture='';
$xml_type=1;

if($picture_limit>0 && $_FILES['picture']['name']!='') {
	$picture = add_file('picture',$picture_limit);
	if($picture!='') $xml_type = 2;
}

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	if($_POST['name_lang-'.$lid]!='')
		$name = $_POST['name_lang-'.$lid];
	else {
		switch($_POST['module']) {
			case 'gallery':
				if($_POST[$_POST['module'].'-type_id']!=0) {
					$sqlN = sql("SELECT category FROM viscms_gallery_descriptions WHERE gallery_id=".$_POST[$_POST['module'].'-type_id']." AND language_id=".$lid);
					list($name)=dbrow($sqlN);
				} else $name=$lang['menu_'.$_POST['module']];
				break;				
			case 'static':
				if($_POST[$_POST['module'].'-type_id']!=0) {
					$sqlN = sql("SELECT title FROM viscms_static WHERE ident=".$_POST[$_POST['module'].'-type_id']." AND language_id=".$lid);
					list($name)=dbrow($sqlN);
				} else $name=$lang['menu_'.$_POST['module']];
				break;
			case 'index':
				$name=$lang['menu_'.$_POST['module']];
				break;
			case 'pets':
				$name=$lang['menu_'.$_POST['module']];
				break;
			case 'contact':
				$name=$lang['menu_'.$_POST['module']];
				break;
			case 'sitemap':
				$name=$lang['menu_'.$_POST['module']];
				break;
			case 'catalog':
				if($_POST[$_POST['module'].'-type_id']!=0) {
					$sqlN = sql("SELECT name FROM viscms_catalog WHERE ident=".$_POST[$_POST['module'].'-type_id']." AND language_id=".$lid);
					list($name)=dbrow($sqlN);
				} else $name=$lang['menu_'.$_POST['module']];
				break;
			case 'guestbook':
				$name=$lang['menu_'.$_POST['module']];
				break;
			case 'articles':
				if($_POST[$_POST['module'].'-type_id']!=0) {
					$sqlN = sql("SELECT name FROM viscms_articles_categories WHERE ident=".$_POST[$_POST['module'].'-type_id']." AND language_id=".$lid);
					list($name)=dbrow($sqlN);
				} else $name=$lang['menu_'.$_POST['module']];
				break;
			case 'forum':
				if($_POST[$_POST['module'].'-type_id']!=0) {
					$sqlN = sql("SELECT name FROM viscms_forum WHERE id=".$_POST[$_POST['module'].'-type_id']);
					list($name)=dbrow($sqlN);
				} else $name=$lang['menu_'.$_POST['module']];
				break;
		}
	}
	$sql = sql("INSERT INTO viscms_menu_links (name,type,type_id,parent,position,menu_id,language_id,picture,external) VALUES ('".sqlfilter($name,4)."','".$_POST['module']."','".$_POST[$_POST['module'].'-type_id']."','".$v."','".$position."','".$p."','".$lid."','".$picture."','".sqlfilter($_POST['external'],4)."')");
	$k++;
	if($k==1) $ident=mysql_insert_id();
	$last=mysql_insert_id();
	$sql = sql("UPDATE viscms_menu_links SET ident=".$ident." WHERE id=".$last);
	if($sql==true) xml_generate($p,$xml_type,$lid);
}

if($sql==true) {
  $msg = '<div class="message">'.$lang['menu_page_added'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['menu_page_not_added'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=menu&act=select,".$p);
}

else {

@form2($p,$v);

  }

}

function form2($p,$v) {
global $cfg,$lang,$language,$var_1,$var_2,$name,$lang_id,$modules,$level,$external;

if($var_1=='edit_page') {
	$action = '?module=menu&amp;act=edit_page,'.$p.','.$v;
	$header = $lang['menu_edit_page'];
} elseif($var_1=='add_page') {
		$header = $lang['menu_add_page'];
		$action = '?module=menu&amp;act=add_page,'.$p.','.$v;
}

$sql = sql("DESCRIBE viscms_menu_links 'type'");
$q = dbarray($sql);

$in = array("enum(",")","'");

$est = str_replace($in,"",$q[1]);
$modules = explode(",",$est);

$sqlLang = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($lang_id)=dbrow($sqlLang);

$level->AddLevel($header);
$level->ShowHead();

echo '<br/>

<script language="JavaScript">
function hide_return(p)
{
';

for($i=0;$i<sizeof($modules);$i++) {
	echo 'if(document.form.module.value == \''.$modules[$i].'\') {
';
	for($k=0;$k<sizeof($modules);$k++) {
		if($i==$k) echo '	document.getElementById(\''.$modules[$k].'\').style.display = \'block\';
';
		else echo '	document.getElementById(\''.$modules[$k].'\').style.display = \'none\';
';
	}
	echo "}\n";
}
echo '
}

</script>';


// modu³: start
$text = '<select name="module" onchange="hide_return(this.value)">
';

for($i=0;$i<sizeof($modules);$i++) {
	$text .= '			<option value="'.$modules[$i].'">'.$lang['menu_'.$modules[$i]].'</option>
';
}
		
$text .= '		</select>';

$text .= '<span id="static" style="display: block;">
';

$sql = sql("SELECT ident,title FROM viscms_static WHERE language_id=".$lang_id." ORDER BY title ASC");
if(mysql_num_rows($sql)!=0) {
	$text .= '<span style="font-size: 1px;">&nbsp;</span><br />'.$lang['menu_static_page'].': <select name="static-type_id" style="width: 300px;">
';
	while(list($id,$name)=dbrow($sql)) {
		$text .= '	<option value="'.$id.'">'.$name.'</option>
';
	}
	$text .= '</select>
';
}

$text .= '</span>

<span id="articles" style="display: none;">
';

$sql = sql("SELECT ident,name FROM viscms_articles_categories WHERE parent=0 AND language_id=".$lang_id." ORDER BY name ASC");
if(mysql_num_rows($sql)!=0) {
	$text .= '<span style="font-size: 1px;">&nbsp;</span><br />'.$lang['menu_articles_category'].': <select name="articles-type_id" style="width: 300px;">
	<option value="0">'.strtoupper($lang['menu_articles_category_na']).'</option>
';
	while(list($id,$name)=dbrow($sql)) {
		$text .= '	<option value="'.$id.'">'.$name.'</option>
';
		$sqlS = sql("SELECT ident,name FROM viscms_articles_categories WHERE parent=".$id." AND language_id=".$lang_id." ORDER BY name ASC");
		while(list($Sid,$Sname)=dbrow($sqlS)) {
			$text .= '	<option value="'.$Sid.'">-- '.$Sname.'</option>
';
		}
	}
	$text .= '</select>
';
}

$text .= '</span>

<span id="gallery" style="display: none;">
';

$sql = sql("SELECT A.id,B.category FROM viscms_gallery A, viscms_gallery_descriptions B WHERE A.id=B.gallery_id AND B.language_id=".$lang_id." ORDER BY A.position DESC");
if(mysql_num_rows($sql)!=0) {
	$text .= '<span style="font-size: 1px;">&nbsp;</span><br />'.$lang['menu_gallery_category'].': <select name="gallery-type_id" style="width: 300px;">
	<option value="0">'.strtoupper($lang['menu_gallery_category_na']).'</option>
';
	while(list($id,$name)=dbrow($sql)) {
		$text .= '	<option value="'.$id.'">'.$name.'</option>
';
	}
	$text .= '</select>
';
}

$text .= '</span>

<span id="forum" style="display: none;">
';

$sql = sql("SELECT id,name FROM viscms_forum WHERE parent=0 ORDER BY position DESC");
if(mysql_num_rows($sql)!=0) {
	$text .= '<span style="font-size: 1px;">&nbsp;</span><br />'.$lang['menu_forum_category'].': <select name="forum-type_id" style="width: 300px;">
	<option value="0">'.strtoupper($lang['menu_forum_category_na']).'</option>
';
	while(list($id,$name)=dbrow($sql)) {
		$text .= '	<option value="'.$id.'">'.$name.'</option>
';
		$sqlS = sql("SELECT id,name FROM viscms_forum WHERE parent=".$id." ORDER BY position DESC");
		while(list($Sid,$Sname)=dbrow($sqlS)) {
			$text .= '	<option value="'.$Sid.'">-- '.$Sname.'</option>
';
		}
	}
	$text .= '</select>
';
}

$text .= '</span>

<span id="catalog" style="display: none;">
';

$sql = sql("SELECT ident,name FROM viscms_catalog WHERE parent=0 AND language_id=".$lang_id." ORDER BY name ASC");
if(mysql_num_rows($sql)!=0) {
	$text .= '<span style="font-size: 1px;">&nbsp;</span><br />'.$lang['menu_catalog_category'].': <select name="catalog-type_id" style="width: 300px;">
	<option value="0">'.strtoupper($lang['menu_catalog_category_na']).'</option>
';
	while(list($id,$name)=dbrow($sql)) {
		$text .= '	<option value="'.$id.'">'.$name.'</option>
';
		$sqlS = sql("SELECT ident,name FROM viscms_catalog WHERE parent=".$id." AND language_id=".$lang_id." ORDER BY name ASC");
		while(list($Sid,$Sname)=dbrow($sqlS)) {
			$text .= '	<option value="'.$Sid.'">-- '.$Sname.'</option>
';
		}
	}
	$text .= '</select>
';
}

$text .= '</span>

<span id="guestbook" style="display: none;"></span>
<span id="sitemap" style="display: none;"></span>
<span id="contact" style="display: none;"></span>
<span id="index" style="display: none;"></span>';

// modu³: end

$form = new Form($action,'post');
$form->SetWidths('20%','80%');
$form->MultiLanguage(1);
$form->AddTextInput($lang['menu_name_page'],'name',$name,'style="width: 100%;"',$lang['menu_title_info']);
$form->MultiLanguage(0);
$form->AddAnyField($lang['menu_module'],$text);
$form->AddFileInput($lang['menu_picture'],'picture',92,null,false,'<br />'.$lang['menu_picture_info']);
$form->AddTextInput($lang['menu_external'],'external',$external,'style="width: 100%;"',$lang['menu_external_info']);
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();



echo '<p align="center"><a href="?module=menu"><b>'.$lang['menu_back'].'</b></a></p>';
}

function delete_page($p) {
	global $cfg,$lang;

	$sql = sql("SELECT menu_id,picture FROM viscms_menu_links WHERE ident=".$p);
	if(list($mid,$picture)=dbrow($sql)) {
		if(auth()==2) {
			if($picture!='') {
				@unlink($cfg['menpath'].$picture);
				$xml_type=2;
			} else $xml_type=1;
			$sqlx1 = sql("DELETE FROM viscms_menu_links WHERE parent=".$p);
			$sqlx2 = sql("DELETE FROM viscms_menu_links WHERE ident=".$p);
	if($sqlx1==true && $sqlx1==true) {
		$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
		while(list($lid,$lc) = dbrow($sqlLang)) {
			xml_generate($mid,$xml_type,$lid);
		}
		$msg = '<div class="message">'.$lang['menu_page_deleted'].'</div>';
	}
	else $msg = '<div class="message">'.$lang['menu_page_not_deleted'].'</div>';
	setcookie('msg',$msg,time()+60);
  	header("Location: ?module=menu&act=select,".$mid);
  	
		}
	} else {
	if($sqlx1==true && $sqlx1==true) $msg = '<div class="message">'.$lang['menu_page_deleted'].'</div>';
	else $msg = '<div class="message">'.$lang['menu_page_not_deleted'].'</div>';
	setcookie('msg',$msg,time()+60);
  	header("Location: ?module=menu");
	}
  
	
}

function add_file($file,$limit) {
global $cfg,$lang,$language,$mid,$_POST,$i;

$typ=getImageSize($_FILES[$file]['tmp_name']);

$namemd5 = md5(time().$file);

if ($typ[2]>=1 && $typ[2]<=3) {
$name = $_FILES[$file]['name']; 
$ext = explode ('.', $name); 
$ext=strtolower($ext[1]); 
$newname=$namemd5 . '.' . $ext; 
if (move_uploaded_file($_FILES[$file]['tmp_name'], $cfg['menpath'].$newname)) {
$wynik=true; 
} else { 
$wynik=false; 
}
if ($wynik) { 
$size = getimagesize($cfg['menpath'].$newname); 
$w = $size[0]; 
$h = $size[1]; 

if($w > $limit || $h > $limit)
	{
	if($w>$h) {
		$w2 = $limit;
		$ratio = $w2/$w;
		$h2 = $h*$ratio;
		}
	else {
		$h2 = $limit;
		$ratio = $h2/$h;
		$w2 = $w*$ratio;
		}
	} else { $w2 = $w; $h2 = $h; }

$w2 = floor($w2);
$h2 = floor($h2);

if($typ[2]==1) {
	$im=imageCreateTransparent($w2,$h2);
	$imf = @ImageCreateFromGIF ($cfg['menpath'].$newname);
} elseif($typ[2]==2) {
	$im=imageCreateTransparent($w2,$h2,true);
	$imf = @ImageCreateFromJPEG ($cfg['menpath'].$newname);
} else {
	$im=imageCreateTransparent($w2,$h2,true);
	$imf = @ImageCreateFromPNG ($cfg['menpath'].$newname);
}
$x= imagesx ($imf);
$y= imagesy ($imf);
imagecopyresampled ($im, $imf, 0, 0, 0, 0, $w2, $h2, $x, $y);

	if($typ[2]==1) $a=imagegif($im,$cfg['menpath'].$newname,100);
	elseif($typ[2]==2) $a=imagejpeg($im,$cfg['menpath'].$newname,100);
	else $a=imagepng($im,$cfg['menpath'].$newname,100);

if($a==true) return $newname;
else return false;

} else return false;

} else return false;


}

function xml_generate($id,$xml_type=1,$lang_id) {
	global $cfg;
	
	$sqlLang = sql("SELECT code FROM viscms_languages WHERE id='".$lang_id."'");
	list($language)=dbrow($sqlLang);
	
	$text = '<?xml version="1.0" encoding="utf-8"?>';
	$text .= "\n";
		
		if($xml_type==1) $text .= "<menu>\n";
		elseif($xml_type==2) $text .= "<thumbnails>\n";
		
		$sql = sql("SELECT ident,name,type,type_id,picture,external FROM viscms_menu_links WHERE menu_id='".$id."' AND parent=0 AND language_id='".$lang_id."' ORDER BY position ASC");
		while(list($ident,$name,$type,$type_id,$picture,$external)=dbrow($sql)) {
			$goto=$type;
			if($type_id!=0) {
				$goto.='-';
				switch($type) {
					case 'static':
						$goto='s';
						break;
					case 'gallery':
						$goto='g';
						break;
					case 'catalog':
						$goto.='show';
						break;
					case 'articles':
						$goto.='show';
						break;
				}
				if($goto==$type.'-') $goto.='link';
				if($type=='static') $goto.=$type_id.'_'.mod_rewrite($name).'.html';
				elseif($type=='gallery') $goto.=$type_id.'_'.mod_rewrite($name).'.html';
				else $goto.='-'.$type_id.'.php';
			} else $goto.='.php';
			
			if($external!='') $goto=$external;
			
			$name = iconv("iso8859-2","utf-8",$name);
			
			if($xml_type==1) {
				$text .= '	<item item_label="'.$name.'" item_url="'.$goto.'" item_url_target="_self" />';
			}
			elseif($xml_type==2) {
				if($picture!='')
					$text .= '	<thumbnail filename="'.$picture.'" label="'.$name.'" url="'.$goto.'" />';
			}
			$text .= "\n";
			
		}
		
		if($xml_type==1) $text .= "</menu>";
		elseif($xml_type==2) $text .= "</thumbnails>";
		
		$fp = fopen("../xml/menu_".$id."_".$language.'.xml',"w+");
		fputs($fp,$text);
		fclose($fp);
}

?>