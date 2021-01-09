<?php
if (!defined ('eStats')) die ();
if (isset ($_POST['SConfig']) || isset ($_POST['RDefault'])) {
   $CArray = array ();
   if (isset ($_POST['RDefault'])) {
      if (!include ('conf/template.php')) e_error ('conf/template.php', __FILE__, __LINE__);
      $DArray = $Array['Stats']['Backups'];
      }
   $SOptions = array ('profile', 'time', 'usertables', 'tablesstructure', 'replacedata');
   for ($i = 0, $c = count ($SOptions); $i < $c; $i++) $CArray['Backups|'.$SOptions[$i]] = (isset ($_POST['RDefault'])?$DArray[$SOptions[$i]][0]:(isset ($_POST[$SOptions[$i]])?(is_array ($_POST[$SOptions[$i]])?implode ('|', $_POST[$SOptions[$i]]):$_POST[$SOptions[$i]]):0));
   $DB->config_set ($CArray);
   }
if (isset ($_POST['SBackup'])) {
   $Data = file_get_contents ('data/backups/'.$_POST['BID'].'.sql.bak');
   $Ext = '';
   switch ($_POST['compress']) {
          case 'gzip':
          header ('Content-Encoding: gzip');
          $Size = strlen ($Data);
          $Data = gzcompress ($Data, 9);
          $Data = "\x1f\x8b\x08\x00\x00\x00\x00\x00".substr ($Data, 0, $Size);
          break;
          case 'bzip':
          $Data = bzcompress ($Data);
          $Ext = '.bz2';
          }
   header ('Content-Type: application/force-download');
   header ('Content-Disposition: attachment; filename=eStats_'.date ('Y-m-d', (int) $_POST['BID']).'_'.date ('Y-m-d').'.sql.bak'.$Ext);
   die (trim ($Data));
   }
if (isset ($_POST['DBackup'])) {
   $Error = 0;
   unlink ('data/backups/'.$_POST['BID'].'.sql.bak') or $Error = 1;;
   e_log (($Error?23:22), !$Error, 'ID: '.$_POST['BID']);
   }
if (isset ($_POST['RBackup'])) $DB->restore_backup ($_POST['BID']);
if (isset ($_POST['CBackup'])) {
   e_create_backup (array ($_POST['profile'], (isset ($_POST['usertables'])?$_POST['usertables']:array ()), (isset ($_POST['tablesstructure'])?1:0), (isset ($_POST['replacedata'])?1:0)));
   clearstatcache ();
   }
if (isset ($_FILES['UBackup']) && is_uploaded_file ($_FILES['UBackup']['tmp_name'])) {
   $BID = 'Upload-'.time ().'.user';
   move_uploaded_file ($_FILES['UBackup']['tmp_name'], 'data/backups/'.$BID.'.sql.bak');
   $DB->restore_backup ($BID);
   e_configuration (0, 1);
   e_configuration (1, 1);
   }
$BList = $SProfile = '';
$BTypes = array ('full', 'data', 'user');
for ($i = 0; $i < 3; $i++) {
    $SProfile.= '<option value="'.$BTypes[$i].'"'.(($BTypes[$i] == $Backups['profile'])?' selected="selected"':'').'>%backuptype'.$BTypes[$i].'%</option>
';
    $ABackups = array_reverse (glob ('data/backups/*.'.$BTypes[$i].'.sql.bak'));
    if ($l = count ($ABackups)) $BList.= '<optgroup label="'.$BTypes[$i].'">
';
    for ($j = 0; $j < $l; $j++) {
        $BTime = explode ('-', basename ($ABackups[$j]));
        $BList.= '<option value="'.basename ($ABackups[$j], '.sql.bak').'">'.(is_numeric ($BTime[0])?e_date ('d.m.Y H:i:s', $BTime[0]):$BTime[0]).' - '.e_date ('d.m.Y H:i:s', $BTime[1]).' ('.e_size (filesize ($ABackups[$j])).')</option>
';
        }
    if ($l) $BList.= '</optgroup>
';
   }
$SUserTables = '';
$DBTables = array_merge ($DBTables, array ('logs', 'configuration'));
sort ($DBTables);
for ($i = 0, $c = count ($DBTables); $i < $c; $i++) $SUserTables.= '<option'.(in_array ($DBTables[$i], $Backups['usertables'])?' selected="selected"':'').'>'.$DBTables[$i].'</option>
';
$T['page'] = '<h3>%managebackups%</h3>
<form action="{spath}" method="post" enctype="multipart/form-data">
'.e_config_row ($L['selectbackup'], 'BID', '', ($BList?'<select name="BID" id="BID" tabindex="'.($TIndex++).'">
'.$BList.'</select><br />
<input type="submit" name="SBackup" value="%download%" class="button" tabindex="'.($TIndex++).'" />
<label for="compress">%compression%</label>:
<select name="compress" id="compress" title="%compressiontype%">
<option value="">%none%</option>
<option selected="selected">gzip</option>
'.(extension_loaded ('bz2')?'<option>bzip</option>
':'').'</select>
<input type="submit" onclick="if (!confirm (\'%confirm_restore%\')) return false" name="RBackup" value="%restore%" class="button" tabindex="'.($TIndex++).'" />
<input type="submit" onclick="if (!confirm (\'%confirm_delete%\')) return false" name="DBackup" value="%delete%" class="button" tabindex="'.($TIndex++).'" />':'<strong>%nobackups%.</strong>')).e_config_row ($L['restorebackupfromhd'], 'UBackup', '', '<input type="file" name="UBackup" id="UBackup" tabindex="'.($TIndex++).'" />
<input type="submit" value="%send%" tabindex="'.($TIndex++).'" class="button" />').'</form>
<h3>%settings%</h3>
<form action="{spath}" method="post">
'.e_config_row ($L['config_backups_profile'], 'F_profile', '', '<select name="profile" id="F_profile" tabindex="'.($TIndex++).'" onchange="document.getElementById(\'UDefinied\').style.display = ((this.options[selectedIndex].value == \'user\')?\'block\':\'none\');footer ();">
'.$SProfile.'</select>').e_config_row ($L['config_backups_time'], 'time', $Backups['time'], 2).'<div id="UDefinied">
'.e_config_row ($L['config_backups_usertables'], 'F_usertables', '', '<select multiple="multiple" size="3" name="usertables[]" id="F_usertables" tabindex="'.($TIndex++).'">
'.$SUserTables.'</select>').e_config_row ($L['config_backups_tablesstructure'], 'tablesstructure', $Backups['tablesstructure'], 1).e_config_row ($L['config_backups_replacedata'], 'replacedata', $Backups['replacedata'], 1).'</div>
<div class="buttons">
'.e_buttons (1).'<input type="submit" name="CBackup" value="%createbackup%" tabindex="'.($TIndex++).'" class="button" />
</div>
</form>
<script type="text/javascript">
var show = '.(int) ($Backups['profile'] == 'user').';
document.getElementById(\'UDefinied\').style.display = (show?\'block\':\'none\');
</script>
';
?>