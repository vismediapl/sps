<?

function htmlentities_iso88592($string='') {
   $pl_iso = array('&ecirc;', '&oacute;', '&plusmn;', '&para;', '&sup3;', '&iquest;', '&frac14;', '&aelig;', '&ntilde;', '&Ecirc;', '&Oacute;', '&iexcl;', '&brvbar;', '&pound;', '&not;', '&macr;', '&AElig;', '&Ntilde;');   
   $entitles = get_html_translation_table(HTML_ENTITIES);
   $entitles = array_diff($entitles, $pl_iso);
   return strtr($string, $entitles);
}

function strtoupperpl($string) {
	$in=array('±','æ','ê','³','ñ','ó','¶','¼','¿');
	$out=array('¡','Æ','Ê','£','Ñ','Ó','¦','¬','¯');
	return str_replace($in,$out,strtoupper($string));
}

function sqlfilter($value,$level=4)  {
  global $cfg;

	$in = array('"');
	$out = array("&quot;");
	if($level!=7) $value=str_replace($in,$out,$value);

	switch($level) {
		case 0:
			return $value;
			break;
		case 1:
			if($cfg['addslashes_block']!=1) return addslashes($value);
			else return $value;
			break;
		case 2:
			if($cfg['addslashes_block']!=1) return addslashes(htmlentities_iso88592($value));
			else return htmlentities_iso88592($value);
			break;
		case 3:
			if($cfg['addslashes_block']!=1) return strip_tags(addslashes(htmlentities_iso88592($value)));
			else return strip_tags(htmlentities_iso88592($value));
			break;
		case 4:
			if($cfg['addslashes_block']!=1) return addslashes(strip_tags($value));
			else return strip_tags($value);
			break;
		case 5:
			$in=array('±','æ','ê','³','ñ','ó','¶','¼','¿','é','á','É','Á','¡','Æ','Ê','£','Ñ','Ó','¦','¬','¯');
			$out=array('a','c','e','l','n','o','s','z','z','e','a','e','a','a','c','e','l','n','o','s','z','z');
			if($cfg['addslashes_block']!=1) return str_replace($in,$out,addslashes(strip_tags($value)));
			else return str_replace($in,$out,strip_tags($value));
			break;
		case 6:
			if($cfg['addslashes_block']!=1) return intval(addslashes(strip_tags($value)));
			else return intval(strip_tags($value));
			break;
		case 7:
			return str_replace("<script","&lt;script",($value));
			break;
	}
	
}

function checkEmail($email) {
 if (!eregi("^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,4}$" , $email)) {
  return false;
 }
 return true;
}

function field($type,$name,$value,$optional) {
	global $language,$cfg,$lang,$path;
	
	$text='';
	
	if(strstr($_SERVER['REQUEST_URI'],"/admin")) $dotted='../';
	
	$sqlLang = sql("SELECT id,code FROM viscms_languages ORDER BY id ASC");
	
	if(mysql_num_rows($sqlLang)>1) {
	$text .= "<table>\n";
		while(list($lid,$lc) = dbrow($sqlLang)) {
			$text .= '	<tr valign="top">
		<td><img src="themes/'.$cfg['theme'].'/gfx/language/'.$lc.'.gif" /></td>
		<td>';
			
			
			if($type=='input') $text .= '<input type="text" name="'.$name.'_lang-'.$lid.'" value="'.$value[$lid].'" '.$optional.'/>';
			elseif($type=='textarea') $text .= '<textarea name="'.$name.'_lang-'.$lid.'" '.$optional.'>'.$value[$lid].'</textarea>';
			elseif($type=='file') { 
				$text .= '<input type="file" name="'.$name.'_lang-'.$lid.'" '.$optional.'>';
				if(file_exists($path.$value[$lid]) && $value[$lid]!='') $text .= '<br /><input type="checkbox" name="'.$name.'_delete_'.$lid.'" value="1" /> '.$lang['delete'];
			}
			elseif($type=='fck') {
   
   if($optional=='basic') $ToolbarSet='Basic';
   else $ToolbarSet='visCMS';

$base_arguments = array();

$base_arguments['Value'] = $value[$lid];
foreach($base_arguments as $key => $valuea)
   {
      if(!is_bool($valuea))
      {
         $valuea = '"' . preg_replace("/[\r\n]+/", '" + $0"', addslashes($valuea)) . '"';
      }
   }
   
$text .= '<script type="text/javascript">
var oFCKeditor = new FCKeditor(\''.$name.'_lang-'.$lid.'\');
oFCKeditor.BasePath = "'.$dotted.'fckeditor/";
oFCKeditor.InstanceName = "'.$name.'_lang-'.$lid.'";
oFCKeditor.Height = "300";
oFCKeditor.Width = "400";
oFCKeditor.Value = '.$valuea.';
oFCKeditor.ToolbarSet = "'.$ToolbarSet.'";
oFCKeditor.Config[ "DefaultLanguage" ] = "'.$lc.'" ;
oFCKeditor.Create();
</script>';
			}
			$text .= '</td>
	</tr>';
			$text .= "\n";
		}
		
	$text .= "</table>";
	} else {
		list($lid,$lc) = dbrow($sqlLang);
		if($type=='input') $text .= '<input type="text" name="'.$name.'_lang-'.$lid.'" value="'.$value[$lid].'" '.$optional.'/>';
		elseif($type=='textarea') $text .= '<textarea name="'.$name.'_lang-'.$lid.'" '.$optional.'>'.$value[$lid].'</textarea>';
		elseif($type=='file') { 
				$text .= '<input type="file" name="'.$name.'_lang-'.$lid.'" '.$optional.'>';
				if(file_exists($path.$value[$lid]) && $value[$lid]!='') $text .= '<br /><input type="checkbox" name="'.$name.'_delete_'.$lid.'" value="1" /> '.$lang['delete'];
			}
		elseif($type=='fck') {
   
   if($optional=='basic') $ToolbarSet='Basic';
   else $ToolbarSet='visCMS';
			
$base_arguments = array();

$base_arguments['Value'] = $value[$lid];
foreach($base_arguments as $key => $valuea)
   {
      if(!is_bool($valuea))
      {
         $valuea = '"' . preg_replace("/[\r\n]+/", '" + $0"', addslashes($valuea)) . '"';
      }
   }
			
$text .= '<script type="text/javascript">
var oFCKeditor = new FCKeditor(\''.$name.'_lang-'.$lid.'\');
oFCKeditor.BasePath = "'.$dotted.'fckeditor/";
oFCKeditor.InstanceName = "'.$name.'_lang-'.$lid.'";
oFCKeditor.Height = "300";
oFCKeditor.Width = "400";
oFCKeditor.Value = '.$valuea.';
oFCKeditor.ToolbarSet = "'.$ToolbarSet.'";
oFCKeditor.Config[ "DefaultLanguage" ] = "'.$lc.'" ;
oFCKeditor.Create();
</script>';
		}
	}
	
	return $text;
}

function getLanguage($default_language) {
	global $cfg,$lang;
	
	$k=0;
	
	$sqlLang = sql("SELECT code FROM viscms_languages ORDER BY id ASC");
	if(mysql_num_rows($sqlLang)>1) {
		while(list($lc) = dbrow($sqlLang)) {
			$langs[$k] = $lc;
			$k++;
		}
	}
	
	$domext = explode(".",$_SERVER['HTTP_HOST']);
	for($i=0;$i<mysql_num_rows($sqlLang);$i++) {
		if($domext[sizeof($domext)-1]==$langs[$i] && file_exists("languages/".$domext[sizeof($domext)-1].".php")) $language = $domext[sizeof($domext)-1];
	}
	
	$hal = explode(",",$_SERVER['HTTP_ACCEPT_LANGUAGE']);
	for($i=sizeof($hal);$i>=0;$i--) {
		for($j=0;$j<$k;$j++) {
			$halp = explode(";",$hal[$i]);
			$halpe = explode("-",$halp[0]);
			if($halpe[0]==$langs[$j] && file_exists("languages/".$halpe[0].".php")) $language = $halpe[0];
			unset($halp);
			unset($halpe);
		}
	}
	
	if(isset($_COOKIE['lng'])) {
		if(file_exists("languages/".$_COOKIE['lng'].".php")) $language = $_COOKIE['lng'];
	}
	
	if(isset($_GET['lng'])) {
		setcookie('lng',$_GET['lng'],time()+3600);
		if(file_exists("languages/".$_GET['lng'].".php")) $language = $_GET['lng'];
	}

	if($language=='') $language = $default_language;
	
	return $language;
	
}

function size_file($p) {
	
	$size = filesize($p);
	
	if($size<1024) return $size.' B';
	elseif($size<(1024*1024)) return round(($size/1024),2).' kB';
	elseif($size<(1024*1024*1024)) return round(($size/(1024*1024)),2).' MB';	
	
}

function swfdecompress($buffer)
{
   if(function_exists('gzuncompress') && substr($buffer, 0, 3) == "CWS" && ord(substr($buffer, 3, 1)) >= 6)
   {
      $output = 'F';
      $output .= substr ($buffer, 1, 7);
      $output .= gzuncompress(substr($buffer, 8));
      return ($output);
   } 
   else 
   {
      return ($buffer);
   }
}
 
function getSWFDimensions($filename)
{
   $image_info = getimagesize($filename);
   $width= $image_info[0];
   if("" == $width)
   {
      $zd = gzopen ($filename,"r");
      $contents = gzread ($zd, filesize($filename));
      gzclose ($zd);
      $image_string = swfdecompress($contents);// Decompress the file
      $tempHandle = fopen("temp.swf","w");
      fwrite($tempHandle,$image_string);
      fclose($tempHandle);
      $image_info = getimagesize("temp.swf");
      unlink("temp.swf");
   }
   return $image_info;
}

function dp_session_register($variable) {
  global ${$variable};
  if(is_null(${$variable}))
    ${$variable}="";
  return session_register($variable);
}

function getLatLng($address) {
	global $cfg;
	
if(strstr($address,'¶w.') || strstr($address,'¦w.')) {
	$addr1=explode(" ",$address);
	$addr2=end($addr1);
	if(is_numeric($addr2[strlen($addr2)-1])) $addr3=$addr1[sizeof($addr1)-2];
	else $addr3=end($addr1);
	$addr4=$addr3[strlen($addr3)-1];
	if(strstr('ae',$addr4)) $out='¶wiêtego';
	elseif(strstr('iy',$addr4)) $out='¶wiêtej';
	else $out='¶wiêtych';
	$in = array("¶w.","¦w.");
	$address=str_replace($in,$out,$address);
}

$in = array("os.","o¶.");
$address=str_replace($in,'Osiedle',$address);

$in = array("±","æ","ê","³","ñ","ó","¶","¿","¼","¡","Æ","Ê","£","Ñ","Ó","¦","¯","¬");
$out = array("a","c","e","l","n","o","s","z","¼","A","C","E","L","N","O","S","Z","Z");
$address=str_replace($in,$out,$address);
	
$url = "http://maps.google.com/maps/geo?q=".urlencode($address)."&output=csv&key=".$cfg['googlemaps'];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER,0); //Change this to a 1 to return headers
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$data = curl_exec($ch);
curl_close($ch);

$ll = explode(",",$data);
$lat=$ll[2];
$lng=$ll[3];

$getLatLng=array($lat,$lng);

return $getLatLng;

}

function imageAlt($source) {

	$img_1=explode("<img",$source);
	$source=preg_replace("#\<img(.*?)>#si","<<<PICTURE>>>",$source);
	preg_match_all("#\<(.*?)<<<PICTURE>>><#si",$source,$alink);
	$lt_1=$alink[0];
	for($i=1;$i<=sizeof($img_1);$i++) {
		if($img_1[1]!='') {
			$img_2=explode('src="',$img_1[$i]);
			$img_2a=explode('alt="',$img_1[$i]);
			$img_2al=explode('align="',$img_1[$i]);
			$img_2w=explode('width="',$img_1[$i]);
			$img_2h=explode('height="',$img_1[$i]);
			$img_2hs=explode('hspace="',$img_1[$i]);
			$img_2vs=explode('vspace="',$img_1[$i]);
			$j=$i-1;
			$lt_2=explode("<",$lt_1[$j]);
			$lt_3=end($lt_2);
			$lt_3=$lt_2[(sizeof($lt_2)-5)];
			$lt='<'.$lt_3;
			if($lt[1]=='a' && $lt[2]==' ') {
				$a1=$lt;
				$a2='</a>';
			} else $a1=$a2='';
			if($img_2[1]!='') {
				$img_3=explode('"',$img_2[1]);
				$img_3a=explode('"',$img_2a[1]);
				$img_3al=explode('"',$img_2al[1]);
				$img_3w=explode('"',$img_2w[1]);
				$img_3h=explode('"',$img_2h[1]);
				$img_3hs=explode('"',$img_2hs[1]);
				$img_3vs=explode('"',$img_2vs[1]);
				$img_4=$img_3[0];
				$img_4a=$img_3a[0];
				$img_4al=$img_3al[0];
				$img_4w=$img_3w[0];
				$img_4h=$img_3h[0];
				$img_4hs=$img_3hs[0];
				$img_4vs=$img_3vs[0];
			}
				if($img_4al!='') $img_4al=' align="'.$img_4al.'"';
				else $img_4al='';
				if($img_4w!='') $img_4w=' width="'.$img_4w.'"';
				if($img_4h!='') $img_4h=' height="'.$img_4h.'"';
				if($img_4hs!='') $img_4hs=' hspace="'.$img_4hs.'"';
				if($img_4vs!='') $img_4vs=' vspace="'.$img_4vs.'"';
				


			$img='<table'.$img_4al.'>
	<tr>
		<td>'.$a1.'<img src="'.$img_4.'" alt="'.$img_4a.'"'.$img_4w.$img_4h.' border="0" />'.$a2.'</td>
	</tr>
';

$img.='	<tr>
		<td style="background: #DFDFDF; font-size: 7pt;">'.$img_4a.'</td>
	</tr>
';
	
$img.='</table>';

if($img_4a=='') $img='<img src="'.$img_4.'" alt="'.$img_4a.'"'.$img_4w.$img_4h.$img_4al.' border="0" />';
			
	$source=preg_replace("#\<<<PICTURE>>>#si",$img,$source,1);
	$source=str_replace($a1.$img.$a2,$img,$source);
		}
	$img='';
	}
	
return $source;

}

function limitWords($source,$limit) {
	$result='';
	$words = explode(" ",$source);
	if(sizeof($words)<=$limit) return $source;
	else {
		for($i=0;$i<$limit;$i++) {
			$result .= $words[$i].' ';
		}
		return $result.'...';
	}
}

function flash($src,$width,$height,$options=false) {
	
echo '<noscript>
    <object data="'.$src.'"
            width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash">
     <param name="allowScriptAccess" value="sameDomain" />
     <param name="movie" value="'.$src.'" />
    </object>
</noscript>
<script type="text/javascript">
//<!--
AC_RunFlContentX ("src","'.$src.'","quality","high","bgcolor","#ffffff","width","'.$width.'","height","'.$height.'","name","flash","align","middle","allowscriptaccess","sameDomain","wmode","opaque");
//-->
</script>';
	
}

function saveLastUpdate() {
	global $cfg;
	$sql = sql("UPDATE viscms_config SET value='".date("d.m.Y")."' WHERE `option`='lastupdate'");
}

function counter() {
	global $cfg;
	$count=$_COOKIE['counter_check'];
	if($count!=1) {
		$cfg['counter']++;
		$sql = sql("UPDATE viscms_config SET value='".$cfg['counter']."' WHERE `option`='counter'");
		setcookie('counter_check',1,time()+86400);
		
	}
}

function mod_rewrite($string) {
	$in=array('±','æ','ê','³','ñ','ó','¶','¼','¿','"',"'",'!','?','/','.',',',' & ',' - ',' ','-','&','{','[','(',')',']','}',';',':','é','á','¡','Æ','Ê','£','Ñ','Ó','¦','¬','¯','?','?','?',"#8211","#8221","#8222","#8217",'@','#');
		$out=array('a','c','e','l','n','o','s','z','z','','','','','','','','_','_','_','_','','','','','','','','','','e','a','a','c','e','l','n','o','s','z','z','','','_','_','','','_','_at_','_');
	
	return strtolower(str_replace($in,$out,$string));
}

function round_special($value,$precision) {
	$value = round($value,$precision);
	$valtab=explode(".",$value);
	$value = $valtab[0].'.'.$valtab[1];
	$strlen=strlen($valtab[1]);
	for($i=$strlen;$i<$precision;$i++) $value.='0';
	return $value;
}

function imageCreateTransparent($x, $y, $tc=false) {
   if($tc==true) $imageOut = imagecreatetruecolor($x, $y);
   else $imageOut = imagecreate($x, $y);
   $colourBlack = imagecolorallocate($imageOut, 0, 0, 0);
   imagecolortransparent($imageOut, $colourBlack);
   return $imageOut;
} 

function HiddenTooLong($pxs=600) {
	
	if(strstr($pxs,"%")) {
		$pxs=floor(600*(intval($pxs)/100));
	}
	
	preg_match('/Firefox|MSIE|Opera/',$_SERVER['HTTP_USER_AGENT'],$user_agent);
	if($user_agent[0]=='Opera') {
		$div='100%';
	} else $div=$pxs.'px';
	
	return $div;
}

function frame($text='',$weight=400,$height=100,$title='',$valign=0,$image='') {
	global $cfg;
	
	$weight=intval($weight); if($weight<77) $weight=400;
	$height=intval($height); if($height==0) $height=100;
	
	if($valign==1) $valign='middle';
	elseif($valign==2) $valign='bottom';
	else $valign='top';
	
	if($image!='' && file_exists($image)) $title='<img src="'.$image.'" alt="'.$title.'" /><br />';
	elseif($title!='') $title = '<div class="header_hp">'.strtoupperpl($title).'</div><br />';
	
echo '<table style="width: '.$weight.'px; height: '.$height.'px; background: #3c3c3c;" cellpadding="0" cellspacing="0">
	<tr valign="top" style="height: 7px;">
		<td style="width: 9px;"><img src="themes/'.$cfg['theme'].'/gfx/corner-1.gif" alt="" /></td>
		<td style="width: '.($weight-76).'px; background-image: url(\'\themes/'.$cfg['theme'].'/gfx/fr-1.gif\'); background-repeat: repeat-x;"><img src="themes/'.$cfg['theme'].'/gfx/spacer.gif" width="'.($weight-76).'" height="1" alt="" /></td>
		<td style="width: 67px;"><img src="themes/'.$cfg['theme'].'/gfx/corner-3.gif" alt="" /></td>
	</tr>
	<tr>
		<td colspan="3" style="border-left: 1px solid #828282; border-right: 1px solid #828282; padding-left: 5px; padding-right: 5px;" valign="'.$valign.'">'.$title.$text.'</td>
	</tr>
	<tr valign="bottom" style="height: 7px;">
		<td style="width: 9px;"><img src="themes/'.$cfg['theme'].'/gfx/corner-2.gif" alt="" /></td>
		<td style="width: '.($weight-76).'px; background-image: url(\'\themes/'.$cfg['theme'].'/gfx/fr-2.gif\'); background-repeat: repeat-x;"></td>
		<td style="width: 67px;"><img src="themes/'.$cfg['theme'].'/gfx/corner-4.gif" alt="" /></td>
	</tr>
</table>';
	
}



function CurrentLanguage($string='') {
  global $language;
  
  if($string=='') $string = $language;

  $sqlLang = sql("SELECT id FROM viscms_languages WHERE code='".$string."'");
  if(list($lid)=dbrow($sqlLang)) {
    return $lid;
  }
}

function InsertImage($file,$alt='') {
  global $cfg,$language;
  
  return '<img src="themes/'.$cfg['theme'].'/gfx/'.$file.'" alt="'.$alt.'" border="0" />';
  
}

function InsertImageLang($file,$alt='') {
  global $cfg,$language;
  
  return '<img src="themes/'.$cfg['theme'].'/gfx/languages/'.$language.'/'.$file.'" alt="'.$alt.'" border="0" />';
  
}

function AInsertImage($file,$link,$alt='') {
  global $cfg,$language;
  
  return '<a href="'.$link.'"><img src="themes/'.$cfg['theme'].'/gfx/'.$file.'" alt="'.$alt.'" border="0" /></a>';
  
}

function nbsp($string) {

$in = array(" i ", " w ", " z ", " o ", " a ");
$out = array(" i&nbsp;", " w&nbsp;", " z&nbsp;", " o&nbsp;", " a&nbsp;");

return str_replace($in,$out,$string);

}

?>