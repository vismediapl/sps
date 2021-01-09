<?php
if (!defined ('eStats')) die ();
if (isset ($_POST['CBackup']) && !isset ($_POST['RCache']) && !isset ($_POST['RBackups'])) e_create_backup (array ('data'));
$DB->reset ();
if (isset ($_POST['RBackups']) || isset ($_POST['RAll']) || isset ($_POST['RCache'])) {
   $Files = glob (isset ($_POST['RBackups'])?'data/backups/*.bak':'data/cache/*');
   if (isset ($_POST['RAll'])) $Files = array_merge ($Files, glob ('data/backups/*.bak'));
   for ($i = 0, $c = count ($Files); $i < $c; $i++) unlink ($Files[$i]);
   if (!isset ($_POST['RAll'])) e_log ((isset ($_POST['RBackups'])?32:33), 1);
   }
$DBSize = $DB->db_size ();
$CSize = e_cache_size ();
$BInfo = e_backups ();
$ROptions = array (
	'All' => ($DBSize['all'] + $CSize + $BInfo[0]),
	'Detailed' => $DBSize['visitors'],
	'Backups' => $BInfo[0],
	'Cache' => $CSize
	);
$i = 0;
$T['page'] = '<form action="{spath}" method="post">
';
foreach ($ROptions as $Key => $Value) $T['page'].= e_config_row ($L['reset'.strtolower ($Key)].' (<strong>'.(($Key == 'All' && $DBSize['all'] == '?')?'>= ':'').e_size ($Value).'</strong>)', 'R'.$Key, '', '<input type="submit" onclick="if (!confirm (\'%confirm_delete%\')) return false" name="R'.$Key.'" value="%reset%" id="R'.$Key.'" class="button" tabindex="'.($TIndex++).'" />');
$RTSelect = '';
for ($i = 0, $c = count ($DBTables); $i < $c; $i++) if (!in_array ($DBTables[$i], array ('configuration', 'logs'))) $RTSelect.= '<option>'.$DBTables[$i].'</option>
';
$T['page'].= e_config_row ($L['resettable'], 'RTable', '', '<select name="RTable" id="RTable" tabindex="'.($TIndex++).'">
'.$RTSelect.'</select>
<input type="submit" onclick="if (!confirm (\'%confirm_delete%\')) return false" name="RSTable" value="%reset%" class="button" tabindex="'.($TIndex++).'" />').e_config_row ($L['resetcreatebackup'], 'CBackup', 1, 1).'</form>
';
?>