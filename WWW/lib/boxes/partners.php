<?
global $cfg,$lang,$language_id;

$n=0;


$sql = sql("SELECT A.id,B.name,A.logo,A.link FROM viscms_customers A, viscms_customers_descriptions B WHERE B.language_id=".$language_id." AND A.category='partner' AND A.id=B.customer_id AND A.active=1 ORDER BY A.position DESC LIMIT 0,".$cfg['cuslimitrows_partner']);
while(list($id,$name,$picture,$url) = dbrow($sql)) {
	
	if($url=='http://' || $url=='') $a1=$a2='';
	else {
		$a1='<a href="'.$url.'" target="_blank">';
		$a2='</a>';
	}
	
	$pct=explode(".",$picture);
	$ext=$pct[sizeof($pct)-1];

if($picture!='' && file_exists($cfg['cuspath'].$picture))
	if($ext=='swf') {
		
$size = @getSWFDimensions($cfg['cuspath'].$picture);

		$img = '<noscript>
    <object data="'.$cfg['cuspath'].$picture.'"
            width="'.$size[0].'" height="'.$size[1].'" type="application/x-shockwave-flash">
     <param name="allowScriptAccess" value="sameDomain" />
     <param name="movie" value="'.$cfg['cuspath'].$picture.'" />
     <param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />
    </object>
</noscript>
<script type="text/javascript">
//<!--
AC_RunFlContentX ("src","'.$cfg['cuspath'].$picture.'","quality","high","bgcolor","#ffffff","width","'.$size[0].'","height","'.$size[1].'","name","flash","align","middle","allowscriptaccess","sameDomain");
//-->
</script>';
		
	} else {
		$img = '<img src="'.$cfg['cuspath'].$picture.'" alt="'.$name.'" border="0" />';
	}
	
if($picture!='') {
	echo "\n";
	echo '<p align="center">'.$a1.$img.$a2.'</p>';
} else {
	echo "\n";
	echo '<p align="center">'.$a1.$name.$a2.'</p>';
}

}

?>