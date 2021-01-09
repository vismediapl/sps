<?php
class estats_db {
function estats_db () {
         $Version = '?';
         $CType = 'pg_'.($GLOBALS['PConnect']?'p':'').'connect';
         if (function_exists ('pg_query')) {
            if (!$DB = $CType ($GLOBALS['DBString'])) e_error ('Could not connect to database!', __FILE__, __LINE__, 1);
            else $Version = pg_version ($DB);
            $Version = $Version['server'];
            define ('eDB', $DB);
            define ('eDBPREFIX', $GLOBALS['DBPrefix']);
            }
         else e_error ('This module does not supported on this server!', __FILE__, __LINE__, 1);
         $GLOBALS['DBInfo']['dbversion'] = $Version;
         }
function query ($Query, $String = 0) {
         $Result = pg_query (eDB, $Query);
         return ($String?(pg_num_rows ($Result)?pg_fetch_result ($Result, 0, 0):''):pg_fetch_all ($Result));
         }
function update ($Table, $Arg) {
         $Date = ($GLOBALS['Monthly']?date ('Y-m-01'):'');
         $Result = pg_query (eDB, 'UPDATE "'.eDBPREFIX.$Table.'" SET "num" = "num" + 1'.(($Table == 'sites')?', "name" = \''.pg_escape_string ($Arg).'\'':'').' WHERE '.(($Table == 'sites')?'"address" = \''.pg_escape_string (eADDRESS).'\'':'"name" = \''.pg_escape_string (is_array ($Arg)?$Arg[0]:$Arg).'\'').(is_array ($Arg)?' AND "version" = \''.pg_escape_string ($Arg[1]).'\'':'').' AND "date" = \''.$Date.'\'');
         if (!pg_affected_rows ($Result)) pg_query (eDB, 'INSERT INTO "'.eDBPREFIX.$Table.'" VALUES (\''.$Date.'\', \''.pg_escape_string (is_array ($Arg)?$Arg[0]:$Arg).'\', 1'.(($Table == 'sites')?', \''.pg_escape_string (eADDRESS).'\'':(is_array ($Arg)?', \''.pg_escape_string ($Arg[1]).'\'':'')).')');
         }
function visitor () {
         global $Time, $LastReset;
         if (isset ($_SESSION['eVISITOR']) && ((time () - $_SESSION['eVISITOR'][0]) > $Time || $_SESSION['eVISITOR'][0] < $LastReset  || ($_SESSION['eVISITOR'] && !$this->query ('SELECT "uid" FROM "'.eDBPREFIX.'visitors" WHERE "uid" = '.$_SESSION['eVISITOR'][1], 1)))) unset ($_SESSION['eVISITOR']);
         if (!isset ($_SESSION['eVISITOR'])) {
            if ($UID = $this->query ('SELECT "uid" FROM "'.eDBPREFIX.'visitors" WHERE "ip" = \''.pg_escape_string (eIP).'\' ORDER BY "uid" DESC LIMIT 1', 1)) {
               if (!($VTime = $this->query ('SELECT "time" FROM "'.eDBPREFIX.'details" WHERE "uid" = '.$UID.' AND ('.time ().' - "time" < '.(int) ($Time / 2).') ORDER BY "time" ASC LIMIT 1', 1))) $UID = 0;
               else $_SESSION['eVISITOR'] = array ($VTime, $UID);
               }
            if (!$UID && isset ($_GET['estats']) && $_GET['estats'] && !$_GET['count']) return (0);
            if (!$UID) {
               $_SESSION['eVISITOR'] = array (time (), e_new_visitor_id ($this->query ('SELECT MAX("uid") FROM "'.eDBPREFIX.'visitors"', 1), $this->query ('SELECT SUM("uni") FROM "'.eDBPREFIX.'archive"', 1)));
               define ('eNEWVISITOR', 1);
               }
            }
         define ('eVID', $_SESSION['eVISITOR'][1]);
         if (defined ('eNEWVISITOR') || !$this->query ('SELECT "info" FROM "'.eDBPREFIX.'visitors" WHERE "uid" = '.eVID, 1)) define ('eNOINFO', 1);
         }
function visit ($Array) {
         if (defined ('eNOINFO')) pg_query (eDB, 'UPDATE "'.eDBPREFIX.'visitors" SET "js" = \''.$Array[0].'\', "cookies" = \''.$Array[1].'\', "flash" = \''.$Array[2].'\', "java" = \''.$Array[3].'\', "screen" = \''.$Array[4].'\', "info" = 1 WHERE "uid" = '.eVID);
         if (!defined ('eCOUNT')) return (0);
         if (defined ('eNEWVISITOR')) pg_query (eDB, 'INSERT INTO "'.eDBPREFIX.'visitors" VALUES('.eVID.', \''.pg_escape_string (eIP).'\', \''.pg_escape_string ($_SERVER['HTTP_USER_AGENT']).'\', \''.$Array[7].'\', \''.(isset ($_SERVER['HTTP_REFERER'])?pg_escape_string ($_SERVER['HTTP_REFERER']):'').'\', \''.$Array[8].'\', \''.implode ('\', \'', array_slice ($Array, 0, 6)).'\', '.$Array[6].', \''.(defined ('ePROXY')?pg_escape_string (ePROXY).'\', \''.pg_escape_string (ePROXYIP):'\', \'').'\', '.time ().', '.time ().', 1)');
         else pg_query (eDB, 'UPDATE "'.eDBPREFIX.'visitors" SET "lasttime" = '.time ().', "visits" = "visits" + 1 WHERE "uid" = '.eVID);
         pg_query (eDB, 'INSERT INTO "'.eDBPREFIX.'details" VALUES('.eVID.', \''.pg_escape_string (eADDRESS).'\', '.time().')');
         if (eROBOT && !$GLOBALS['CountRobots']) return (0);
         $Date = date ('Y-m-d');
         $Time = date (' H:00:00');
         $Query = defined ('eNEWVISITOR')?'"uni" = "uni" + 1':'"all" = "all" + 1';
         $Result = pg_query (eDB, 'UPDATE "'.eDBPREFIX.'hours" SET '.$Query.' WHERE "time" = \''.$Date.$Time.'\'');
         if (!pg_affected_rows ($Result)) pg_query (eDB, 'INSERT INTO "'.eDBPREFIX.'hours" VALUES (\''.$Date.$Time.'\', '.(defined ('eNEWVISITOR')?'1, 0':'0, 1').')');
         pg_query (eDB, 'UPDATE "'.eDBPREFIX.'daysofweekpopularity" SET '.$Query.' WHERE "day" = '.date ('w'));
         pg_query (eDB, 'UPDATE "'.eDBPREFIX.'hourspopularity" SET '.$Query.' WHERE "hour" = '.date ('G'));
         $Result = pg_query (eDB, 'UPDATE "'.eDBPREFIX.'archive" SET '.$Query.' WHERE "date" = \''.$Date.'\'');
         if (!pg_affected_rows ($Result)) pg_query (eDB, 'INSERT INTO "'.eDBPREFIX.'archive" VALUES (\''.$Date.'\', '.(defined ('eNEWVISITOR')?'1, 0':'0, 1').')');
         }
function ignored_visit ($Blocked = 0) {
         $Result = pg_query (eDB, 'UPDATE "'.eDBPREFIX.'ignored" SET '.($this->query ('SELECT "ip" FROM "'.eDBPREFIX.'ignored" WHERE "ip" = \''.pg_escape_string (eIP).'\' AND ('.time ().' - "lastuni" < 4320)', 1)?'"all" = "all" + 1, "lastall"':'"uni" = "uni" + 1, "ua" = \''.pg_escape_string ($_SERVER['HTTP_USER_AGENT']).'\', "lastuni"').' = '.time ().' WHERE "ip" = \''.pg_escape_string (eIP).'\' AND "type" = '.(int) $Blocked);
         if (!pg_affected_rows ($Result)) pg_query (eDB, 'INSERT INTO "'.eDBPREFIX.'ignored" VALUES('.time ().', '.time ().', '.time ().', \''.pg_escape_string (eIP).'\', 1, 0, \''.pg_escape_string ($_SERVER['HTTP_USER_AGENT']).'\', '.(int) $Blocked.')');
         }
function backup ($Profile) {
         $DBPrefix = eDBPREFIX;
         if ($Profile[2]) if (!include (ePATH.'db/PGSQL/schema.php')) return (0);
         $Backup = 'BEGIN WORK;
';
         for ($i = 0, $c = count ($Profile[1]); $i < $c; $i++) {
             if ($Profile[3]) $Backup.= 'DELETE FROM "'.eDBPREFIX.$Profile[1][$i].'";
';
             if ($Profile[2]) $Backup.= 'DROP TABLE IF EXISTS "'.eDBPREFIX.$Profile[1][$i].'";
'.$Schema[$Profile[1][$i]].';
LOCK TABLE "'.eDBPREFIX.$Profile[1][$i].'" IN EXCLUSIVE MODE;
';
             $Result = pg_query (eDB, 'SELECT * FROM '.eDBPREFIX.$Profile[1][$i]);
             while ($Row = pg_fetch_row ($Result)) {
                   $Values = array ();
                   for ($v = 0, $l = count ($Row); $v < $l; $v++) $Values[] = pg_escape_string ($Row[$v]);
                   $Backup.= 'INSERT INTO "'.eDBPREFIX.$Profile[1][$i].'" VALUES (\''.implode ('\', \'', $Values).'\');
';
                   }
             }
         return ($Backup.'COMMIT WORK;');
         }
function log ($Log, $Info) {
         if (!defined ('eCRITICAL')) pg_query (eDB, 'INSERT INTO "'.eDBPREFIX.'logs" VALUES('.time ().', '.(int) $Log.', \''.($Info?pg_escape_string ($Info):'').'\')');
         }
function config_get ($Mode) {
         $Data = array ();
         $Result = pg_query (eDB, 'SELECT * FROM "'.eDBPREFIX.'configuration" WHERE "mode" = '.(int) $Mode);
         while ($Row = pg_fetch_row ($Result)) $Data[$Row[0]] = $Row[1];
         return ($Data);
         }
function config_set ($Array, $Notify = 1) {
         foreach ($Array as $Key => $Value) {
                 $Result = pg_query ('UPDATE "'.eDBPREFIX.'configuration" SET "value" = \''.pg_escape_string ($Value).'\' WHERE "name" = \''.$Key.'\'');
                 if (!pg_affected_rows ($Result)) pg_query (eDB, 'INSERT INTO "'.eDBPREFIX.'configuration" VALUES(\''.$Key.'\', \''.pg_escape_string ($Value).'\', 1)');
                 }
         e_configuration (0, 1);
         e_configuration (1, 1);
         if ($Notify) e_log (2, 1);
         }
}
?>