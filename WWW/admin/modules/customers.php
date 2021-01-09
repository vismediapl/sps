<?

###############################
#           visCMS            #
############-------############
#          VISMEDIA           #
#       www.vismedia.pl       #
#      biuro@vismedia.pl      #
###############################

## MODULE: customers ##

include 'languages/'.$language.'/customers.php';

$level->AddLevel($lang['customers'],'?module=customers');

$vars = explode(',',$_GET['act']);
$var_1 = $vars[0];
$var_2 = $vars[1];
$var_3 = $vars[2];

$cfg['cuspath']='../'.$cfg['cuspath'];

if(is_numeric($var_2) || $var_2=='') {

###################################### 

if(auth()!=3)
switch(@$var_1) {

   case '':
   browse();
   break;

   case 'add':
   add();
   break;

   case 'edit':
   edit($var_2);
   break;
   
   case 'delete':
   delete($var_2);
   break;
   
   case 'down':
   @down($var_2);
   break;
   
   case 'up':
   @up($var_2);
   break;

   case 'active':
   if($var_2!='')
     active($var_2);
   break;

   case 'deactive':
   if($var_2!='')
     deactive($var_2);
   break;

   }

######################################

}

function browse() {
global $cfg,$lang,$language,$level,$links;

// poziom
$level->AddIcon("add","?module=customers&amp;act=add",$lang['customers_add']);
$level->ShowHead();

// linki
$links->AddLink($lang['customers_add'],"?module=customers&amp;act=add");

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

$sqlmnr = sql("SELECT id FROM viscms_customers");
if(mysql_num_rows($sqlmnr)>0) {

$table = new Table('TableClass','TableClassHd',7,3);
$table->NewCell($lang['customers_name'],300,'left','left','bottom','top');
$table->NewCell($lang['show'],45,'center','center','bottom','top');
$table->NewCell($lang['customers_type'],110,'center','center','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');
$table->NewCell($lang['order'],60,'center','center','bottom','top');


$sql2 = sql("SELECT position FROM viscms_customers ORDER BY position DESC LIMIT 1");
list($max) = dbrow($sql2);
$sql2 = sql("SELECT position FROM viscms_customers ORDER BY position ASC LIMIT 1");
list($min) = dbrow($sql2);

$sql = sql('SELECT A.id, B.name, A.position, A.category, A.active FROM viscms_customers A, viscms_customers_descriptions B WHERE A.id=B.customer_id AND B.language_id="'.$lang_id.'" ORDER BY A.position DESC');
while (list($id,$name,$position,$type,$active) = dbrow($sql)) {
	
// tworzenie pola select
$select = new Select($id);
$select->Add(strtolower($lang['edit']),'?module=customers&amp;act=edit,'.$id);
$select->Add(strtolower($lang['delete']),'?module=customers&amp;act=delete,'.$id,' onclick="return confirmSubmit();"');
$actions=$select->Ret();

$arrows = new Arrows();
$arrows->Up($position,$max,'?module=customers&amp;act=up,'.$id);
$arrows->Down($position,$min,'?module=customers&amp;act=down,'.$id);
$UpAndDown = $arrows->Ret();

// tworzenie pola pokaz
if($active==1) $show = $table->ShowCheck($active,'?module=customers&amp;act=deactive,'.$id);
else $show = $table->ShowCheck($active,'?module=customers&amp;act=active,'.$id);

// wylistowanie wartosci
$values = array($name,$show,$lang['customers_'.$type],$actions,$UpAndDown);
$table->CellValue($values);

 }

$table->Show(); // pokaz tabele
    
$links->Show(); // pokaz linki

} else {
	echo '<div class="message">'.$lang['customers_not_found'].'</div>';
	echo '<div align="center"><a href="?module=customers&amp;act=add">'.$lang['customers_add'].'</a></div>';
	echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
  }
}

function add() {
global $cfg,$lang,$language,$_POST,$var_1,$var_2,$i,$idc,$lc,$lid,$message;

if($_POST['step'] == '1') {
	
$k=0;
$t=1;

$sql2 = sql("SELECT position FROM viscms_customers ORDER BY position DESC LIMIT 1");
list($max) = dbrow($sql2);
$max++;

$_POST['www']=str_replace('http://http://','http://',$_POST['www']);

$sql = sql("INSERT INTO viscms_customers (link,position,category) VALUES ('".sqlfilter($_POST['www'])."',".$max.",'".$_POST['type']."')");
if($sql==true) $k++;
$mid = mysql_insert_id();

$idc = $mid;

if($_FILES['picture']['name']!='') {
	if(add_file('picture',$cfg['cuslimit_w'],$cfg['cuslimit_h'])) $k++;
} else $k++;

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	$_POST['name_lang-'.$lid] = sqlfilter($_POST['name_lang-'.$lid]);
	$_POST['address_lang-'.$lid] = sqlfilter($_POST['address_lang-'.$lid]);
	$_POST['address_lang-'.$lid] = str_replace("\n","<br />",$_POST['address_lang-'.$lid]);
	$sql = sql("INSERT INTO viscms_customers_descriptions (name,address,language_id,customer_id) VALUES ('".$_POST['name_lang-'.$lid]."','".$_POST['address_lang-'.$lid]."','".$lid."','".$mid."')");
	if($sql==true) $t=1; else { $t=0; break; }
	if($_FILES['file_lang-'.$lid]['name']!='') { if(ftp('file_lang-'.$lid)) $t=1; else { $t=0; break; }}
}
if($t==1) $k++;
	
if($k==3) {
  $msg = '<div class="message">'.$lang['customers_added'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['customers_not_added'].'</div>'.$message;
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=customers");
}

else {

@form();

  }

}

function edit($p) {
global $cfg,$var_1,$name,$address,$www,$type,$logo,$file,$idc,$lang,$_POST,$i,$lc,$lid,$message;

if($_POST['step'] == '1') {
	
$_POST['www']=str_replace('http://http://','http://',$_POST['www']);

$sql = sql("UPDATE viscms_customers SET link='".sqlfilter($_POST['www'])."', category='".$_POST['type']."' WHERE id=".$p);
if($sql==true) $k++;

$idc = $p;

if($_POST['picture_delete']==1) {
	$sql = sql("SELECT logo FROM viscms_customers WHERE id=".$p);
	if(list($pict) = dbrow($sql)) {
	$sqld = sql("UPDATE viscms_customers SET logo='' WHERE id=".$p);
	if($sqld==true) if(@unlink($cfg['cuspath'].$pict)) $k++;
	}
} else $k++;

if($_FILES['picture']['name']!='') {
	if(add_file('picture',$cfg['cuslimit_w'],$cfg['cuslimit_h'])) $k++;
} else $k++;

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	$_POST['name_lang-'.$lid] = sqlfilter($_POST['name_lang-'.$lid]);
	$_POST['address_lang-'.$lid] = sqlfilter($_POST['address_lang-'.$lid]);
	$_POST['address_lang-'.$lid] = str_replace("\n","<br />",$_POST['address_lang-'.$lid]);
	$sql = sql("UPDATE viscms_customers_descriptions SET name = '".$_POST['name_lang-'.$lid]."', address = '".$_POST['address_lang-'.$lid]."' WHERE language_id=".$lid." AND customer_id=".$p);
	if($sql==true) $t=1; else { $t=0; break; }
	if($_FILES['file_lang-'.$lid]['name']!='') { if(ftp('file_lang-'.$lid)) $t=1; else { $t=0; break; }}
	if($_POST['file_delete_'.$lid]==1) {
	$sql = sql("SELECT id,file FROM viscms_customers_descriptions WHERE language_id=".$lid." AND customer_id=".$p);
		if(list($fid,$filetd) = dbrow($sql)) {
		$sqld = sql("UPDATE viscms_customers_descriptions SET file='' WHERE id=".$fid);
		if($sqld==true) @unlink($cfg['cuspath'].$filetd);
		}
	}
}
if($t==1) $k++;

if($k==4) {
  $msg = '<div class="message">'.$lang['customers_edited'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['customers_not_edited'].'</div>'.$message;
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=customers");
}

else {

$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
while(list($lid,$lc) = dbrow($sqlLang)) {
	
	$sql = sql('SELECT name,address,file FROM viscms_customers_descriptions WHERE customer_id='.$p.' AND language_id='.$lid);
	while(list($c,$a,$f) = dbrow($sql)) {
		$name[$lid] = $c;
		$address[$lid] = str_replace("<br />","\n",$a);
		$file[$lid] = $cfg['cuspath'].$f;
	}
}
	$sql = sql('SELECT logo,link,category FROM viscms_customers WHERE id='.$p);
if(list($logo,$www,$type) = dbrow($sql))
   form($p);
   
  }
}

function form($p) {
global $cfg,$lang,$language,$var_1,$name,$address,$www,$type,$logo,$file,$path,$level;

$path = $cfg['cuspath'];

if($www=='') $www='http://';

if($var_1=='edit') {
	$action = '?module=customers&amp;act=edit,'.$p;
	$header = $lang['customers_edit'];
}
	
if($var_1=='add') {
	$action = '?module=customers&amp;act=add';
	$header = $lang['customers_add'];
}
	
$level->AddLevel($header,'');
	
$level->ShowHead();

echo '<br/>';

// typ
$type_fields = array();
$sqlType = sql("DESCRIBE viscms_customers 'category'");
$qp = dbarray($sqlType);
$in = array("enum(",")","'");
$tp = str_replace($in,"",$qp[1]);
$tp = explode(",",$tp);

		for($i=0;$i<sizeof($tp);$i++) {
			if($tp[$i]!='') {
				array_push($type_fields,array($lang['customers_'.$tp[$i]],$tp[$i]));
			}
		}
  
  $default='';
  
  if($type=='') $type=$default;

$form = new Form($action,'post');
$form->SetWidths('20%','80%');
$form->MultiLanguage(1);
$form->AddTextInput($lang['customers_name'],'name',$name);
$form->MultiLanguage(0);
$form->AddSelect($lang['customers_type'],'type',$type_fields,$type);
$form->AddTextInput($lang['customers_link'],'www',$www);
$form->AddFileInput($lang['customers_picture'],'picture',92,$form->FileInputDel('picture_delete',$cfg['cuspath'],$logo));
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();

echo '<p align="center"><a href="?module=customers"><b>'.$lang['customers_back'].'</b></a></p>';
}

function delete($p) {
	global $cfg,$lang;
	
	$k=0;
	$t=1;
	$sql = sql("SELECT id,logo FROM viscms_customers WHERE id=".$p);
	while(list($ido,$picture) = dbrow($sql)) {
		$sql2 = sql("DELETE FROM viscms_customers WHERE id=".$p."");
		if($sql2==true) {
			$sqlx = sql("SELECT file FROM viscms_customers_descriptions WHERE customer_id=".$p);
			list($file) = dbrow($sqlx);
			$sql3 = sql("DELETE FROM viscms_customers_descriptions WHERE customer_id=".$p."");
			@unlink($cfg['cuspath'].$picture);
			@unlink($cfg['cuspath'].$file);
	}
}
	
	if($sql==true || $sql3==true) $msg = '<div class="message">'.$lang['customers_deleted'].'</div>';
	else $msg = '<div class="message">'.$lang['customers_not_deleted'].'</div>';
	setcookie('msg',$msg,time()+60);
  	header("Location: ?module=customers");
	
}

function up($p) {
	global $cfg;
	
	$i=0;
	
	$sql = sql("SELECT id,position,category FROM viscms_customers WHERE id=".$p);
	list($id,$pos,$cat) = dbrow($sql);
	
	$sql2 = sql("SELECT position FROM viscms_customers WHERE category='".$cat."' AND position>".$pos." ORDER BY position ASC LIMIT 1");
	list($new_pos) = dbrow($sql2);
	
	$sql3 = sql("SELECT id,position FROM viscms_customers WHERE position>".$pos." AND position<=".$new_pos."");
	while(list($idx,$posx) = dbrow($sql3)) {
		$ident[$i] = $idx;
		$position[$i] = $posx-1;
		$i++;
	}
	
	for($i=0;$i<sizeof($ident);$i++) {
		$sql4 = sql("UPDATE viscms_customers SET position = ".$position[$i]." WHERE id=".$ident[$i]."");
	}
	
	$sql5 = sql("UPDATE viscms_customers SET position = ".$new_pos." WHERE id='".$id."'");
	
	header("Location: ?module=customers");
	
}

function down($p) {
	global $cfg;
	
	$i=0;
	
	$sql = sql("SELECT id,position,category FROM viscms_customers WHERE id=".$p);
	list($id,$pos,$cat) = dbrow($sql);
	
	$sql2 = sql("SELECT position FROM viscms_customers WHERE category='".$cat."' AND position<".$pos." ORDER BY position DESC LIMIT 1");
	list($new_pos) = dbrow($sql2);
	
	$sql3 = sql("SELECT id,position FROM viscms_customers WHERE position<".$pos." AND position>=".$new_pos."");
	while(list($idx,$posx) = dbrow($sql3)) {
		$ident[$i] = $idx;
		$position[$i] = $posx+1;
		$i++;
	}
	
	for($i=0;$i<sizeof($ident);$i++) {
		$sql4 = @sql("UPDATE viscms_customers SET position = ".$position[$i]." WHERE id=".$ident[$i]."");
	}
	
	$sql5 = sql("UPDATE viscms_customers SET position = ".$new_pos." WHERE id='".$id."'");
	
	header("Location: ?module=customers");
	
}

function ftp($file) {
global $cfg,$idc,$lc,$lid;

$name = $_FILES[$file]['name'];
$ext = explode ('.', $name);
$ext=strtolower($ext[sizeof($ext)-1]);
$newname='file_'.$idc.'_'.$lc.'.'.$ext;
if(move_uploaded_file($_FILES[$file]['tmp_name'], $cfg['cuspath'].$newname)) {
@chmod($cfg['cuspath'].$newname, 0644);
$sqlAF = sql("UPDATE viscms_customers_descriptions SET file = '".$newname."' WHERE language_id = ".$lid." AND customer_id = ".$idc);
	}
	if($sqlAF==true) return true;
	else return false;
}

function add_file($file,$limit_w,$limit_h) {
global $cfg,$lang,$language,$idc,$_POST,$i,$message;

$typ=getImageSize($_FILES[$file]['tmp_name']);

$namemd5 = 'cp_'.$idc.'_logo';

$name = $_FILES[$file]['name']; 
$ext = explode ('.', $name); 
$ext=strtolower($ext[sizeof($ext)-1]); 
$newname=$namemd5 . '.' . $ext; 

if ($typ[2]>0 && $typ[2]<=3) {

if (move_uploaded_file($_FILES[$file]['tmp_name'], $cfg['cuspath'].$newname)) {
$wynik=true; 
} else { 
$wynik=false; 
} 
if ($wynik) { 
$size = getimagesize($cfg['cuspath'].$newname); 
$w = $size[0]; 
$h = $size[1]; 

if($w > $limit_w || $h > $limit_h)
	{
	if($w>$h) {
		$w2 = $limit_w;
		$ratio = $w2/$w;
		$h2 = $h*$ratio;
		if($h2>$limit_h) {
				$h3 = $limit_h;
				$ratio = $h3/$h2;
				$w3 = $w2*$ratio;
				$h2 = $h3;
				$w2 = $w3;
		}
	}
	else {
		$h2 = $limit_h;
		$ratio = $h2/$h;
		$w2 = $w*$ratio;
		if($w2>$limit_w) {
				$w3 = $limit_w;
				$ratio = $w3/$w2;
				$h3 = $h2*$ratio;
				$h2 = $h3;
				$w2 = $w3;
		}
		}

$w2 = floor($w2);
$h2 = floor($h2);

$im= imagecreatetruecolor($w2, $h2);
if ($typ[2]==1) $imf = @ImageCreateFromGIF ($cfg['cuspath'].$newname);
elseif ($typ[2]==2) $imf = @ImageCreateFromJPEG ($cfg['cuspath'].$newname);
elseif ($typ[2]==3) $imf = @ImageCreateFromPNG ($cfg['cuspath'].$newname);
$x= imagesx ($imf); 
$y= imagesy ($imf); 
$x2= imagesx ($imf2); 
$y2= imagesy ($imf2);    
imagecopyresampled ($im, $imf, 0, 0, 0, 0, $w2, $h2, $x, $y);
$a=imagejpeg($im,$cfg['cuspath'].$newname,100);
	} else $a=true;
	
if($a==true) {
	$sqlAF = sql("UPDATE viscms_customers SET logo = '".$newname."' WHERE id = ".$idc);
    }
}

} elseif($typ[2]==4 || $ext=='swf') {

if(move_uploaded_file($_FILES[$file]['tmp_name'], $cfg['cuspath'].$newname)) {
	
$size = @getSWFDimensions($cfg['cuspath'].$newname); 
$w = $size[0];
$h = $size[1];

echo $w;

if($w>$cfg['cuslimit_w']) {
	$message='<div class="message">'.$lang['customers_swf_w'].$cfg['cuslimit_w'].'px</div>';
	return false;
}
elseif($h>$cfg['cuslimit_h']) {
	$message='<div class="message">'.$lang['customers_swf_h'].$cfg['cuslimit_h'].'px</div>';
	return false;
}
else $sqlAF = sql("UPDATE viscms_customers SET logo = '".$newname."' WHERE id = ".$idc);
	}
}

if($sqlAF==true) return true;
else return false;

}

function category_up($p) {
	global $cfg;
	
	$i=0;
	
	$sql = sql("SELECT position FROM viscms_customers_category WHERE id=".$p."");
	list($pos) = dbrow($sql);
	
	$sql2 = sql("SELECT position FROM viscms_customers_category WHERE position>".$pos." ORDER BY position ASC LIMIT 1");
	list($new_pos) = dbrow($sql2);
	
	$sql3 = sql("SELECT id,position FROM viscms_customers_category WHERE position>".$pos." AND position<=".$new_pos."");
	while(list($idx,$posx) = dbrow($sql3)) {
		$ident[$i] = $idx;
		$position[$i] = $posx-1;
		$i++;
	}
	
	for($i=0;$i<sizeof($ident);$i++) {
		$sql4 = sql("UPDATE viscms_customers_category SET position = ".$position[$i]." WHERE id=".$ident[$i]."");
	}
	
	$sql5 = sql("UPDATE viscms_customers_category SET position = ".$new_pos." WHERE id=".$p."");
	
	header("Location: ?module=customers");
	
}

function category_down($p) {
	global $cfg;
	
	$i=0;
	
	$sql = sql("SELECT position FROM viscms_customers_category WHERE id=".$p."");
	list($pos) = dbrow($sql);
	
	$sql2 = sql("SELECT position FROM viscms_customers_category WHERE position<".$pos." ORDER BY position DESC LIMIT 1");
	list($new_pos) = dbrow($sql2);
	
	$sql3 = sql("SELECT id,position FROM viscms_customers_category WHERE position<".$pos." AND position>=".$new_pos."");
	while(list($idx,$posx) = dbrow($sql3)) {
		$ident[$i] = $idx;
		$position[$i] = $posx+1;
		$i++;
	}
	
	for($i=0;$i<sizeof($ident);$i++) {
		$sql4 = sql("UPDATE viscms_customers_category SET position = ".$position[$i]." WHERE id=".$ident[$i]."");
	}
	
	$sql5 = sql("UPDATE viscms_customers_category SET position = ".$new_pos." WHERE id=".$p."");
	
	header("Location: ?module=customers");
	
}

function active($p) {
global $cfg,$lang;

	$sql = sql("UPDATE viscms_customers SET active=1 WHERE id=".$p);
	
if($sql==true)  {
  $msg = '<div class="message">'.$lang['customers_activated'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['customers_not_activated'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=customers");
}

function deactive($p) {
global $cfg,$lang,$var_2;

	$sql = sql("UPDATE viscms_customers SET active=0 WHERE id=".$p);
	
if($sql==true)  {
  $msg = '<div class="message">'.$lang['customers_deactivated'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['customers_not_deactivated'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=customers");
}

?>