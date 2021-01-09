<?php
if (!defined ('eStats')) die ();
if (!include ('lib/chart.php')) e_error ('lib/chart.php', __FILE__, __LINE__);
else {
     $FName = 'cache/time';
     if (e_cache_status ($FName) || eEMODE || (eULEVEL == 2 && $RegenerateForAdmin)) {
        $Data = $DB->time ();
        e_save ($FName, $Data);
        }
     else {
          $Data = e_read ($FName);
          e_cache_info ($FName);
          }
     }
$Array = array ('last24hours', 'lastmonth', 'lastyear', 'lastyears', 'hourspopularity', 'dayspopularity');
for ($Mode = 0; !defined ('eCRITICAL') && $Mode < 6; $Mode++) {
    switch ($Mode) {
           case 0:
           $Today = e_date ('w');
           $Yesterday = (e_date ('w')?(e_date ('w') - 1):6);
           $Chart = '<tfoot>
<tr>
'.((23 - e_date ('G'))?'<th colspan="'.(23 - e_date ('G')).'" title="'.$Days[0][$Yesterday].'">
'.(in_array ($Yesterday, array (0, 6))?'<em>'.$Days[1][$Yesterday].'</em>':$Days[1][$Yesterday]).'
</th>
':'').((e_date ('G') + 1)?'<th colspan="'.(e_date ('G') + 1).'" title="'.$Days[0][$Today].'">
'.(in_array ($Today, array (0, 6))?'<em>'.$Days[1][$Today].'</em>':$Days[1][$Today]).'
</th>
':'').'<th>&nbsp;</th>
</tr>
</tfoot>
';
           break;
           case 1:
           $Chart = '<tfoot>
<tr>
'.((e_date ('t', strtotime ('last month')) - e_date ('j'))?'<th colspan="'.(e_date ('t', strtotime ('last month')) - e_date ('j')).'" title="'.$Months[0][(e_date ('n') - 1)?(e_date ('n') - 2):11].'">
'.$Months[1][(e_date ('n') - 1)?(e_date ('n') - 2):11].'
</th>
':'').'<th colspan="'. e_date ('j').'" title="'.$Months[0][e_date ('n') - 1].'">
'.$Months[1][e_date ('n') - 1].'
</th>
<th>&nbsp;</th>
</tr>
</tfoot>
';
           break;
           case 2:
           $Chart = '<tfoot>
<tr>
'.((12 - e_date ('n'))?'<th colspan="'.(12 - e_date ('n')).'" title="'.(e_date ('Y') - 1).'">
'.(e_date ('Y') - 1).'
</th>
':'').'<th colspan="'.e_date ('n').'" title="'.e_date ('Y').'">
'.e_date ('Y').'
</th>
<th>&nbsp;</th>
</tr>
</tfoot>
';
           break;
           default:
           $Chart = '';
           }
    $Page = '';
    $i = 0;
    if ($Mode == 5 && $WeekStartDay) {
       $Data[5][0] = array_merge (array_slice ($Data[5][0], $WeekStartDay), array_slice ($Data[5][0], 0, $WeekStartDay));
       $Data[5][1] = array_merge (array_slice ($Data[5][1], $WeekStartDay), array_slice ($Data[5][1], 0, $WeekStartDay));
       }
    for ($Key = 0, $c = count ($Data[$Mode][0]); $Key < $c; $Key++) {
        $N = $Key;
        switch ($Mode) {
               case 0:
               $N = (($Key < (24 - e_date ('G')))?((($H = $Key + e_date ('G') + 1) != 24)?$H:0):++$i);
               break;
               case 1:
               $N = (($Key < (e_date ('t', strtotime ('last month')) - e_date ('j')))?($Key + e_date ('j') + 1):++$i);
               break;
               case 2:
               $N = (($Key < (12 - e_date ('n')))?($Key + e_date ('n')):$i++);
               break;
               case 3:
               $N = ($Key + e_date ('Y') - 9);
               break;
               case 5:
               if ($WeekStartDay) {
                  $N += $WeekStartDay;
                  if ($N > 6) $N -= 7;
                  }
               }
        $MD = (($Mode == 2)?$Months:(($Mode == 5)?$Days:0));
        $Desc = ($MD?$MD[1][$N]:(($N < 10)?' '.$N:$N));
        if ($Mode == 1) {
           $WeekDay = e_date ('w', strtotime ((e_date ('Y') - (($Key < (e_date ('t') - e_date ('j')) && e_date ('n') == 1)?1:0)).'-'.(($N < e_date ('j'))?e_date ('m'):e_date ('m', strtotime ('last month'))).'-'.$N));
           if (in_array ($WeekDay, array (0, 6))) $Desc = '<em>'.$Desc.'</em>';
           }
        if ($Mode == 5 && in_array ($N, array (0, 6))) $Desc = '<em>'.$Desc.'</em>';
        $Page.= '<th'.((!in_array ($Mode, array (0, 3, 4)))?' title="'.($MD?$MD[0][$N]:(($Mode == 1)?$Days[0][$WeekDay]:$N)).'"':'').'>'.$Desc.'</th>
';
        }
    $Chart.= '<tbody>
<tr>
'.e_chart ($Data[$Mode], $Vars[2], $Mode).'</tr>
<tr>
'.$Page.'<th>{cbutton}</th>
</tr>
</tbody>
';
    $T[$Array[$Mode]] = e_parse ($Theme['chart'], array (
	'id' => $Mode,
	'title' => $L[$Array[$Mode]],
	'colspan' => (count ($Data[$Mode][0]) + 1),
	'chart' => $Chart,
	'summary' => e_summary ($Data[$Mode], $Vars[2], $Mode),
	'cbutton' => ((max ($Data[$Mode][0]) && !$TConfig['simpleCharts'])?'<input type="button" title="%showhidelevels%" onclick="levelsSH (\'chart_'.$Mode.'\')" id="chart_'.$Mode.'_switch" value="  &#06'.($Charts['showlevels']?2:0).';  " class="button" tabindex="'.($TIndex++).'" />':'&nbsp;'),
	'vprofile' => preg_replace ('#(\{tindex\})#e', '$TIndex++', str_replace ('{mode}', $Mode, $VProfile))
	));
    }
?>