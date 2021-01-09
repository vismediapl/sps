<?php
if (!defined ('eStats')) die ();
$LSearch = array ();
if (isset ($_GET['search']) && !isset ($_POST['search'])) $Search = $_POST = $_GET;
if (isset ($_POST['search'])) {
   $Search = $_POST;
   foreach ($_POST as $Key => $Value) {
           if (is_array ($Value)) {
              for ($i = 0, $c = count ($Value); $i < $c; $i++) $LSearch[] = $Key.'[]='.urlencode ($Value[$i]);
              }
           else $LSearch[] = $Key.'='.urlencode ($Value);
           }
   }
else $Search = 0;
if (!isset ($Vars[3])) $Vars[3] = 0;
if (isset ($_POST['amount'])) $LogsAmount = (int) $_POST['amount'];
if (isset ($_POST['export'])) {
   $Logs = 'eStats v'.$eStats['version'].' logs backup
Creation date: '.date ('m.d.Y H:i:s').'

';
   $Array = $DB->logs ((int) $Vars[3], 0, $Search);
   for ($i = 0, $c = count ($Array[0]); $i < $c; $i++) $Logs.= '
'.e_date ('d.m.Y H:i:s', $Array[0][$i][0]).' - '.$Log[$Array[0][$i][1]].($Array[0][$i][2]?' ('.$Array[0][$i][2].')':'');
   header ('Content-Type: application/force-download');
   header ('Content-Disposition: attachment; filename=eStats_'.date ('Y-m-d').'.log.bak');
   die ($Logs);
   }
$Array = $DB->logs ((int) $Vars[3], $LogsAmount, $Search);
$Amount = count ($Array[0]);
$Filter = '';
foreach ($Log as $Key => $Value) $Filter.= '<option value="'.$Key.'"'.((!isset ($_POST['filter']) || in_array ($Key, $_POST['filter']))?' selected="selected"':'').'>'.$Value.'</option>
';
$T['page'] = '<form action="{spath}" method="post">
<h3>%search%</h3>
'.e_config_row ('%findregistration%', 'search', (isset ($_POST['search'])?stripslashes ($_POST['search']):''), 2).e_config_row ('%resultsperpage%', 'amount', $LogsAmount, 2).e_config_row ('%filter%', 'filter', '', '<select name="filter[]" multiple="multiple" size="5" id="filter" tabindex="'.($TIndex++).'">
'.$Filter.'</select>').e_config_row ('%inperiod%', 'from', '', '%from% <input name="from" value="'.(isset ($_POST['from'])?$_POST['from']:e_date ('Y-m-d H:00:00', $ITime)).'" id="from" tabindex="'.($TIndex++).'" />
%to% <input name="to" value="'.(isset ($_POST['to'])?$_POST['to']:e_date ('Y-m-d H:00:00', strtotime ('next hour'))).'" tabindex="'.($TIndex++).'" />
').'<div class="buttons">
<input type="submit" value="%show%" tabindex="'.($TIndex++).'" class="button" />
<input type="submit" name="export" value="%export%" tabindex="'.($TIndex++).'" class="button" />
<input type="reset" value="%reset%" tabindex="'.($TIndex++).'" class="button" />
</div>
<h3>%browse%</h3>
<p>
<strong>%registrationsamount%: '.$Array[1].'. %meetingconditions%: '.$Array[3].'. %showed%: '.$Amount.'.</strong>
</p>
<table cellspacing="0" cellpadding="1">
<tr>
<th>
#
</th>
<th>
%date%
</th>
<th>
%log%
</th>
<th>
%information%
</th>
</tr>
';
for ($i = 0; $i < $Amount; $i++) $T['page'].= '<tr>
<td>
<em>'.($i + 1 + (($Array[2] - 1) * $LogsAmount)).'</em>.
</td>
<td>
'.e_date ('d.m.Y H:i:s', $Array[0][$i][0]).'
</td>
<td>
'.$Log[$Array[0][$i][1]].'
</td>
<td>
'.($Array[0][$i][2]?$Array[0][$i][2]:'&nbsp;').'
</td>
</tr>
';
if (!$Amount) $T['page'].= '<td colspan="4">
<strong>%none%</strong>
</td>
';
$T['page'].= '</table>
</form>
'.e_links ($Array[2], ceil ($Array[3] / $LogsAmount), $T['path'].'admin/logs/<page>'.$Path['suffix'].($LSearch?$Path['separator'].implode ('&#038;', $LSearch):''));
?>