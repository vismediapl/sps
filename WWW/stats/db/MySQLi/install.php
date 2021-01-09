<?php
if (!$DB = mysqli_connect ($_POST['DBHost'], $_POST['DBUser'], $_POST['DBPass'], $_POST['DBName'])) $Errors['DBStructure'] = 1;
$SQL = 'START TRANSACTION;
'.(isset ($_POST['replacetables'])?'DROP TABLE IF EXISTS `'.$_POST['DBPrefix'].'configuration`;
':'').'CREATE TABLE `'.$_POST['DBPrefix'].'configuration` (`name` varchar(50) NOT NULL, `value` text, `mode` tinyint(1) NOT NULL, PRIMARY KEY (`name`));
'.(isset ($_POST['replacetables'])?'DROP TABLE IF EXISTS `'.$_POST['DBPrefix'].'logs`;
':'').'CREATE TABLE `'.$_POST['DBPrefix'].'logs` (`time` int(11) NOT NULL, `log` smallint(6) NOT NULL, `info` text);
';
if ($_POST['Action'] == 'upgrade' && $CurrentDB != 'TXT') {
   $Input = array ();
   $Result = mysqli_query ($DB, 'SELECT * FROM `'.$_POST['DBPrefix'].'oses`');
   while ($Row = mysqli_fetch_row ($Result)) $Input[] = $Row;
   $OSes = e_convert_oses ($Input);
   $SQL.= 'ALTER TABLE `'.$_POST['DBPrefix'].'ignored` ADD COLUMN `type` tinyint(1) NOT NULL AFTER `ua`, ADD KEY (`ip`, `type`);
ALTER TABLE `'.$_POST['DBPrefix'].'oses` ADD COLUMN `version` text NOT NULL AFTER `num`;
ALTER TABLE `'.$_POST['DBPrefix'].'visitors` ADD COLUMN `proxy` varchar(50) NOT NULL AFTER `robot`, ADD COLUMN `proxyip` varchar(50) NOT NULL AFTER `proxy`;
ALTER TABLE `'.$_POST['DBPrefix'].'sites` CHANGE COLUMN `adress` `address` text NOT NULL;
DELETE FROM `'.$_POST['DBPrefix'].'oses`;
';
   for ($i = 0, $c = count ($OSes); $i < $c; $i++) $SQL.= 'INSERT INTO `'.$_POST['DBPrefix'].'oses` VALUES(\''.$OSes[$i][0].'\', \''.mysqli_escape_string ($DB, $OSes[$i][1]).'\', '.mysqli_escape_string ($DB, $OSes[$i][2]).', \''.$OSes[$i][3].'\');
';
   $SQL.= 'DELETE FROM `'.$_POST['DBPrefix'].'visitors`;
DELETE FROM `'.$_POST['DBPrefix'].'details`;
'.(isset ($_POST['replacetables'])?'DROP TABLE IF EXISTS `'.$_POST['DBPrefix'].'websearchers`;
':'').'CREATE TABLE `'.$_POST['DBPrefix'].'websearchers` (`date` date NOT NULL, `name` text NOT NULL, `num` int(11) NOT NULL);
';
   if (isset ($_POST['convertlogs']) && isset ($LogConverted)) {
      for ($i = 0, $c = count ($LogConverted); $i < $c; $i++) $SQL.= 'INSERT INTO `'.$_POST['DBPrefix'].'logs` VALUES('.$LogConverted[$i][0].', '.$LogConverted[$i][1].', \''.mysqli_escape_string ($LogConverted[$i][2]).'\');';
      }
   }
else {
     $SQL.= (isset ($_POST['replacetables'])?'DROP TABLE IF EXISTS `'.$_POST['DBPrefix'].'daysofweekpopularity`;
':'').'CREATE TABLE `'.$_POST['DBPrefix'].'daysofweekpopularity` (`day` tinyint(1) NOT NULL, `uni` int(11) NOT NULL, `all` int(11) NOT NULL, PRIMARY KEY (`day`));
'.(isset ($_POST['replacetables'])?'DROP TABLE IF EXISTS `'.$_POST['DBPrefix'].'hourspopularity`;
':'').'CREATE TABLE `'.$_POST['DBPrefix'].'hourspopularity` (`hour` tinyint(2) NOT NULL, `uni` int(11) NOT NULL, `all` int(11) NOT NULL, PRIMARY KEY (`hour`));
'.(isset ($_POST['replacetables'])?'DROP TABLE IF EXISTS `'.$_POST['DBPrefix'].'archive`;
':'').'CREATE TABLE `'.$_POST['DBPrefix'].'archive` (`date` date NOT NULL, `uni` int(11) NOT NULL, `all` int(11) NOT NULL, PRIMARY KEY (`date`));
'.(isset ($_POST['replacetables'])?'DROP TABLE IF EXISTS `'.$_POST['DBPrefix'].'visitors`;
':'').'CREATE TABLE `'.$_POST['DBPrefix'].'visitors` (`uid` int(11) NOT NULL, `ip` text NOT NULL, `ua` text NOT NULL, `host` text NOT NULL, `referrer` text NOT NULL, `lang` text NOT NULL, `js` text NOT NULL, `cookies` text NOT NULL, `flash` text NOT NULL, `java` text NOT NULL, `screen` text NOT NULL, `info` tinyint(4) NOT NULL, `robot` varchar(50) NOT NULL, `proxy` varchar(50) NOT NULL, `proxyip` varchar(50) NOT NULL, PRIMARY KEY (`uid`));
'.(isset ($_POST['replacetables'])?'DROP TABLE IF EXISTS `'.$_POST['DBPrefix'].'details`;
':'').'CREATE TABLE `'.$_POST['DBPrefix'].'details` (`uid` int(11) NOT NULL, `sid` text NOT NULL, `time` int(12) NOT NULL);
'.(isset ($_POST['replacetables'])?'DROP TABLE IF EXISTS `'.$_POST['DBPrefix'].'ignored`;
':'').'CREATE TABLE `'.$_POST['DBPrefix'].'ignored` (`lastall` int(12) NOT NULL, `lastuni` int(12) NOT NULL, `first` int(12) NOT NULL, `ip` varchar(20) NOT NULL, `uni` int(11) NOT NULL, `all` int(11) NOT NULL, `ua` text NOT NULL, `type` tinyint(1) NOT NULL, PRIMARY KEY (`ip`, `type`));
'.(isset ($_POST['replacetables'])?'DROP TABLE IF EXISTS `'.$_POST['DBPrefix'].'hours`;
':'').'CREATE TABLE `'.$_POST['DBPrefix'].'hours` (`time` datetime NOT NULL, `uni` int(11) NOT NULL, `all` int(11) NOT NULL, PRIMARY KEY (`time`));
'.(isset ($_POST['replacetables'])?'DROP TABLE IF EXISTS `'.$_POST['DBPrefix'].'browsers`;
':'').'CREATE TABLE `'.$_POST['DBPrefix'].'browsers` (`date` date NOT NULL, `name` text NOT NULL, `num` int(11) NOT NULL, `version` text NOT NULL);
'.(isset ($_POST['replacetables'])?'DROP TABLE IF EXISTS `'.$_POST['DBPrefix'].'oses`;
':'').'CREATE TABLE `'.$_POST['DBPrefix'].'oses` (`date` date NOT NULL, `name` text NOT NULL, `num` int(11) NOT NULL, `version` text NOT NULL);
'.(isset ($_POST['replacetables'])?'DROP TABLE IF EXISTS `'.$_POST['DBPrefix'].'sites`;
':'').'CREATE TABLE `'.$_POST['DBPrefix'].'sites` (`date` date NOT NULL, `name` text NOT NULL, `num` int(11) NOT NULL, `address` text NOT NULL);
';
     $DBTables = array ('cookies', 'flash', 'hosts', 'java', 'javascript', 'keywords', 'langs', 'referrers', 'robots', 'screens', 'websearchers');
     for ($i = 0; $i < count ($DBTables); $i++) $SQL.= ''.(isset ($_POST['replacetables'])?'DROP TABLE IF EXISTS `'.$_POST['DBPrefix'].$DBTables[$i].'`;
':'').'CREATE TABLE `'.$_POST['DBPrefix'].$DBTables[$i].'` (`date` date NOT NULL, `name` text NOT NULL, `num` int(11) NOT NULL);
';
     for ($i = 0; $i < 7; $i++) $SQL.= 'INSERT INTO `'.$_POST['DBPrefix'].'daysofweekpopularity` VALUES('.$i.', 0, 0);
';
     for ($i = 0; $i < 24; $i++) $SQL.= 'INSERT INTO `'.$_POST['DBPrefix'].'hourspopularity` VALUES('.$i.', 0, 0);
';
     }
$SQL.= 'INSERT INTO `'.$_POST['DBPrefix'].'logs` VALUES('.(($_POST['Action'] == 'upgrade')?$LastReset.', 0, \'4.0\'':time ().', 0, \''.$eStats['version'].'\'').');
';
foreach ($Array as $Group => $Value) {
        foreach ($Value as $SGroup => $Option) {
                if (is_array (reset ($Option))) {
                   foreach ($Option as $Field => $SOption) $SQL.= 'INSERT INTO `'.$_POST['DBPrefix'].'configuration` VALUES(\''.$SGroup.'|'.$Field.'\', \''.mysqli_escape_string ($DB, $SOption[0]).'\', '.(int) ($Group != 'Stats').');
';
                   }
                else $SQL.= 'INSERT INTO `'.$_POST['DBPrefix'].'configuration` VALUES(\''.$SGroup.'\', \''.mysqli_escape_string ($DB, $Option[0]).'\', '.(int) ($Group != 'Stats').');
';
                }
        }
if ($_POST['Action'] == 'upgrade') {
   if (isset ($_POST['convertlogs']) && isset ($LogConverted)) {
      for ($i = 0, $c = count ($LogConverted); $i < $c; $i++) $SQL.= 'INSERT INTO `'.$_POST['DBPrefix'].'logs` VALUES('.$LogConverted[$i][0].', '.$LogConverted[$i][1].', \''.mysqli_escape_string ($DB, $LogConverted[$i][2]).'\');';
      }
   if ($CurrentDB == 'TXT') {
      for ($i = 0, $c = count ($Files); $i < $c; $i++) {
          if ($Files[$i] == 'vbrowsers') $Files[$i] = 'browsers';
          for ($j = 0, $l = count ($Output[$Files[$i]]); $j < $l; $j++) $SQL.= 'INSERT INTO `'.$_POST['DBPrefix'].$Files[$i].'` VALUES(1, \''.mysql_escape_string ($Output[$Files[$i]][$j][0]).'\', '.$Output[$Files[$i]][$j][1].(in_array ($Files[$i], array ('browsers', 'oses', 'sites'))?', \''.mysqli_escape_string ($DB, $Output[$Files[$i]][$j][2]).'\'':'').');
';
          }
      for ($i = 0, $c = count ($Output['archive']); $i < $c; $i++) $SQL.= 'INSERT INTO `'.$_POST['DBPrefix'].'archive` VALUES('.$Output['archive'][$i][0].', '.e_date ('Y', $Output['archive'][$i][0]).', '.e_date ('n', $Output['archive'][$i][0]).', '.e_date ('j', $Output['archive'][$i][0]).', '.$Output['archive'][$i][1].', '.$Output['archive'][$i][2].');
';
      for ($i = 0; $i < 24; $i++) $SQL.= 'INSERT INTO `'.$_POST['DBPrefix'].'hours` VALUES('.$Output['hours'][$i][0].', '.e_date ('G', $Output['hours'][$i][0]).', '.$Output['hours'][$i][1].', '.$Output['hours'][$i][2].');
';
      for ($i = 0; $i < 24; $i++) $SQL.= 'INSERT INTO `'.$_POST['DBPrefix'].'hourspopularity` VALUES('.$i.', '.$Output['hourspopularity'][$i][0].', '.$Output['hourspopularity'][$i][1].');
';
      for ($i = 0; $i < 7; $i++) $SQL.= 'INSERT INTO `'.$_POST['DBPrefix'].'daysofweekpopularity` VALUES('.$i.', '.$Output['daysofweekpopularity'][$i][0].', '.$Output['daysofweekpopularity'][$i][1].');
';
      }
   $SQL.= 'INSERT INTO `'.$_POST['DBPrefix'].'logs` VALUES('.time ().', 1, \'From 4.0 to '.$eStats['version'].'\');
UPDATE `'.$_POST['DBPrefix'].'oses` SET `name` = \'MacOS\' WHERE `name` = \'Mac\';
UPDATE `'.$_POST['DBPrefix'].'cookies` SET `name` = 0 WHERE `name` = \'_0\';
UPDATE `'.$_POST['DBPrefix'].'cookies` SET `name` = 1 WHERE `name` = \'_1\';
UPDATE `'.$_POST['DBPrefix'].'java` SET `name` = 0 WHERE `name` = \'_0\';
UPDATE `'.$_POST['DBPrefix'].'java` SET `name` = 1 WHERE `name` = \'_1\';
UPDATE `'.$_POST['DBPrefix'].'javascript` SET `name` = 0 WHERE `name` = \'_0\';
UPDATE `'.$_POST['DBPrefix'].'javascript` SET `name` = 1 WHERE `name` = \'_1\';
';
   for ($i = 0; $i < 10; $i++) $SQL.= 'UPDATE `'.$_POST['DBPrefix'].'flash` SET `name` = '.$i.' WHERE `name` = \'_'.$i.'\';
';
   }
$SQL.= 'COMMIT;';
if (!isset ($_POST['onlygeneratesql'])) if (!mysqli_multi_query ($DB, $SQL)) $Errors['DBStructure'] = 1;
?>