<?php
if (!defined ('eStats')) die ();
if (!include ('conf/template.php')) e_error ('conf/template.php', __FILE__, __LINE__);
$TCTemplate = array (
	'header' => 0,
	'submenuSign' => 0,
	'blockRowValueLength' => 2,
	'detailedRowValueLength' => 2,
	'detailsRowValueLength' => 2,
	'type' => 0,
	'icons' => 1,
	'simpleCharts' => 1
	);
for ($i = 0, $c = count ($Dirs = glob ('themes/*', GLOB_ONLYDIR)); $i < $c; $i++) {
    $TName = basename ($Dirs[$i]);
    $ThemeConfig[$TName] = parse_ini_file ($Dirs[$i].'/theme.ini');
    foreach ($ThemeConfig[$TName] as $Key => $Value) $Array['Themes'][$TName][$Key] = array ($Value, $TCTemplate[$Key]);
    }
if (isset ($_POST['SConfig']) || isset ($_POST['RDefault'])) {
   $CArray = array ();
   $Reset = isset ($_POST['RDefault']);
   foreach ($Array as $Group => $Value) {
           foreach ($Value as $SGroup => $Option) {
                   if (is_array (reset ($Option))) {
                      foreach ($Option as $Field => $SOption) {
                              if ($Group == 'Themes') $CArray['ThemesConfig|'.$SGroup.'|'.$Field] = ($Reset?$ThemeConfig[$SGroup][$Field]:(isset ($_POST['Themes|'.$SGroup.'|'.$Field])?$_POST['Themes|'.$SGroup.'|'.$Field]:0));
                              else $CArray[$SGroup.'|'.$Field] = ($Reset?$Value[$SGroup][$Field][0]:(isset ($_POST[$SGroup.'|'.$Field])?stripslashes ($_POST[$SGroup.'|'.$Field]):0));
                              }
                      }
                   else $CArray[$SGroup] = ($Reset?$Value[$SGroup][0]:(isset ($_POST[$SGroup])?stripslashes ($_POST[$SGroup]):0));
                   }
           }
   $DB->config_set ($CArray);
   }
$T['page'] = '<div id="advanced">
<noscript>
'.e_announce ($L['announce_needjs'], 2).'</noscript>
<div id="search">
<span>
<label for="AdvancedSearch">%filter%</label>:&nbsp;
<input value="%search%" id="AdvancedSearch" onblur="if (!this.value) this.value = \'%search%\';if (this.value == \'%search%\') this.style.color = \'gray\';" onfocus="this.style.color = \'black\';if (this.value == \'%search%\') this.value = \'\';else search (this.value)" onkeydown="search (this.value)" tabindex="'.($TIndex++).'" style="padding:0 3px;" />
<input type="button" value="%search%" onclick="document.getElementById(\'AdvancedSearch\').focus ();search (document.getElementById(\'AdvancedSearch\').value);" tabindex="'.($TIndex++).'" class="button" /><br />
%meetingconditions%: <em id="ResultsAmount">{resultsamount}</em>.
</span>
<input type="checkbox" id="ShowAll" onclick="showAll ()" tabindex="'.($TIndex++).'" />
<label for="ShowAll">
%showall%
</label>
</div>
<form action="{spath}" method="post">
';
$T['resultsamount'] = 0;
foreach ($Array as $Group => $Value) {
        $T['page'].= '<fieldset class="expanded" id="g_'.$Group.'">
<legend class="parent" onclick="changeClassName (\'g_'.$Group.'\')" title="%group_'.$Group.'%">'.$Group.'</legend>
<div>
<i class="gdesc">%group_'.$Group.'%</i>
';
        foreach ($Value as $SGroup => $Option) {
                if (is_array (reset ($Option))) {
                   $T['page'].= '<fieldset class="expanded" id="g_'.$Group.'.'.$SGroup.'">
<legend onclick="changeClassName (\'g_'.$Group.'.'.$SGroup.'\')"'.(($Group != 'Themes')?' title="%group_'.$SGroup.'%"':'').'>'.$SGroup.'</legend>
<div>
'.(($Group != 'Themes')?'<i class="gdesc">%group_'.$SGroup.'%</i>
':'');
                   foreach ($Option as $Field => $SOption) {
                           if ($Group == 'Themes') $OValue = (isset ($ThemesConfig[$SGroup])?$ThemesConfig[$SGroup]:$ThemeConfig[$SGroup]);
                           else $OValue = $$SGroup;
                           if (in_array ($SGroup, array ('HowMany', 'CollectData'))) $LID = $Field;
                           else $LID = 'config_'.strtolower ((($Group == 'Themes')?'Themes':$SGroup).'_'.$Field);
                           $T['page'].= e_option_row ($SOption, $Field, (($Group == 'Themes')?'Themes|':'').$SGroup.'|'.$Field, $OValue[$Field], (isset ($L[$LID])?$L[$LID]:''));
                           $T['resultsamount']++;
                           }
                   $T['page'].= '</div>
</fieldset>
';
                   }
                else {
                     $LID = 'config_'.strtolower ($SGroup);
                     $T['page'].= e_option_row ($Option, $SGroup, $SGroup, $$SGroup, (isset ($L[$LID])?$L[$LID]:''));
                     $T['resultsamount']++;
                     }
                }
        $T['page'].= '</div>
</fieldset>
';
        }
$T['page'].= '<div class="buttons">
'.e_buttons ().'</div>
</form>
<script type="text/javascript">
// <![CDATA[
document.getElementById(\'AdvancedSearch\').style.color = \'gray\';
Expanded = 0;
ResultsAmount = {resultsamount};
ChangedValueString = \'%changedvalue%\';
SearchString = \'%search%\';
window.onload = hideAll ();
// ]]>
</script>
</div>
';
?>