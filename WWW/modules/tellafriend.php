<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr valign="middle">
		<td class="header_td_bg">Poleæ stronê znajomemu</td>
	</tr>
</table>

<?

global $language,$lang;

include 'languages/'.$language.'/articles.php';
	
if($_POST['friendemail']==true) {
	
	if(checkEmail($_POST['youremail'])==true && checkEmail($_POST['friendemail'])==true) {
		
		$message = 'Witaj,

Twój znajomy '.$_POST['yourname'].' zachêca Ciê do obejrzenia strony STUDIA PROFILAKTYKI SPO£ECZNEJ

Zobacz koniecznie: http://www.sps.org.pl

'.$_POST['content'];
		
		if(mail($_POST['friendname']." <".$_POST['friendemail'].">", 'SPS.ORG.PL - zobacz koniecznie', $message, "From: ".$_POST['yourname']." <".$_POST['youremail'].">")) $msg = '<div class="message">Powiadomienie zosta³o wys³ane do Twojego znajomego</div>';
		else $msg = '<div class="message">Wyst±pi³ b³±d! Powiadomienie nie zosta³o wys³ane</div>';
		
	} else $msg = '<div class="message">Wyst±pi³ b³±d! Sprawd¼ czy wype³ni³e¶ wszystkie pola</div>';

  setcookie('msg',$msg,time()+60);
  header("Location: tellafriend.php");	
	
} else {
	
$msg = $_COOKIE['msg'];

if($msg!='') echo str_replace("\\","",$msg);
setcookie('msg',$msg,time()-60);
	
echo '<br />
	
	<table width="97%" align="center">
	<tr valign="top">
		<td>

<form action="tellafriend.php" method="post">';
	
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
<a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a>
</div>';
	
	echo '</form>
		
		</td>
	</tr>
</table>';
  }

?>