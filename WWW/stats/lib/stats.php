<?php
$DBTables = array ('archive', 'browsers', 'cookies', 'daysofweekpopularity', 'details', 'flash', 'hosts', 'hours', 'hourspopularity', 'ignored', 'java', 'javascript', 'keywords', 'langs', 'oses', 'referrers', 'robots', 'screens', 'sites', 'visitors', 'websearchers');
if (!defined ('eINSTALL')) {
   if (!include (ePATH.'db/'.$DBType.'/info.php')) e_error ('db/'.$DBType.'/info.php', __FILE__, __LINE__);
   if (!include (ePATH.'var/oses.php')) e_error ('var/oses.php', __FILE__, __LINE__);
   }
function e_create_data_dirs () {
         $Dirs = array ('backups', 'cache');
         for ($i = 0, $c = count ($Dirs); $i < $c; $i++) {
             $DirName = ePATH.'data/'.$Dirs[$i].'/';
             if (!is_dir ($DirName)) mkdir ($DirName);
             if (!is_writeable ($DirName)) chmod ($DirName, 0777);
             }
         }
function e_lang () {
         if (!isset ($_SERVER['HTTP_ACCEPT_LANGUAGE']) || !$_SERVER['HTTP_ACCEPT_LANGUAGE']) return ('?');
         $String = strtolower ($_SERVER['HTTP_ACCEPT_LANGUAGE']);
         return (substr ($String, 0, (strlen ($String) > 2 && $String[2] == '-')?5:2));
         }
function e_headers () {
         header ('Expires: '.gmdate ('r', 0));
         header ('Last-Modified: '.gmdate ('r'));
         header ('Cache-Control: no-store, no-cache, must-revalidate');
         header ('Pragma: no-cache');
         }
function e_ip ($IP, $IPs) {
         for ($i = 0, $c = count ($IPs); $i < $c; $i++) if ($IPs[$i] == $IP || (strstr ($IPs[$i], '*') && substr ($IP, 0, (strlen ($IPs[$i]) - 1)) == substr ($IPs[$i], 0, - 1))) return (1);
         }
function e_read ($Path) {
         $Path.= '_'.$GLOBALS['DBID'];
         return (is_file (ePATH.'data/'.$Path.'.dat')?unserialize (file_get_contents (ePATH.'data/'.$Path.'.dat')):'');
         }
function e_new_visitor_id ($Max, $Uni) {
         $Num = (($Max > $Uni)?$Max:$Uni);
         return (++$Num);
         }
function e_save ($Path, $Data) {
         $Path.= '_'.$GLOBALS['DBID'];
         if (!is_writable (ePATH.'data/'.$Path.'.dat')) {
            if (!is_writable (dirname (ePATH.'data/'.$Path.'.dat'))) e_create_data_dirs ();
            touch (ePATH.'data/'.$Path.'.dat');
            chmod (ePATH.'data/'.$Path.'.dat', 0666);
            }
         file_put_contents (ePATH.'data/'.$Path.'.dat', serialize ($Data));
         }
function e_create_backup ($Profile = 0) {
         global $DB, $DBTables, $DBInfo;
         $Error = 0;
         $BID = $GLOBALS['LastReset'].'-'.time ();
         if ($Profile[0] == 'data') $Profile = array ('data', $DBTables, 0, 1);
         else if ($Profile[0] == 'full') $Profile = array ('full', array_merge ($DBTables, array ('logs', 'configuration')), 1, 1);
         else if ($Profile[0] != 'user') $Profile = array ($GLOBALS['Backups']['profile'], $GLOBALS['Backups']['usertables'], $GLOBALS['Backups']['tablesstructure'], $GLOBALS['Backups']['replacedata']);
         $BFile = ePATH.'data/backups/'.$BID.'.'.$Profile[0].'.sql.bak';
         touch ($BFile) or $Error = 1;
         chmod ($BFile, 0666);
         file_put_contents ($BFile, '/*
eStats v'.$GLOBALS['Version'].' database backup
Database type: '.$DBInfo['db'].' '.$DBInfo['dbversion'].'
Module: '.$DBInfo['module'].' v'.$DBInfo['version'].' ('.$DBInfo['url'].')
Creation date: '.date ('m.d.Y H:i:s').'
Backup mode: '.$Profile[0].'
*/

'.$DB->backup ($Profile)) or $Error = 1;
         if (!$Error) $DB->config_set (array ('LastBackup' => time ()), 0);
         e_log (($Error?21:20), !$Error, 'ID: '.$BID);
         }
function e_log ($Log, $Type = 2, $Info = '') {
         global $DB;
         if ((int) $Type != 2) $GLOBALS['Info'][] = array ($Log, $Type);
         if ($GLOBALS['LogEnabled']) $DB->log ($Log, $Info);
         if ($GLOBALS['LogFile']) {
            if (!is_writable (ePATH.'data/estats_'.$GLOBALS['DBID'].'.log')) {
               touch ('data/estats_'.$GLOBALS['DBID'].'.log');
               chmod ('data/estats_'.$GLOBALS['DBID'].'.log', 0666);
               }
            $File = fopen (ePATH.'data/estats_'.$GLOBALS['DBID'].'.log', 'a');
            fwrite ($File, '
'.time ().'|'.$Log.'|'.$Info);
            fclose ($File);
            }
         }
function e_get_ip () {
         if (isset ($_SERVER['HTTP_VIA'])) {
            define ('ePROXYIP', $_SERVER['REMOTE_ADDR']);
            define ('ePROXY', $_SERVER['HTTP_VIA']);
            define ('eIP', $_SERVER[isset ($_SERVER['HTTP_X_FORWARDED_FOR'])?'HTTP_X_FORWARDED_FOR':(isset ($_SERVER['HTTP_X_FORWARDED'])?'HTTP_X_FORWARDED':$_SERVER['HTTP_CLIENT_IP'])]);
            }
         else define ('eIP', $_SERVER['REMOTE_ADDR']);
         }
function e_configuration ($Mode, $Refresh = 0) {
         $FName = 'cache/config-'.($Mode?'gui':'stats');
         if ($Refresh || !is_file (ePATH.'data/'.$FName.'.dat')) {
            global $DB;
            $Array = $DB->config_get ($Mode);
            foreach ($Array as $Key => $Value) {
                    $Key = explode ('|', $Key);
                    if (in_array ($Key[0], array ('Keywords', 'BlockedIPs', 'IgnoredIPs', 'Referrers')) || (isset ($Key[1]) && $Key[1] == 'usertables')) {
                       if (!$Value) $Value = array ();
                       else $Value = explode ('|', $Value);
                       }
                    $l = count ($Key);
                    if ($l > 2) $GLOBALS[$Key[0]][$Key[1]][$Key[2]] = $Data[$Key[0]][$Key[1]][$Key[2]] = $Value;
                    else if ($l > 1) $GLOBALS[$Key[0]][$Key[1]] = $Data[$Key[0]][$Key[1]] = $Value;
                    else $GLOBALS[$Key[0]] = $Data[$Key[0]] = $Value;
                    }
            e_save ($FName, $Data);
            }
         else {
              $Data = e_read ($FName);
              foreach ($Data as $Key => $Value) $GLOBALS[$Key] = $Value;
              }
        }
function e_browser ($String) {
         if (!$String) return ('?');
         if (!include (ePATH.'var/browsers.php')) e_error ('var/browsers.php', __FILE__, __LINE__);
         for ($i = 1, $c = count ($Browsers); $i < $c; $i += 2) {
             if (strstr ($String, $Browsers[$i])) {
                preg_match ('#'.$Browsers[$i - 1].'#i', $String, $Version);
                return (array ($Browsers[$i], $Version[1]));
                }
             }
         return (array ('?'));
         }
function e_keywords ($String) {
         $Array = explode (' ', $String);
         $Keywords = array ();
         for ($i = 0, $c = count ($Array); $i < $c; $i++) {
             if (strlen ($Array[$i]) > 1 && $Array[$i][0] != '-' && !in_array ($Array[$i], $GLOBALS['Keywords'])) $Keywords[] = $Array[$i];
             }
         return ($Keywords);
         }
function e_websearcher ($Referrer, $Phrase) {
         if (!isset ($Referrer['query'])) return ('');
         if (!include (ePATH.'var/websearchers.php')) e_error ('var/websearchers.php', __FILE__, __LINE__);
         parse_str ($Referrer['query'], $Query);
         for ($i = 1, $c = count ($Websearchers); $i < $c; $i += 2) {
             if (strstr ($Referrer['host'], $Websearchers[$i])) {
                $String = str_replace (array ('"', '\'', '+', '\\'), ' ', $Query[$Websearchers[$i - 1]]);
                return (array ('http://'.$Referrer['host'], ($Phrase?array ($String):e_keywords ($String))));
                }
             }
         return (0);
         }
function e_robot ($String) {
         if (!$String) return ('?');
         if (!include (ePATH.'var/robots.php')) e_error ('var/robots.php', __FILE__, __LINE__);
         $Var = reset ($Robots);
         while ($Var) {
               if (stristr ($String, $Var)) return (!is_numeric (array_search ($Var, $Robots))?array_search ($Var, $Robots):$Var);
               $Var = next ($Robots);
               }
         return (0);
         }
if (!function_exists ('file_put_contents')) {
   function file_put_contents ($Path, $Data) {
            $File = fopen ($Path, 'w');
            if (!fwrite ($File, $Data)) return (0);
            fclose ($File);
            return (1);
            }
   }
?>