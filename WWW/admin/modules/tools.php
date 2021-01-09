<?

###############################
#           visCMS            #
############-------############
#          VISMEDIA           #
#       www.vismedia.pl       #
#      biuro@vismedia.pl      #
###############################

## MODULE: TOOLS ##

include 'languages/'.$language.'/tools.php';

$level->AddLevel($lang['tools'],'?module=tools');

$vars = explode(',',$_GET['act']);
$var_1 = $vars[0];
$var_2 = $vars[1];
$var_3 = $vars[2];

###################################### 

if(auth()!=3)
switch(@$var_1) {

   case '':
   if(auth()==2)
   browse();
   break;

   case 'db_backup':
   if(auth()==2)
   db_backup();
   break;

   case 'db_delete':
   if(auth()==2 && $var_2!='')
   db_delete($var_2);
   break;

   case 'db_restore':
   if(auth()==2 && $var_2!='')
   db_restore($var_2);
   break;

   case 'db_optimalize':
   if(auth()==2)
   db_optimalize();
   break;

   case 'htpasswd':
   if(auth()==2)
   htpasswd();
   break;

   }

######################################

function browse() {
global $cfg,$lang,$level,$links;

// poziom
$level->AddIcon("add","?module=tools&amp;act=db_backup",$lang['tools_dbbackup']);
$level->ShowHead();

// linki
$links->AddLink($lang['tools_dbbackup'],"?module=tools&amp;act=db_backup");
$links->AddLink($lang['tools_dboptimalize'],"?module=tools&amp;act=db_optimalize");

$links->Show();

echo '<script language="javascript">
function confirmSubmit(p) {
switch (p)
{
case 1: var agree=confirm("'.$lang['confirm_submit'].'"); break;
case 2: var agree=confirm("'.$lang['tools_confirm_restore'].'\n\n'.$lang['tools_confirm_restore_1'].'"); break;
}
if (agree)
	return true ;
else
	return false ;
}
</script>';

$i=$btc=0;

$text = '<span class="message"><b>'.$lang['notice'].'</b></span> '.$lang['tools_htpasswd_info'].' <a href="?module=tools&act=htpasswd">'.$lang['tools_htpasswd_info_here'].'</a>';

$handle = opendir($cfg['backuppath']);
while ($file = readdir($handle)) {
	if ($file != "." && $file != ".." && $file != "index.php" && $file != ".htaccess" && $file != ".htpasswd" && $file != "licence.pdf") {
		$files[$i]=$file;
		$i++;
	}
}
closedir($handle);

	if($files[0]!='') {
		
		rsort($files);

// tworzenie nowej tabeli
$table = new Table('TableClass','TableClassHd',7,3);
$table->QuoteBeforeTable($text);
$table->NewCell($lang['tools_file'],560,'left','left','bottom','top');
$table->NewCell($lang['action'],150,'center','center','bottom','top');

$date=array();

		for($j=0;$j<$i;$j++) {
			
			$date1=explode("_",$files[$j]);
			$date2=explode("-",$date1[2]);
			$date3=$date1[1].' '.$date2[0].':'.$date2[1].':'.$date2[2];
			$date3=explode(".",$date3);
			$date[$j]=$date3[0];

$file_t = '<a href="'.$cfg['backuppath'].$files[$j].'" class="LinksOnGrey"><b>'.$files[$j].'</b></a><br /><span class="date">'.$date[$j].'</span>';

$select = new Select($j);
$select->Add(strtolower($lang['tools_restore']),'?module=tools&act=db_restore,'.$files[$j],' onclick="return confirmSubmit(2);"');
$select->Add(strtolower($lang['delete']),'?module=tools&act=db_delete,'.$files[$j],' onclick="return confirmSubmit(1);"');
$actions=$select->Ret();

// wylistowanie wartosci
$values = array($file_t,$actions);
$table->CellValue($values);

		}
		
$table->Show(); // pokaz tabele

$links->Show();

	} else {
		echo '<div class="message">'.$lang['tools_dbbackups_not_found'].'</div>';
		echo '<p align="center"><br/><a href="javascript:history.go(-1)"><b>'.$lang['back'].'</b></a></p>';
	}

}

function db_backup() {
global $cfg,$lang;

$backupFile = $cfg['backuppath'] . 'backup_' . date("Y-m-d_H-i-s") . '.sql.gz';

$backup = new Backup();
$backup->DumpMySQL();

if(file_exists($backupFile)) {
  $msg = '<div class="message">'.$lang['tools_backup_ok'].'</a></div>';  
  } else {
  $msg = '<div class="message">'.$lang['tools_backup_error'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=tools");
}

function db_optimalize() {
global $cfg,$lang;

$db=$cfg['sql_db'];

$result = mysql_list_tables ($db);
$i = 0;
$k = 0;
while ($i < mysql_num_rows ($result)) {
    $tb_names[$i] = mysql_tablename ($result, $i);
    $sql = sql('OPTIMIZE TABLE '.$tb_names[$i].'');
    if($sql==true) $k++;
    $i++;
}

if($k==mysql_num_rows ($result)) {
  $msg = '<div class="message">'.$lang['tools_optimalize_ok'].' <a href="'.$backupFile.'">'.str_replace($cfg['backuppath'],'',$backupFile).'</a></div>';  
  } else {
  $msg = '<div class="message">'.$lang['tools_optimalize_error'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=tools");

}

function db_delete($p) {
global $cfg,$lang;

$backupFile=$cfg['backuppath'].$p;

@unlink($backupFile);

if(!file_exists($backupFile)) {
  $msg = '<div class="message">'.$lang['tools_backup_del_ok'].'</div>';  
  } else {
  $msg = '<div class="message">'.$lang['tools_backup_del_error'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=tools");
}

function db_restore($p) {
global $cfg,$lang;

$backupFile=$cfg['backuppath'].$p;

$backup = new Backup();
$k = $backup->RestoreMySQL($backupFile);

if($k==true) {
  $msg = '<div class="message">'.$lang['tools_restore_ok'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['tools_restore_error'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=tools");
}

function htpasswd() {
global $cfg,$lang,$level;

$level->AddLevel($lang['tools_htpasswd'],'');
$level->ShowHead();

echo '<br />';

if ($_POST['user'] && $_POST['pass'])
{
	
	@chmod($cfg['backuppath'],0777);
	
	$dirname = dirname(__FILE__);
	$dirn=explode("/",$dirname);
	unset($dirn[sizeof($dirn)-1]);
	$dirname = implode("/",$dirn);
	
	$url = $dirname . "/" . $cfg['backuppath'] . ".htpasswd";
	
	$htaccess_txt  = "ErrorDocument 401 /errors/401.html" . "\n";
	$htaccess_txt  .= "ErrorDocument 403 /errors/403.html" . "\n";
	$htaccess_txt  .= "ErrorDocument 404 /errors/404.html" . "\n";
	$htaccess_txt  .= "ErrorDocument 500 /errors/500.html" . "\n\n";
	$htaccess_txt  .= "AuthType Basic" . "\n";
	$htaccess_txt .= "AuthName \"".$lang['tools_htpasswd_logdate']."\"" . "\n";
	$htaccess_txt .= "AuthUserFile $url" . "\n";
	$htaccess_txt .= "require valid-user" . "\n";

    $htpasswd_txt .= $_POST['user'].":".crypt($_POST['pass'],CRYPT_STD_DES)."\n"; 
	$htaccess= fopen($cfg['backuppath'] . ".htaccess", "w");
	$htpasswd= fopen($cfg['backuppath'] . ".htpasswd", "w");

	$fp1=fputs($htaccess, $htaccess_txt);
	$fp2=fputs($htpasswd, $htpasswd_txt);
	fclose($htaccess);
	fclose($htpasswd);
	
	@chmod($cfg['backuppath'],0755);
	
if($fp1>0 && $fp2>0) {
  $msg = '<div class="message">'.$lang['tools_htpasswd_ok'].'</div>';
  } else {
  $msg = '<div class="message">'.$lang['tools_htpasswd_error'].'</div>';
  }
  setcookie('msg',$msg,time()+60);
  header("Location: ?module=tools");

} else {

$action = '?module=tools&amp;act=htpasswd';

$form = new Form($action,'post');
$form->SetWidths('20%','80%');
$form->AddTextInput($lang['tools_htpasswd_user'],'user');
$form->AddPasswordInput($lang['tools_htpasswd_password'],'pass');
$form->AddHidden('step',1);
$form->SetSubmitImg('save');
$form->Show();
	
}

}

?>