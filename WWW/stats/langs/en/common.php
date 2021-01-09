<?php
$Titles['install'] = array (
	'Installer'
	);
$Titles['archive'] = array (
	'Statistics archive',
	'Archival data',
	'Archive'
	);
$Titles['detailed'] = array (
	'Detailed stats',
	'Last visitors details',
	'Detailed'
	);
$Titles['details'] = array (
	'Visit details #%d'
	);
$Titles['general'] = array (
	'General stats',
	'Statistics summary',
	'General'
	);
$Titles['technical'] = array (
	'Technical data',
	'Browsers, OSes, bots, etc.',
	'Technical'
	);
$Titles['time'] = array (
	'Time stats',
	'Number of visits from last twenty - four hours, month and year',
	'Time'
	);
$Titles['login'] = array (
	'Login'
	);
$Titles['admin'] = array (
	'Administration',
	'Administration',
	'Admin'
	);
$Titles['main'] = array (
	'Main page',
	'Main page of administration'
	);
$Titles['configuration'] = array (
	'Configuration',
	'Statistics configuration'
	);
$Titles['advanced'] = array (
	'Advanced',
	'Advanced configuration'
	);
$Titles['blacklist'] = array (
	'Blacklist',
	'Blacklist management'
	);
$Titles['backups'] = array (
	'Backups',
	'Backups management'
	);
$Titles['reset'] = array (
	'Reseting',
	'Data reseting'
	);
$Titles['logs'] = array (
	'Logs',
	'Logs browsing'
	);
$Titles['plugins'] = array (
	'Plugins',
	'Plugins extending admin board functionality'
	);
$Titles['documentation'] = array (
	'Documentation',
	'Online Documentation'
	);
$Titles['forum'] = array (
	'Project&#039;s forum',
	'Official project&#039;s forum'
	);

$Months = array (
	array ('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
	array ('JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC')
	);

$Days = array (
	array ('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'),
	array ('SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT')
	);

$Log[0] = 'eStats was installed';
$Log[1] = 'eStats version was changed';
$Log[2] = 'Configuration was saved';
$Log[10] = 'Administrator logged in';
$Log[11] = 'Unsuccessful log into admin board attempt';
$Log[12] = 'Administrator password was changed';
$Log[13] = 'Unsuccessful administrator password change attempt';
$Log[14] = 'User logged in';
$Log[15] = 'Unsuccessful user login attempt';
$Log[20] = 'Backup was created';
$Log[21] = 'Unsuccessful backup create attempt';
$Log[22] = 'Backup was deleted';
$Log[23] = 'Unsuccessful backup delete attempt';
$Log[24] = 'Data was restored from backup';
$Log[25] = 'Unsuccessful backup restore attempt';
$Log[30] = 'Detailed data were deleted';
$Log[31] = 'All data were deleted';
$Log[32] = 'Backups were deleted';
$Log[33] = 'Cache was deleted';
$Log[34] = 'Data from selected table were deleted';

$L['announce_couldnotloadfile'] = 'Could not load file!';
$L['announce_couldnotconnect'] = 'Could not connect to database!';
$L['announce_notsupprotedmodule'] = 'This module does not supported on this server!';
$L['announce_unfinishedtranslation'] = 'This translation (%s) is not complete!';
$L['announce_needjs'] = 'Enabled JavaScript is requeired for correct work of this tool!';
$L['announce_differentpass'] = 'Given passwords are not the same!';
$L['announce_disabledplugin'] = 'This plugin is disabled!';
$L['announce_adminboarddisabled'] = 'Admin board was disabled!';
$L['announce_wrongpass'] = 'Wrong password!';
$L['announce_statsdisabled'] = 'Statistics are disabled.';
$L['announce_removeinstall.php'] = 'File <em>install.php</em> should be removed after installation!';
$L['announce_maintenance'] = 'Site unavailable by the reason of maintenance.';
$L['announce_maintenanceadmin'] = 'Maintenance mode is active!<br />
If You will log out, then You can not log in for deactivate it!';
$L['announce_ipblocked'] = 'This IP address was blocked!';
$L['announce_refresh'] = 'You could not refresh page so quickly!';
$L['announce_newversion'] = 'New version is available (%s)!';
$L['announce_groupdisabled'] = 'This group is disabled!';
$L['announce_groupcollectingdisabled'] = 'Data collecting for this group was disabled!';
$L['announce_couldnotcheckversion'] = 'Could not check for new version availabity!';
$L['announce_unstableversion'] = 'This is a test version of <em>eStats</em> (status: <em>%s</em>).<br />
Its functionality could be incomplete, could work incorrect and be incompatible with newest versions!<br />
<strong style="text-decoration:underline;">Use at own risk!</strong>';

$L['confirm_defaults'] = 'Do You really want to restore defaults?';
$L['confirm_save'] = 'Do You really want to save?';
$L['confirm_restore'] = 'Do You really want to restore data?';
$L['confirm_delete'] = 'Do You really want to delete data?';
$L['confirm_ipblock'] = 'Do You really want to ban this IP adress?';
$L['confirm_referrerblock'] = 'Do You really want to exclude this referrer?';
$L['confirm_keywordblock'] = 'Do You really want to exclude this keyword / phrase?';

$L['logout'] = 'Log out';
$L['maintenance'] = 'Maintenance';
$L['accesdenied'] = 'Acces denied';
$L['critical'] = 'Critical error!';
$L['enablecollectdata'] = 'Enable data collecting';
$L['disablemaintenace'] = 'Disable maintenance mode';
$L['information'] = 'Information';
$L['error'] = 'Error';
$L['warning'] = 'Warning';
$L['success'] = 'Success';
$L['sites'] = 'Sites popularity';
$L['langs'] = 'Languages';
$L['oses'] = 'OSes';
$L['browsers'] = 'Browsers';
$L['robots'] = 'Bots';
$L['hosts'] = 'Hosts';
$L['referrers'] = 'Referrers';
$L['keywords'] = 'Keywords';
$L['screens'] = 'Screen resolutions';
$L['flash'] = 'Flash plugin';
$L['java'] = 'Java';
$L['javascript'] = 'JavaScript';
$L['cookies'] = 'Cookies';
$L['vbrowsers'] = 'Browser versions';
$L['voses'] = 'OS versions';
$L['websearchers'] = 'Websearchers';
$L['statsfor'] = 'Statistics for';
$L['selectlang'] = 'Choose language';
$L['selecttheme'] = 'Choose theme';
$L['debug'] = 'Debug';
$L['pagegeneration'] = 'Page generation time: %.3lf (s)';
$L['gototop'] = 'Go to top';
$L['change'] = 'Change';
$L['pass'] = 'Password';
$L['loginto'] = 'Login';
$L['remember'] = 'Remember password';
$L['datafromcache'] = 'Data from <em>cache</em>, refreshed: %s.';
$L['showdatafor'] = 'Show data for';
$L['of'] = 'of';
$L['itemsamount'] = 'Amount of items (current: %d)';
$L['groupdatacollectingenabled'] = 'Data collecting enabled for this group';
$L['online'] = 'Online';
$L['lastweek'] = 'Last week';
$L['lasthour'] = 'Last hour';
$L['excluded'] = 'Excluded';
$L['most'] = 'Most';
$L['averageperday'] = 'Average per day';
$L['averageperhour'] = 'Average per hour';
$L['sum'] = 'Sum';
$L['directentries'] = 'Direct entries';
$L['mobile'] = 'Mobile devices';
$L['yes'] = 'Yes';
$L['no'] = 'No';
$L['unknown'] = 'Unknown';
$L['blockreferrer'] = 'Zablokuj zliczanie tego źródła';
$L['unblockreferrer'] = 'Odblokuj zliczanie tego źródła';
$L['blockkeyword'] = 'Zablokuj zliczanie tego słowa kluczowego / frazy';
$L['all'] = 'All';
$L['firstvisit'] = 'First visit';
$L['lastvisit'] = 'Last visit';
$L['visitamount'] = 'Amount of visits';
$L['referrer'] = 'Referrer website';
$L['host'] = 'Host';
$L['userinfo'] = 'Configuration';
$L['date'] = 'Date';
$L['site'] = 'Site';
$L['seedetails'] = 'See details of this visit';
$L['legend'] = 'Legend';
$L['yourvisit'] = 'Your visit';
$L['onlinevisitors'] = 'Online visitors (last five minutes)';
$L['hiderobots'] = 'Hide bots';
$L['showrobots'] = 'Show bots';
$L['proxy'] = 'Proxy';
$L['browser'] = 'Browser';
$L['lang'] = 'Language';
$L['screenresolution'] = 'Screen resolution';
$L['flashversion'] = 'Flash plugin version';
$L['javaenabled'] = 'Java enabled';
$L['jsenabled'] = 'JavaScript enabled';
$L['cookiesenabled'] = 'Cookies enabled';
$L['blockip'] = 'Block this IP';
$L['visitedpages'] = 'Visited pages';
$L['dataunavailable'] = 'Data unavailable';
$L['last24hours'] = 'Last twenty - four hours';
$L['lastmonth'] = 'Last month';
$L['lastyear'] = 'Last year';
$L['lastyears'] = 'Last years';
$L['hourspopularity'] = 'Hours popularity';
$L['dayspopularity'] = 'Days of week popularity';
$L['summary'] = 'Summary';
$L['average'] = 'Average';
$L['least'] = 'Least';
$L['month'] = 'Month';
$L['year'] = 'Year';
$L['visits'] = 'Visits';
$L['chartsview'] = 'View of visits charts';
$L['showhidelevels'] = 'Show/ hide levels of maximum, average and minimum';
$L['levelsmax'] = 'maximum';
$L['levelsaverage'] = 'average';
$L['levelsmin'] = 'minimum';
$L['unique'] = 'Unique';
$L['views'] = 'Views';
$L['unblockip'] = 'Unblock IP';
$L['unblockiprange'] = 'Unblock IPs range';
$L['view'] = 'View';
$L['save'] = 'Save';
$L['defaults'] = 'Defaults';
$L['reset'] = 'Reset';
$L['filter'] = 'Filter';
$L['search'] = 'Search';
$L['settings'] = 'Settings';
$L['download'] = 'Download';
$L['delete'] = 'Delete';
$L['restore'] = 'Restore';
$L['none'] = 'None';
$L['export'] = 'Export';
$L['show'] = 'Show';
$L['whois'] = 'Whois';

$L['adminpass'] = 'Administrator password';
$L['currentpass'] = 'Current password';
$L['newpass'] = 'New password';
$L['repeatpass'] = 'Repeat password';
$L['changepass'] = 'Change password';
$L['advanced'] = 'Advanced';
$L['showall'] = 'Show all';
$L['registrationsamount'] = 'Registrations amount';
$L['meetingconditions'] = 'Meeting conditions';
$L['showed'] = 'Showed';
$L['default'] = 'Default';
$L['defaultvalue'] = 'Default value';
$L['valuetype0'] = 'Text string';
$L['valuetype1'] = 'Logic value';
$L['valuetype2'] = 'Number';
$L['valuetype3'] = 'Array, elements separated by |';
$L['changedvalue'] = 'Field value is other than default';
$L['managebackups'] = 'Backups management';
$L['selectbackup'] = 'Select backup';
$L['nobackups'] = 'No backups';
$L['compression'] = 'Compression';
$L['compressiontype'] = 'Type of compression of file for download';
$L['createbackup'] = 'Create backup';
$L['send'] = 'Send';
$L['restorebackupfromhd'] = 'Restore backup saved on HD';
$L['backuptypefull'] = 'Full';
$L['backuptypedata'] = 'Only collected data';
$L['backuptypeuser'] = 'User';
$L['ignoreruledesc'] = 'Use * for replace end part of adress.';
$L['ignoredvisits'] = 'Ignored and blocked visits';
$L['ip'] = 'IP';
$L['lastua'] = 'Last UA';
$L['type'] = 'Type';
$L['blocked'] = 'Blocked';
$L['ignored'] = 'Ignored';
$L['findregistration'] = 'Find registration (search in all fileds)';
$L['resultsperpage'] = 'Results per page';
$L['inperiod'] = 'In period';
$L['from'] = 'From';
$L['to'] = 'To';
$L['browse'] = 'Browse';
$L['log'] = 'Log';
$L['informations'] = 'Informations';
$L['actions'] = 'Actions';
$L['phpversion'] = 'PHP version';
$L['estatsversion'] = '<em>eStats</em> version';
$L['database'] = 'Database';
$L['databasemodule'] = 'Database module';
$L['author'] = 'Author';
$L['safemode'] = 'PHP safe mode';
$L['os'] = 'Operating system';
$L['serverload'] = 'Server load';
$L['collectedfrom'] = 'Data collected from';
$L['datasize'] = 'Data size';
$L['data'] = 'Data';
$L['cache'] = 'Cache';
$L['backups'] = 'Backups';
$L['lastbackuptime'] = 'Date of creation last backup';
$L['availablebackupsamount'] = 'Amount of available backups';
$L['newversionavailable'] = 'New version is available!';
$L['deactivatestats'] = 'Disable statistics';
$L['activatestats'] = 'Enable statistics';
$L['deactivatemaintenance'] = 'Disable maintenance mode';
$L['activatemaintenance'] = 'Enable maintenance mode';
$L['deactivateeditmode'] = 'Disable edit mode';
$L['activateeditmode'] = 'Enable edit mode';
$L['resetall'] = 'Delete all statistics data';
$L['resetdetailed'] = 'Reset detailed statistics';
$L['resetbackups'] = 'Delete backups';
$L['resetcache'] = 'Reset cache';
$L['resettable'] = 'Reset selected table';
$L['resetcreatebackup'] = 'Create backup (data only)';
$L['enabled'] = 'Enabled';
$L['disabled'] = 'Disabled';
$L['pluginsactivate'] = 'For (de)activate of plugin You must edit file <em>config.php</em> from its directory (example: <em>plugins/editor/config.php</em>) and set value of variable <em>$Plugins[\'<strong>PLUGIN NAME</strong>\']</em> to <em>1</em> or <em>0</em>.';
$L['safemodewarn'] = '<em>PHP safe mode</em> has been activated on this server!<br />
That could cause problems in case of automatic creation of files and directories.<br />
Solution is change of their owner or manual creation.';
?>