<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr valign="middle">
		<td class="header_td_bg">Kontrahenci</td>
	</tr>
</table>
<br />
<? new FreeSpace(56); ?>
<br /><div class="contractors_header">Interaktywna mapa naszych Kontrahentów</div><div style="font-size: 11px; font-weight: bold; text-align: center;">(kliknij myszk± na interesuj±ce Ciê województwo)</div>

<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th scope="col">&nbsp;</th>
  </tr>
  <tr>
    <td>
    
    <noscript>
    <object data="themes/<?=$cfg['theme'];?>/gfx/mapa_woj.swf"
            width="400" height="400" type="application/x-shockwave-flash">
     <param name="allowScriptAccess" value="sameDomain" />
     <param name="movie" value="themes/<?=$cfg['theme'];?>/gfx/mapa_woj.swf" />
     <param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />
    </object>
</noscript>
<script type="text/javascript">
//<!--
AC_RunFlContentX ("src","themes/<?=$cfg['theme'];?>/gfx/mapa_woj.swf","quality","high","bgcolor","#ffffff","width","400","height","400","name","flash","align","middle","allowscriptaccess","sameDomain","wmode","opaque");
//-->
</script>

</td>
  </tr>
</table>

<?

$vars = explode(',',$_GET['act']);
$var_1 = $vars[0];

if($var_1!='') {
	
	include 'languages/'.$language.'/contractors.php';
	
$districts = array(
'dolno¶l±skie',
'kujawsko-pomorskie',
'lubelskie',
'lubuskie',
'³ódzkie',
'ma³opolskie',
'mazowieckie','opolskie',
'podkarpackie',
'podlaskie',
'pomorskie',
'¶l±skie',
'¶wiêtokrzyskie',
'warmiñsko-mazurskie',
'wielkopolskie',
'zachodnio-pomorskie'
);


	for($i=0;$i<count($districts);$i++) {
		if($var_1==mod_rewrite($districts[$i])) {
			echo '<h1 align="center">'.$lang['contractors_district'].' '.$districts[$i].'</h1>';
			break;
		}
	}
	
	$sql = sql("SELECT text FROM viscms_contractors WHERE id='".sqlfilter($var_1,3)."' AND language_id='".$language_id."'");
	if(list($text)=dbrow($sql)) echo $text;

}

?>