<?php
$DBFile = 'data/estats_'.$DBID.'.sqlite';
if ($_POST['Action'] == 'upgrade' && $CurrentDB != 'TXT') {
   copy ('data/estats.sqlite', $DBFile);
   if (!is_file ($DBFile)) $Errors['DBStructure'] = 1;
   }
else touch ($DBFile);
chmod ($DBFile, 0666);
if (!$DB = sqlite_open ($DBFile, 0666)) $Errors['DBStructure'] = 1;
$SQL = 'BEGIN;
'.(isset ($_POST['replacetables'])?'DROP TABLE "logs";
':'').'CREATE TABLE "logs" ("time" integer, "log" integer, "info" text);
'.(isset ($_POST['replacetables'])?'DROP TABLE "configuration";
':'').'CREATE TABLE "configuration" ("name" text PRIMARY KEY, "value" text, "mode" integer);
'.(isset ($_POST['replacetables'])?'DROP TABLE "archive";
':'').'CREATE TABLE "archive" ("time" integer PRIMARY KEY, "year" integer, "month" integer, "day" integer, "uni" integer, "all" integer);
'.(isset ($_POST['replacetables'])?'DROP TABLE "hours";
':'').'CREATE TABLE "hours" ("time" integer, "hour" integer, "uni" integer, "all" integer);
'.(isset ($_POST['replacetables'])?'DROP TABLE "visitors";
':'').'CREATE TABLE "visitors" ("uid" integer PRIMARY KEY, "ip" text, "ua" text, "host" text, "referrer" text, "lang" text, "js" text, "cookies" text, "flash" text, "java" text, "screen" text, "info" integer, "robot" text, "proxy" text, "proxyip" text);
'.(isset ($_POST['replacetables'])?'DROP TABLE "details";
':'').'CREATE TABLE "details" ("uid" integer, "sid" text, "time" integer);
'.(isset ($_POST['replacetables'])?'DROP TABLE "ignored";
':'').'CREATE TABLE "ignored" ("lastall" integer, "lastuni" integer, "first" integer, "ip" text, "uni" integer, "all" integer, "ua" text, "type" integer, PRIMARY KEY("ip", "type"));
'.(isset ($_POST['replacetables'])?'DROP TABLE "daysofweekpopularity";
':'').'CREATE TABLE "daysofweekpopularity" ("day" integer PRIMARY KEY, "uni" integer, "all" integer);
'.(isset ($_POST['replacetables'])?'DROP TABLE "hourspopularity";
':'').'CREATE TABLE "hourspopularity" ("hour" integer PRIMARY KEY, "uni" integer, "all" integer);
'.(isset ($_POST['replacetables'])?'DROP TABLE "browsers";
':'').'CREATE TABLE "browsers" ("time" integer, "name" text, "num" integer, "version" text);
'.(isset ($_POST['replacetables'])?'DROP TABLE "oses";
':'').'CREATE TABLE "oses" ("time" integer, "name" text, "num" integer, "version" text);
'.(isset ($_POST['replacetables'])?'DROP TABLE "sites";
':'').'CREATE TABLE "sites" ("time" integer, "name" text, "num" integer, "address" text);
';
$DBTables = array ('cookies', 'flash', 'hosts', 'java', 'javascript', 'keywords', 'langs', 'referrers', 'robots', 'screens', 'websearchers');
for ($i = 0, $c = count ($DBTables); $i < $c; $i++) $SQL.= (isset ($_POST['replacetables'])?'DROP TABLE "'.$DBTables[$i].'";
':'').'CREATE TABLE "'.$DBTables[$i].'" ("time" integer, "name" text, "num" integer);
';
$SQL.= 'INSERT INTO "logs" VALUES('.(($_POST['Action'] == 'upgrade')?$LastReset.', 0, \'4.0\'':time ().', 0, \''.$eStats['version'].'\'').');
';
if ($_POST['Action'] != 'upgrade') {
   for ($i = 0; $i < 7; $i++) $SQL.= 'INSERT INTO "daysofweekpopularity" VALUES('.$i.', 0, 0);
';
   for ($i = 0; $i < 24; $i++) $SQL.= 'INSERT INTO "hourspopularity" VALUES('.$i.', 0, 0);
';
   }
foreach ($Array as $Group => $Value) {
        foreach ($Value as $SGroup => $Option) {
                if (is_array (reset ($Option))) {
                   foreach ($Option as $Field => $SOption) $SQL.= 'INSERT INTO "configuration" VALUES(\''.$SGroup.'|'.$Field.'\', \''.sqlite_escape_string ($SOption[0]).'\', '.(int) ($Group != 'Stats').');
';
                   }
                else $SQL.= 'INSERT INTO "configuration" VALUES(\''.$SGroup.'\', \''.sqlite_escape_string ($Option[0]).'\', '.(int) ($Group != 'Stats').');
';
                }
        }
if ($_POST['Action'] == 'upgrade' && $CurrentDB != 'TXT') {
   unset ($DBTables[10]);
   $DBTables = array_merge ($DBTables, array ('archive', 'hours', 'daysofweekpopularity', 'hourspopularity', 'browsers', 'sites'));
   for ($i = 0, $c = count ($DBTables); $i < $c; $i++) $SQL.= 'INSERT INTO "'.$DBTables[$i].'" SELECT * FROM "e_'.$DBTables[$i].'";
DROP TABLE "e_'.$DBTables[$i].'";
';
   $OSes = e_convert_oses (sqlite_array_query ($DB, 'SELECT * FROM "e_oses"', SQLITE_NUM));
   for ($i = 0, $c = count ($OSes); $i < $c; $i++) $SQL.= 'INSERT INTO "oses" VALUES('.$OSes[$i][0].', \''.sqlite_escape_string ($OSes[$i][1]).'\', '.sqlite_escape_string ($OSes[$i][2]).', \''.$OSes[$i][3].'\');
';
   $SQL.= 'DROP TABLE "e_oses";
INSERT INTO "ignored" ("lastall", "lastuni", "first", "ip", "uni", "all", "ua") SELECT * FROM "e_ignored";
DROP TABLE "e_ignored";
DROP TABLE "e_details";
';
   }
if ($_POST['Action'] == 'upgrade') {
   if (isset ($_POST['convertlogs']) && isset ($LogConverted)) {
      for ($i = 0, $c = count ($LogConverted); $i < $c; $i++) $SQL.= 'INSERT INTO "logs" VALUES('.$LogConverted[$i][0].', '.$LogConverted[$i][1].', \''.sqlite_escape_string ($LogConverted[$i][2]).'\');
';
      }
   if ($CurrentDB == 'TXT') {
      for ($i = 0, $c = count ($Files); $i < $c; $i++) {
          if ($Files[$i] == 'vbrowsers') $Files[$i] = 'browsers';
          for ($j = 0, $l = count ($Output[$Files[$i]]); $j < $l; $j++) $SQL.= 'INSERT INTO "'.$Files[$i].'" VALUES(1, \''.sqlite_escape_string ($Output[$Files[$i]][$j][0]).'\', '.$Output[$Files[$i]][$j][1].(in_array ($Files[$i], array ('browsers', 'oses', 'sites'))?', \''.sqlite_escape_string ($Output[$Files[$i]][$j][2]).'\'':'').');
';
          }
      for ($i = 0, $c = count ($Output['archive']); $i < $c; $i++) $SQL.= 'INSERT INTO "archive" VALUES('.$Output['archive'][$i][0].', '.e_date ('Y', $Output['archive'][$i][0]).', '.e_date ('n', $Output['archive'][$i][0]).', '.e_date ('j', $Output['archive'][$i][0]).', '.$Output['archive'][$i][1].', '.$Output['archive'][$i][2].');
';
      for ($i = 0; $i < 24; $i++) $SQL.= 'INSERT INTO "hours" VALUES('.$Output['hours'][$i][0].', '.e_date ('G', $Output['hours'][$i][0]).', '.$Output['hours'][$i][1].', '.$Output['hours'][$i][2].');
';
      for ($i = 0; $i < 24; $i++) $SQL.= 'INSERT INTO "hourspopularity" VALUES('.$i.', '.$Output['hourspopularity'][$i][0].', '.$Output['hourspopularity'][$i][1].');
';
      for ($i = 0; $i < 7; $i++) $SQL.= 'INSERT INTO "daysofweekpopularity" VALUES('.$i.', '.$Output['daysofweekpopularity'][$i][0].', '.$Output['daysofweekpopularity'][$i][1].');
';
      }
   $SQL.= 'INSERT INTO "logs" VALUES('.time ().', 1, \'From 4.0 to '.$eStats['version'].'\');
UPDATE "oses" SET "name" = \'MacOS\' WHERE "name" = \'Mac\';
UPDATE "cookies" SET "name" = 0 WHERE "name" = \'_0\';
UPDATE "cookies" SET "name" = 1 WHERE "name" = \'_1\';
UPDATE "java" SET "name" = 0 WHERE "name" = \'_0\';
UPDATE "java" SET "name" = 1 WHERE "name" = \'_1\';
UPDATE "javascript" SET "name" = 0 WHERE "name" = \'_0\';
UPDATE "javascript" SET "name" = 1 WHERE "name" = \'_1\';
';
   for ($i = 0; $i < 10; $i++) $SQL.= 'UPDATE "flash" SET "name" = '.$i.' WHERE "name" = \'_'.$i.'\';
';
   }
$SQL.= 'COMMIT;
VACUUM;';
if (!isset ($_POST['onlygeneratesql'])) {
   if (!function_exists ('sqlite_exec')) {
      $Array = explode (';
', $SQL);
      for ($i = 0, $c = count ($Array); $i < $c; $i++) if ($Array[$i]) sqlite_query ($DB, $Array[$i]) or $Errors['DBStructure'] = 1;
      }
   else if (!sqlite_exec ($DB, $SQL)) $Errors['DBStructure'] = 1;
   }
?>