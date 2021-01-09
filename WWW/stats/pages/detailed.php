<?php
if (!defined ('eStats')) die ();
if (!include ('lib/details.php')) e_error ('lib/details.php', __FILE__, __LINE__);
$T['rows'] = '';
if (!isset ($Vars[2])) $Vars[2] = $Detailed['showrobots'];
if (!isset ($Vars[3])) $Vars[3] = 1;
$Vars[2] = (int) $Vars[2];
$Vars[3] = (int) $Vars[3];
$FName = 'cache/detailed'.($Vars[2]?'':'-norobots');
if ($Vars[3] != 1 || e_cache_status ($FName) || eEMODE || (eULEVEL == 2 && $RegenerateForAdmin)) {
   $Data = $DB->detailed ($Vars[2], $Vars[3]);
   e_save ($FName, $Data);
   }
else {
     $Data = e_read ($FName);
     e_cache_info ($FName);
     }
for ($i = 0, $c = count ($Data[0]); $i < $c; $i++) $T['rows'].= e_details ($Data[0][$i], 1);
$T['switch'] = '<a href="'.$T['path'].'detailed/'.(int) (!$Vars[2]).'/'.$Vars[3].'"><strong>[%'.($Vars[2]?'hide':'show').'robots%]</strong></a>';
$T['links'] = (($Data[2] > $Detailed['amount'])?str_replace ('{links}', e_links ($Data[1], ceil ($Data[2] / $Detailed['amount']), $T['path'].'detailed/'.$Vars[2].'/<page>'.$Path['suffix']), $Theme['detailed-links']):'');
if (!$T['rows']) $T['rows'] = $Theme['detailed-none'];
?>