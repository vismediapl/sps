<?php
if (!defined ('eStats')) die ();
e_theme ('detailed');
if (!include ('lib/details.php')) e_error ('lib/details.php', __FILE__, __LINE__);
$T['switch'] = '';
$T['title'] = sprintf ($T['title'], $Vars[2]);
$T['rows'] = '';
if (!isset ($Vars[2])) $Vars[2] = 1;
if (!isset ($Vars[3])) $Vars[3] = 1;
$Vars[2] = (int) $Vars[2];
$Vars[3] = (int) $Vars[3];
$Array = ($Detailed['showdetails']?$DB->details ($Vars[2], $Vars[3]):0);
$PAmount = ceil ($Array[0][17] / $Detailed['detailsamount']);
if ($Array) {
   $c = count ($Array[1]) - 1;
   $T['page'] = str_replace ('{rowspan}', ($c + (($Array[0][17] > $Detailed['detailsamount'])?3:2)), e_details ($Array[0], 0));
   for ($i = 0; $i <= $c; $i++) $T['rows'].= e_parse ($Theme['details-row'], array (
	'num' => ($Array[0][17] - $i - (($Array[2] - 1) * $Detailed['detailsamount'])),
	'date' => e_date ('d.m.Y H:i:s', $Array[1][$i][0]),
	'title' => htmlspecialchars ($Array[1][$i][2]),
	'link' => '<a href="'.$Array[1][$i][1].'" tabindex="'.($TIndex++).'">'.e_cut (($Array[1][$i][2]?$Array[1][$i][2]:$Array[1][$i][1]), $TConfig['detailsRowValueLength']).'</a>'
	));
   }
else $T['page'] = $Theme['details-none'];
$T['links'] = (($Array && $Array[0][17] > $Detailed['detailsamount'])?str_replace ('{links}', e_links ($Array[2], $PAmount, $T['path'].'details/'.$Vars[2].'/<page>'.$Path['suffix']), $Theme['details-links']):'');
?>