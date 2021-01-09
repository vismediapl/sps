<?php
if (!defined ('eStats')) die ();
$CArray = array ();
if (isset ($_POST['SConfig']) || isset ($_POST['RDefault'])) {
   if (isset ($_POST['RDefault'])) {
      if (!include ('conf/template.php')) e_error ('conf/template.php', __FILE__, __LINE__);
      $DArray = array_merge ($Array['Stats'], $Array['GUI']);
      }
   $SOptions = array ('Pass', 'Time', 'AntyFlood', 'LogEnabled', 'CountPhrases', 'Antipixel', 'DefaultTheme', 'Path|mode', 'Path|prefix', 'Path|separator');
   if (!isset ($_POST['RDefault'])) {
      if (isset ($_POST['Path_Mode'])) {
         $_POST['Path|mode'] = 1;
         $_POST['Path|prefix'] = 'index.php/';
         $_POST['Path|separator'] = '?';
         }
      else {
           $_POST['Path|mode'] = 0;
           $_POST['Path|prefix'] = 'index.php?vars=';
           $_POST['Path|separator'] = '&amp;';
           }
      }
   for ($i = 0, $c = count ($SOptions); $i < $c; $i++) {
       if (!$i && !isset ($_POST['RDefault'])) $CArray[$SOptions[$i]] = ($_POST['Pass']?md5 ($_POST['Pass']):'');
       else {
            if (strstr ('|', $SOptions[$i])) $SOptions[$i] = explode ('|', $SOptions[$i]);
            $CArray[$SOptions[$i]] = (isset ($_POST['RDefault'])?(is_array ($SOptions[$i])?$DArray[$SOptions[$i][0]][$SOptions[$i][1]][0]:$DArray[$SOptions[$i]][0]):(isset ($_POST[$SOptions[$i]])?$_POST[$SOptions[$i]]:0));
            }
       }
   $DB->config_set ($CArray);
   }
if (isset ($_POST['CPass'])) {
   if (md5 ($_POST['APass_0']) == $AdminPass && $_POST['APass_1'] == $_POST['APass_2']) {
      e_log (12, 1);
      $CArray['AdminPass'] = $_SESSION['ePASS'] = md5 ($_POST['APass_1']);
      if (isset ($_COOKIE[$UID])) setcookie ($UID, md5 ($_SESSION['ePASS'].$UID), time () + $RemeberTime, $T['dpath']);
      $DB->config_set ($CArray, 0);
      }
   else {
        e_log (13);
        if (md5 ($_POST['APass_0']) !== $AdminPass) {
           $_SESSION['ePASS'] = '';
           die (header ('Location: ?logout'));
           }
        else $Info[] = array ($L['announce_differentpass'], 0);
        }
   }
$Configuration = array (
	'Pass' => ($Pass?'*':''),
	'Time' => $Time,
	'AntyFlood' => $AntyFlood,
	'Path_Mode' => $Path['mode'],
	'LogEnabled' => $LogEnabled,
	'CountPhrases' => $CountPhrases
	);
$T['page'] = '<form action="{spath}" method="post">
<h3>%adminpass%</h3>
';
$Keys = array ('currentpass', 'newpass', 'repeatpass');
for ($i = 0; $i < 3; $i++) $T['page'].= e_config_row ($L[$Keys[$i]], 'APass_'.$i, '', '<input type="password" name="APass_'.$i.'" id="APass_'.$i.'" tabindex="'.($TIndex++).'" />');
$T['page'].= '<div class="buttons">
<input type="submit" name="CPass" value="%changepass%" tabindex="'.($TIndex++).'" class="button" />
</div>
</form>
<form action="{spath}" method="post">
<h3>%settings%</h3>
';
$i = 0;
foreach ($Configuration as $Key => $Value) $T['page'].= e_config_row ($L['config_'.strtolower ($Key)], 'F_'.$Key, '', '<input'.((++$i > 3)?' type="checkbox"'.($Value?' checked="checked"':''):'').' name="'.$Key.'" value="'.htmlspecialchars (($i > 3)?1:$Value).'" id="F_'.$Key.'" tabindex="'.($TIndex++).'" />');
$Antipixels = '';
$Dirs = glob ('antipixels/*');
for ($i = 0, $c = count ($Dirs); $i < $c; $i++) {
    if (is_dir ($Dirs[$i])) {
       if ($Num = count ($Images = glob ($Dirs[$i].'/*.{png,gif,jpg}', GLOB_BRACE))) $Antipixels.= '<optgroup label="'.ucfirst (basename ($Dirs[$i])).'">
';
       for ($v = 0; $v < $Num; $v++) $Antipixels.= '<option value="'.($AID = str_replace ('antipixels/', '', dirname ($Images[$v])).'/'.basename ($Images[$v])).'"'.(($Antipixel == $AID)?' selected="selected"':'').'>'.ucfirst (str_replace ('_', ' ', basename ($Images[$v]))).'</option>
';
       if ($Num) $Antipixels.= '</optgroup>
';
       }
    }
$T['page'].= e_config_row ($L['config_antipixel'], 'F_Antipixel', 0, '<select name="Antipixel" id="F_Antipixel" onchange="document.getElementById(\'apreview\').src =\''.dirname ($_SERVER['SCRIPT_NAME']).'/antipixels/\' + this.options[selectedIndex].value">
'.$Antipixels.'</select>
<img src="'.dirname ($_SERVER['SCRIPT_NAME']).'/antipixels/'.$Antipixel.'" alt="Preview" id="apreview" />');
$Files = glob ('themes/*');
$TList = '';
for ($i = 0, $c = count ($Files); $i < $c; $i++) if (is_dir ($Files[$i])) $TList.= '<option'.((basename ($Files[$i]) == $DefaultTheme)?' selected="selected"':'').'>'.basename ($Files[$i]).'</option>
';
$T['page'].= e_config_row ($L['config_defaulttheme'], 'F_DefaultTheme', '', '<select name="DefaultTheme" id="F_DefaultTheme">
'.$TList.'</select>').'<div class="buttons">
'.e_buttons ().'<input type="button" onclick="location.href=\'{path}admin/advanced{suffix}\'" value="%advanced%" class="button" />
</div>
</form>
';
?>