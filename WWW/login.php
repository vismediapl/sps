<?

ob_start();
session_start();

include 'config.php';
include "lib/inc/mysql.php";
include "lib/inc/functions.php";

$admin=addslashes($_POST['login_admin']);
$pass_admin=addslashes(md5( $_POST['pass_admin'] ));

if($_POST['login_admin']==true) {
	$sql = sql("SELECT clog_last_time,clog_last_IP,uclog_last_time,uclog_last_IP FROM viscms_admins WHERE login='".$admin."'");
	list($ctime,$cip,$uctime,$ucip) = dbrow($sql);
	session_register("admin", "pass_admin", "ctime", "cip", "uctime", "ucip");
	$sqlx1 = sql("SELECT id FROM viscms_admins WHERE login='".$admin."' AND password='".$pass_admin."'");
	if(mysql_num_rows($sqlx1)==1) {
		$sqlx1 = sql("UPDATE viscms_admins SET clog_last_time='".time()."', clog_last_IP='".$_SERVER['REMOTE_ADDR']."' WHERE login='".$admin."'");
	}
	$sqlx2 = sql("SELECT id FROM viscms_admins WHERE login='".$admin."' AND password!='".$pass_admin."'");
	if(mysql_num_rows($sqlx2)==1) {
		$sqlx1 = sql("UPDATE viscms_admins SET uclog_last_time='".time()."', uclog_last_IP='".$_SERVER['REMOTE_ADDR']."' WHERE login='".$admin."'");
	}
	header('Location: '.$_SERVER['HTTP_REFERER']);
}

$user=addslashes($_POST['login_user']);
$pass_user=addslashes(md5( $_POST['pass_user'] ));

if($_POST['login_user']==true) {
	$sql = sql("SELECT clog_last_time,clog_last_IP,uclog_last_time,uclog_last_IP FROM viscms_members WHERE login='".$user."'");
	list($ctime,$cip,$uctime,$ucip) = dbrow($sql);
	session_register("user", "pass_user", "ctime", "cip", "uctime", "ucip");
	$sqlx1 = sql("SELECT id FROM viscms_members WHERE login='".$user."' AND password='".$pass_user."'");
	if(mysql_num_rows($sqlx1)==1) {
		$sqlx1 = sql("UPDATE viscms_members SET clog_last_time='".time()."', clog_last_IP='".$_SERVER['REMOTE_ADDR']."' WHERE login='".$user."'");
		if(!strstr($_SERVER['HTTP_REFERER'],'logout.php')) $referer = $_SERVER['HTTP_REFERER'];
		else $referer = 'index.php';
	} else {
		list($test_mod)=explode("-",$_SERVER['HTTP_REFERER']);
		$tm=explode("/",$test_mod);
		$test_mod=end($tm);
		if($test_mod=='discounts') $referer = $_SERVER['HTTP_REFERER'];
		else $referer = 'user.php';
	}
	$sqlx2 = sql("SELECT id FROM viscms_members WHERE login='".$user."' AND password!='".$pass_user."'");
	if(mysql_num_rows($sqlx2)==1) {
		$sqlx1 = sql("UPDATE viscms_members SET uclog_last_time='".time()."', uclog_last_IP='".$_SERVER['REMOTE_ADDR']."' WHERE login='".$user."'");
	}
	echo $error;
	header("Location: ".$referer);
}

$owner=addslashes($_POST['login_owner']);
$pass_owner=addslashes(md5( $_POST['pass_owner'] ));

if($_POST['login_owner']==true) {
	$sql = sql("SELECT clog_last_time,clog_last_IP,uclog_last_time,uclog_last_IP FROM viscms_party_owners WHERE login='".$owner."'");
	list($ctime,$cip,$uctime,$ucip) = dbrow($sql);
	session_register("owner", "pass_owner", "ctime", "cip", "uctime", "ucip");
	$sqlx1 = sql("SELECT id FROM viscms_party_owners WHERE login='".$owner."' AND password='".$pass_owner."'");
	if(mysql_num_rows($sqlx1)==1) {
		$sqlx1 = sql("UPDATE viscms_party_owners SET clog_last_time='".time()."', clog_last_IP='".$_SERVER['REMOTE_ADDR']."' WHERE login='".$owner."'");
		if(!strstr($_SERVER['HTTP_REFERER'],'logout.php')) $referer = $_SERVER['HTTP_REFERER'];
		else $referer = 'index.php';
	} else {
		$referer = 'owner.php';
	}
	$sqlx2 = sql("SELECT id FROM viscms_party_owners WHERE login='".$owner."' AND password!='".$pass_owner."'");
	if(mysql_num_rows($sqlx2)==1) {
		$sqlx1 = sql("UPDATE viscms_party_owners SET uclog_last_time='".time()."', uclog_last_IP='".$_SERVER['REMOTE_ADDR']."' WHERE login='".$owner."'");
	}
	header("Location: ".$referer);
}

?>