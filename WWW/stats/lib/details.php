<?php
function e_details ($Data, $Mode) {
         global $L, $T, $TConfig, $Referrers, $TIndex;
         $Browser = e_browser ($Data[2]);
         $OS = e_os ($Data[2]);
         $Language = e_lang_name ($Data[5]);
         $Keywords = '';
         if (is_numeric (str_replace ('.', '', $Data[3])) || !$Data[3]) $Data[3] = '%unknown%';
         else if (strstr ($Data[3], '.') && eULEVEL < 2) $Data[3] = '*'.substr ($Data[3], strpos ($Data[3], '.'));
         if ($Data[4] && !$Data[12]) {
            $Referrer = parse_url ($Data[4]);
            if ($WebSearch = e_websearcher ($Referrer, 0)) $Keywords = implode (', ', $WebSearch[1]);
            if (in_array ($Referrer['host'], $Referrers) && eULEVEL < 2) $Data[4] = '';
            }
         return (e_parse ($GLOBALS['Theme'][$Mode?'detailed-row':'details'], array (
	'class' => ($Data[12]?'robot':((isset ($_SESSION['eVISITOR']) && $_SESSION['eVISITOR'][1] == $Data[0])?'user':(((time () - $Data[16]) < 300)?'online':''))),
	'id' => $Data[0],
	'first' => e_date ('d.m.Y<b\r />H:i:s', $Data[15]),
	'last' => e_date ('d.m.Y<b\r />H:i:s', $Data[16]),
	'visits' => (($Mode && $GLOBALS['Detailed']['showdetails'] && $Data[17])?'<a href="'.$T['path'].'details/'.$Data[0].'/1" title="%seedetails%" tabindex="'.($TIndex++).'"><strong>'.(int) $Data[17].'</strong></a>':(int) $Data[17]),
	'referrer' => (($Data[4] && !$Data[12])?'<a href="'.htmlspecialchars ($Data[4]).'" tabindex="'.($TIndex++).'" rel="nofollow"'.($Keywords?' title="%keywords%: '.$Keywords.'"':'').'>'.e_cut ($Data[4], $TConfig['detailedRowValueLength']).'</a>'.((eEMODE)?'
<a href="{spath}{separator}referrer='.$Referrer['host'].'" tabindex="'.($TIndex++).'"><strong '.(in_array ($Referrer['host'], $Referrers)?'class="green" title="%unblockreferrer%"':'title="%blockreferrer%" onclick="if (!confirm (\'%confirm_referrerblock%\')) return false"').'>&#187;</strong></a>':''):'&nbsp;'),
	'keywords' => e_cut ($Keywords, $TConfig['detailedRowValueLength'], 1),
	'host' => e_cut ($Data[3], $TConfig['detailedRowValueLength'], 1).((eEMODE)?'<br />
'.e_ignore_rule ($Data[1]):((eULEVEL == 2)?'<br />
'.$Data[1]:'')).((eULEVEL == 2 && $Data[1] != '127.0.0.1')?' ('.e_whois_link ($Data[1]).')':'').($Data[13]?'<br />
<strong title="'.htmlspecialchars ($Data[13]).'">%proxy%</strong>'.((eULEVEL == 2)?' ('.e_whois_link ($Data[14]).')':''):''),
	'useragent' => htmlspecialchars ($Data[2]),
	'configuration' => ($TConfig['icons']?(($Data[12])?e_icon ($Data[12]).'
':e_icon ($Browser[0], '%browser%: '.(($Browser[0] != '?')?trim (implode (' ', $Browser)):'%unknown%')).'
'.e_os_icon ($OS, 1).'
'.(($Data[5] != '?')?e_lang_icon ($Data[5], 1).'
':'').($Data[10]?e_icon (e_screen ($Data[10]), '%screenresolution%: '.$Data[10]).'
':'').(($Data[8] != 0 || $Data[8] == '?')?e_icon ('flash', '%flashversion%: '.(($Data[8] == '?')?'%unknown%':$Data[8]), 1).'
':'').($Data[9]?e_icon ('java', '%javaenabled%', 1).'
':'').($Data[6]?e_icon ('javascript', '%jsenabled%', 1).'
':'').($Data[7]?e_icon ('cookies', '%cookiesenabled%', 1).'
':'')):'<small>
%browser%: <em>'.(($Browser[0] != '?')?trim (implode (' ', $Browser)):'%unknown%').'</em>.<br />
%os%: <em>'.(($OS[0] != '?')?trim (implode (' ', $OS)):'%unknown%').'</em>.<br />
'.(($Data[5] != '?')?'%lang%: <em>'.$Language[2].'</em>.<br />
':'').($Data[10]?'%screenresolution%: <em>'.$Data[10].'</em>.<br />
':'').(($Data[8] != 0 || $Data[8] == '?')?'%flashversion%: <em>'.(($Data[8] == '?')?'%unknown%':$Data[8]).'</em><br />
':'').($Data[9]?'%javaenabled%.<br />
':'').($Data[6]?'%jsenabled%.<br />
':'').($Data[7]?'%cookiesenabled%.<br />
':'').'</small>
')
	)));
         }
$T['legend'] = $Theme['detailed-legend'];
?>