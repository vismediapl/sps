<?php
class estats_db {
var $TimeStamp;
function estats_db () {
         $GLOBALS['DBInfo']['dbversion'] = (function_exists ('sqlite_libversion')?sqlite_libversion ():'?');
         $CType = 'sqlite_'.($GLOBALS['PConnect']?'p':'').'open';
         if (function_exists ('sqlite_query')) {
            $this->TimeStamp = strtotime (date ('Y-m-01'));
            if (is_readable (ePATH.'data/estats_'.$GLOBALS['DBID'].'.sqlite') && $DB = $CType (ePATH.'data/estats_'.$GLOBALS['DBID'].'.sqlite')) define ('eDB', $DB);
            else e_error ('Could not connect to database!', __FILE__, __LINE__, 1);
            }
         else e_error ('This module does not supported on this server!', __FILE__, __LINE__, 1);
         }
function update ($Table, $Arg) {
         sqlite_query (eDB, 'UPDATE "'.$Table.'" SET "num" = "num" + 1'.(($Table == 'sites')?', "name" = \''.sqlite_escape_string ($Arg).'\'':'').' WHERE '.(($Table == 'sites')?'"address" = \''.sqlite_escape_string (eADDRESS).'\'':'"name" = \''.sqlite_escape_string (is_array ($Arg)?$Arg[0]:$Arg).'\'').(is_array ($Arg)?' AND "version" = \''.sqlite_escape_string ($Arg[1]).'\'':'').' AND "time" = '.($GLOBALS['Monthly']?$this->TimeStamp:0));
         if (!sqlite_changes (eDB)) sqlite_query (eDB, 'INSERT INTO "'.$Table.'" VALUES ('.($GLOBALS['Monthly']?$this->TimeStamp:0).', \''.sqlite_escape_string (is_array ($Arg)?$Arg[0]:$Arg).'\', 1'.(($Table == 'sites')?', \''.sqlite_escape_string (eADDRESS).'\'':(is_array ($Arg)?', \''.sqlite_escape_string ($Arg[1]).'\'':'')).')');
         }
function visitor () {
         global $Time, $LastReset;
         if (isset ($_SESSION['eVISITOR']) && ((time () - $_SESSION['eVISITOR'][0]) > $Time || $_SESSION['eVISITOR'][0] < $LastReset || ($_SESSION['eVISITOR'] && !sqlite_single_query (eDB, 'SELECT "uid" FROM "visitors" WHERE "uid" = '.$_SESSION['eVISITOR'][1], 1)))) unset ($_SESSION['eVISITOR']);
         if (!isset ($_SESSION['eVISITOR'])) {
            if ($UID = sqlite_single_query (eDB, 'SELECT "uid" FROM "visitors" WHERE "ip" = \''.sqlite_escape_string (eIP).'\' ORDER BY "uid" DESC LIMIT 1', 1)) {
               if (!($VTime = sqlite_single_query (eDB, 'SELECT "time" FROM "details" WHERE "uid" = '.$UID.' AND ('.time ().' - "time" < '.(int) ($Time / 2).') ORDER BY "time" ASC LIMIT 1', 1))) $UID = 0;
               else $_SESSION['eVISITOR'] = array ($VTime, $UID);
               }
            if (!$UID && isset ($_GET['estats']) && $_GET['estats'] && !$_GET['count']) return (0);
            if (!$UID) {
               $_SESSION['eVISITOR'] = array (time (), e_new_visitor_id (sqlite_single_query (eDB, 'SELECT MAX("uid") FROM "visitors"', 1), sqlite_single_query (eDB, 'SELECT SUM("uni") FROM "archive"', 1)));
               define ('eNEWVISITOR', 1);
               }
            }
         define ('eVID', $_SESSION['eVISITOR'][1]);
         if (defined ('eNEWVISITOR') || !sqlite_single_query (eDB, 'SELECT "info" FROM "visitors" WHERE "uid" = '.eVID)) define ('eNOINFO', 1);
         }
function visit ($Array) {
         $Date = explode ('-', date ('Y-n-j-G'));
         if (defined ('eNOINFO')) sqlite_query (eDB, 'UPDATE "visitors" SET "js" = '.$Array[0].', "cookies" = '.$Array[1].', "flash" = \''.$Array[2].'\', "java" = '.$Array[3].', "screen" = \''.$Array[4].'\', "info" = 1 WHERE "uid" = '.eVID);
         if (!defined ('eCOUNT')) return (0);
         if (defined ('eNEWVISITOR')) sqlite_query (eDB, 'INSERT INTO "visitors" VALUES('.eVID.', \''.sqlite_escape_string (eIP).'\', \''.sqlite_escape_string ($_SERVER['HTTP_USER_AGENT']).'\', \''.$Array[7].'\', \''.(isset ($_SERVER['HTTP_REFERER'])?sqlite_escape_string ($_SERVER['HTTP_REFERER']):'').'\', \''.$Array[8].'\', \''.implode ('\', \'', array_slice ($Array, 0, 6)).'\', \''.$Array[6].'\', \''.(defined ('ePROXY')?sqlite_escape_string (ePROXY).'\', \''.sqlite_escape_string (ePROXYIP):'\', \'').'\')');
         $Query = (defined ('eNEWVISITOR')?'"uni" = "uni" + 1':'"all" = "all" + 1');
         sqlite_query (eDB, 'INSERT INTO "details" VALUES('.eVID.', \''.eADDRESS.'\', '.time().')');
         if (eROBOT && !$GLOBALS['CountRobots']) return (0);
         sqlite_query (eDB, 'UPDATE "daysofweekpopularity" SET '.$Query.' WHERE "day" = '.date ('w'));
         sqlite_query (eDB, 'UPDATE "hourspopularity" SET '.$Query.' WHERE "hour" = '.$Date[3]);
         $Archive = ($this->TimeStamp + (($Date[2] - 1) * 86400));
         $Hours = ($Archive + ($Date[3] * 3600));
         sqlite_query (eDB, 'UPDATE "hours" SET '.$Query.' WHERE "time" = '.$Hours);
         if (!sqlite_changes (eDB)) sqlite_query (eDB, 'INSERT INTO "hours" VALUES ('.$Hours.', '.$Date[3].', '.(defined ('eNEWVISITOR')?'1, 0':'0, 1').')');
         sqlite_query (eDB, 'UPDATE "archive" SET '.$Query.' WHERE "time" = '.$Archive);
         if (!sqlite_changes (eDB)) sqlite_query (eDB, 'INSERT INTO "archive" VALUES ('.$Archive.', '.$Date[0].', '.$Date[1].', '.$Date[2].', '.(defined ('eNEWVISITOR')?'1, 0':'0, 1').')');
         }
function ignored_visit ($Blocked = 0) {
         sqlite_query (eDB, 'UPDATE "ignored" SET '.(sqlite_single_query (eDB, 'SELECT "ip" FROM "ignored" WHERE "ip" = \''.sqlite_escape_string (eIP).'\' AND ('.time ().' - "lastuni" < 4320)', 1)?'"all" = "all" + 1, "lastall"':'"uni" = "uni" + 1, "ua" = \''.sqlite_escape_string ($_SERVER['HTTP_USER_AGENT']).'\', "lastuni"').' = '.time ().' WHERE "ip" = \''.sqlite_escape_string (eIP).'\' AND "type" = '.(int) $Blocked);
         if (!sqlite_changes (eDB)) sqlite_query (eDB, 'INSERT INTO "ignored" VALUES('.time ().', '.time ().', '.time ().', \''.sqlite_escape_string (eIP).'\', 1, 0, \''.sqlite_escape_string ($_SERVER['HTTP_USER_AGENT']).'\', '.(int) $Blocked.')');
         }
function backup ($Profile) {
         $Backup = ($Profile[2]?'/*
If You experienced problems with restoring of this backup You could try to remove lines starting with "DROP TABLE" and try to restore it again.
*/

':'').'BEGIN;
';
         for ($i = 0, $c = count ($Profile[1]); $i < $c; $i++) {
             if ($Profile[3]) $Backup.= 'DELETE FROM "'.$Profile[1][$i].'";
';
             if ($Profile[2]) $Backup.= 'DROP TABLE "'.$Profile[1][$i].'";
'.sqlite_single_query (eDB, 'SELECT "sql" FROM "sqlite_master" WHERE "name" = \''.$Profile[1][$i].'\'', 1).';
';
             $Array = sqlite_array_query (eDB, 'SELECT * FROM "'.$Profile[1][$i].'"', SQLITE_NUM);
             $Fields = count ($Array[0]);
             for ($v = 0, $Rows = count ($Array); $v < $Rows; $v++) {
                 $Values = array ();
                 for ($z = 0; $z < $Fields; $z++) $Values[] = sqlite_escape_string ($Array[$v][$z]);
                 $Backup.= 'INSERT INTO "'.$Profile[1][$i].'" VALUES(\''.implode ('\', \'', $Values).'\');
';
                 }
             }
         return ($Backup.'COMMIT;');
         }
function log ($Log, $Info) {
         if (!defined ('eCRITICAL')) sqlite_query (eDB, 'INSERT INTO "logs" VALUES('.time ().', '.(int) $Log.', \''.($Info?sqlite_escape_string ($Info):'').'\')');
         }
function config_get ($Mode) {
         $Data = array ();
         $Result = sqlite_query (eDB, 'SELECT * FROM "configuration" WHERE "mode" '.($Mode?'':'!').'= 1');
         while ($Row = sqlite_fetch_array ($Result, SQLITE_NUM)) $Data[$Row[0]] = $Row[1];
         return ($Data);
         }
function config_set ($Array, $Notify = 1) {
         foreach ($Array as $Key => $Value) {
                 sqlite_query (eDB, 'UPDATE "configuration" SET value = \''.sqlite_escape_string ($Value).'\' WHERE "name" = \''.$Key.'\'');
                 if (!sqlite_changes (eDB)) sqlite_query (eDB, 'INSERT INTO "configuration" VALUES(\''.$Key.'\', \''.sqlite_escape_string ($Value).'\', 1)');
                 }
         e_configuration (0, 1);
         e_configuration (1, 1);
         if ($Notify) e_log (2, 1);
         }
}
?>