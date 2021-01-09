<?php
error_reporting (0);
ignore_user_abort (1);
if (!session_id ()) session_start ();
define ('ePATH', dirname (__FILE__).'/');
function e_error ($Error, $File, $Line, $Arg = 0) {
         if (!defined ('eCRITICAL')) define ('eCRITICAL', 1);
         echo '<b>eStats error:</b> <i>'.($Arg?$Error:'Could not load file: <b>'.$Error.'</b>!').'</i> (<b>'.$File.': '.$Line.'</b>)<br />
';
         }
if (isset ($_GET['estats']) && isset ($_GET['count']) && $_GET['count']) {
   define ('eCOUNT', 1);
   if (isset ($_GET['address'])) {
      $Address = parse_url ($_GET['address']);
      define ('eADDRESS', $Address['path'].($Address['query']?'?'.$Address['query']:''));
      }
   if (isset ($_GET['title'])) define ('eTITLE', $_GET['title']);
   }
if (!include (ePATH.'conf/config.php')) e_error ('conf/config.php', __FILE__, __LINE__);
if (!include (ePATH.'lib/stats.php')) e_error ('lib/stats.php', __FILE__, __LINE__);
if (!include (ePATH.'db/'.$DBType.'/stats.php')) e_error ('db/'.$DBType.'/stats.php', __FILE__, __LINE__);
if (!defined ('eCRITICAL')) $DB = new estats_db;
if (!defined ('eCRITICAL')) {
   e_configuration (0);
   if ($StatsEnabled) {
      if ($SendHeaders) e_headers ();
      if ($Backups['time'] && ((time () - $LastBackup > $Backups['time']))) e_create_backup ();
      if (defined ('eCOUNT') || isset ($_GET['estats'])) {
         e_get_ip ();
         if (e_ip (eIP, $IgnoredIPs)) {
            if (!isset ($_GET['estats'])) $DB->ignored_visit ();
            }
         else $DB->visitor ();
         }
      }
   }
if (isset ($_GET['estats']) && $_GET['estats'] && defined ('eNOINFO') && defined ('eVID')) {
   $Stats = array (
	(($_GET['javascript'] == 1)?1:0),
	(is_numeric ($_GET['cookies'])?(int) $_GET['cookies']:'?'),
	(is_numeric ($_GET['flash'])?(int) $_GET['flash']:'?'),
	(is_numeric ($_GET['java'])?(int) $_GET['java']:'?'),
	(((int) $_GET['width'] && (int) $_GET['height'])?((int) $_GET['width']).' x '.((int) $_GET['height']):'?'),
	1
	);
   $Array = array (
	'javascript',
	'cookies',
	'flash',
	'java',
	'screens'
	);
   for ($i = 0; $i < 5; $i++) $DB->update ($Array[$i], $Stats[$i]);
   }
else $Stats = array_fill (0, 9, 0);
define ('eROBOT', e_robot ($_SERVER['HTTP_USER_AGENT']));
if (!defined ('eADDRESS')) define ('eADDRESS', $_SERVER['REQUEST_URI']);
if (defined ('eCOUNT') && defined ('eNEWVISITOR')) {
   $Stats[6] = eROBOT;
   if (!eROBOT) {
      $Stats[7] = gethostbyaddr (eIP);
      $Stats[8] = strtoupper (e_lang ());
      if ($CollectData['langs']) $DB->update ('langs', $Stats[8]);
      if ($CollectData['browsers']) $DB->update ('browsers', e_browser ($_SERVER['HTTP_USER_AGENT']));
      if ($CollectData['oses']) $DB->update ('oses', e_os ($_SERVER['HTTP_USER_AGENT']));
      if ($CollectData['hosts']) {
         $SHost = explode ('.', $Stats[7]);
         $SHost = (!is_numeric (((count ($SHost) > 1)?$SHost[count ($SHost) - 2].'.':'').end ($SHost))?((count ($SHost) > 1)?$SHost[count ($SHost) - 2].'.':'').end ($SHost):'?');
         $DB->update ('hosts', ($SHost?$SHost:'?'));
         }
      if (isset ($_SERVER['HTTP_REFERER']) && ($CollectData['websearchers'] || $CollectData['keywords'])) {
         $Referrer = parse_url ($_SERVER['HTTP_REFERER']);
         if ($CollectData['referrers']) $DB->update ('referrers', (in_array ($Referrer['host'], $Referrers))?'?':'http://'.strtolower ($Referrer['host']));
         $WebSearch = e_websearcher ($Referrer, $CountPhrases);
         if ($WebSearch) {
            if ($CollectData['websearchers']) $DB->update ('websearchers', $WebSearch[0]);
            if ($CollectData['keywords']) {
               for ($i = 0, $c = count ($WebSearch[1]); $i < $c; $i++) {
                   if ($WebSearch[1][$i]) $DB->update ('keywords', $WebSearch[1][$i]);
                   }
               }
            }
         }
      }
   else if ($CollectData['robots']) $DB->update ('robots', $Stats[6]);
   }
if (defined ('eVID')) {
   $DB->visit ($Stats);
   if (defined ('eCOUNT') && $CollectData['sites']) $DB->update ('sites', (defined ('eTITLE')?eTITLE:0));
   }
if (str_replace ('\\', '/', __FILE__) == str_replace ('\\', '/', $_SERVER[(isset ($_SERVER['ORIG_SCRIPT_FILENAME'])?'ORIG_':'').'SCRIPT_FILENAME'])) header ('Location: antipixels/'.$Antipixel);
?>