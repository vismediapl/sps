<?php
if (!defined ('eStats')) die ();
if (!include ('lib/chart.php')) e_error ('lib/chart.php', __FILE__, __LINE__);
else {
     for ($i = 0; $i < 2; $i++) {
         $FName = 'cache/archive-'.$Vars[2].($i?'':'-'.$Vars[3]);
         if (e_cache_status ($FName) || eEMODE || (eULEVEL == 2 && $RegenerateForAdmin)) {
            $Data[$i] = $DB->archive ($Vars[2], ($i?0:$Vars[3]));
            e_save ($FName, $Data[$i]);
            }
         else {
              $Data[$i] = e_read ($FName);
              if (!$i) e_cache_info ($FName);
              }
         }
     }
for ($Mode = 0; !defined ('eCRITICAL') && $Mode < 2; $Mode++) {
    $Page = '';
    for ($i = 0, $c = count ($Data[$Mode][0]); $i < $c; $i++) {
        $Desc = ($Mode?$Months[1][$i]:(($i < 9)?' '.($i + 1):($i + 1)));
        if (!$Mode) {
           $WeekDay = e_date ('w', strtotime ($Vars[2].'-'.(($Vars[3] < 10)?'0':'').$Vars[3].'-'.(($i < 9)?'0':'').($i + 1)));
           if (in_array ($WeekDay, array (0, 6))) $Desc = '<em>'.$Desc.'</em>';
           }
        $Page.= '<th title="'.($Mode?$Months[0][$i]:$Days[0][$WeekDay]).'">'.$Desc.'</th>
';
        }
         $T[$Mode?'year':'month'] = e_parse ($Theme['chart'], array (
	'id' => $Mode,
	'title' => ($Mode?$Vars[2]:$Months[0][$Vars[3] - 1].' '.$Vars[2]),
	'colspan' => (count ($Data[$Mode][0]) + 1),
	'chart' => '<tr>
'.e_chart ($Data[$Mode], $Vars[4], $Mode).'</tr>
<tr>
'.$Page.'<th>{cbutton}</th>
</tr>
',
	'summary' => e_summary ($Data[$Mode], $Vars[4], $Mode),
	'cbutton' => ((max ($Data[$Mode][0]) && !$TConfig['simpleCharts'])?'<input type="button" title="%showhidelevels%" onclick="levelsSH (\'chart_'.$Mode.'\')" id="chart_'.$Mode.'_switch" value="  &#06'.($Charts['showlevels']?2:0).';  " class="button" tabindex="'.($TIndex++).'" />':'&nbsp;'),
	'vprofile' => preg_replace ('#(\{tindex\})#e', '$TIndex++', str_replace ('{mode}', $Mode, $VProfile))
	));
   }
?>