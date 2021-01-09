<?php
$_POST['DBString'] = e_connection_string ();
$DBPrefix = $_POST['DBPrefix'];
$COptions = array (
	'DBString' => array ('', 1),
	'DBPrefix' => array ('estats_', 1),
	'PConnect' => array (0, 0)
	);
if (!$DB = pg_connect ($_POST['DBString'])) $Errors['DBStructure'] = 1;
if (!include ('db/PGSQL/schema.php')) e_error ('db/PGSQL/schema.php', __FILE__, __LINE__);
$SQL = 'BEGIN WORK;
';
foreach ($Schema as $Key => $Value) $SQL.= (isset ($_POST['replacetables'])?'DROP TABLE IF EXISTS "'.$DBPrefix.$Key.'";
':'').$Value.';
';
$SQL.= 'INSERT INTO "'.$_POST['DBPrefix'].'logs" VALUES('.(($_POST['Action'] == 'upgrade')?$LastReset.', 0, \'4.0\'':time ().', 0, \''.$eStats['version'].'\'').');
';
for ($i = 0; $i < 7; $i++) $SQL.= 'INSERT INTO "'.$_POST['DBPrefix'].'daysofweekpopularity" VALUES('.$i.', 0, 0);
';
for ($i = 0; $i < 24; $i++) $SQL.= 'INSERT INTO "'.$_POST['DBPrefix'].'hourspopularity" VALUES('.$i.', 0, 0);
';
foreach ($Array as $Group => $Value) {
        foreach ($Value as $SGroup => $Option) {
                if (is_array (reset ($Option))) {
                   foreach ($Option as $Field => $SOption) $SQL.= 'INSERT INTO "'.$_POST['DBPrefix'].'configuration" VALUES(\''.$SGroup.'|'.$Field.'\', \''.pg_escape_string ($SOption[0]).'\', '.(int) ($Group != 'Stats').');
';
                   }
                else $SQL.= 'INSERT INTO "'.$_POST['DBPrefix'].'configuration" VALUES(\''.$SGroup.'\', \''.pg_escape_string ($Option[0]).'\', '.(int) ($Group != 'Stats').');
';
                }
        }
if ($_POST['Action'] == 'upgrade') {
   if (isset ($_POST['convertlogs']) && isset ($LogConverted)) {
      for ($i = 0, $c = count ($LogConverted); $i < $c; $i++) $SQL.= 'INSERT INTO "'.$_POST['DBPrefix'].'logs" VALUES('.$LogConverted[$i][0].', '.$LogConverted[$i][1].', \''.pg_escape_string ($LogConverted[$i][2]).'\');';
      }
   if ($CurrentDB == 'TXT') {
      for ($i = 0, $c = count ($Files); $i < $c; $i++) {
          if ($Files[$i] == 'vbrowsers') $Files[$i] = 'browsers';
          for ($j = 0, $l = count ($Output[$Files[$i]]); $j < $l; $j++) $SQL.= 'INSERT INTO "'.$_POST['DBPrefix'].$Files[$i].'" VALUES(1, \''.pg_escape_string ($Output[$Files[$i]][$j][0]).'\', '.$Output[$Files[$i]][$j][1].(in_array ($Files[$i], array ('browsers', 'oses', 'sites'))?', \''.pg_escape_string ($Output[$Files[$i]][$j][2]).'\'':'').');
';
          }
      for ($i = 0, $c = count ($Output['archive']); $i < $c; $i++) $SQL.= 'INSERT INTO "'.$_POST['DBPrefix'].'archive" VALUES('.$Output['archive'][$i][0].', '.e_date ('Y', $Output['archive'][$i][0]).', '.e_date ('n', $Output['archive'][$i][0]).', '.e_date ('j', $Output['archive'][$i][0]).', '.$Output['archive'][$i][1].', '.$Output['archive'][$i][2].');
';
      for ($i = 0; $i < 24; $i++) $SQL.= 'INSERT INTO "'.$_POST['DBPrefix'].'hours" VALUES('.$Output['hours'][$i][0].', '.e_date ('G', $Output['hours'][$i][0]).', '.$Output['hours'][$i][1].', '.$Output['hours'][$i][2].');
';
      for ($i = 0; $i < 24; $i++) $SQL.= 'INSERT INTO "'.$_POST['DBPrefix'].'hourspopularity" VALUES('.$i.', '.$Output['hourspopularity'][$i][0].', '.$Output['hourspopularity'][$i][1].');
';
      for ($i = 0; $i < 7; $i++) $SQL.= 'INSERT INTO "'.$_POST['DBPrefix'].'daysofweekpopularity" VALUES('.$i.', '.$Output['daysofweekpopularity'][$i][0].', '.$Output['daysofweekpopularity'][$i][1].');
';
      }
   $SQL.= 'INSERT INTO "'.$_POST['DBPrefix'].'logs" VALUES('.time ().', 1, \'From 4.0 to '.$eStats['version'].'\');
UPDATE "'.$_POST['DBPrefix'].'oses" SET "name" = \'MacOS\' WHERE "name" = \'Mac\';
UPDATE "'.$_POST['DBPrefix'].'cookies" SET "name" = 0 WHERE "name" = \'_0\';
UPDATE "'.$_POST['DBPrefix'].'cookies" SET "name" = 1 WHERE "name" = \'_1\';
UPDATE "'.$_POST['DBPrefix'].'java" SET "name" = 0 WHERE "name" = \'_0\';
UPDATE "'.$_POST['DBPrefix'].'java" SET "name" = 1 WHERE "name" = \'_1\';
UPDATE "'.$_POST['DBPrefix'].'javascript" SET "name" = 0 WHERE "name" = \'_0\';
UPDATE "'.$_POST['DBPrefix'].'javascript" SET "name" = 1 WHERE "name" = \'_1\';
';
   for ($i = 0; $i < 10; $i++) $SQL.= 'UPDATE "'.$_POST['DBPrefix'].'flash" SET "name" = '.$i.' WHERE "name" = \'_'.$i.'\';
';
   }
$SQL.= 'COMMIT WORK;';
if (!isset ($_POST['onlygeneratesql'])) if (!pg_query ($DB, $SQL)) $Errors['DBStructure'] = 1;
?>