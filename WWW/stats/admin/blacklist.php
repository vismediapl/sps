<?php
if (!defined ('eStats')) die ();
if (isset ($_POST['SConfig']) || isset ($_POST['RDefault'])) {
   $CArray = array ();
   if (isset ($_POST['RDefault'])) {
      if (!include ('conf/template.php')) e_error ('conf/template.php', __FILE__, __LINE__);
      $DArray = array_merge ($Array['Stats'], $Array['GUI']);
      }
   $SOptions = array ('IgnoredIPs', 'BlockedIPs', 'Keywords', 'Referrers', 'Monitor');
   for ($i = 0, $c = count ($SOptions); $i < $c; $i++) $CArray[$SOptions[$i]] = (isset ($_POST['RDefault'])?$DArray[$SOptions[$i]][0]:$_POST[$SOptions[$i]]);
   $DB->config_set ($CArray);
   }
if (!isset ($Vars[3])) $Vars[3] = 0;
$T['page'] = '<form action="{spath}" method="post">
<h3>%settings%</h3>
'.e_config_row ('%config_blockedips% <a href="#desc" tabindex="'.($TIndex++).'"><sup>*</sup></a>', 'BlockedIPs', $BlockedIPs, 3).e_config_row ('%config_ignoredips% <a href="#desc" tabindex="'.($TIndex++).'"><sup>*</sup></a>', 'IgnoredIPs', $IgnoredIPs, 3).e_config_row ($L['config_keywords'], 'Keywords', $Keywords, 3).e_config_row ($L['config_referrers'], 'Referrers', $Referrers, 3).e_config_row ($L['config_monitor'], 'Monitor', $Monitor, 1).'<p>
<small id="desc"><sup>*</sup> %ignoreruledesc%</small>
</p>
<div class="buttons">
'.e_buttons ().'</div>
<h3>%ignoredvisits%</h3>
<table cellpadding="0" cellspacing="0">
<thead>
<tr>
<th>
%ip%
</th>
<th>
%firstvisit%
</th>
<th>
%lastvisit%
</th>
<th>
%visitamount%
</th>
<th>
%lastua%
</th>
<th>
%type%
</th>
</tr>
</thead>
<tbody>
';
$Array = $DB->ignored ($Vars[3], $IgnoredAmount);
for ($i = 0, $c = count ($Array[0]); $i < $c; $i++) $T['page'].= '<tr>
<td>
'.e_ignore_rule ($Array[0][$i][3], $TIndex).'
</td>
<td>
'.e_date ('d.m.Y H:i:s', $Array[0][$i][2]).'
</td>
<td>
'.e_date ('d.m.Y H:i:s', $Array[0][$i][0]).'
</td>
<td>
<span title="%unique%">'.$Array[0][$i][4].'</span> / <span title="%views%">'.($Array[0][$i][4] + $Array[0][$i][5]).'</span>
</td>
<td>
'.e_cut ($Array[0][$i][6], 40, 1).'
</td>
<td>
%'.($Array[0][$i][7]?'blocked':'ignored').'%
</td>
</tr>
';
$T['page'].= ($c?'':'<tr>
<td colspan="6"><strong>%none%</strong>
</td>
</tr>
').'</tbody>
</table>
</form>
'.e_links ($Array[2], ceil ($Array[1] / $IgnoredAmount), $T['path'].'admin/blacklist/<page>'.$Path['suffix']);
?>