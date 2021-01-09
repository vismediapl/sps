<?php
if (!defined ('eStats')) die ();
if (!is_writeable ('conf/menu.php')) $Info[] = array ('%plugin_notwriteable%', 0);
$IMenu = 1;
function e_me_menu_option ($ID, $Array, $SMenu = 0) {
         global $Titles;
         return (e_config_row ('%plugin_position%', 'menu['.$ID.'][position]', (($SMenu == 2)?'':($GLOBALS[$SMenu?'ISMenu':'IMenu']++)), 2).e_config_row ('%plugin_id%', 'menu['.$ID.'][id]', $ID, 0).e_config_row ('%plugin_text%', 'menu['.$ID.'][text]', (isset ($Array['text'])?$Array['text']:''), 0).e_config_row ('%plugin_title%', 'menu['.$ID.'][title]', (isset ($Array['title'])?$Array['title']:''), 0).e_config_row ('%plugin_link%', 'menu['.$ID.'][link]', (isset ($Array['link'])?$Array['link']:''), 0));
         }
if (isset ($_POST['save'])) {
   $MData = '<?php
$Menu = array (
';
   $TMenus = $TSMenus = array ();
   foreach ($_POST['menu'] as $Key => $Value) {
           if (!$Value['id']) continue;
           if (strstr ($Value['id'], '|')) {
              $ID = explode ('|', $Value['id']);
              if ($Value['position']) $TSMenus[$ID[0]][$Value['position']] = $Value;
              else $TSMenus[$ID[0]][] = $Value;
              }
           else {
                if ($Value['position']) $TMenus[$Value['position']] = $Value;
                else $TMenus[] = $Value;
                }
           }
   ksort ($TMenus);
   $Menu[$_POST['menu_level']] = array ();
   foreach ($TMenus as $Key => $Value) {
           $Menu[$_POST['menu_level']][$Value['id']] = array ();
           if ($Value['text']) $Menu[$_POST['menu_level']][$Value['id']]['text'] = $Value['text'];
           if ($Value['title']) $Menu[$_POST['menu_level']][$Value['id']]['link'] = $Value['title'];
           if ($Value['link']) $Menu[$_POST['menu_level']][$Value['id']]['link'] = $Value['link'];
           if (isset ($TSMenus[$Value['id']])) {
              ksort ($TSMenus[$Value['id']]);
              foreach ($TSMenus[$Value['id']] as $Key2 => $Value2) {
                      $ID = explode ('|', $Value2['id']);
                      $Menu[$_POST['menu_level']][$Value['id']]['submenu'][$ID[1]] = array ();
                      if ($Value2['text']) $Menu[$_POST['menu_level']][$Value['id']]['submenu'][$ID[1]]['text'] = $Value2['text'];
                      if ($Value2['title']) $Menu[$_POST['menu_level']][$Value['id']]['submenu'][$ID[1]]['link'] = $Value2['title'];
                      if ($Value2['link']) $Menu[$_POST['menu_level']][$Value['id']]['submenu'][$ID[1]]['link'] = $Value2['link'];
                      }
              }
           }
   for ($MenuLevel = 0; $MenuLevel < 3; $MenuLevel++) {
       $MData.= '	array (
';
       foreach ($Menu[$MenuLevel] as $Key => $Value) {
               $MData.= '		\''.$Key.'\' => array (
';
               foreach ($Menu[$MenuLevel][$Key] as $Key2 => $Value2) {
                       if ($Key2 != 'submenu') $MData.= '			\''.$Key2.'\' => \''.$Value2.'\',
';
                       else {
                            $MData.= '			\'submenu\' => array (
';
                            foreach ($Value2 as $Key3 => $Value3) {
                                    $MData.= '				\''.$Key3.'\' => array (
';
                                     foreach ($Value3 as $Key4 => $Value4) $MData.= '					\''.$Key4.'\' => \''.$Value4.'\',
';
                                    $MData.= '					),
';
                                    }
                            $MData.= '				),
';

                            }

                       }

       $MData.= '			),
';

               }
       $MData.= '		),
';
       }
       $MData.= '	);
?>';
   if (file_put_contents ('conf/menu.php', $MData)) $Info[] = array ('%plugin_success%', 1);
   else $Info[] = array ('%plugin_error%', 0);
   include ('conf/menu.php');
   }
if (!isset ($_POST['menu_level'])) $_POST['menu_level'] = 0;
$MLSelect = '';
$Array = array ('user', 'loggedinuser', 'admin');
for ($i = 0; $i < 3; $i++) $MLSelect.= '<option value="'.$i.'"'.(($_POST['menu_level'] == $i)?' selected="selected"':'').'>%plugin_'.$Array[$i].'%</option>
';
$T['page'] = '<form action="{spath}" method="post" id="menu_editor">
<p>
<span>
<select name="menu_level" id="menu_level" tabindex="'.($TIndex++).'">
'.$MLSelect.'</select>
<input type="submit" value="%plugin_load%" tabindex="'.($TIndex++).'" class="button" />
</span>
<label for="menu_level">%plugin_menulevel%</label>:
</p>
'.e_announce ('%plugin_information%', 3).'<div style="margin:5px;">
';
foreach ($Menu[$_POST['menu_level']] as $Key => $Value) {
        $T['page'].= '<fieldset class="expanded" id="m_'.$Key.'">
<legend onclick="changeClassName (\'m_'.$Key.'\')">'.$Key.' - <em>'.(isset ($Value['text'])?$Value['text']:($Titles[$Key][isset ($Titles[$Key][2])?2:0])).' (<a href="'.(isset ($Value['link'])?$Value['link']:$T['path'].$Key).'" tabindex="'.($TIndex++).'">'.(isset ($Value['title'])?$Value['title']:$Titles[$Key][1]).'</a>)</em></legend>
<div>
'.e_me_menu_option ($Key, $Value).'<input type="button" value="%plugin_deleteoption%" onclick="removeOption (\'m_'.$Key.'\')" tabindex="'.($TIndex++).'" class="button" />
<input type="button" value="'.((isset ($Value['submenu']) && count ($Value['submenu']))?'%plugin_deletesub%':'%plugin_addsub%').'" onclick="ARSubmenu (\'sm_'.$Key.'\')" id="sm_'.$Key.'_switch" tabindex="'.($TIndex++).'" class="button" /><br />
<div id="sm_'.$Key.'"'.((isset ($Value['submenu']) && count ($Value['submenu']))?'':' style="display:none;"').'>
';
        if (isset ($Value['submenu']) && count ($Value['submenu'])) {
           $ISMenu = 1;
           foreach ($Value['submenu'] as $SKey => $SValue) $T['page'].= '<fieldset class="expanded" id="m_'.$Key.'_'.$SKey.'">
<legend onclick="changeClassName (\'m_'.$Key.'_'.$SKey.'\')">'.$SKey.' - <em>'.(isset ($SValue['text'])?$SValue['text']:($Titles[$SKey][isset ($Titles[$SKey][2])?2:0])).' (<a href="'.(isset ($SValue['link'])?$SValue['link']:$T['path'].$Key.'/'.$SKey).'" tabindex="'.($TIndex++).'">'.(isset ($SValue['title'])?$SValue['title']:$Titles[$SKey][1]).'</a>)</em></legend>
<div>
'.e_me_menu_option ($Key.'|'.$SKey, $SValue, 1).'<input type="button" value="%plugin_deleteoption%" onclick="removeOption (\'m_'.$Key.'_'.$SKey.'\')" tabindex="'.($TIndex++).'" class="button" />
</div>
</fieldset>
';
           }
        $T['page'].= '<span id="me_submenu_'.$Key.'"></span>
<input type="button" value="%plugin_addoption%" onclick="addOption (\'me_submenu_'.$Key.'\', \''.$Key.'\')" tabindex="'.($TIndex++).'" class="button" />
</div>
</div>
</fieldset>
';
        }
$T['page'].= '<span id="me_menu_main"></span>
<p>
<input type="button" value="%plugin_addoption%" onclick="addOption (\'me_menu_main\', 0)" tabindex="'.($TIndex++).'" class="button" />
</p>
</div>
<div class="buttons">
<input type="submit" onclick="if (!confirm (\'%confirm_save%\')) return false" name="save" value="%save%" tabindex="'.($TIndex++).'" class="button" />
<input type="reset" value="%reset%" tabindex="'.($TIndex++).'" class="button" />
</div>
</form>
<script type="text/javascript">
// <![CDATA[
function changeClassName (id) {
         document.getElementById(id).className = (document.getElementById(id).className == \'expanded\')?\'nexpanded\':\'expanded\';
         footer ();
         }
function hideAll () {
         a = document.getElementById(\'menu_editor\').getElementsByTagName(\'fieldset\');
         for (i = 0; i < a.length; i++) a[i].className = \'nexpanded\';
         footer ();
         }
function ARSubmenu (id) {
         Expanded = !(document.getElementById(id).style.display == \'none\');
         document.getElementById(id).style.display = (Expanded?\'none\':\'block\');
         document.getElementById(id + \'_switch\').value = (Expanded?\'%plugin_addsub%\':\'%plugin_deletesub%\');
         if (Expanded) {
            textarea = document.getElementById(id).getElementsByTagName(\'textarea\');
            for (i = 0; i < textarea.length; i++) textarea[i].disabled = 1;
            fieldset = document.getElementById(id).getElementsByTagName(\'fieldset\');
            for (i = 0; i < fieldset.length; i++) fieldset[i].style.display = \'none\';
            }
         footer ();
         }
function removeOption (id) {
         textarea = document.getElementById(id).getElementsByTagName(\'textarea\');
         for (i = 0; i < textarea.length; i++) textarea[i].disabled = 1;
         document.getElementById(id).style.display = \'none\';
         footer ();
         }
function addOption (id, v) {
         menuID = prompt (\'%plugin_setid%:\');
         if (!menuID) return (0);
         document.getElementById(id).innerHTML += \''.str_replace ('
', '\n', '<fieldset class="expanded" id="m_\' + (v?v + \'_\':\'\') + menuID + \'">
<legend onclick="changeClassName (\\\'m_\' + (v?v + \'_\':\'\') + menuID + \'\\\')"><em>%plugin_newoption%: \' + menuID + \'</em></legend>
<div>
'.e_me_menu_option ('\' + (v?v + \'|\':\'\') + menuID + \'', array (), 2).'<input type="button" value="%plugin_deleteoption%" onclick="removeOption (\\\'m_\' + (v?v + \'_\':\'\') + menuID + \'\\\')" class="button" />
\' + (v?\'\':\'<input type="button" value="%plugin_addsub%" onclick="ARSubmenu (\\\'sm_\' + menuID + \'\\\')" id="sm_\' + menuID + \'_switch" class="button" /><br />
<div id="sm_\' + menuID + \'" style="display:none;">
<span id="me_submenu_\' + menuID + \'"></span>
<input type="button" value="%plugin_addoption%" onclick="addOption (\\\'me_submenu_\' + menuID + \'\\\', \\\'\' + menuID + \'\\\')" class="button" />
</div>
\') + \'
</div>
</fieldset>
').'\';
         footer ();
         }
window.onload = hideAll ();
// ]]>
</script>
';
?>