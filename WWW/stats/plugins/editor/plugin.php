<?php
if (!defined ('eStats')) die ();
if (isset ($_POST['edit'])) $_GET['edit'] = $_POST['filename'];
if (isset ($_POST['delete'])) {
   if (unlink ($_POST['filename'])) $Info[] = array ($L['plugin_deletesuccessful'], 1);
   else $Info[] = array ($L['plugin_deleteerror'], 0);
   }
if (isset ($_GET['edit']) && !isset ($_POST['delete'])) {
   $_GET['edit'] = str_replace ('../', '', $_GET['edit']);
   if (!is_file ($_GET['edit'])) {
      if (!touch ($_GET['edit']) || !chmod ($_GET['edit'], 0666)) $Info[] = array ($L['plugin_createrror'], 0);
      else $Info[] = array ($L['plugin_createsuccessful'], 1);
      }
   }
if (isset ($_POST['save']) && is_writeable ($_POST['filename'])) {
   if (file_put_contents ($_POST['filename'], $_POST['contents'])) $Info[] = array ($L['plugin_savesuccesful'], 1);
   else $Info[] = array ($L['plugin_saveeror'], 1);
   }
$Files = array (
	'conf/config.php',
	'conf/menu.php',
	'var/robots.php',
	'var/websearchers.php',
	'var/browsers.php',
	'var/oses.php',
	'var/langs.php'
	);
$T['page'] = '<h3>%plugin_mainconfigfiles%</h3>
';
for ($i = 0, $c = count ($Files); $i < $c; $i++) $T['page'].= '<p>
<strong><em>'.$Files[$i].'</em> <a href="{spath}{separator}edit='.$Files[$i].'" tabindex="'.($TIndex++).'">[ %plugin_edit% ]</a>'.((substr (sprintf ('%o', fileperms ($Files[$i])), - 3) >= 666)?'':' <em class="red">%plugin_notwriteable%</em>').'</strong><br />
'.$L['plugin_file_'.$Files[$i]].'.
</p>
';
$T['page'].= '<h3>%plugin_fileediting%'.((isset ($_GET['edit']) && is_file ($_GET['edit']))?': '.$_GET['edit'].(is_writeable ($_GET['edit'])?'':' (%plugin_readonlymode%)'):'').'</h3>
<form action="{spath}'.((isset ($_GET['edit']) && is_file ($_GET['edit']))?'?edit='.str_replace ('"', '&#034;', $_GET['edit']):'').'" method="post">
<p>
'.e_announce ($L['plugin_backupwarning'], 2).'
</p>
<p>
<span>
<input name="filename" value="'.((isset ($_GET['edit']) && !isset ($_POST['delete']))?htmlspecialchars ($_GET['edit']):'').'" tabindex="'.($TIndex++).'" id="filename" />
</span>
<label for="filename">%plugin_path%</label>:
</p>
<div>
<textarea rows="50" cols="100" style="height:500px;white-space:nowrap;" name="contents">'.((isset ($_GET['edit']) && is_file ($_GET['edit']))?htmlspecialchars (file_get_contents($_GET['edit'])):'').'</textarea>
</div>
<div class="buttons">
<input type="submit" name="save" value="%save%" onclick="if (!confirm (\'%plugin_saveconfirm%\')) return false" tabindex="'.($TIndex++).'" class="button" />
<input type="submit" name="edit" value="%plugin_edit%" tabindex="'.($TIndex++).'" class="button" />
<input type="submit" name="delete" value="%delete%" onclick="if (!confirm (\'%plugin_deleteconfirm%\')) return false" tabindex="'.($TIndex++).'" class="button" />
<input type="reset" value="%reset%" tabindex="'.($TIndex++).'" class="button" />
</div>
</form>
';
?>