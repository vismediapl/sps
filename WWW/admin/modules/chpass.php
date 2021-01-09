<?

###############################
#           visCMS            #
############-------############
#          VISMEDIA           #
#       www.vismedia.pl       #
#      biuro@vismedia.pl      #
###############################

## MODULE: CHANGE PASSWORD ##

include 'languages/'.$language.'/admins.php';

$level->AddLevel($lang['admins_chpass'],'?module=chpass');

$vars = explode(',',$_GET['act']);
$var_1 = $vars[0];
$var_2 = $vars[1];
$var_3 = $vars[2];

if(is_numeric($var_2) || $var_2=='') {

######################################

$var_2 = sqlfilter($var_2,6);

switch(@$var_1) {

   case '':
   chpass($var_2);
   break;

   }

######################################

}

function chpass() {
	global $cfg,$lang,$uid,$level;
	
$level->ShowHead();

if($_POST['step']==1) {
	
 	if($_POST['oldpass']!='')
  	$sqlP = sql("SELECT password FROM viscms_admins WHERE id=".$uid);
  	if(list($password) = dbrow($sqlP)) {
  		if($password!=md5($_POST['oldpass'])) 
  			$msg = '<div class="message">'.$lang['admins_pass_old_other'].'</div>';
  		else {
  			if($_POST['newpass1']!=$_POST['newpass2']) $msg = '<div class="message">'.$lang['admins_pass_new_other'].'</div>';
  			else {
  				$sql = sql("UPDATE viscms_admins SET password='".md5($_POST['newpass1'])."' WHERE id = ".$uid);
  				session_start();
  				unset($_SESSION['pass_admin']);
  				$_SESSION['pass_admin'] = md5($_POST['newpass1']);
  			}
  		}
  	}
  	
	if($sql==true) $msg .= '<div class="message">'.$lang['admins_pass_changed'].'</div>';
	else $msg .= '<div class="message">'.$lang['admins_pass_not_changed'].'</div>';
	setcookie('msg',$msg,time()+60);
	$_POST['step']=0;
  	header("Location: ?module=admins");
}else {

$action='?module=chpass';

	echo "<br/>";
	
$form = new Form($action,'post');
$form->SetWidths('20%','80%');
$form->AddPasswordInput($lang['admins_oldpass'],'oldpass');
$form->AddPasswordInput($lang['admins_newpass'],'newpass1');
$form->AddPasswordInput($lang['admins_newpassrepeat'],'newpass2');
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();
	
	}
}

?>