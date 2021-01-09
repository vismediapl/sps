<?
global $cfg,$lang,$language_id,$var_1;

include 'languages/'.$language.'/articles.php';

$n=0;

if($q=='') $q=1;
$str = ($q-1)*$cfg['artlimitrows2'];

echo '<table width="95%" align="center">
';

echo '	<tr valign="top">
		<td>
';

$n=0;

echo '<table style="width: 100%; text-align: justify;" align="left" cellspacing="0">
';
$sql = sql("SELECT id,date,author,title,intro,category_id,moretext FROM viscms_articles WHERE active=1 AND language_id = ".$language_id." AND category_id!=3 ORDER BY position DESC LIMIT 0,".$cfg['artlimitrows2']);
while(list($id,$date,$author,$title,$intro,$cid,$mt) = dbrow($sql)) {

$n++;
if($n%2==0) $bt=1;
else $bt=2;


if(file_exists($cfg['artpath'].'pictures/img_'.$id.'.jpg')) {
  $img = '<a href="a'.$id.'_'.mod_rewrite($title).'.html"><img src="'.$cfg['artpath'].'pictures/img_'.$id.'.jpg" alt="" hspace="2" vspace="2" align="left" border="0" /></a>';
} else {

  preg_match("#\<img(.*?)>#si",$intro,$match);
  preg_match("#src=\"(.*?).jpg\"#si",$match[0],$image);
  
  $oldname = $image[1].'.jpg';
  $oldnameU = $image[1].'.JPG';
  
  if($oldname!='.jpg' && $oldname!='/files/Image/html.gif' && $oldname!='/files/Image/pdf.gif') {
    
    if(file_exists($cfg['root'].$oldname)) $source=$cfg['root'].$oldname;
    elseif(file_exists($cfg['root'].$oldnameU)) $source=$cfg['root'].$oldnameU;
    else $source='';
    
    // tworzenie nowego obrazka
    if($source!='') {
      $newname = 'img_'.$id.'.jpg';
      
      $size = getimagesize($source); 
      $w = $size[0]; 
      $h = $size[1];
      
      $limit = 80;
      $limit_w=$limit_h=$limit;
      
      if($w > $limit || $h > $limit) {
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
	       } else {
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
      $imf = @ImageCreateFromJPEG ($source);
      $x= imagesx ($imf); 
      $y= imagesy ($imf);
      imagecopyresampled ($im, $imf, 0, 0, 0, 0, $w2, $h2, $x, $y);
      $a=imagejpeg($im,$cfg['artpath'].'pictures/'.$newname,100);
      if($a==true) {
        $img = '<a href="a'.$id.'_'.mod_rewrite($title).'.html"><img src="'.$cfg['artpath'].'pictures/img_'.$id.'.jpg" alt="" hspace="2" vspace="2" align="left" border="0" /></a>';
      } else $img='';

    } else $img='';
      
    } else $img = '';
    
    
  } else $img = '';
}

/*
  $oldname='';
  preg_match("#\<img(.*?)>#si",$intro,$match);
  preg_match("#src=\"(.*?)\"#si",$match[0],$image);
  $oldname = $image[1];
  if($oldname!='.jpg' && $oldname!='/files/Image/html.gif' && $oldname!='/files/Image/pdf.gif') {
    $img = '<img src="'.$cfg['artpath'].'pictures/img_'.$id.'.jpg" alt="" hspace="2" vspace="2" />';
  } else $img='';
	*/
	$sqlC = sql("SELECT name FROM viscms_articles_categories WHERE ident=".$cid." AND language_id = ".$language_id);
	list($catname) = dbrow($sqlC);

							//$dateauthor = date("d.m.Y H:i",$date);
							$dateauthor = date("Y-m-d",$date);
							$dateauthor .= ', kategoria: '.$catname;
echo '	<tr>
		<td>'.$img.'<a href="a'.$id.'_'.mod_rewrite($title).'.html" class="articles_title_short'.$bt.'">'.$title.'</a><br /><span style="font-size: 7px;">&nbsp;</span></td>	
	</tr>';

}
echo '</table>
		</td>
	</tr>
';
echo '</table>
    ';


?>