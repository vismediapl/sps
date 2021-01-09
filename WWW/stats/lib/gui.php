<?php
function e_theme ($File) {
         if (!is_file ('themes/'.$_SESSION['eTHEME'].'/'.$File.'.tpl')) $File = 'lib/theme/'.$File.'.tpl';
         else $File = 'themes/'.$_SESSION['eTHEME'].'/'.$File.'.tpl';
         if (!is_file ($File)) {
            e_error ($File, __FILE__, __LINE__);
            return (0);
            }
         $Theme = file_get_contents ($File);
         preg_match_all ('#\[start:(.*?)\](.*?)\[/end\]#si', $Theme, $Blocks);
         for ($i = 0, $c = count ($Blocks[0]); $i < $c; $i++) $GLOBALS['Theme'][$Blocks[1][$i]] = $Blocks[2][$i];
         }
function e_menu_option ($Key, $Value, $Parent = '') {
         global $Titles;
         $Active = (isset ($GLOBALS['Vars'][$Parent?2:1])?$GLOBALS['Vars'][$Parent?2:1]:'');
         if (isset ($Value['text']) || isset ($Titles[$Key][0]) || isset ($Titles[$Key][2])) return (e_parse ($GLOBALS['Theme'][($Parent?'sub':'').'menu-row'], array (
	'link' => (isset ($Value['link'])?$Value['link']:$GLOBALS['T']['path'].($Parent?$Parent.'/':'').$Key).$GLOBALS['Path']['suffix'],
	'title' => (isset ($Value['title'])?$Value['title']:$Titles[$Key][1]),
	'text' => (isset ($Value['text'])?$Value['text']:($Titles[$Key][isset ($Titles[$Key][2])?2:0])),
	'ssign' => (isset ($Value['submenu'])?$GLOBALS['TConfig']['submenuSign']:''),
	'class' => (($Key == $Active)?'active':''),
	'id' => $Parent.($Parent?'_':'').$Key,
	'tindex' => $GLOBALS['TIndex']++
	)));
         }
function e_links ($Page, $Amount, $Path) {
         $Links = array ();
         if ($Amount < 2) return ('');
         $Array = array_merge (array (
		'&#060;&#060;' => 1,
		'&#060;' => ($Page - 1)
		),
	range (1, $Amount),
	array (
		'&#062;' => ($Page + 1),
		'&#062;&#062;' => $Amount
		));
         foreach ($Array as $Key => $Value) {
                 if (is_numeric ($Key)) $Key = $Value;
                 if (!is_numeric ($Key) || ($Key >= ($Page - 2) && $Key <= ($Page + 2)) || $Key > ($Amount - 2) || $Key < 3) {
                    if ($Value > 0 && $Value <= $Amount && $Value != $Page) $Links[] = '<a href="'.str_replace ('<page>', $Value, $Path).'" tabindex="'.($GLOBALS['TIndex']++).'">'.$Key.'</a>';
                    else $Links[] = '<strong>'.$Key.'</strong>';
                    }
                 else if ($Key == ($Page - 3) || $Key == ($Page + 3)) $Links[] = '...';
                 }
         return ('<div class="links">
'.implode ('
|
', $Links).'
</div>
');
         }
function e_announce ($Content, $Type) {
         $Types = array ('error', 'success', 'warning', 'information');
         return (e_parse ($GLOBALS['Theme']['announcement'], array (
	'class' => $Types[$Type],
	'type' => $GLOBALS['L'][$Types[$Type]],
	'content' => $Content
	)));
         }
function e_date ($Format, $Time = 0) {
         return (date ($Format, (($Time?$Time:time ()) + $GLOBALS['Offset'])));
         }
function e_screen ($Width) {
         $Array = array (0, 800, 1024, 1280, 1600, 5000);
         if ((int) $Width) for ($i = 0; $i < 5; $i++) if ((int) $Width >= $Array[$i] && (int) $Width < $Array[$i + 1]) return ('screen_'.$i);
         return (($Width == '?')?'?':'screen_4');
         }
function e_icon ($Name, $Title = 0, $Theme = 0) {
         if (!is_dir ('icons/') || !$GLOBALS['TConfig']['icons']) return ('');
         $FName = ($Theme?'themes/'.$_SESSION['eTHEME'].'/':'').'icons/'.((substr ($Name, 0, 6) != 'flags/')?str_replace (array (' ', '/'), '', strtolower ($Name)):$Name).'.png';
         if ($Name == '?') {
            if (!$Title) $Title = '%unknown%';
            $Name = 'Unknown';
            $Theme = 1;
            }
         else if (!is_file ($FName)) {
                 $Name = 'N/A';
                 $Theme = 1;
                 }
         if ($Theme) $FName = 'themes/'.$_SESSION['eTHEME'].'/icons/'.str_replace ('/', '', strtolower ($Name)).'.png';
         return ('<img src="'.$GLOBALS['T']['dpath'].$FName.'" alt="'.($Title?$Title:$Name).'" title="'.($Title?$Title:$Name).'" />');
         }
function e_lang_name ($Name) {
         global $Languages, $Countries, $LL, $LC;
         $Lang = explode ('-', strtolower ($Name));
         $GLOBALS['RValue'] = $Lang[2] = (isset ($Languages[$Lang[0]])?(isset ($LL[$Lang[0]])?$LL[$Lang[0]]:$Languages[$Lang[0]][0]):'%unknown%').((isset ($Lang[1]) && isset ($Countries[$Lang[1]]))?' ('.(isset ($LC[$Lang[1]])?$LC[$Lang[1]]:$Countries[$Lang[1]]).')':'');
         if (!isset ($Lang[1])) $Lang[1] = (isset ($Languages[$Lang[0]][1])?$Languages[$Lang[0]][1]:'');
         return ($Lang);
         }
function e_lang_icon ($Name, $Prefix = 0) {
         $Lang = e_lang_name ($Name);
         return (e_icon ((is_file ('icons/flags/'.$Lang[1].'.png')?'flags/'.$Lang[1]:'?'), ($Prefix?'%lang%: ':'').$Lang[2]));
         }
function e_os_icon ($Array, $Prefix = 0) {
         if ((!isset ($Array[1]) || !$Array[1]) && $Array[0] != '?') return (e_icon ($Array[0], ($Prefix?'%os%: ':'').$Array[0]));
         if ($Array[0] == 'Windows') {
            if ($Array[1] == 'Vista') return (e_icon ('win-new', ($Prefix?'%os%: ':'').'Windows '.$Array[1]));
            if (in_array ($Array[1], array ('2003', 'XP'))) return (e_icon ('windows', ($Prefix?'%os%: ':'').'Windows '.$Array[1]));
            return (e_icon ('win-old', ($Prefix?'%os%: ':'').'Windows '.$Array[1]));
            }
         if ($Array[0] == 'Linux') return (e_icon ($Array[1], ($Prefix?'%os%: ':'').'Linux '.$Array[1]));
         if ($Array[0] == 'MacOS') {
            if ($Array[1] == 'X') return (e_icon ('macosx', ($Prefix?'%os%: ':'').'MacOS X'));
            return (e_icon ('macos', ($Prefix?'%os%: ':'').'MacOS Classic'));
            }
         if ($Array[0] == 'mobile') {
            $Name = explode (' ', $Array[1]);
            return (e_icon ($Name[0], ($Prefix?'%os%: ':'').$Array[1].(isset ($Array[2])?' '.$Array[2]:'')));
            }
         return (e_icon ('?', ($Prefix?'%os%: ':'').'%unknown%'));
         }
function e_parse ($Theme, $Array, $Start = 0, $End = 0) {
         if (!$Start) {
            $Start = '{';
            $End = '}';
            }
         if (!$End) $End = $Start;
         foreach ($Array as $Key => $Value) $Theme = str_replace ($Start.$Key.$End, $Value, $Theme);
         return ($Theme);
         }
function e_number ($Num) {
         return ('<em'.(($Num >= 1000 || is_float ($Num))?' title="'.round ($Num, 5).'"':'').'>'.(($Num < 1000)?round ($Num, 2):(($Num < 1000000)?(round ($Num / 1000, 1)).'K':(round ($Num / 1000000, 1)).'M')).'</em>');
         }
function e_size ($Size) {
         if ($Size === '?') return ('N/A');
         return (($Size > 1024)?(($Size > 1048576)?round ($Size / 1048576, 2).' MB':round ($Size / 1024, 2).' KB'):((int) $Size).' B');
         }
function e_cache_status ($File) {
         global $DBCache, $Vars;
         $File.= '_'.$GLOBALS['DBID'];
         return ($DBCache[$Vars[1]] && (!is_file ('data/'.$File.'.dat') || (time () - filemtime ('data/'.$File.'.dat')) > $DBCache[$Vars[1]]));
         }
function e_cache_info ($FName) {
         $GLOBALS['Info'][] = array (sprintf ($GLOBALS['L']['datafromcache'], e_date ('d.m.Y H:i:s', filemtime ('data/'.$FName.'_'.$GLOBALS['DBID'].'.dat'))), 3);
         }
function e_cut ($String, $Length, $Title = 0) {
         if (!$Length) return ($String);
         if (!function_exists ('mb_substr')) return ((strlen ($String) > $Length + 3)?($Title?'<span title="'.htmlspecialchars ($String).'">'.htmlspecialchars (substr_replace ($String, '...', $Length)).'</span>':htmlspecialchars (substr_replace ($String, '...', $Length))):htmlspecialchars ($String));
         else return ((mb_strwidth ($String, 'UTF-8') > $Length + 3)?($Title?'<span title="'.htmlspecialchars ($String).'">'.htmlspecialchars (mb_substr ($String, 0, $Length, 'UTF-8')).'...</span>':htmlspecialchars (mb_substr ($String, 0, $Length, 'UTF-8')).'...'):htmlspecialchars ($String));
         }
function e_ignore_rule ($IP) {
         global $IgnoredIPs;
         for ($i = 0, $c = count ($IgnoredIPs); $i < $c; $i++) if ($IP == $IgnoredIPs[$i] || (strstr ($IgnoredIPs[$i], '*') && substr ($IP, 0, (strlen ($IgnoredIPs[$i]) - 1)) == substr ($IgnoredIPs[$i], 0, -1))) return ('<a href="{spath}{separator}IP='.$IgnoredIPs[$i].'" title="%unblockip'.(($IP == $IgnoredIPs[$i])?'':'range').'%'.(($IP == $IgnoredIPs[$i])?'':' ('.$IgnoredIPs[$i].')').'" tabindex="'.($GLOBALS['TIndex']++).'"><strong class="green">'.$IP.'</strong></a>');
         return ('<a href="{spath}{separator}IP='.$IP.'" title="%blockip%" onclick="if (!confirm (\'%confirm_ipblock%\')) return false" tabindex="'.($GLOBALS['TIndex']++).'"><strong>'.$IP.'</strong></a>');
         }
function e_whois_link ($Data) {
         return ('<a href="'.str_replace ('[data]', htmlspecialchars ($Data), $GLOBALS['WhoisLink']).'" tabindex="'.($GLOBALS['TIndex']++).'">%whois%</a>');
         }
function e_buttons ($Backups = 0) {
         $Buttons = '';
         $i = 0;
         $Array = array (
	'save' => '%confirm_save%',
	'defaults' => '%confirm_defaults%',
	'reset' => ''
	);
         foreach ($Array as $Key => $Value) $Buttons.= '<input type="'.($Value?'submit':'reset').'"'.(($Value || $Backups)?' onclick="'.($Value?'if (!confirm (\''.$Value.'\')) return false':'document.getElementById(\'UDefinied\').style.display = (show?\'block\':\'none\');footer ();').'"':'').' value="%'.$Key.'%"'.(($i !=2 )?' name="'.($i++?'RDefault':'SConfig').'"':'').' tabindex="'.($GLOBALS['TIndex']++).'" class="button" />
';
         return ($Buttons);
         }
?>