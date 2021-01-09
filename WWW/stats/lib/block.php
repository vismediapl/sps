<?php
e_theme ('block');
$TYear = e_date ('Y');
if ($Vars[3] == e_date ('n') && $Vars[2] == $TYear) $Suffix = 'current-month';
else if ($Vars[2] == $TYear && !$Vars[3]) $Suffix = 'current-year';
else if ($Vars[2] || $Vars[3]) $Suffix = ($Vars[2]?$Vars[2]:'').($Vars[3]?'-'.$Vars[3]:'');
else $Suffix = '';
$FName = 'cache/'.$Vars[1].($Suffix?'-'.$Suffix:'');
if ((($Suffix == 'current-month' || $Suffix == 'current-year') && is_file ('data/'.$FName.'.dat') && e_date ('Ym', filemtime ('data/'.$FName.'.dat')) != e_date ('Ym')) || e_cache_status ($FName) || (eEMODE && isset ($_POST['HowMany'])) || (eULEVEL == 2 && $RegenerateForAdmin)) define ('eUCACHE', 1);
else {
     $Data = e_read ($FName);
     e_cache_info ($FName);
     }
$SOptions = array ();
$AForm = '';
foreach ($Groups as $Group => $Mode) {
        $Page = $Address = $AForm = '';
        if (eEMODE && (isset ($_POST['SConfig']) || isset ($_POST['RDefault']))) {
           if (isset ($_POST['RDefault'])) {
              include ('conf/template.php');
              $DArray = array_merge ($Array['Stats'], $Array['GUI']);
              }
           $HowMany[$Group] = $SOptions['HowMany|'.$Group] = (isset ($_POST['RDefault'])?$DArray['HowMany'][$Group][0]:$_POST['HowMany'][$Group]);
           $CollectData[$Group] = $SOptions['CollectData|'.$Group] = (isset ($_POST['RDefault'])?$DArray['CollectData'][$Group][0]:(isset ($_POST['CollectData'][$Group])?1:0));
           }
        $IsActive = $HowMany[$Group];
        if (eEMODE && isset ($_POST['HowMany'][$Group]) && !isset ($_POST['RDefault'])) $HowMany[$Group] = $_POST['HowMany'][$Group];
        if (defined ('eUCACHE')) $Data[$Group] = $DB->data ($Group, $HowMany[$Group], $Vars[2], $Vars[3]);
        if (eEMODE) {
           $AForm = '<h3>%settings%</h3>
'.($IsActive?'':e_announce ($L['announce_groupdisabled'], 2)).((!in_array ($Group, array ('vbrowsers', 'voses')) && !$CollectData[$Group])?e_announce ($L['announce_groupcollectingdisabled'], 2):'').'<p>
<span>
<select name="HowMany['.$Group.']" tabindex="'.($TIndex++).'" id="HowMany_'.$Group.'">
';
           $Max = (($HowMany[$Group] < $Data[$Group][2])?$Data[$Group][2]:$HowMany[$Group]);
           if ($Max < $MaxAdminGroupOptions) $Max = $MaxAdminGroupOptions;
           for ($j = 0; $j <= $Max; $j++) $AForm.= '<option'.(($j == $HowMany[$Group])?' selected="selected"':'').'>'.$j.'</option>
';
           $AForm.= '</select>
</span>
<label for="HowMany_'.$Group.'">'.sprintf ($L['itemsamount'], $IsActive).'</label>:
</p>
'.(in_array ($Group, array ('vbrowsers', 'voses'))?'':'<p>
<span>
<input type="checkbox" value="1" name="CollectData['.$Group.']"'.($CollectData[$Group]?' checked="checked"':'').' tabindex="'.($TIndex++).'" id="CollectData_'.$Group.'" />
</span>
<label for="CollectData_'.$Group.'">%groupdatacollectingenabled%</label>:
</p>
');
           }
        if (!$HowMany[$Group]) {
           $T[$Group] = $AForm;
           continue;
           }
        $TSwitch['block_'.$Group.'_info'] = $Data[$Group][2];
        $Num = 0;
        arsort ($Data[$Group][0]);
        foreach ($Data[$Group][0] as $Key => $Value) {
                $Key = trim ($Key);
                if ($Group == 'sites') {
                   $Address = $Key;
                   $Key = ($Value[1]?$Value[1]:$Key);
                   $Value = $Value[0];
                   }
                $RValue = $Key;
                if ($Key == '?') $RValue = $L[($Group == 'referrers')?'directentries':'unknown'];
                else if (in_array ($Group, array ('java', 'javascript', 'cookies'))) $RValue = $L[$Key?'yes':'no'];
                else if ($Group == 'flash' && !$Key) $RValue = $L['no'];
                if ($Group == 'voses' && substr ($RValue, 0, 6) == 'mobile') $RValue = substr ($RValue, 7);
                if ($Mode > 1) {
                   if ($Group == 'voses') $Icon = e_os_icon (explode (' ', $Key));
                   else if ($Group == 'langs') $Icon = e_lang_icon ($Key);
                   else if ($Group == 'screens') $Icon = e_icon (e_screen ($Key), (($Key == '?')?'%unknown%':$Key));
                   else if ($Group == 'vbrowsers' && strstr ($Key, ' ')) $Icon = e_icon (substr ($Key, 0, strrpos ($Key, ' ')), $Key);
                   else $Icon = e_icon ($Key);
                   }
                else $Icon = '';
                if ($Key == 'mobile' && $Group == 'oses') {
                   $RValue = $L['mobile'];
                   $Icon = e_icon ($Key, $RValue);
                   }
                if ($Icon) $Icon.= '
';
                if (eEMODE && ($Group == 'referrers' || $Group == 'keywords') && $Key != '?') {
                   if ($Group == 'referrers') $Referrer = parse_url ($Key);
                   $AOptions = '
<a href="{spath}{separator}'.(($Group == 'referrers')?'referrer='.$Referrer['host']:'keyword='.urlencode ($Key)).'" tabindex="'.($TIndex++).'" title="%block'.(($Group == 'referrers')?'referrer':'keyword').'%" onclick="if (!confirm (\'%confirm_'.(($Group == 'referrers')?'referrer':'keyword').'block%\')) return false"><strong>&#187;</strong></a>';
                   }
                else $AOptions = '';
                $Page.= e_parse ($Theme['block-row'], array (
	'title' => htmlspecialchars ($Key),
	'num' => ++$Num,
	'icon' => $Icon,
	'value' => (($Mode == 1 && $Key != '?')?'<a href="'.htmlspecialchars ($Address?$Address:$Key).'" tabindex="'.($TIndex++).'" title="'.$Key.'" rel="nofollow">':'').e_cut ($RValue, $TConfig['blockRowValueLength']).(($Mode == 1 && $Key != '?')?'</a>':'').$AOptions,
	'amount' => e_number ($Value),
	'percent' => round (($Value / $Data[$Group][1]) * 100, 2)
	));
                if ($Num == $HowMany[$Group] && eULEVEL != 2) break;
                }
            $T[$Group] = e_parse ($Theme['block'], array (
	'id' => $Group,
	'amount' => (int) $Data[$Group][2],
	'displayed' => (int) (($HowMany[$Group] > $Data[$Group][2])?$Data[$Group][2]:$HowMany[$Group]),
	'limit' => (int) $HowMany[$Group],
	'title' => $L[$Group],
	'rows' => $Page,
	'sum' => ($Data[$Group][1]?str_replace ('{amount}', e_number ($Data[$Group][1]), $Theme['block-amount']):$Theme['block-none']),
	'admin' => (eEMODE?str_replace ('{admin}', $AForm, $Theme['block-admin']):'')
	));
       }
if (eEMODE) {
   if (isset ($_POST['SConfig']) || isset ($_POST['RDefault'])) $DB->config_set ($SOptions);
   $T['adminbuttons'] = '<div class="buttons">
<input type="submit" value="%view%" tabindex="'.($TIndex++).'" class="button" />
'.e_buttons ().'</div>
';
   }
else $T['adminbuttons'] = '';
if (defined ('eUCACHE') && !eEMODE) e_save ($FName, $Data);
?>