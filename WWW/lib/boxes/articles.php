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

echo '<table style="width: 100%;" align="center">
';
$sql = sql("SELECT id,date,author,title,intro,category_id,moretext FROM viscms_articles WHERE active=1 AND language_id = ".$language_id." AND category_id!=3 ORDER BY position DESC LIMIT 0,".$cfg['artlimitrows2']);
while(list($id,$date,$author,$title,$intro,$cid,$mt) = dbrow($sql)) {
	
	$sqlC = sql("SELECT name FROM viscms_articles_categories WHERE ident=".$cid." AND language_id = ".$language_id);
	list($catname) = dbrow($sqlC);
	
	if($mt!='') $mt_t = '<tr>
		<td style="text-align: right;"><a href="articles-show-'.$id.'.php" class="articles_footer">'.$lang['articles_readmore'].' &raquo;</a></td>
	</tr>';
	else $mt_t='';

							//$dateauthor = date("d.m.Y H:i",$date);
							$dateauthor = date("Y-m-d",$date);
							$dateauthor .= ', kategoria: '.$catname;
echo '	<tr>
		<td><a href="a'.$id.'_'.mod_rewrite($title).'.html" class="articles_title">'.$title.'</a></td>	
	</tr>
	<tr>
		<td>'.$intro.'<div class="dateauthor">'.$dateauthor.'</div></td>	
	</tr>
	'.$mt_t.'
	<tr>
		<td>&nbsp;</td>
	</tr>';

}
echo '</table>
		</td>
	</tr>
';
echo '</table>
    ';

?>