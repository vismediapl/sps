<?php
if (!defined ('eStats')) die ();
$Groups = array (
	'sites' => 1,
	'referrers' => 1,
	'hosts' => 0,
	'keywords' => 0,
	'langs' => 2
	);
if (!include ('lib/block.php')) e_error ('lib/block.php', __FILE__, __LINE__);
$FName = 'cache/visits';
if (e_cache_status ($FName, 'visits') || eEMODE) {
   $Data['visits'] = $DB->visits ();
   e_save ($FName, $Data['visits']);
   }
else $Data['visits'] = e_read ($FName);
$HoursAmount = ceil ((time () - $LastReset) / 3600);
$DaysAmount = ceil ($HoursAmount / 24);
$Data['visits'][10] = ($Data['visits'][0] / $DaysAmount);
$Data['visits'][11] = ($Data['visits'][0] / $HoursAmount);
$Array = array ('unique', 'views', 'excluded', 'most', 'lasthour', 'last24hours', 'lastweek', 'lastmonth', 'lastyear', 'online', 'averageperday', 'averageperhour');
for ($i = 0; $i < 12; $i++) $T[$Array[$i]] = (is_array ($Data['visits'][$i])?e_number ($Data['visits'][$i][0]).' ('.($Data['visits'][$i][0]?e_date ('d.m.Y', $Data['visits'][$i][1]):'-').')':e_number ($Data['visits'][$i]));
?>