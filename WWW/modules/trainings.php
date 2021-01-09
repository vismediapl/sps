<?
###############################
#           VIS-CMS           #
############-------############
#          VISMEDIA           #
#       www.vismedia.pl       #
#      biuro@vismedia.pl      #
###############################

## MODULE: TRAININGS ##

global $cfg,$lang,$language_id,$exists;

include 'languages/'.$language.'/trainings.php';

$vars = explode(',',$_GET['act']);
$var_1 = $vars[0];
$var_2 = $vars[1];
$var_3 = $vars[2];
$var_4 = $vars[3];

if(($var_1!='search' && (is_numeric($var_2) || $var_2=='' || $var_2=='page' || $var_2=='add' || $var_2=='show')) || $var_1=='search') {

###################################### 

if($_GET['module']!='static')
switch(@$var_1) {
   
   case 'page':
   training_browse(0,$var_2);
   break;
   
   case 'category':
   training_browse($var_2,$var_3);
   break;
   
   case 'date':
   training_browse($var_2,$var_3);
   break;
   
   case 'show':
   training_showHD($var_2);
   training_show($var_2);
   break;
   
   case 'tellafriend':
   training_tellafriend($var_2);
   break;
   
   case 'tellafriendS':
   static_tellafriend($var_2,$var_3);
   break;

   }

######################################

}

function training_browse($p,$q) {
global $cfg,$lang,$language_id,$var_1;

$n=0;

if($var_1=='category') {
  $sql = sql("SELECT name FROM viscms_trainings_categories WHERE ident=".$p." AND language_id = ".$language_id);
  list($catname) = dbrow($sql);
  $catname = ': '.$catname;
  
} elseif($var_1=='date') {
  $d = $p[6].$p[7];
  $m = $p[4].$p[5];
  $y = $p[0].$p[1].$p[2].$p[3];
  $catname = ': '.$d.'.'.$m.'.'.$y;
  $dtt = mktime(12,0,0,$m,$d,$y);
}

echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr valign="middle">
		<td class="header_td_bg">'.$lang['trainings'].$catname.'</td>
	</tr>
</table>';

if($p!=0) {
	if($var_1=='category') {
		$clause=" AND A.id=B.training_id AND B.category_id=".$p;
		$clause1=", viscms_trainings_to_categories B";
		
		switch($p) {

      case 103:
        new FreeSpace(6);
        break;

      case 104:
        new FreeSpace(7);
        break;

    }

	} elseif($var_1=='date') {
		$clause=" AND ( (A.date2=0 AND A.date1>='".($dtt-7200)."' AND A.date1<='".($dtt+7200)."') OR (A.date2!=0 AND A.date1<='".($dtt+7200)."' AND A.date2>='".($dtt-7200)."') )";
	} 
} else {
	$page='page';
		$clause="";
}

$date = date("d.m.Y");
list($d,$m,$y) = explode(".", $date);
$time = mktime(4,0,0,$m,$d,$y);

if($var_1!='date') $clause.=' AND ( (A.date2=0 AND A.date1>="'.$time.'") OR (A.date2!=0 AND A.date2>="'.$time.'") )';

$i=0;

$sql = sql("SELECT A.id FROM viscms_trainings A".$clause1." WHERE A.active=1 AND A.language_id = ".$language_id.$clause." ORDER BY A.position DESC");
while(list($id) = dbrow($sql)) {
  $i++;
  echo '<div style="padding-bottom: 30px;">';
    training_show($id);
  echo '</div>';
}

if($i==0) echo '<div align="center">'.$lang['trainings_not_found'].'</div>';

}

function training_show($p) {
global $cfg,$lang,$language,$exists;

$sqlLang = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($language_id)=dbrow($sqlLang);

$sql = sql("SELECT id,date1,date2,date_info,date_info_color,title,info,place,attachment FROM viscms_trainings WHERE id = '".$p."' AND active=1 AND language_id=".$language_id);
if(list($id,$date1,$date2,$date_info,$date_info_color,$title,$info,$place,$attachment) = dbrow($sql)) {
	

echo '<div style="text-align: justify; padding-bottom: 5px;">
  <b>'.nbsp($title).'</b>
</div>
';

$date_info_t='';
if($date_info!='') {
  if($date_info_color!='') {
    $span1 = '<span style="color: '.$date_info_color.'">';
    $span2 = '</span>';
  } else $span1=$span2='';
  $date_info_t = ' '.$span1.'('.$date_info.')'.$span2;
}

$date='';
if($date1>0 && $date2>0) $date = date("d.m.Y",$date1).' r. - '.date("d.m.Y",$date2).' r.';
elseif($date1>0) $date = date("d.m.Y",$date1).' r.';

echo '<div style="text-align: justify">
  <b>'.$lang['trainings_date'].'</b>: '.$date.$date_info_t.'
</div>
';

if($place!='') {

	$in = array(" www.","-www.","(www.");
	$out = array(" http://www.","-http://www.","(http://www.");
	$place=str_replace($in,$out,$place);
  $place = preg_replace("/(http|https|ftp|news)(:\/\/[[:alnum:]Z±æê³ñó¶¼¿¡ÆÊ£ÑÓ¦¬¯@#%\&_=?\/\.-]+)/","<a href='\\1\\2' class=\"Ablue\" target=\"_blank\">\\1\\2</a>",$place);
  $in = array(">http://",">https://",">ftp://",">news://");
  $place=str_replace($in,">",$place);

echo '<div style="text-align: justify">
  <b>'.$lang['trainings_place'].'</b>: '.nbsp($place).'
</div>
';
}

echo '<div style="text-align: justify">
  '.nbsp($info).'
</div>
';

if($attachment!='' && file_exists($cfg['trapath'].$attachment)) {

$default = 'txt';

$ext = explode ('.', $attachment);
$ext = strtolower($ext[sizeof($ext)-1]);

switch($ext) {

  case 'pdf';
    $icon='pdf';
    break;

  case 'doc';
    $icon='doc';
    break;

  case 'rtf';
    $icon='doc';
    break;

  case 'docx';
    $icon='doc';
    break;

}

if($icon=='') $icon = $default;

if($attachment!='' && file_exists($cfg['trapath'].$attachment)) $attachment = '<a href="'.$cfg['trapath'].$attachment.'"><img src="themes/'.$cfg['theme'].'/gfx/download_t.png" alt="" border="0" /></a>';

//echo '<div align="right"><a href="'.$cfg['trapath'].$attachment.'">'.$lang['trainings_attachment'].'</a></div>';
echo '<table width="100%">
  <tr valign="top">
    <td align="left"><a href="szkolenie_'.$id.'-polec.html"><img src="themes/'.$cfg['theme'].'/gfx/tellafriend.png" alt="" border="0" /></a></td>
    <td align="right">'.$attachment.'</td>
  </tr>
</table>';

}

echo '<div style="height: 3px; border-bottom: 1px solid #fff;"></div>';

}

 
}

function training_showHD($p) {
global $cfg,$lang,$language_id,$var_1;


echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr valign="middle">
		<td class="header_td_bg">'.$lang['trainings'].'</td>
	</tr>
</table>';

$msg = $_COOKIE['msg'];

if($msg!='') echo str_replace("\\","",$msg);
setcookie('msg',$msg,time()-60);

}

function training_showCatInc($p,$once=0) {
global $cfg,$lang,$language,$tt;

$sqlLang = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
list($language_id)=dbrow($sqlLang);

if($once==0) {
  $clause=" AND A.id=B.training_id AND B.category_id=".$p;
  $clause1=", viscms_trainings_to_categories B";
} else $clause = "A.id=".$p;

$date = date("d.m.Y");
list($d,$m,$y) = explode(".", $date);
$time = mktime(4,0,0,$m,1,$y);

$clause.=' AND ( (A.date2=0 AND A.date1>"'.$time.'") OR (A.date2!=0 AND A.date2>"'.$time.'") )';

$i=0;

$sql = sql("SELECT A.id FROM viscms_trainings A".$clause1." WHERE A.active=1 AND A.language_id = ".$language_id.$clause." ORDER BY A.position DESC");
while(list($id) = dbrow($sql)) {
  $i++;
  echo '<div style="padding-bottom: 20px;">';
    training_show($id);
  echo '</div>';
}

if($i==0 && $tt!=1) echo '<div align="center">'.$lang['trainings_not_found'].'</div><br />';

}

function training_tellafriend($p) {
global $cfg,$lang,$language_id;
	
if($_POST['friendemail']==true) {
	
	if(checkEmail($_POST['youremail'])==true && checkEmail($_POST['friendemail'])==true) {
		
$sql = sql("SELECT title,date1,date2,place FROM viscms_trainings WHERE id = ".$p);
list($title,$date1,$date2,$place) = dbrow($sql);

$date='';
if($date1>0 && $date2>0) $date = date("d.m.Y",$date1).' r. - '.date("d.m.Y",$date2).' r.';
elseif($date1>0) $date = date("d.m.Y",$date1).' r.';

$in = array("%yourname", "%title", "%date", "%place", "%link");
$out= array($_POST['yourname'], $title, $date, $place, $cfg['address']."/szkolenie_".$p.".html");
		
		$message = str_replace($in,$out,$lang['trainings_tellafriend_cont']);
		
		if($_POST['content']!='') $message .= "\n\n".$_POST['content'];
		
		$message = str_replace("&quot;",'"',$message);
		if($place=='') $message = str_replace("Miejsce szkolenia: \n",'',$message);
		
		if(mail($_POST['friendname']." <".$_POST['friendemail'].">", $lang['trainings_tellafriend_subject'], $message, "From: ".$_POST['yourname']." <".$_POST['youremail'].">")) $msg = '<div class="message">'.$lang['trainings_tellafriend_sent'].'</div>';
		else $msg = '<div class="message">'.$lang['trainings_tellafriend_nsent'].'</div>';
		
	} else $msg = '<div class="message">'.$lang['trainings_tellafriend_email_nv'].'</div>';

  setcookie('msg',$msg,time()+60);
  header("Location: szkolenie_".$p.".html");	
	
} else {
	
$sql = sql("SELECT title FROM viscms_trainings WHERE active=1 AND id = ".$p);
if(list($title) = dbrow($sql)) {
	
echo '<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr valign="middle">
		<td class="header_td_bg">'.$lang['training_tell_a_friend'].'</td>
	</tr>
</table>
	
	<table width="97%" align="center">
	<tr valign="top">
		<td><br />'.$lang['trainings_training'].': <a href="szkolenie_'.$p.'.html">'.$title.'</a></td>
	</tr>
	<tr valign="top">
		<td>

<form action="szkolenie_'.$p.'-polec.html" method="POST">';
	
	echo '<div align="center"><table width="100%">
	<tr valign="top">
		<td style="width: 200px;">'.$lang['trainings_tellafriend_yourname'].':</td>
		<td><input type="text" name="yourname" style="width: 100%;"/></td>
	</tr>
	<tr valign="top">
		<td>'.$lang['trainings_tellafriend_youremail'].':</td>
		<td><input type="text" name="youremail" style="width: 100%;"/></td>
	</tr>
	<tr valign="top">
		<td>'.$lang['trainings_tellafriend_friendname'].':</td>
		<td><input type="text" name="friendname" style="width: 100%;"/></td>
	</tr>
	<tr valign="top">
		<td>'.$lang['trainings_tellafriend_friendemail'].':</td>
		<td><input type="text" name="friendemail" style="width: 100%;"/></td>
	</tr>
	<tr valign="top">
		<td>'.$lang['trainings_tellafriend_content'].':</td>
		<td><textarea name="content" style="width: 100%;" rows="7"></textarea></td>
	</tr>
	<tr valign="top">
		<td colspan="2" style="text-align: center;"><br /><input type="hidden" name="step" value="1" /><input type="submit" value=" '.$lang['send'].' " class="button" /></td>
	</tr>
</table><br />
<a href="articles-show-'.$p.'.php"><b>'.$lang['back'].'</b></a>
</div>';
	
	echo '</form>
		
		</td>
	</tr>
</table>';
	}
  }
	
}

function static_tellafriend($p,$type='program') {
global $cfg,$lang,$language_id;

if($type=='program' || $type=='szkolenie')
if($_POST['friendemail']==true) {
	
	if(checkEmail($_POST['youremail'])==true && checkEmail($_POST['friendemail'])==true) {
		
$sql = sql("SELECT title FROM viscms_static WHERE ident = ".intval($p)." AND language_id='".CurrentLanguage()."'");
list($title) = dbrow($sql);

$in = array("%yourname", "%title", "%link");
$out= array($_POST['yourname'], '"'.$title.'"', $cfg['address']."/s".$p."_".$type.".html");
		
		$message = str_replace($in,$out,$lang['trainings_tellafriend_cont_'.$type]);
		
		if($_POST['content']!='') $message .= "\n\n".$_POST['content'];
		
		$message = str_replace("&quot;",'"',$message);
		
		if(mail($_POST['friendname']." <".$_POST['friendemail'].">", $lang['trainings_tellafriend_subject_'.$type], $message, "From: ".$_POST['yourname']." <".$_POST['youremail'].">")) $msg = '<div class="message">'.$lang['trainings_tellafriend_sent_'.$type].'</div>';
		else $msg = '<div class="message">'.$lang['trainings_tellafriend_nsent_'.$type].'</div>';
		
	} else $msg = '<div class="message">'.$lang['trainings_tellafriend_email_nv'].'</div>';

  setcookie('msg',$msg,time()+60);
  header('Location: s'.$p.'_'.substr(mod_rewrite($title),0,240).'.html');	
	
} else {
	
$sql = sql("SELECT title FROM viscms_static WHERE ident = ".intval($p)." AND language_id='".CurrentLanguage()."'");
if(list($title) = dbrow($sql)) {
	
echo '<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr valign="middle">
		<td class="header_td_bg">'.$lang['training_tell_a_friend_'.$type].'</td>
	</tr>
</table>
	
	<table width="97%" align="center">
	<tr valign="top">
		<td><br />'.$lang['trainings_'.$type].': <a href="s'.$p.'_'.substr(mod_rewrite($title),0,240).'.html">'.$title.'</a></td>
	</tr>
	<tr valign="top">
		<td>

<form action="polec_znajomemu_'.$p.'s-'.$type.'.html" method="POST">';
	
	echo '<div align="center"><table width="100%">
	<tr valign="top">
		<td style="width: 200px;">'.$lang['trainings_tellafriend_yourname'].':</td>
		<td><input type="text" name="yourname" style="width: 100%;"/></td>
	</tr>
	<tr valign="top">
		<td>'.$lang['trainings_tellafriend_youremail'].':</td>
		<td><input type="text" name="youremail" style="width: 100%;"/></td>
	</tr>
	<tr valign="top">
		<td>'.$lang['trainings_tellafriend_friendname'].':</td>
		<td><input type="text" name="friendname" style="width: 100%;"/></td>
	</tr>
	<tr valign="top">
		<td>'.$lang['trainings_tellafriend_friendemail'].':</td>
		<td><input type="text" name="friendemail" style="width: 100%;"/></td>
	</tr>
	<tr valign="top">
		<td>'.$lang['trainings_tellafriend_content'].':</td>
		<td><textarea name="content" style="width: 100%;" rows="7"></textarea></td>
	</tr>
	<tr valign="top">
		<td colspan="2" style="text-align: center;"><br /><input type="hidden" name="step" value="1" /><input type="submit" value=" '.$lang['send'].' " class="button" /></td>
	</tr>
</table><br />
<a href="articles-show-'.$p.'.php"><b>'.$lang['back'].'</b></a>
</div>';
	
	echo '</form>
		
		</td>
	</tr>
</table>';
	}
  }
	
}

?>