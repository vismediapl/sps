<?

global $cfg,$lang,$language_id,$exists;

include 'languages/'.$language.'/articles.php';

$vars = explode(',',$_GET['act']);
$var_1 = $vars[0];
$var_2 = $vars[1];
$var_3 = $vars[2];
$var_4 = $vars[3];

if(($var_1!='search' && (is_numeric($var_2) || $var_2=='' || $var_2=='page' || $var_2=='add' || $var_2=='show')) || $var_1=='search') {

###################################### 

switch(@$var_1) {

   case '':
   browse(0,1);
   break;
   
   case 'page':
   browse(0,$var_2);
   break;

   case 'category':
   browse($var_2,$var_3);
   break;
   
   case 'show':
   show($var_2,$var_3);
   break;

   case 'pdf':
   pdf($var_2);
   break;

   case 'tellafriend':
   tellafriend($var_2);
   break;

   }

######################################

}

function browse($p,$q) {
global $cfg,$lang,$language_id,$var_1;

$cfg['artlimitrows2']=100;

echo '<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr valign="middle">
		<td class="header_td_bg">Archiwum</td>
	</tr>
</table>';

$n=0;

if($q=='') $q=1;
$str = ($q-1)*$cfg['artlimitrows2'];

echo '<table width="95%" align="center">
';

if($var_1=='category') {
$sql = sql("SELECT name,description FROM viscms_articles_categories WHERE ident=".$p." AND language_id = ".$language_id);
if(list($catname,$description) = dbrow($sql)) {
	if($description!='')
	echo '	<tr valign="top">
		<td><a href="articles-category-'.$p.'.php" class="articles_title">'.$catname.'</a></td>
	</tr>
	<tr valign="top">
		<td style="border-bottom: dotted #000000 1px;">'.$description.'</td>
	</tr>
';
}
}


echo '	<tr valign="top">
		<td>
';

if($p!=0) {
	if($var_1=='category') {
		$clause=" AND category_id=".$p;
		$page="category-".$p;
	}
} else {
	$page='page';
		$clause=" AND category_id=1";
}

if($var_1=='search') {
	$clause=" AND (title LIKE CONVERT( '%".addslashes($p)."%' USING latin2 ) OR intro LIKE CONVERT( '%".addslashes($p)."%' USING latin2 ) OR moretext LIKE CONVERT( '%".addslashes($p)."%' USING latin2 ) )";
	$page="search-".addslashes($p);
}

echo '<table style="width: 100%;" align="center">
';
$sql = sql("SELECT id,date,author,title,intro, category_id FROM viscms_articles WHERE active=1 AND language_id = ".$language_id.$clause." ORDER BY position DESC LIMIT ".$str.",".$cfg['artlimitrows2']);
while(list($id,$date,$author,$title,$intro,$category_id) = dbrow($sql)) {
	
	if($category_id>0) {
		$sqlC = sql("SELECT name FROM viscms_articles_categories WHERE language_id = ".$language_id." AND ident=".$category_id);
		if(list($cc)=dbrow($sqlC)) {
			$catnam=', Kategoria: '.$cc;
		} else $catnam='';
	} else $catnam='';

							//$dateauthor = date("d.m.Y H:i",$date);
							$dateauthor = date("d.m.Y",$date);
							if($author!='') $dateauthor .= ', '.$author;
echo '	<tr>
		<td><a href="articles-show-'.$id.'.php" class="articles_title">'.$title.'</a><br /><span class="dateauthor">'.$dateauthor.$catnam.'</span></td>	
	</tr>';

}
echo '</table>
		</td>
	</tr>
	<tr valign="bottom">
		<td>
<table width="100%" align="right">
';

$sqlJ = sql("SELECT id FROM viscms_articles WHERE active=1 AND language_id=".$language_id.$clause);
$pages = ceil(mysql_num_rows($sqlJ)/$cfg['artlimitrows2']);

if($q==1) $num_of_pages = '<img src="themes/'.$cfg['theme'].'/gfx/sleft.gif" border="0" alt="" /> ';
else $num_of_pages = '<a href="articles-'.$page.'-'.($q-1).'.php"><img src="themes/'.$cfg['theme'].'/gfx/sleft.gif" border="0" alt="" /></a> ';

if($pages>5) {

	if($q>3 && ($q-2)<$pages) $num_of_pages.= ' ... ';
	
	if($q==$pages) $num_of_pages.= "<a href=\"articles-".$page."-".$p."-".($q-4).".php\" class=\"pg\">".($q-4)."</a> <a href=\"articles-".$page."-".($q-3).".php\" class=\"pg\">".($q-3)."</a>  ";
	if($q==$pages-1) $num_of_pages.= "<a href=\"articles-".$page."-".($q-3).".php\" class=\"pg\">".($q-3)."</a>  ";
	
	for($i=$q-2;$i<=$q+2;$i++) {
	  if($i>0 && $i<=$pages) {
		if($i==$q) $strcl = '<span class="str2">'.$i.'</span> '; 
		else $strcl = "<a href=\"articles-".$page."-".$i.".php\" class=\"pg\">".$i."</a>  ";
		$num_of_pages.=$strcl;		
	  }
	}
		if(($q-2)==-1) $num_of_pages.= "<a href=\"articles-".$page."-".$i.".php\" class=\"pg\">".$i."</a> <a href=\"articles-".$page."-".($i+1).".php\" class=\"pg\">".($i+1)."</a>  ";
		if(($q-2)==0) $num_of_pages.= "<a href=\"articles-".$page."-".$i.".php\" class=\"pg\">".$i."</a> ";
	if(($q+2)<$pages) $num_of_pages.= ' ... ';
}
else {
	for($i=1;$i<=$pages;$i++) {
		if($i==$q) $strcl = '<span class="str2">'.$i.'</span> '; 
		else $strcl = "<a href=\"articles-".$page."-".$i.".php\">".$i."</a>  ";
		$num_of_pages.=$strcl;
	}
}

if($q==$pages) $num_of_pages.= '<img src="themes/'.$cfg['theme'].'/gfx/sright.gif" border="0" alt="" /> ';
else $num_of_pages.= '<a href="articles-'.$page.'-'.($q+1).'.php"><img src="themes/'.$cfg['theme'].'/gfx/sright.gif" border="0" alt="" /></a> ';

if($pages<=1) $num_of_pages='';

echo '	<tr>
		<td valign="middle" align="center" colspan="4">'.$num_of_pages.'</td>
	</tr>
</table>
'; 
 
echo '		</td>
	</tr>
';
echo '</table>
    ';
}

function browse1($p,$q) {
global $cfg,$lang,$language_id,$var_1;

echo '<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr valign="middle">
		<td class="header_td_bg">Archiwum</td>
	</tr>
</table>';

$n=0;

if($q=='') $q=1;
$str = ($q-1)*$cfg['artlimitrows2'];

echo '<table width="95%" align="center">
';

if($var_1=='category') {
$sql = sql("SELECT name,description FROM viscms_articles_categories WHERE ident=".$p." AND language_id = ".$language_id);
if(list($catname,$description) = dbrow($sql)) {
	if($description!='')
	echo '	<tr valign="top">
		<td><a href="articles-category-'.$p.'.php" class="articles_title">'.$catname.'</a></td>
	</tr>
	<tr valign="top">
		<td style="border-bottom: dotted #000000 1px;">'.$description.'</td>
	</tr>
';
}
}

echo '	<tr valign="top">
		<td>
';

if($p!=0) {
	if($var_1=='category') {
		$clause=" AND category_id=".$p;
		$page="category-".$p;
	}
} else {
	$page='page';
		$clause=" AND category_id=1";
}

if($var_1=='search') {
	$clause=" AND (title LIKE CONVERT( '%".addslashes($p)."%' USING latin2 ) OR intro LIKE CONVERT( '%".addslashes($p)."%' USING latin2 ) OR moretext LIKE CONVERT( '%".addslashes($p)."%' USING latin2 ) )";
	$page="search-".addslashes($p);
}

echo '<table style="width: 100%;" align="center">
';
$sql = sql("SELECT id,date,author,title,intro FROM viscms_articles WHERE active=1 AND language_id = ".$language_id.$clause." ORDER BY position DESC LIMIT ".$str.",".$cfg['artlimitrows2']);
while(list($id,$date,$author,$title,$intro) = dbrow($sql)) {

							//$dateauthor = date("d.m.Y H:i",$date);
							$dateauthor = date("d.m.Y",$date);
							if($author!='') $dateauthor .= ', '.$author;
echo '	<tr>
		<td style="border-bottom: 1px solid #000000;"><a href="articles-show-'.$id.'.php" class="articles_title">'.$title.'</a><br /><span class="dateauthor">'.$dateauthor.'</span></td>	
	</tr>
	<tr>
		<td>'.$intro.'</td>	
	</tr>
	<tr>
		<td style="background-image: url(\'themes/'.$cfg['theme'].'/gfx/art_bg.gif\'); text-align: right;"><span class="art_bg"><a href="articles-show-'.$id.'.php" class="articles_footer">'.$lang['articles_readmore'].'</a> | <a href="articles-comments-add-'.$id.'.php" class="articles_footer">'.$lang['articles_commentarticle'].'</a> | <a href="articles-tellafriend-'.$id.'.php" class="articles_footer">'.$lang['articles_tell_a_friend'].'</a></span> </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>';

}
echo '</table>
		</td>
	</tr>
	<tr valign="bottom">
		<td>
<table width="100%" align="right">
';

$sqlJ = sql("SELECT id FROM viscms_articles WHERE active=1 AND language_id=".$language_id.$clause);
$pages = ceil(mysql_num_rows($sqlJ)/$cfg['artlimitrows2']);

if($q==1) $num_of_pages = '<img src="themes/'.$cfg['theme'].'/gfx/sleft.gif" border="0" alt="" /> ';
else $num_of_pages = '<a href="articles-'.$page.'-'.($q-1).'.php"><img src="themes/'.$cfg['theme'].'/gfx/sleft.gif" border="0" alt="" /></a> ';

if($pages>5) {

	if($q>3 && ($q-2)<$pages) $num_of_pages.= ' ... ';
	
	if($q==$pages) $num_of_pages.= "<a href=\"articles-".$page."-".$p."-".($q-4).".php\" class=\"pg\">".($q-4)."</a> <a href=\"articles-".$page."-".($q-3).".php\" class=\"pg\">".($q-3)."</a>  ";
	if($q==$pages-1) $num_of_pages.= "<a href=\"articles-".$page."-".($q-3).".php\" class=\"pg\">".($q-3)."</a>  ";
	
	for($i=$q-2;$i<=$q+2;$i++) {
	  if($i>0 && $i<=$pages) {
		if($i==$q) $strcl = '<span class="str2">'.$i.'</span> '; 
		else $strcl = "<a href=\"articles-".$page."-".$i.".php\" class=\"pg\">".$i."</a>  ";
		$num_of_pages.=$strcl;		
	  }
	}
		if(($q-2)==-1) $num_of_pages.= "<a href=\"articles-".$page."-".$i.".php\" class=\"pg\">".$i."</a> <a href=\"articles-".$page."-".($i+1).".php\" class=\"pg\">".($i+1)."</a>  ";
		if(($q-2)==0) $num_of_pages.= "<a href=\"articles-".$page."-".$i.".php\" class=\"pg\">".$i."</a> ";
	if(($q+2)<$pages) $num_of_pages.= ' ... ';
}
else {
	for($i=1;$i<=$pages;$i++) {
		if($i==$q) $strcl = '<span class="str2">'.$i.'</span> '; 
		else $strcl = "<a href=\"articles-".$page."-".$i.".php\">".$i."</a>  ";
		$num_of_pages.=$strcl;
	}
}

if($q==$pages) $num_of_pages.= '<img src="themes/'.$cfg['theme'].'/gfx/sright.gif" border="0" alt="" /> ';
else $num_of_pages.= '<a href="articles-'.$page.'-'.($q+1).'.php"><img src="themes/'.$cfg['theme'].'/gfx/sright.gif" border="0" alt="" /></a> ';

if($pages<=1) $num_of_pages='';

echo '	<tr>
		<td valign="middle" align="center" colspan="4">'.$num_of_pages.'</td>
	</tr>
</table>
'; 
 
echo '		</td>
	</tr>
';
echo '</table>
    ';
}

function show($p) {
global $cfg,$lang,$language_id,$exists;

echo '<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr valign="middle">
		<td class="header_td_bg">'.$lang['articles'].'</td>
	</tr>
</table>';

$msg = $_COOKIE['msg'];

if($msg!='') echo str_replace("\\","",$msg);
setcookie('msg',$msg,time()-60);

echo '<table width="100%" align="center">
	<tr valign="top">
		<td>
';

echo '<table style="width: 100%;" align="center">
';
$sql = sql("SELECT id,date,author,title,intro,moretext,attachments,similar,category_id FROM viscms_articles WHERE id = ".$p." AND active=1 AND language_id=".$language_id);
if(list($id,$date,$author,$title,$intro,$moretext,$attach,$similar,$category) = dbrow($sql)) {
	
	$exists=1;
	
if($similar!='') {
	
$similar_articles = '<fieldset class="articles_fieldset"><legend class="articles_legend">'.$lang['articles_similar'].'</legend>
';

$similar=explode(",",$similar);
for($i=0;$i<sizeof($similar);$i++) {
	$S=explode("_",$similar[$i]);
	$Sid=$S[1];
	$Stype=$S[0];
	if($Stype=='A') {
		$Stype='articles';
		$sqlSIM1=0;
	}
	elseif($Stype=='B') {
		$Stype='blog';
		$sqlSIM1=0;
	}
	elseif($Stype=='T') {
		$Stype='topics';
		$sqlSIM1=1;
	}
	if($sqlSIM1!=1)
		$sqlSIM = sql("SELECT title FROM viscms_".$Stype." WHERE id=".$Sid." AND active=1 AND language_id=".$language_id);
	else
		$sqlSIM = sql("SELECT name FROM viscms_articles_categories WHERE ident=".$Sid." AND language_id=".$language_id);
	if(list($name) = dbrow($sqlSIM)) {
	
		$title_o='';
		
		for($j=0;$j<50;$j++) {
			$title_o.=$name[$j];
		}
		if($name[49]!='') $title_o.='...';
		
		if($i!=0) $similar_articles .= '<br />';
		$similar_articles .= '<img src="themes/'.$cfg['theme'].'/gfx/dot.gif" width="10" alt="" /> <a href="'.$Stype.'-show-'.$Sid.'.php">'.$title_o.'</a>
';
	}
}

$similar_articles .= '
</fieldset>
';
	
}

		$i=0;
		$src_txt='';
		$sqlSrc = sql('SELECT name,url FROM viscms_articles_sources WHERE article_id='.$p);
		while(list($SRCn,$SRCu)=dbrow($sqlSrc)) {
			$i++;
			if($SRCn!='') {
				if($i!=1) $src_txt.=', ';
				if($SRCu!='') $src_txt.='<a href="'.$SRCu.'">'.$SRCn.'</a>';
				else $src_txt.=$SRCn;
			}
		}
	
							//$dateauthor = date("d.m.Y H:i",$date);
							$dateauthor = date("d.m.Y",$date);
							if($author!='') $dateauthor .= ', '.$author;
							
							if($src_txt!='') {
								$src = '<br /><br /><table><tr><td><img src="themes/'.$cfg['theme'].'/gfx/source.gif" alt="" /> </td><td><b>'.$lang['articles_source'].':</b> '.$src_txt.'</td></tr></table>';
							}
echo '	<tr>
		<td> <!-style="border-bottom: 1px dotted #000000;"--><a href="articles-show-'.$id.'.php" class="articles_title">'.$title.'</a><br /><span class="dateauthor">'.$dateauthor.'</span></td>	
	</tr>
	<tr>
		<td>'.$intro.'</td>	
	</tr>
	<tr>
		<td><center>';

new ads(46);

echo '</center></td>	
	</tr>
	<tr>
		<td>'.$moretext.$src.'</td>	
	</tr>
	<tr>
		<td>';



if($attach!='') {
	
echo '<br /><table width="100%">
<tr>
<td colspan="3" align="left" style="background: #ebebeb;"><b>'.$lang['articles_attachments'].'</b></td>
</tr>
';

$attach=explode(",",$attach);
for($i=0;$i<sizeof($attach);$i++) {
	$sqlATT = sql("SELECT name,file FROM viscms_articles_attachments WHERE id=".$attach[$i]);
	if(list($name,$file) = dbrow($sqlATT)) {
		echo '<tr>
<td width="3" align="right">'.($i+1).'.</td>
<td align="left">&nbsp;&nbsp;<a href="'.$cfg['artpath'].$file.'" target="_blank">'.$name.'</a></td>
<td width="100" align="right">'.size_file($cfg['artpath'].$file).'</td>
</tr>
';
	}
}

echo '
</table>
<br />
';
	
}

	echo '</td>
	</tr>
	<tr>
		<td>
<table width="95%">
<tr valign="top">
<td width="50%" align="left"><br /><img src="themes/'.$cfg['theme'].'/gfx/send.gif" alt="" />
<a href="articles-tellafriend-'.$p.'.php">'.$lang['articles_tell_a_friend'].'</a>
<br />
<img src="themes/'.$cfg['theme'].'/gfx/print.gif" alt="" /> <a href="articles-pdf-'.$p.'.php">'.$lang['articles_print'].'</a></td>
<td width="50%" align="right">'.$similar_articles.'</td>
</tr>
</table>

		</td>	
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>';

}
echo '</table>
';

echo '
		</td>
	</tr>
</table>
';

 
}

function pdf($p) {
global $cfg,$lang,$language_id;

$sql = sql("SELECT id,date,author,title,intro,moretext FROM viscms_articles WHERE active=1 AND id = ".$p);
if(list($id,$date,$author,$title,$intro,$moretext) = dbrow($sql)) {
	
		$i=0;
		$src_txt='';
		$sqlSrc = sql('SELECT name,url FROM viscms_articles_sources WHERE article_id='.$p);
		while(list($SRCn,$SRCu)=dbrow($sqlSrc)) {
			$i++;
			if($SRCn!='') {
				if($i!=1) $src_txt.=', ';
				if($SRCu!='') $src_txt.=$SRCn.' ('.$SRCu.')';
				else $src_txt.=$SRCn;
			}
		}
		
		$source=$src_txt;

	$dateauthor = date("d.m.Y H:i",$date);
	if($author!='') $dateauthor .= ', '.$author;
	
define('FPDF_FONTPATH','fpdf/font/');  //definiuje katalog z czcionkami komponentu
require('fpdf/fpdf.php');  //odniesienie do skryptu komponentu
$pdf=new FPDF();
$pdf->Open();     //otwiera nowy dokument
$pdf->AddPage();    //dodaje now± stronê do dokumentu
$pdf->AddFont('times','','times.php');  //dodaje Twoj± czcionkê times do dokumentu
$pdf->AddFont('timesbd','','timesbd.php');  //dodaje Twoj± czcionkê timesbd do dokumentu
$pdf->AddFont('timesbi','','timesbi.php');  //dodaje Twoj± czcionkê timesbi do dokumentu
$pdf->AddFont('timesi','','timesi.php');  //dodaje Twoj± czcionkê timesi do dokumentu

$pdf->SetFont('timesi','',9);
$pdf->Multicell(0,3, $lang['articles_printfooter']."\n".$cfg['address']."/articles-show-".$p.".php\n\n\n\n", 0, 'L',0);

$pdf->SetFont('timesbd','',14);
$pdf->Multicell(0,5, $title, 0, 'L',0);   //tekst wieloliniowy o szeroko¶ci do prawej linii, wysoko¶ci linii 5, bez ramki, wyjustowany, bez t³a

$pdf->SetFont('timesi','',9);
$pdf->Multicell(0,3, $dateauthor, 0, 'L',0);

$pdf->SetFont('times','',12);
$in=array("&ndash;","<li>","&bdquo;","&rdquo;","<li>
","&rsquo;","&lsquo;");
$out=array("-","- ","&quot;","&quot;","- ","'","'");
$pdf->Multicell(0,5, "\n".html_entity_decode(strip_tags(str_replace($in,$out,$intro)))."\n\n".html_entity_decode(strip_tags(str_replace($in,$out,$moretext))), 0, 'J',0);

if($source!='') {
	$pdf->SetFont('timesbi','',12);
	$pdf->Multicell(0,5, "\n\n".$lang['articles_source'].": ".$source, 0, 'L',0);
}

$pdf->SetCompression(true);
$pdf->SetAuthor($author);  //ustawia autora dokumentu
$pdf->SetCreator('Dokument generowany przy pomocy skryptu');  //ustawia generator dokumentu
$pdf->SetTitle($title);  //ustawia tytu³ dokumentu

$pdf->SetDisplayMode(100);  //domy¶lne powiêkszenie dokumentu w przegl±darce
$pdf->SetMargins(20, 20 , 20);  //ustawia marginesy dla dokumentu

/* koñczy zabawê i generuje dokument */
ob_clean();
$pdf->Output('article'.date("YmdHis").'_'.$p.'.pdf',true);  //zamyka i generuje dokument
	
	}	
	
}

function tellafriend($p) {
global $cfg,$lang,$language_id;
	
if($_POST['friendemail']==true) {
	
	if(checkEmail($_POST['youremail'])==true && checkEmail($_POST['friendemail'])==true) {
		
$sql = sql("SELECT title FROM viscms_articles WHERE id = ".$p);
list($title) = dbrow($sql);
		
		$message = $lang['articles_tellafriend_cont1']." ".$_POST['yourname']." ".$lang['articles_tellafriend_cont2'].": \"".$title."\""."\n\n".$_POST['content']."\n\n".$lang['articles_tellafriend_cont3'].": ".$cfg['address']."/articles-show-".$p.".php";
		
		if(mail($_POST['friendname']." <".$_POST['friendemail'].">", $lang['articles_tellafriend_subject'], $message, "From: ".$_POST['yourname']." <".$_POST['youremail'].">")) $msg = '<div class="message">'.$lang['articles_tellafriend_sent'].'</div>';
		else $msg = '<div class="message">'.$lang['articles_tellafriend_nsent'].'</div>';
		
	} else $msg = '<div class="message">'.$lang['articles_tellafriend_email_nv'].'</div>';

  setcookie('msg',$msg,time()+60);
  header("Location: articles-show-".$p.".php");	
	
} else {
	
$sql = sql("SELECT title FROM viscms_articles WHERE active=1 AND id = ".$p);
if(list($title) = dbrow($sql)) {
	
echo '<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr valign="middle">
		<td class="header_td_bg">'.$lang['articles_tell_a_friend'].'</td>
	</tr>
</table>
	
	<table width="97%" align="center">
	<tr valign="top">
		<td><br />'.$lang['articles_article'].': <a href="articles-show-'.$p.'.php">'.$title.'</a></td>
	</tr>
	<tr valign="top">
		<td>

<form action="articles-tellafriend-'.$p.'.php" method="POST">';
	
	echo '<div align="center"><table>
	<tr valign="top">
		<td>'.$lang['articles_tellafriend_yourname'].':</td>
		<td><input type="text" name="yourname" class="articles_form_comm" /></td>
	</tr>
	<tr valign="top">
		<td>'.$lang['articles_tellafriend_youremail'].':</td>
		<td><input type="text" name="youremail" class="articles_form_comm" /></td>
	</tr>
	<tr valign="top">
		<td>'.$lang['articles_tellafriend_friendname'].':</td>
		<td><input type="text" name="friendname" class="articles_form_comm" /></td>
	</tr>
	<tr valign="top">
		<td>'.$lang['articles_tellafriend_friendemail'].':</td>
		<td><input type="text" name="friendemail" class="articles_form_comm" /></td>
	</tr>
	<tr valign="top">
		<td>'.$lang['articles_tellafriend_content'].':</td>
		<td><textarea name="content" class="articles_form_comm" rows="7"></textarea></td>
	</tr>
	<tr valign="top">
		<td colspan="2" style="text-align: center;"><br /><input type="hidden" name="step" value="1" /><input type="submit" value=" '.$lang['articles_comments_send'].' " class="button" /></td>
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