<?php
if (!defined ('eStats')) die ();
$DBSize = $DB->db_size ();
$CSize = e_cache_size ();
$BInfo = e_backups ();
$SafeMode = ini_get ('safe_mode');
include ('langs/'.$DefaultLang.'/config.php');
$T['page'] = '<h3>%actions%</h3>
<form action="{spath}" method="get">
<div class="buttons">
<input type="submit" name="statsenabled" value="%'.($StatsEnabled?'de':'').'activatestats%" tabindex="'.($TIndex++).'" class="button" />
<input type="submit" name="maintenance" value="%'.($Maintenance?'de':'').'activatemaintenance%" tabindex="'.($TIndex++).'" class="button" />
<input type="submit" name="editmode" value="%'.(eEMODE?'de':'').'activateeditmode%" tabindex="'.($TIndex++).'" class="button" />
</div>
</form>
<h3>%informations%</h3>
<p>
%estatsversion%: <em><a href="http://estats.emdek.cba.pl/index.php/'.$Vars[0].'/changelog/#'.$eStats['version'].'" tabindex="'.($TIndex++).'">'.$eStats['version'].' - '.$eStats['status'].'</a> ('.e_date ('d.m.Y H:i:s', $eStats['time']).')</em>'.($NewVersion?' (<strong>%newversionavailable% - <a href="http://estats.emdek.cba.pl/index.php/'.$Vars[0].'/changelog/#'.$_SESSION['eVERSION'][0].'" tabindex="'.($TIndex++).'">'.$_SESSION['eVERSION'][0].'</a></strong>)':'').';
</p>
<p>
%databasemodule%: <em><a href="'.$DBInfo['url'].'" tabindex="'.($TIndex++).'" title="%author%: '.$DBInfo['author'].'">'.$DBInfo['module'].' v'.$DBInfo['version'].' - '.$DBInfo['status'].'</a> ('.e_date ('d.m.Y H:i:s', $DBInfo['time']).')</em>;
</p>
<p>
%database%: <em>'.$DBInfo['db'].' - '.$DBInfo['dbversion'].'</em>;
</p>
<p>
%phpversion%: <em>'.PHP_VERSION.(function_exists ('phpinfo')?' (<a href="'.$T['path'].'admin/phpinfo" tabindex="'.($TIndex++).'">phpinfo</a>)':'').'</em>;
</p>
<p>
%safemode%: <em>'.(($SafeMode != '')?$SafeMode:'N/A').'</em>;
</p>
<p>
%os%: <em>'.PHP_OS.'</em>;
</p>
<p>
%serverload%: <em>'.(function_exists ('sys_getloadavg')?implode (', ', sys_getloadavg ()):'N/A').'</em>;
</p>
<p>
%collectedfrom%: <em>'.e_date ('d.m.Y H:i:s', $LastReset).'</em>;
</p>
<p>
%datasize%: <em>'.(($DBSize['all'] == '?')?'<strong>>=</strong> ':'').e_size ($DBSize['all'] + $CSize + $BInfo[0]).' (<em title="%data%">'.e_size ($DBSize['all']).'</em> / <em title="%cache%">'.e_size ($CSize).'</em> / <em title="%backups%">'.e_size ($BInfo[0]).'</em>)</em>;
</p>
<p>
%lastbackuptime%: <em>'.($BInfo[1]?e_date ('d.m.Y H:i:s', $LastBackup):' - ').'</em>;
</p>
<p>
%availablebackupsamount%: <em>'.$BInfo[1].'</em>;
</p>
<p>
%config_defaultlang%: <em>'.$LName[$DefaultLang].'</em>;
</p>
<p>
%config_defaulttheme%: <em>'.$DefaultTheme.'</em>.
</p>
';
?>