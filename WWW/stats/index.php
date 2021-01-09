<?php
//=============eStats v4.5.20=============\\
// Author: Emdek                          \\
// URL: http://estats.emdek.cba.pl        \\
// Licence: GPL                           \\
// GUI: Default v4.5.20                   \\
// Last modified: 2007-09-29 14:11:06 UTC \\
//========================================\\

$eStats = array (
	'version' => '4.5.20',
	'status' => 'stable',
	'time' => 1191075066
	);

error_reporting (E_ALL);
if (function_exists ('ini_set')) ini_set ('display_errors', 0);
$Start = array_sum (explode (' ', microtime ()));
$ERRORS = '';
$ECounter = 0;
function e_error_handler ($ENo, $EString, $EFile, $ELine) {
         $GLOBALS['ERRORS'].= '<strong>'.$EFile.': <em>'.$ELine.'</em></strong> '.$EString.'<br />
';
         $GLOBALS['ECounter']++;
         }
function e_error ($Error, $File, $Line, $Arg = 0) {
         if (!defined ('eCRITICAL')) define ('eCRITICAL', 1);
         $GLOBALS['Info'][] = array (($Arg?$Error:'Could not load file! (<em>'.$Error.'</em>)').'<br />
<strong>'.$File.': <em>'.$Line.'</em></strong>', 0);
         }
set_error_handler ('e_error_handler');
session_start ();
define ('ePATH', '');
$Info = $Theme = $T = $L = $Log = array ();
$T['info'] = $T['menu'] = $T['page'] = $T['css'] = $LSelect = $TSelect = $Meta = $TForm = $SYears = $SMonths = '';
$TIndex = 1;
$DirName = dirname ($_SERVER['SCRIPT_NAME']);
$T['dpath'] = (($DirName == '/')?'':$DirName).'/';
include ('conf/config.php');
if (!defined ('eStats') || $IVersion !== substr ($eStats['version'], 0, 3)) {
   if (!include ('conf/default.php')) e_error ('conf/default.php', __FILE__, __LINE__);
   else {
        $Vars[1] = 'install';
        define ('eINSTALL', 1);
        }
   }
if (!include ('conf/menu.php')) e_error ('conf/menu.php', __FILE__, __LINE__);
if (!include ('var/langs.php')) e_error ('var/langs.php', __FILE__, __LINE__);
if (!include ('lib/stats.php')) e_error ('lib/stats.php', __FILE__, __LINE__);
if (!include ('lib/gui.php')) e_error ('lib/gui.php', __FILE__, __LINE__);
if (!defined ('eINSTALL') && !defined ('eCRITICAL')) {
   if (!include ('db/'.$DBType.'/stats.php')) e_error ('db/'.$DBType.'/stats.php', __FILE__, __LINE__);
   if (!defined ('eCRITICAL')) if (!include ('db/'.$DBType.'/gui.php')) e_error ('db/'.$DBType.'/gui.php', __FILE__, __LINE__);
   if (!defined ('eCRITICAL')) $DB = new estats_db_gui;
   if (!defined ('eCRITICAL')) {
      e_get_ip ();
      e_configuration (0);
      e_configuration (1);
      if ($Version != $eStats['version']) {
         e_log (1, 2, 'From: '.$Version.', to: '.$eStats['version']);
         $DB->config_set (array ('Version' => $eStats['version']), 0);
         e_configuration (1);
         }
      }
   }
if (defined ('eCRITICAL') && !include ('conf/default.php')) e_error ('conf/default.php', __FILE__, __LINE__);
if ($Path['mode']) $Vars = (isset ($_SERVER['PATH_INFO'])?explode ('/', substr ($_SERVER[((!$_SERVER['PATH_INFO'] && isset ($_SERVER['ORIG_PATH_INFO']))?'ORIG_':'').'PATH_INFO'], 1)):0);
else $Vars = (isset ($_GET['vars'])?explode ('/', $_GET['vars']):0);
if (!$Vars) $Vars = array ('', $DefaultPage);
if (!is_file ('pages/'.$Vars[1].'.php') && $Vars[1] != 'admin') $Vars[1] = $DefaultPage;
if (isset ($_POST['year'])) die (header ('Location: '.$T['dpath'].$Path['prefix'].$Vars[0].'/'.$Vars[1].'/'.$_POST['year'].'/'.$_POST['month'].$Path['suffix']));
if (function_exists ('date_default_timezone_set') && $TimeZone) date_default_timezone_set ($TimeZone);
if (!defined ('eINSTALL') && (!isset ($Vars[1]) || !$Vars[1] || $Vars[1] == 'install')) $Vars[1] = $DefaultPage;
if (isset ($_COOKIE['eTHEME'])) $_SESSION['eTHEME'] = $_COOKIE['eTHEME'];
if (isset ($_GET['theme'])) $_SESSION['eTHEME'] = $_GET['theme'];
if (isset ($_POST['eTHEME'])) {
   $_SESSION['eTHEME'] = $_POST['eTHEME'];
   setcookie ('eTHEME', $_POST['eTHEME'], time () + 31356000, $T['dpath']);
   }
if (isset ($_POST['eLANG'])) die (header ('Location: '.$T['dpath'].$Path['prefix'].$_POST['eLANG'].'/'.$Vars[1].'/'.$Vars[2].$Path['suffix']));
if (isset ($_GET['logout'])) {
   unset ($_SESSION['ePASS']);
   setcookie ($UID, 1, 1, $T['dpath']);
   die (header ('Location: '.$_SERVER['PHP_SELF']));
   }
if (isset ($_COOKIE[$UID]) && (!isset ($_SESSION['ePASS']) || !$_SESSION['ePASS'])) {
   if ($_COOKIE[$UID] == md5 ($Pass.$UID)) $_SESSION['ePASS'] = $Pass;
   if ($_COOKIE[$UID] == md5 ($AdminPass.$UID)) {
      if (!isset ($_SESSION['ePASS']) || $_SESSION['ePASS'] != $AdminPass) e_log (10, 2, 'IP: '.eIP);
      $_SESSION['ePASS'] = $AdminPass;
      }
   setcookie ($UID, md5 ($_SESSION['ePASS'].$UID), (time () + $RemeberTime), $T['dpath']);
   }
if (isset ($_POST['Password'])) {
   $_SESSION['ePASS'] = md5 ($_POST['Password']);
   if (isset ($_POST['Remember'])) setcookie ($UID, md5 ($_SESSION['ePASS'].$UID), (time () + $RemeberTime), $T['dpath']);
   }
define ('eULEVEL', (isset ($_SESSION['ePASS'])?($_SESSION['ePASS'] == $AdminPass && $AdminBoard)?2:(($_SESSION['ePASS'] == $Pass)?1:0):0));
define ('eLOGIN', (!defined ('eINSTALL') && (($Vars[1] == 'admin' && eULEVEL < 2) || ($Pass && !eULEVEL))));
$TSwitch = array (
	'loggedin' => eULEVEL,
	'user' => (eULEVEL == 1),
	'admin' => (eULEVEL == 2),
	'adminpage' => ($Vars[1] == 'admin'),
	'loginpage' => eLOGIN
	);
if (isset ($Vars[2]) && $Vars[1] == 'admin' && $Vars[2] == 'phpinfo' && eULEVEL == 2) die (phpinfo ());
if (!isset ($_SESSION['eTHEME']) || !is_file ('themes/'.$_SESSION['eTHEME'].'/theme.tpl')) $_SESSION['eTHEME'] = $DefaultTheme;
$TConfig = (isset ($ThemesConfig[$_SESSION['eTHEME']])?$ThemesConfig[$_SESSION['eTHEME']]:parse_ini_file ('themes/'.$_SESSION['eTHEME'].'/theme.ini'));
$Langs = glob ('langs/*', GLOB_ONLYDIR);
for ($i = 0, $c = count ($Langs); $i < $c; $i++) $Langs[$i] = basename ($Langs[$i]);
if (!isset ($_SESSION['eDLANG'])) {
   $Lang = (function_exists ('e_lang')?e_lang ():'en');
   $_SESSION['eDLANG'] = (in_array ($Lang, $Langs)?$Lang:(in_array (substr ($Lang, 0, 2), $Langs)?substr ($Lang, 0, 2):$DefaultLang));
   }
if (!isset ($Vars[0]) || !is_file ('langs/'.$Vars[0].'/common.php')) $Vars[0] = $_SESSION['eDLANG'];
if (!is_readable ('langs/'.$Vars[0].'/common.php')) $Vars[0] = $DefaultLang;
for ($i = 0; $i < $c; $i++) {
    include ('langs/'.$Langs[$i].'/config.php');
    if (!isset ($LName[$Langs[$i]])) unset ($Langs[$i]);
    else $LSelect.= '<option value="'.$Langs[$i].'"'.(($Langs[$i] == $Vars[0])?' selected="selected"':'').'>'.$LName[$Langs[$i]].'</option>
';
    }
if ($_SESSION['eDLANG'] != $Vars[0]) $Info[] = array ('<a href="'.$T['dpath'].$Path['prefix'].$_SESSION['eDLANG'].'/'.implode ('/', array_slice ($Vars, 1)).$Path['suffix'].'" id="linfo" tabindex="'.($TIndex++).'">'.$LInfo[$_SESSION['eDLANG']].'</a>.', 3);
if (!$LComplete[$Vars[0]]) {
   if (!include ('langs/en/common.php')) e_error ('langs/en/common.php', __FILE__, __LINE__);
   else $Info[] = array (sprintf ($L['announce_unfinishedtranslation'], $LName[$Vars[0]]), 2);
   }
if (!include ('langs/'.$Vars[0].'/common.php')) e_error ('langs/'.$Vars[0].'/common.php', __FILE__, __LINE__);
$Themes = glob ('themes/*', GLOB_ONLYDIR);
for ($i = 0, $c = count ($Themes); $i < $c; $i++) {
    $Themes[$i] = basename ($Themes[$i]);
    $TSelect.= '<option value="'.$Themes[$i].'"'.(($Themes[$i] == $_SESSION['eTHEME'])?' selected="selected"':'').'>'.str_replace ('_', ' ', $Themes[$i]).'</option>
';
    }
if (!defined ('eINSTALL')) {
   if (!isset ($_SESSION['eTIME'])) $_SESSION['eTIME'] = 0;
   if (eULEVEL != 2 && $Maintenance) {
      $Info[] = array ($L['announce_maintenance'], 3);
      $T['title'] = $L['maintenance'];
      }
   else if (defined ('eIP') && e_ip (eIP, $BlockedIPs)) {
           $Info[] = array ($L['announce_ipblocked'], 2);
           $DB->ignored_visit (1);
           $T['title'] = $L['accesdenied'];
           }
   else if ((time () - $_SESSION['eTIME']) < $AntyFlood && !eULEVEL) {
           $Meta.= '<meta http-equiv="Refresh" content="'.$AntyFlood.'" />
';
           $Info[] = array ($L['announce_refresh'], 2);
           $T['title'] = $L['accesdenied'];
           }
   else if (!eLOGIN) define ('eLPAGE', 1);
   if (is_file ('install.php') && eULEVEL == 2 && !defined ('eCRITICAL')) $Info[] = array ($L['announce_removeinstall.php'], 2);
   }
$TSwitch['loadpage'] = defined ('eLPAGE');
$TSwitch['antyflood'] = ((time () - $_SESSION['eTIME']) < $AntyFlood && !eULEVEL);
$TSwitch['selectform'] = (count ($Langs) > 1 || count ($Themes) > 1);
$_SESSION['eTIME'] = time ();
if (function_exists ('e_theme')) e_theme ('common');
if (is_file ('langs/'.$Vars[0].'/langs.php')) include ('langs/'.$Vars[0].'/langs.php');
$T['header'] = preg_replace ('#(\{tindex\})#e', '$TIndex++', $Header);
$T['startdate'] = e_date ('d.m.Y', $LastReset);
$T['starttime'] = e_date ('H:i:s', $LastReset);
$T['servername'] = $_SERVER['SERVER_NAME'];
$T['lang'] = $Vars[0];
$T['dir'] = $Dir[$Vars[0]];
$T['meta'] = $Meta;
$T['theme'] = $_SESSION['eTHEME'];
$T['langselect'] = ((count ($Langs) > 1)?'<select name="eLANG" title="%selectlang%" tabindex="'.($TIndex++).'">
'.$LSelect.'</select>
':'');
$T['themeselect'] = ((count ($Themes) > 1)?'<select name="eTHEME" title="%selecttheme%" tabindex="'.($TIndex++).'">
'.$TSelect.'</select>
':'');
$T['selectformindex'] = ($TSwitch['selectform']?$TIndex++:'');
$T['logoutlink'] = 'href="{spath}{separator}logout" tabindex="'.($TIndex++).'"';
$T['path'] = $T['dpath'].$Path['prefix'].$Vars[0].'/';
if ($Vars[1] == 'admin' && (!isset ($Vars[2]) || !is_file ('admin/'.$Vars[2].'.php'))) $Vars[2] = 'main';
if ($eStats['status'] != 'stable' && !defined ('eCRITICAL')) $Info[] = array (sprintf ($L['announce_unstableversion'], $eStats['status']), 2);
if ((eULEVEL == 2 || defined ('eINSTALL')) && ini_get ('safe_mode') && !defined ('eCRITICAL')) $Info[] = array ($L['safemodewarn'], 2);
if (eULEVEL == 2) {
   if (!include ('lib/admin.php')) e_error ('lib/admin.php', __FILE__, __LINE__);
   if (!$LComplete[$Vars[0]]) include ('langs/en/admin.php');
   if (!include ('langs/'.$Vars[0].'/admin.php')) e_error ('langs/'.$Vars[0].'/admin.php', __FILE__, __LINE__);
   if ($_GET) {
      $Array = array (
	'keyword' => 'Keywords',
	'referrer' => 'Referrers',
	'IP' => 'IgnoredIPs'
	);
      foreach ($Array as $Key => $Value) {
              if (isset ($_GET[$Key])) {
                 $TArray = $$Value;
                 if (in_array ($_GET[$Key], $TArray)) unset ($TArray[array_search ($_GET[$Key], $TArray)]);
                 else {
                      $TArray[] = $_GET[$Key];
                      if ($Key == 'keyword' || $Key == 'referrer') $DB->delete_row ($Key.'s', urldecode ($_GET[$Key]));
                      }
                 $DB->config_set (array ($Value => implode ('|', $TArray)));
                 e_configuration (1);
                 }
              }
      }
   if (isset ($_GET['statsenabled'])) $DB->config_set (array ('StatsEnabled' => (int) !$StatsEnabled), 0);
   if (isset ($_GET['maintenance'])) $DB->config_set (array ('Maintenance' => (int) !$Maintenance), 0);
   if (isset ($_GET['editmode'])) $_SESSION['eEMODE'] = !$_SESSION['eEMODE'];
   if (!isset ($_SESSION['eEMODE'])) $_SESSION['eEMODE'] = $EditMode;
   define ('eEMODE', $_SESSION['eEMODE']);
   }
else define ('eEMODE', 0);
if (!defined ('eINSTALL') && !defined ('eCRITICAL')) {
   $SMenus = array ();
   foreach ($Menu[eULEVEL] as $Key => $Value) {
           $TMenu = e_menu_option ($Key, $Value);
           if (isset ($Value['submenu']) && count ($Value['submenu'])) {
              $SMenus[$Key] = '';
              foreach ($Value['submenu'] as $SKey => $SValue) $SMenus[$Key].= e_menu_option ($SKey, $SValue, $Key);
              }
           $T['menu'].= e_parse ($TMenu, array (
	'submenu' => (isset ($Value['submenu'])?e_parse ($Theme['submenu'], array (
		'id' => $Key,
		'menu' => $SMenus[$Key]
		)):'')
	));
           }
   $T['menu'] = str_replace ('{menu}', $T['menu'], $Theme['menu']);
   }
if (eULEVEL == 2 || defined ('eINSTALL')) {
   if (($CheckVersionTime || (defined ('eINSTALL') && !isset ($_POST))) && (!isset ($_SESSION['eVERSION']) || (time () - $_SESSION['eVERSION'][1]) > $CheckVersionTime)) {
      if ($File = fopen ('http://estats.emdek.cba.pl/current.php?'.$_SERVER['SERVER_NAME'].'---'.$_SERVER['SCRIPT_NAME'].'---'.$eStats['version'], 'r')) $_SESSION['eVERSION'] = array (fread ($File, 6), time ());
      else $Info[] = array ($L['announce_couldnotcheckversion'], 0);
      $NewVersion = (isset ($_SESSION['eVERSION']) && str_replace ('.', '', $_SESSION['eVERSION'][0]) > str_replace ('.', '', $eStats['version']))?$_SESSION['eVERSION'][0]:0;
      }
   else $NewVersion = '';
   if ($NewVersion) $Info[] = array (sprintf ($L['announce_newversion'], $_SESSION['eVERSION'][0]), 3);
   }
if ($Maintenance && eULEVEL == 2) $Info[] = array ('%announce_maintenanceadmin%<br />
<a href="{spath}{separator}maintenance" tabindex="'.($TIndex++).'"><strong>%disablemaintenace%</strong></a>.', 2);
if (!defined ('eCRITICAL')) {
   if (defined ('eLPAGE')) {
      $T['title'] = $Titles[$Vars[1]][0].((eULEVEL == 2 && $Vars[1] == 'admin')?' - '.$Titles[$Vars[2]][0]:'');
      if ($Vars[1] != 'admin') e_theme ($Vars[1]);
      if ($Vars[1] != 'admin') $T['page'] = $Theme[$Vars[1]];
      if (isset ($_POST['Password']) && ($Vars[1] == 'admin' || $Pass)) e_log ((($Vars[1] == 'admin')?10:14), 2, 'IP: '.eIP);
      if (($Monthly && in_array ($Vars[1], array ('general', 'technical'))) || $Vars[1] == 'archive') {
         if (!isset ($Vars[3])) $Vars[3] = (($Vars[1] == 'archive')?e_date ('n'):0);
         if ((!isset ($Vars[2]) || !$Vars[2]) || !in_array ($Vars[2], range (e_date ('Y', $LastReset), e_date ('Y')))) {
            $Vars[2] = (($Vars[1] == 'archive')?e_date ('Y'):0);
            if ($Vars[1] == 'archive') $Vars[3] = e_date ('n');
            }
         if (!$Vars[2] || $Vars[2].(($Vars[3] < 10)?'0':'').$Vars[3] < e_date ('Ym', $LastReset) || $Vars[2].(($Vars[3] < 10)?'0':'').$Vars[3] > e_date ('Ym')) $Vars[3] = ($Vars[1] == 'archive')?e_date ('n'):0;
         for ($Month = 1; $Month <= 12; $Month++) $SMonths.= '<option value="'.$Month.'"'.(((int) $Vars[3] == $Month)?' selected="selected"':'').'>'.$Months[0][$Month - 1].'</option>
';
         for ($Year = e_date ('Y', $LastReset); $Year <= e_date ('Y'); $Year++) $SYears.= '<option value="'.$Year.'"'.(($Vars[2] == $Year)?' selected="selected"':'').'>'.$Year.'</option>
';
         $T['monthselect'] = '<select name="month" id="month" title="%month%" tabindex="'.($TIndex++).'">
'.(($Vars[1] !== 'archive')?'<option'.(!$Vars[3]?' selected="selected"':'').' value="">%all%</option>
':'').$SMonths.'</select>
';
        $T['yearselect'] = '<select name="year" id="year" title="%year%" tabindex="'.($TIndex++).'">
'.(($Vars[1] !== 'archive')?'<option'.(!$Vars[2]?' selected="selected"':'').' value="">%all%</option>
':'').$SYears.'</select>
';
        $T['dateformindex'] = $TIndex++;
         }
      if (!include ((($Vars[1] == 'admin')?'admin/'.$Vars[2]:'pages/'.$Vars[1]).'.php')) e_error (((($Vars[1] == 'admin')?'admin/'.$Vars[2]:'pages/'.$Vars[1]).'.php'), __FILE__, __LINE__);
      }
   if (eLOGIN) {
      if (isset ($_POST['Password']) && !eULEVEL) {
         e_log ((($Vars[1] == 'admin')?11:15), 2, 'IP: '.eIP);
         $Info[] = array ($L['announce_wrongpass'], 0);
         }
      if ($Vars[1] != 'admin' || $AdminBoard) {
         e_theme ('login');
         $T['page'] = $Theme['login'];
         $T['title'] = $Titles['login'][0];
         }
      else {
           e_error ($L['announce_adminboarddisabled'], __FILE__, __LINE__);
           $T['title'] = $L['accesdenied'];
           }
      }
   if (!$StatsEnabled && !defined ('eINSTALL') && !defined ('eCRITICAL')) $Info[] = array ($L['announce_statsdisabled'].((eULEVEL == 2)?'<br />
<a href="{spath}{separator}statsenabled" tabindex="'.($TIndex++).'"><strong>%enablecollectdata%</strong></a>.':''), 3);
   }
else $T['page'] = '';
if (defined ('eINSTALL') && !include ('install.php')) e_error ('install.php', __FILE__, __LINE__);
if ($T['css']) $T['css'] = '<style type="text/css">
'.$T['css'].'</style>
';
$TSwitch['critical'] = defined ('eCRITICAL');
if ($c = count ($Info)) {
   for ($i = 0; $i < $c; $i++) {
       $Message = explode ('|', $Info[$i][0]);
       if (defined ('eCRITICAL') && !$Info[$i][1] && isset ($L['announce_couldnotloadfile'])) {
          $Array = array (
	'couldnotloadfile' => 'Could not load file!',
	'couldnotconnect' => 'Could not connect to database!',
	'notsupprotedmodule' => 'This module does not supported on this server!'
	);
          foreach ($Array as $Key => $Value) if (substr ($Message[0], 0, strlen ($Value)) == $Value && isset ($L['announce_'.$Key])) $Message[0] = $L['announce_'.$Key].substr ($Message[0], strlen ($Value));
          }
       if (function_exists ('e_announce') && is_readable ('themes/'.$_SESSION['eTHEME'].'/theme.tpl')) $T['info'].= e_announce ((is_numeric ($Message[0])?$Log[$Message[0]].'.':$Message[0]).(isset ($Message[1])?'<br />
<em>'.$Message[1].'</em>.':''), $Info[$i][1]);
       else $T['info'].= implode (' - ', $Message).'<br />
';
       }
   }
$T['spath'] = $T['dpath'].$Path['prefix'].implode ('/', $Vars).$Path['suffix'];
$T['separator'] = $Path['separator'];
$T['suffix'] = $Path['suffix'];
if (defined ('eCRITICAL')) {
   $T['title'] = $T['header'] = $L['critical'];
   $T['page'] = '';
   }
$T['date'] = ($DateFormat?e_date ($DateFormat).'<br />
':'');
if (is_file ('themes/'.$_SESSION['eTHEME'].'/theme.php')) include ('themes/'.$_SESSION['eTHEME'].'/theme.php');
if (function_exists ('e_parse') && isset ($L['statsfor']) && ($Page = file_get_contents ('themes/'.$_SESSION['eTHEME'].'/theme.tpl'))) {
   $Page = str_replace ('{page}', $T['page'], $Page);
   $Page = e_parse (e_parse (e_parse ($Page, $Theme, '$'), $T), $L, '%');
   $TSwitch['announcements'] = (int) $Info;
   foreach ($TSwitch as $Key => $Value) $Page = preg_replace (
	array (
		'#<!--start:'.$Key.'-->(.*?)<!--end:'.$Key.'-->#si',
		'#<!--start:!'.$Key.'-->(.*?)<!--end:!'.$Key.'-->#si'
		),
	array (
		($Value?'\\1':''),
		($Value?'':'\\1'),
		),
	$Page
	);
   header ($TConfig['header']);
   e_headers ();
   $Page = e_parse ($Page, array (
	'pagegeneration' => sprintf ($L['pagegeneration'], (array_sum (explode (' ', microtime ())) - $Start)),
	'debug' => (((defined ('eCRITICAL') || $Debug) && $ERRORS)?str_replace (array ('{debug}', '%debug%'), array ($ERRORS, $L['debug']), $Theme['debug']):'')
	));
   if ($TConfig['type'] != 'xhtml') $Page = str_replace (' />', '>', $Page);
   }
else die ($Page = '<h1>Critical error!</h1>
'.$T['info'].'<h2>Debug ('.$ECounter.' errors):</h2><br />
'.$ERRORS);
die (preg_replace ('#(\{tindex\})#e', '$TIndex++', $Page));
?>