<?php
class estats_db_gui extends estats_db {
function data ($Table, $HowMany, $Year, $Month) {
         $Data[0] = array ();
         if ($Year) {
            $Query = ' WHERE "time" ';
            if ($Month) {
               $Time = strtotime ($Year.'-'.(($Month < 10)?'0':'').$Month.'-01');
               $Query.= '> '.($Time - 86400).' AND "time" < '.($Time + 86400);
               }
            else $Query.= '>= '.strtotime ($Year.'-01-01').' AND "time" < '.strtotime (($Year + 1).'-01-01');
            }
         else $Query = '';
         $Result = sqlite_query (eDB, 'SELECT '.(($Table == 'vbrowsers' || $Table == 'voses')?'"name" || \' \' || "version" AS "ver", SUM("num") AS "num" FROM "'.substr ($Table, 1).'"':'"name", SUM("num") AS "num"'.(($Table == 'sites')?', "address"':'').' FROM "'.$Table.'"').$Query.' GROUP BY "'.(($Table == 'vbrowsers' || $Table == 'voses')?'ver':(($Table == 'sites')?'address':'name')).'" ORDER BY "num" DESC LIMIT '.$HowMany);
         while ($Row = sqlite_fetch_array ($Result, SQLITE_NUM)) $Data[0][$Row[($Table == 'sites')?2:0]] = (($Table == 'sites')?array ($Row[1], ($Row[0]?$Row[0]:$Row[2])):$Row[1]);
         $Data[1] = sqlite_single_query (eDB, 'SELECT SUM("num") FROM "'.(($Table == 'vbrowsers' || $Table == 'voses')?substr ($Table, 1):$Table).'"'.$Query, 1);
         $Data[2] = count (sqlite_array_query (eDB, 'SELECT COUNT("num") FROM "'.(($Table == 'vbrowsers' || $Table == 'voses')?substr ($Table, 1):$Table).'"'.$Query.' GROUP BY "name"'.(($Table == 'vbrowsers' || $Table == 'voses')?', "version"':(($Table  == 'sites')?', "address"':'')), SQLITE_NUM));
         return ($Data);
         }
function time () {
         $this->clean ();
         $Array = array (
	array ('"hour", SUM("uni"), SUM("all") FROM "hours" GROUP BY "hour"', 24, e_date ('G') + 1),
	array ('"day", "uni", "all" FROM "archive" WHERE "time" > '.strtotime ('last month').' GROUP BY "day"', e_date ('t', ((e_date ('t') == e_date ('j'))?time ():strtotime ('last month'))) + 1, e_date ('j'), 1),
	array ('"month", SUM("uni"), SUM("all") FROM "archive" WHERE "time" > '.strtotime (e_date ('Y-m-t', strtotime ('last year'))).' GROUP BY "month"', 13, e_date ('n'), 1),
	array ('"year", SUM("uni"), SUM("all") FROM "archive" GROUP BY "year" ORDER BY "year" DESC LIMIT 10', e_date ('Y') + 1, 0, e_date ('Y') - 9),
	array ('"hour", "uni", "all" FROM "hourspopularity"', 24),
	array ('"day", "uni", "all" FROM "daysofweekpopularity"', 7)
	);
         for ($i = 0, $c = count ($Array); $i < $c; $i++) {
             $Result = sqlite_query (eDB, 'SELECT '.$Array[$i][0]);
             $TData = array ();
             while ($Row = sqlite_fetch_array ($Result, SQLITE_NUM)) {
                   $TData[0][$Row[0]] = (int) $Row[1];
                   $TData[1][$Row[0]] = $Row[1] + $Row[2];
                   }
             for ($v = (int) (isset ($Array[$i][3])?$Array[$i][3]:0); $v < $Array[$i][1]; $v++) {
                 $Data[$i][0][] = (isset ($TData[0][$v])?(int) $TData[0][$v]:0);
                 $Data[$i][1][] = (isset ($TData[1][$v])?$TData[1][$v]:0);
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
         $Visits = sqlite_array_query (eDB, 'SELECT SUM("uni"), SUM("all") FROM "archive"', SQLITE_NUM);
         $Most = sqlite_array_query (eDB, 'SELECT "uni", "time" FROM "archive" WHERE "time" >= '.$LastReset.' ORDER BY "uni" DESC LIMIT 1', SQLITE_NUM);
         $Data = array (
	$Visits[0][0],
	($Visits[0][0] + $Visits[0][1]),
	sqlite_single_query (eDB, 'SELECT SUM("uni") FROM "ignored"', 1),
	$Most[0],
	sqlite_single_query (eDB, 'SELECT "uni" FROM "hours" WHERE "time" = '.strtotime (date ('Y-m-d H:00:00')), 1),
	sqlite_single_query (eDB, 'SELECT SUM("uni") FROM "hours" WHERE "time" > '.strtotime ('last day'), 1),
	sqlite_single_query (eDB, 'SELECT SUM("uni") FROM "archive" WHERE "time" > '.strtotime ('last week'), 1),
	sqlite_single_query (eDB, 'SELECT SUM("uni") FROM "archive" WHERE "time" > '.strtotime ('last month'), 1),
	sqlite_single_query (eDB, 'SELECT SUM("uni") FROM "archive" WHERE "time" > '.strtotime ('last year'), 1),
	sqlite_num_rows (sqlite_query (eDB, 'SELECT COUNT("uid") FROM "details" WHERE (('.time ().' - "time") < 300) GROUP BY "uid"'))
	);
         return ($Data);
         }
function detailed ($Robots, $Page) {
         global $Detailed;
         $c = sqlite_single_query (eDB, 'SELECT COUNT(*) FROM "visitors"'.($Robots?'':' WHERE "robot" = 0'), 1);
         $Pages = ceil ($c / $Detailed['amount']);
         if ($Detailed['maxpages'] && eULEVEL < 2 && $Pages > $Detailed['maxpages']) {
            $c = ($Detailed['amount'] * $Detailed['maxpages']);
            $Pages = $Detailed['maxpages'];
            }
         if ($Page < 1 || $Page > $Pages) $Page = 1;
         $Data = array (array (), $Page, $c);
         $Result = sqlite_query (eDB, 'SELECT "v".*, MIN("d"."time"), MAX("d"."time") AS "vtime", COUNT("d"."time") FROM "visitors" "v" LEFT JOIN "details" "d" ON "d"."uid" = "v"."uid"'.($Robots?'':' WHERE "robot" = 0').' GROUP BY "d"."uid" ORDER BY "vtime" DESC LIMIT '.($Detailed['amount'] * ($Page - 1)).', '.$Detailed['amount']);
         while ($Row = sqlite_fetch_array ($Result, SQLITE_NUM)) $Data[0][] = $Row;
         return ($Data);
         }
function details ($ID, $Page) {
         if (!$Data = sqlite_array_query (eDB, 'SELECT "v".*, MIN("d"."time"), MAX("d"."time") AS "vtime", COUNT("d"."time") FROM "visitors" "v" LEFT JOIN "details" "d" ON "d"."uid" = "v"."uid" WHERE "d"."uid" = '.(int) $ID.'  GROUP BY "d"."uid"', SQLITE_NUM)) return (0);
         $Data = $Data[0];
         $Amount = $GLOBALS['Detailed']['detailsamount'];
         if ($Page < 1 || $Page > ceil ($Data[17] / $Amount)) $Page = 1;
         $Sites = sqlite_array_query (eDB, 'SELECT "time", "sid" FROM "details" WHERE "uid" = '.(int) $ID.' ORDER BY "time" DESC LIMIT '.($Amount * ($Page - 1)).', '.$Amount, SQLITE_NUM);
         for ($i = 0, $c = count ($Sites); $i < $c; $i++) $Sites[$i][2] = sqlite_single_query (eDB, 'SELECT "name" FROM "sites" WHERE "address" = \''.sqlite_escape_string ($Sites[$i][1]).'\' ORDER BY "time" DESC LIMIT 1', 1);
         return (array ($Data, $Sites, $Page));
         }
function archive ($Year, $Month) {
         $Array = array_fill (0, ($Month?e_date ('t', strtotime ($Year.'-'.(($Month < 10)?'0':'').$Month.'-01')):12), 0);
         $Data = array ($Array, $Array);
         $Result = sqlite_query (eDB, 'SELECT "'.($Month?'day':'month').'", '.($Month?'"uni", "all"':'SUM("uni"), SUM("all")').' FROM "archive" WHERE "year" = '.$Year.($Month?' AND "month" = '.$Month:' GROUP BY "month"'));
         while ($Row = sqlite_fetch_array ($Result, SQLITE_NUM)) {
               $Data[0][$Row[0] - 1] = $Row[1];
               $Data[1][$Row[0] - 1] = $Row[1] + $Row[2];
               }
         return ($Data);
         }
function ignored ($Page, $Amount) {
         $Array = array ();
         $HowMany = sqlite_single_query (eDB, 'SELECT COUNT(*) FROM "ignored"', 1);
         if (!$Page) $Page = ceil ($HowMany / $Amount);
         $From = ($Amount * ($Page - 1));
         if ($From > $HowMany) {
            $From = 0;
            $Page = 1;
            }
         $Result = sqlite_query (eDB, 'SELECT * FROM "ignored" ORDER BY "lastall" DESC'.($Amount?' LIMIT '.$From.', '.$Amount:''));
         while ($Row = sqlite_fetch_array ($Result, SQLITE_NUM)) $Array[] = $Row;
         return (array ($Array, $HowMany, $Page));
         }
function logs ($Page, $Amount, $Search = 0) {
         if ($Search) $Where = (($_POST['from'] && $_POST['to'])?' WHERE "time" >= '.strtotime ($_POST['from']).' AND "time" <= '.strtotime ($_POST['to']):'').(isset ($_POST['filter'])?' AND ("log" = '.implode (' OR "log" = ', $_POST['filter']).')':'').($_POST['search']?' AND ("'.implode ('" LIKE \'%'.sqlite_escape_string ($_POST['search']).'%\' OR "', array ('log', 'time', 'user', 'ip', 'db', 'table', 'additional')).'" LIKE \'%'.sqlite_escape_string ($_POST['search']).'%\')':'');
         else $Where = '';
         $HowMany = sqlite_single_query (eDB, 'SELECT COUNT(*) FROM "logs"', 1);
         $RAmount = ($Where?sqlite_single_query ('SELECT COUNT(*) FROM "logs"'.$Where, 1):$HowMany);
         if (!$Page) $Page = ceil ($RAmount / $Amount);
         $From = ($Amount * ($Page - 1));
         if ($From > $RAmount) {
            $From = 0;
            $Page = 1;
            }
         if ($RAmount) $Array = sqlite_array_query (eDB, 'SELECT * FROM "logs"'.$Where.' ORDER BY "time"'.($Amount?' LIMIT '.$From.', '.$Amount:''));
         else $Array = array ();
         return (array ($Array, $HowMany, $Page, $RAmount));
         }
function delete_row ($Table, $Row) {
         if (eULEVEL == 2) {
            sqlite_query (eDB, 'DELETE FROM "'.$Table.'" WHERE "name" = "'.$Row.'"');
            return (sqlite_changes (eDB)?1:0);
            }
         }
function reset () {
         if (isset ($_POST['RDetailed'])) {
            sqlite_query (eDB, 'DELETE FROM "visitors"');
            sqlite_query (eDB, 'DELETE FROM "details"');
            e_log (30, 1);
            return (0);
            }
         global $DBTables;
         if (isset ($_POST['RAll'])) {
            for ($i = 0, $c = count ($DBTables); $i < $c; $i++) if (!in_array ($DBTables[$i], array ('configuration', 'logs'))) sqlite_query (eDB, in_array ($DBTables[$i], array ('hourspopularity', 'daysofweekpopularity'))?'UPDATE "'.$DBTables[$i].'" SET "uni" = 0, "all" = 0':'DELETE FROM "'.$DBTables[$i].'"');
            $this->config_set (array ('LastReset' => time ()), 0);
            e_log (31, 1);
            return (0);
            }
         if (isset ($_POST['RSTable']) && in_array ($_POST['RTable'], $DBTables)) {
            sqlite_query (eDB, 'DELETE FROM "'.$_POST['RTable'].'"');
            e_log (34, 1, $_POST['RTable']);
            }
         }
function restore_backup ($BID) {
         $Error = 0;
         if (!is_file ('data/backups/'.$BID.'.sql.bak')) return (0);
         sqlite_query (eDB, file_get_contents ('data/backups/'.$BID.'.sql.bak')) or $Error = 1;
         e_log (($Error?25:24), !$Error, 'ID: '.$BID);
         }
function db_size () {
         return (array ('all' => filesize ('data/estats_'.$GLOBALS['DBID'].'.sqlite'), 'visitors' => '?'));
         }
function clean () {
         if (date ('YmdH', $GLOBALS['LastClean']) == date ('YmdH')) return (0);
         global $Detailed;
         sqlite_query (eDB, 'DELETE FROM "hours" WHERE "time" < '.strtotime ('last day'));
         $UIDs = array ();
         if (!$Detailed['keepalldata']) {
            $Time = (int) sqlite_single_query (eDB, 'SELECT MAX("time") AS "mtime" FROM "details" GROUP BY "uid" ORDER BY "mtime" DESC LIMIT '.($Detailed['amount'] * $Detailed['maxpages']).', 1', 1);
            $Array = sqlite_array_query (eDB, 'SELECT "uid", MAX("time"), MIN("time") FROM "details" GROUP BY "uid"', SQLITE_NUM);
            for ($i = 0, $c = count ($Array); $i < $c; $i++) if ($Array[$i][1] <= $Time && (time () - $Array[$i][2]) > $Detailed['period'] && (time () - $Array[$i][2]) > $GLOBALS['Time']) $UIDs[] = $Array[$i][0];
            if ($UIDs) {
               sqlite_query (eDB, 'DELETE FROM "visitors" WHERE "uid" = '.implode (' OR "uid" = ', $UIDs));
               sqlite_query (eDB, 'DELETE FROM "details" WHERE "uid" = '.implode (' OR "uid" = ', $UIDs));
               }
            }
         $this->config_set (array ('LastClean' => time ()), 0);
         }
}
?>