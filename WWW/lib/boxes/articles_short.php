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
	
	$sqlC = sql("SELECT name FROM viscms_articles_categories WHERE ident=".$cid." AND language_id = ".$language_id);
	list($catname) = dbrow($sqlC);

							//$dateauthor = date("d.m.Y H:i",$date);
							$dateauthor = date("Y-m-d",$date);
							$dateauthor .= ', kategoria: '.$catname;
echo '	<tr>
		<td><a href="a'.$id.'_'.mod_rewrite($title).'.html" class="articles_title_short'.$bt.'">'.$title.'</a><br /><span style="font-size: 7px;">&nbsp;</span></td>	
	</tr>';

}
echo '</table>
		</td>
	</tr>
';
echo '</table>
    ';


?>