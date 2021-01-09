<?php
class estats_db_gui extends estats_db {
function data ($Table, $HowMany, $Year, $Month) {
         $Data[0] = array ();
         $Query = ((!$Month && !$Year)?'':' WHERE YEAR(`date`) = '.$Year.($Month?' AND MONTH(`date`) = '.$Month:''));
         $Result = mysql_query ('SELECT '.(($Table == 'vbrowsers' || $Table == 'voses')?'CONCAT(`name`," ",`version`) AS `ver`, SUM(`num`) AS `num` FROM `'.eDBPREFIX.substr ($Table, 1).'`':'`name`, SUM(`num`) AS `num`'.(($Table == 'sites')?', `address`':'').' FROM `'.eDBPREFIX.$Table.'`').$Query.' GROUP BY `'.(($Table == 'vbrowsers' || $Table == 'voses')?'ver':(($Table == 'sites')?'address':'name')).'` ORDER BY `num` DESC LIMIT '.$HowMany);
         while ($Row = mysql_fetch_row ($Result)) $Data[0][$Row[($Table == 'sites')?2:0]] = (($Table == 'sites')?array ($Row[1], ($Row[0]?$Row[0]:$Row[2])):$Row[1]);
         $Data[1] = $this->query ('SELECT SUM(`num`) FROM `'.eDBPREFIX.(($Table == 'vbrowsers' || $Table == 'voses')?substr ($Table, 1):$Table).'`'.$Query, 1);
         $Data[2] = mysql_num_rows (mysql_query ('SELECT COUNT(`num`) FROM `'.eDBPREFIX.(($Table == 'vbrowsers' || $Table == 'voses')?substr ($Table, 1):$Table).'`'.$Query.' GROUP BY `name`'.(($Table == 'vbrowsers' || $Table == 'voses')?', `version`':(($Table  == 'sites')?', `address`':''))));
         return ($Data);
         }
function time () {
         $this->clean ();
         $Array = array (
	array ('HOUR(`time`) as `hour`, SUM(`uni`), SUM(`all`) FROM `'.eDBPREFIX.'hours` WHERE `time` > "'.e_date ('Y-m-d H:00:00', strtotime ('last day')).'" GROUP BY `hour`', 24, (e_date ('G') + 1)),
	array ('DAYOFMONTH(`date`) as `day`, SUM(`uni`), SUM(`all`) FROM `'.eDBPREFIX.'archive` WHERE `date` > "'.e_date ('Y-m-d', strtotime ('last month')).'" GROUP BY `day`', e_date ('t', ((e_date ('t') == e_date ('j'))?time ():strtotime ('last month'))) + 1, e_date ('j'), 1),
	array ('MONTH(`date`) as `month`, SUM(`uni`), SUM(`all`) FROM `'.eDBPREFIX.'archive` WHERE `date` > "'.e_date ('Y-m-t', strtotime ('last year')).'" GROUP BY `month`', 13, e_date ('n'), 1),
	array ('YEAR(`date`) as `year`, SUM(`uni`), SUM(`all`) FROM `'.eDBPREFIX.'archive` GROUP BY `year` ORDER BY `year` DESC LIMIT 10', (e_date ('Y') + 1), 0, (e_date ('Y') - 9)),
	array ('`hour`, `uni`, `all` FROM `'.eDBPREFIX.'hourspopularity`', 24),
	array ('`day`, `uni`, `all` FROM `'.eDBPREFIX.'daysofweekpopularity`', 7)
	);
         for ($i = 0, $c = count ($Array); $i < $c; $i++) {
             $Result = mysql_query ('SELECT '.$Array[$i][0]);
             $TData = array ();
             while ($Row = mysql_fetch_row ($Result)) {
                   $TData[0][$Row[0]] = (int) $Row[1];
                   $TData[1][$Row[0]] = $Row[1] + $Row[2];
                   }
             for ($v = (isset ($Array[$i][3])?$Array[$i][3]:0); $v < $Array[$i][1]; $v++) {
                 $Data[$i][0][] = (isset ($TData[0][$v])?(int) $TData[0][$v]:0);
                 $Data[$i][1][] = (isset ($TData[1][$v])?(int) $TData[1][$v]:0);
                 }
             if ($i < 3) {
                $Data[$i][0] = array_merge (array_slice ($Data[$i][0], $Array[$i][2]), array_slice ($Data[$i][0], 0, $Array[$i][2]));
                $Data[$i][1] = array_merge (array_slice ($Data[$i][1], $Array[$i][2]), array_slice ($Data[$i][1], 0, $Array[$i][2]));
                }
             }
         return ($Data);
         }
function visits () {
         global $LastReset;
         $this->clean ();
         $Visits = $this->query ('SELECT SUM(`uni`), SUM(`all`) FROM `'.eDBPREFIX.'archive`');
         $Data = array (
	$Visits[0],
	($Visits[0] + $Visits[1]),
	$this->query ('SELECT SUM(`uni`) FROM `'.eDBPREFIX.'ignored`', 1),
	$this->query ('SELECT `uni`, UNIX_TIMESTAMP(`date`) FROM `'.eDBPREFIX.'archive` WHERE `date` >= "'.date ('Y-m-d', $LastReset).'" ORDER BY `uni` DESC LIMIT 1'),
	$this->query ('SELECT `uni` FROM `'.eDBPREFIX.'hours` WHERE `time` = "'.e_date ('Y-m-d H:00:00').'"', 1),
	$this->query ('SELECT SUM(`uni`) FROM `'.eDBPREFIX.'hours` WHERE `time` > "'.e_date ('Y-m-d H:00:00', strtotime ('last day')).'"', 1),
	$this->query ('SELECT SUM(`uni`) FROM `'.eDBPREFIX.'archive` WHERE `date` > "'.e_date ('Y-m-d', strtotime ('last week')).'"', 1),
	$this->query ('SELECT SUM(`uni`) FROM `'.eDBPREFIX.'archive` WHERE `date` > "'.e_date ('Y-m-d', strtotime ('last month')).'"', 1),
	$this->query ('SELECT SUM(`uni`) FROM `'.eDBPREFIX.'archive` WHERE `date` > "'.e_date ('Y-m-d', strtotime ('last year')).'"', 1),
	$this->query ('SELECT COUNT(`uid`) FROM `'.eDBPREFIX.'details` WHERE ((UNIX_TIMESTAMP() - `time`) < 300) GROUP BY `uid`', 1)
	);
         return ($Data);
         }
function detailed ($Robots, $Page) {
         global $Detailed;
         $c = $this->query ('SELECT COUNT(*) FROM `'.eDBPREFIX.'visitors`'.($Robots?'':' WHERE `robot` = 0'), 1);
         $Pages = ceil ($c / $Detailed['amount']);
         if ($Detailed['maxpages'] && eULEVEL < 2 && $Pages > $Detailed['maxpages']) {
            $c = ($Detailed['amount'] * $Detailed['maxpages']);
            $Pages = $Detailed['maxpages'];
            }
         if ($Page < 1 || $Page > $Pages) $Page = 1;
         $Data = array (array (), $Page, $c);
         $Result = mysql_query ('SELECT `v`.*, MIN(`d`.`time`), MAX(`d`.`time`) AS `vtime`, COUNT(`d`.`time`) FROM `'.eDBPREFIX.'visitors` `v`, `'.eDBPREFIX.'details` `d` WHERE `d`.`uid` = `v`.`uid`'.($Robots?'':' AND `v`.`robot` = "0"').' GROUP BY `uid` ORDER BY `vtime` DESC LIMIT '.($Detailed['amount'] * ($Page - 1)).', '.$Detailed['amount']);
         while ($Row = mysql_fetch_row ($Result)) $Data[0][] = $Row;
         return ($Data);
         }
function details ($ID, $Page) {
         if (!$Data = $this->query ('SELECT `v`.*, MIN(`d`.`time`), MAX(`d`.`time`) AS `vtime`, COUNT(`d`.`time`) FROM `'.eDBPREFIX.'visitors` `v`, `'.eDBPREFIX.'details` `d` WHERE `d`.`uid` = `v`.`uid` AND `d`.`uid` = '.(int) $ID.' GROUP BY `uid`')) return (0);
         $Amount = $GLOBALS['Detailed']['detailsamount'];
         if ($Page < 1 || $Page > ceil ($Data[17] / $Amount)) $Page = 1;
         $Result = mysql_query ('SELECT `time`, `sid` FROM `'.eDBPREFIX.'details` WHERE `uid` = '.(int) $ID.' ORDER BY `time` DESC LIMIT '.($Amount * ($Page - 1)).', '.$Amount);
         $Sites = array ();
         while ($Row = mysql_fetch_row ($Result)) $Sites[] = array ($Row[0], $Row[1], $this->query ('SELECT `name` FROM `'.eDBPREFIX.'sites` WHERE `address` = \''.mysql_escape_string ($Sites[$i][1]).'\' ORDER BY `time` DESC LIMIT 1', 1));
         return (array ($Data, $Sites, $Page));
         }
function archive ($Year, $Month) {
         $Array = array_fill (0, ($Month?e_date ('t', strtotime ($Year.'-'.(($Month < 10)?'0':'').$Month.'-01')):12), 0);
         $Data = array ($Array, $Array);
         $Result = mysql_query ('SELECT '.($Month?'DAYOFMONTH':'MONTH').'(`date`)'.($Month?'':' as `month`').', '.($Month?'`uni`, `all`':'SUM(`uni`), SUM(`all`)').' FROM `'.eDBPREFIX.'archive` WHERE YEAR(`date`) = '.$Year.($Month?' AND MONTH(`date`) = '.$Month:' GROUP BY `month`'));
         while ($Row = mysql_fetch_row ($Result)) {
               $Data[0][$Row[0] - 1] = $Row[1];
               $Data[1][$Row[0] - 1] = ($Row[1] + $Row[2]);
               }
         return ($Data);
         }
function ignored ($Page, $Amount) {
         $Array = array ();
         $HowMany = $this->query ('SELECT COUNT(*) FROM `'.eDBPREFIX.'ignored`', 1);
         if (!$Page) $Page = ceil ($HowMany / $Amount);
         $From = ($Amount * ($Page - 1));
         if ($From > $HowMany) {
            $From = 0;
            $Page = 1;
            }
         $Result = mysql_query ('SELECT * FROM `'.eDBPREFIX.'ignored` ORDER BY "lastall" DESC'.($Amount?' LIMIT '.$From.', '.$Amount:''));
         while ($Row = mysql_fetch_row ($Result)) $Array[] = $Row;
         return (array ($Array, $HowMany, $Page));
         }
function logs ($Page, $Amount, $Search = 0) {
         if ($Search) $Where = (($_POST['from'] && $_POST['to'])?' WHERE `time` >= '.strtotime ($_POST['from']).' AND `time` <= '.strtotime ($_POST['to']):'').(isset ($_POST['filter'])?' AND (`log` = '.implode (' OR `log` = ', $_POST['filter']).')':'').($_POST['search']?' AND (`'.implode ('` LIKE "%'.mysql_escape_string ($_POST['search']).'%" OR `', array ('log', 'time', 'info')).'` LIKE "%'.mysql_escape_string ($_POST['search']).'%")':'');
         else $Where = '';
         $HowMany = $this->query ('SELECT COUNT(*) FROM `'.eDBPREFIX.'logs`', 1);
         $RAmount = ($Where?$this->query ('SELECT COUNT(*) FROM `'.eDBPREFIX.'logs`'.$Where, 1):$HowMany);
         if (!$Page) $Page = ceil ($RAmount / $Amount);
         $From = ($Amount * ($Page - 1));
         if ($From > $RAmount) {
            $From = 0;
            $Page = 1;
            }
         $Array = array ();
         if ($RAmount) {
            $Result = mysql_query ('SELECT * FROM `'.eDBPREFIX.'logs`'.$Where.' ORDER BY `time`'.($Amount?' LIMIT '.$From.', '.$Amount:''));
            while ($Row = mysql_fetch_row ($Result)) $Array[] = $Row;
            }
         return (array ($Array, $HowMany, $Page, $RAmount));
         }
function delete_row ($Table, $Row) {
         if (eULEVEL == 2) {
            mysql_query ('DELETE FROM `'.eDBPREFIX.$Table.'` WHERE `name` = "'.$Row.'"');
            return (mysql_affected_rows ()?1:0);
            }
         }
function reset () {
         if (isset ($_POST['RDetailed'])) {
            mysql_query ('TRUNCATE TABLE `'.eDBPREFIX.'visitors`');
            mysql_query ('TRUNCATE TABLE `'.eDBPREFIX.'details`');
            e_log (30, 1);
            return (0);
            }
         global $DBTables;
         if (isset ($_POST['RAll'])) {
            for ($i = 0, $c = count ($DBTables); $i < $c; $i++) if (!in_array ($DBTables[$i], array ('configuration', 'logs'))) mysql_query (in_array ($DBTables[$i], array ('hourspopularity', 'daysofweekpopularity'))?'UPDATE `'.eDBPREFIX.$DBTables[$i].'` SET `uni` = 0, `all` = 0':'TRUNCATE TABLE `'.eDBPREFIX.$DBTables[$i].'`');
            $this->config_set (array ('LastReset' => time ()), 0);
            e_log (31, 1);
            return (0);
            }
         if (isset ($_POST['RSTable']) && in_array ($_POST['RTable'], $DBTables)) {
            mysql_query ('TRUNCATE TABLE `'.eDBPREFIX.$_POST['RTable'].'`');
            e_log (34, 1, $_POST['RTable']);
            }
         }
function restore_backup ($BID) {
         $Error = 0;
         if (!is_file ('data/backups/'.$BID.'.sql.bak')) return (0);
         $Array = explode (';
', file_get_contents ('data/backups/'.$BID.'.sql.bak'));
         for ($i = 0, $c = count ($Array); $i < $c; $i++) if ($Array[$i]) mysql_query ($Array[$i]) or $Error = 1;
         e_log (($Error?25:24), !$Error, 'ID: '.$BID);
         }
function db_size () {
         global $DBTables, $DBName;
         $Array = array ('all' => 0, 'visitors' => 0, 'details' => 0);
         $Result = mysql_query ('SHOW TABLE STATUS FROM `'.$DBName.'` LIKE "'.eDBPREFIX.'%"');
         while ($Row = mysql_fetch_array ($Result)) if (in_array ($TName = substr ($Row['Name'], strlen (eDBPREFIX)), $DBTables)) $Array['all'] += ($Array[$TName] = $Row['Data_length']);
         $Array['visitors'] += $Array['details'];
         return ($Array);
         }
function clean () {
         if (date ('YmdH', $GLOBALS['LastClean']) == date ('YmdH')) return (0);
         global $Detailed;
         mysql_query ('DELETE FROM `'.eDBPREFIX.'hours` WHERE `time` < "'.date ('Y-m-d H:00:00', strtotime ('last day')).'"');
         if (!$Detailed['keepalldata']) {
            $UIDs = array ();
            $Time = (int) $this->query ('SELECT MAX(`time`) AS `mtime` FROM `'.eDBPREFIX.'details` GROUP BY `uid` ORDER BY `mtime` DESC LIMIT '.($Detailed['amount'] * $Detailed['maxpages']).', 1', 1);
            $Result = mysql_query ('SELECT `uid`, MAX(`time`), MIN(`time`) FROM `'.eDBPREFIX.'details` GROUP BY `uid`');
            while ($Row = mysql_fetch_row ($Result)) {
                  if ($Row[1] <= $Time && (time () - $Row[2]) > $Detailed['period'] && (time () - $Row[2]) > $GLOBALS['Time']) $UIDs[] = $Row[0];
                  }
            if ($UIDs) {
               mysql_query ('DELETE FROM `'.eDBPREFIX.'details` WHERE `uid` = '.implode (' OR `uid` = ', $UIDs));
               mysql_query ('DELETE FROM `'.eDBPREFIX.'visitors` WHERE `uid` = '.implode (' OR `uid` = ', $UIDs));
               }
            }
         $this->config_set (array ('LastClean' => time ()), 0);
         }
}
?>