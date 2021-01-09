<?

global $language_id,$language,$tt;

$vars = explode(',',$_GET['act']);
$var_1 = $vars[0];
$var_2 = $vars[1];
$var_3 = $vars[2];

if($var_1=='show') {
	
	if(is_numeric($var_2)) {

$sql = sql("SELECT title,text FROM viscms_static WHERE ident=".$var_2." AND language_id=".$language_id);
if(list($title,$text) = dbrow($sql)) {
	
echo '<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr valign="middle">
		<td class="header_td_bg">'.$title.'</td>
	</tr>
</table>
';

$msg = $_COOKIE['msg'];

if($msg!='') echo str_replace("\\","",$msg);
setcookie('msg',$msg,time()-60);
	
	echo "<br />\n";
	echo nbsp($text);
	
	if($text!='') $tt = 1;
	
	include 'modules/trainings.php';
	
switch($var_2) {

  case 62:
    training_showCatInc(101);
  break;

  case 63:
    training_showCatInc(102);
  break;

  case 64:
    training_showCatInc(103);
  break;

  case 65:
    training_showCatInc(104);
  break;

  case 66:
    training_showCatInc(105);
  break;

  case 69:
    training_showCatInc(106);
  break;

  case 89:
    training_showCatInc(107);
  break;

  case 70:
    training_showCatInc(108);
  break;

  case 100:
    training_showCatInc(109);
  break;

}	
	
	
	
	}
  }	
}

?>