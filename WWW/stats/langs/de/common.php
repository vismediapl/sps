<?php
$Titles['install'] = array (
	'Installieren'
	);
$Titles['archive'] = array (
	'Statistik-Archiv',
	'Archivdaten',
	'Archiv'
	);
$Titles['detailed'] = array (
	'Detaillierte Statistik',
	'Daten der letzten Gäste',
	'Detaillierte'
	);
$Titles['details'] = array (
	'Besuch Einzelheiten #%d'
	);
$Titles['general'] = array (
	'Allgemeine Statistik',
	'Statistik Zusammenfassung',
	'Allgemeine'
	);
$Titles['technical'] = array (
	'Technische Daten',
	'Webbrowsers, Betreibssysteme, webcrawlers, usw.',
	'Technische'
	);
$Titles['time'] = array (
	'Zeitliche Statistik',
	'Anzahl der besuche aus: letzte Tag, letzte Woche, letztes Jahr',
	'Zeitliche'
	);
$Titles['login'] = array (
	'Anmeldung'
	);
$Titles['admin'] = array (
	'Administration',
	'Besucherstatistik Administration',
	'Administrator'
	);
$Titles['main'] = array (
	'Hauptseite',
	'Hauptseite (Administration)'
	);
$Titles['configuration'] = array (
	'Einstellungen',
	'Besucherstatistik Einstellungen'
	);
$Titles['advanced'] = array (
	'Erweiterte',
	'Erweiterte Einstellungen'
	);
$Titles['blacklist'] = array (
	'Blacklist',
	'Blacklist verwalten'
	);
$Titles['backups'] = array (
	'Sicherheitskopien',
	'Sicherheitskopien verwalten'
	);
$Titles['reset'] = array (
	'Löschen',
	'Daten löschen'
	);
$Titles['logs'] = array (
	'Protokoll',
	'Protokoll anzeigen'
	);
$Titles['plugins'] = array (
	'Plugins',
	'Panel Erweiterungen'
	);
$Titles['documentation'] = array (
	'Dokumentation',
	'Online-Dokumentation'
	);
$Titles['forum'] = array (
	'Forum des Projektes',
	'Das offizielle Forum des Projektes'
	);

$Months = array (
	array ('January', 'February', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'),
	array ('Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez')
	);

$Days = array (
	array ('Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'),
	array ('So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa')
	);

$Log[0] = 'eStats wurde installiert';
$Log[1] = 'eStats-Version wurde geändert';
$Log[2] = 'Einstellungen wurden geändert';
$Log[10] = 'Administrator hat sich angemeldet';
$Log[11] = 'Fehlgeschlagene Anmeldevorgang des Administrators';
$Log[12] = 'Administratorkennwort wurde geändert';
$Log[13] = 'Fehlgeschlagene Änderung des Administratorkennworts';
$Log[14] = 'Benutzer hat sich angemeldet';
$Log[15] = 'Fehlgeschlagene Anmeldevorgang des Benutzers';
$Log[20] = 'Sicherheitskopien wurde erfolgreich erstellt';
$Log[21] = 'Erstellung einer Sicherheitskopie fehlgeschlagen';
$Log[22] = 'Sicherheitskopie wurde erfolgreich gelöscht';
$Log[23] = 'Löschen von einer Sicherheitskopie fehlgeschlagen';
$Log[24] = 'Sicherheitskopie wurde erfolgreich wiederherstellt';
$Log[25] = 'Wiederherstellung von einer Sicherheitskopie fehlgeschlagen';
$Log[30] = 'Detallierte Daten wurden erfolgreich gelöscht';
$Log[31] = 'Gesamte Daten wurden erfolgreich gelöscht';
$Log[32] = 'Sicherheitskopie wurde erfolgreich gelöscht';
$Log[33] = 'Cache wurde erfolgreich gelöscht';
$Log[34] = 'Daten aus ausgewählte Tabelle wurden erfolgreich gelöscht';

$L['announce_couldnotloadfile'] = 'Datei kann nicht hochgeladen werden!';
$L['announce_couldnotconnect'] = 'Keine Verbindung zur Datenbank!';
$L['announce_notsupprotedmodule'] = 'Dieses Modul ist von den Server nicht unterstützt!';
$L['announce_unfinishedtranslation'] = 'Die Übersetzung (%s) ist nicht komplett!';
$L['announce_needjs'] = 'Dieses Werkzeug funktioniert nur dann, wenn Sie JavaScript aktivieren!';
$L['announce_differentpass'] = 'Kennwort stimmt nicht überein!';
$L['announce_disabledplugin'] = 'Dieses Plugin ist nicht aktiviert!';
$L['announce_adminboarddisabled'] = 'Administration Panel wurde deaktiviert!';
$L['announce_wrongpass'] = 'Falsches Kennwort!';
$L['announce_statsdisabled'] = 'Besucherstatistik sind nicht aktiviert.';
$L['announce_removeinstall.php'] = 'Aus Sicherheitsgründen es wird empfohlen, die Datei <em>install.php</em> nach der Installation zu löschen!';
$L['announce_maintenance'] = 'Die Seite ist temporär Wegen Wartungsarbeiten nicht verfügbar.';
$L['announce_maintenanceadmin'] = 'Wartungsmodus aktiviert!<br />
Solange das Wartungsmodus aktiviert bleibt, bitte nicht abmelden!';
$L['announce_ipblocked'] = 'Diese IP-Adresse wurde geblockt!';
$L['announce_refresh'] = 'Die Seite kann nicht aktualisiert werden. Versuchen Sie es bitte noch mal in ein paar Minuten.';
$L['announce_newversion'] = 'Neue Version verfügbar (%s)!';
$L['announce_groupdisabled'] = 'Diese Gruppe ist nicht aktiv!';
$L['announce_groupcollectingdisabled'] = 'Datensammlung für diese Gruppe wurde deaktiviert!';
$L['announce_couldnotcheckversion'] = 'Informationen über neue Version können nicht aufgerufen werden!';
$L['announce_unstableversion'] = 'Das ist eine Testversion von <em>eStats</em> (Status: <em>%s</em>).<br />
Diese Version wurde nicht auf Funktionalität geprüft!<br />
<strong style="text-decoration:underline;">Nutzen nur auf eigene Gefahr!</strong>';

$L['confirm_defaults'] = 'Wollen Sie wirklich Standardeinstellungen wiederherstellen?';
$L['confirm_save'] = 'Wollen Sie wirklich alle Änderungen speichern?';
$L['confirm_restore'] = 'Wollen Sie wirklich gewählte Daten widerherstellen?';
$L['confirm_delete'] = 'Wollen Sie wirklich gewählte Daten löschen?';
$L['confirm_ipblock'] = 'wollen Sie wirklich diese IP-Adresse bannen?';
$L['confirm_referrerblock'] = 'Wollen Sie wirklich gewälte Referrer ausschlißen?';
$L['confirm_keywordblock'] = 'Wollen sie wirklich gewählte Schlagwort / Ausdruck ausschließen?';

$L['logout'] = 'Abmelden';
$L['maintenance'] = 'Wartungsarbeiten';
$L['accesdenied'] = 'Zugriff verboten';
$L['critical'] = 'Kritischer Fehler!';
$L['enablecollectdata'] = 'Datensammlung aktivieren';
$L['disablemaintenace'] = 'Wartungsmodus deaktiviren';
$L['information'] = 'Information';
$L['error'] = 'Fehler';
$L['warning'] = 'Warnung';
$L['success'] = 'Erfolg';
$L['sites'] = 'Seitenpopularität';
$L['langs'] = 'Sprachen';
$L['oses'] = 'Betriebssysteme';
$L['browsers'] = 'Webbrowser';
$L['robots'] = 'Webcrawler';
$L['hosts'] = 'Hosts';
$L['referrers'] = 'Referrer (Verweise)';
$L['keywords'] = 'Schlagwörter';
$L['screens'] = 'Bildschirmgröße';
$L['flash'] = 'Flash Plugin';
$L['java'] = 'Java';
$L['javascript'] = 'JavaScript';
$L['cookies'] = 'Cookies';
$L['vbrowsers'] = 'Webbrowser-Versionen';
$L['voses'] = 'Betriebssystem-Versionen';
$L['websearchers'] = 'Suchmaschinen';
$L['statsfor'] = 'Besucherstatistik für';
$L['selectlang'] = 'Sprache auswählen';
$L['selecttheme'] = 'Motiv auswählen';
$L['debug'] = 'Debugen';
$L['pagegeneration'] = 'Seite generiert in: %.3lf (s)';
$L['gototop'] = 'Nach oben';
$L['change'] = 'Ändern';
$L['pass'] = 'Benutzerpasswort';
$L['loginto'] = 'Anmelden';
$L['remember'] = 'Angemeldet bleiben?';
$L['datafromcache'] = 'Daten aus <em>Cachespeicher</em>, aktualisiert: %s.';
$L['showdatafor'] = 'Zeige Daten aus';
$L['of'] = 'aus';
$L['itemsamount'] = 'Einträge Anzahl (zur Zeit: %d)';
$L['groupdatacollectingenabled'] = 'Datensammlung für die Gruppe aktiviert';
$L['online'] = 'Online';
$L['lastweek'] = 'Letzte Woche';
$L['lasthour'] = 'Letzte Stunde';
$L['excluded'] = 'Nicht gespeicherte';
$L['most'] = 'Höchst';
$L['averageperday'] = 'Durchschnittlich innerhalb eines Tages';
$L['averageperhour'] = 'Durchschnittlich innerhalb einer Stunde';
$L['sum'] = 'Zusammen';
$L['directentries'] = 'Direkte Zugänge';
$L['mobile'] = 'Mobile Geräte';
$L['yes'] = 'Ja';
$L['no'] = 'Nein';
$L['unknown'] = 'Keine Daten vorhanden';
$L['blockreferrer'] = 'Diesen Referrer aus Statistik ausschließen';
$L['unblockreferrer'] = 'Diesen Refferer zur Statistik zurechnen';
$L['blockkeyword'] = 'Dieses Schlagwort aus Statistik ausschließen';
$L['all'] = 'Alle';
$L['firstvisit'] = 'Erste Besuch';
$L['lastvisit'] = 'Letzter Besuch';
$L['visitamount'] = 'Anzahl der Besuche';
$L['referrer'] = 'Verweisseite';
$L['host'] = 'Host';
$L['userinfo'] = 'Einstellungen';
$L['date'] = 'Datum';
$L['site'] = 'Seite';
$L['seedetails'] = 'Details zu dem Besuch anzeigen';
$L['legend'] = 'Erklärung';
$L['yourvisit'] = 'Ihr Besuch';
$L['onlinevisitors'] = 'Gäste online (innerhalb letzten 5 Minuten)';
$L['hiderobots'] = 'Webcrawler verbergen';
$L['showrobots'] = 'Webcrawler anzeigen';
$L['proxy'] = 'Proxy';
$L['browser'] = 'Webbrowser';
$L['os'] = 'Betriebssystem';
$L['lang'] = 'Sprache';
$L['screenresolution'] = 'Bildschirmgröße';
$L['flashversion'] = 'Flash Plugin-Version';
$L['javaenabled'] = 'Java aktivirt';
$L['jsenabled'] = 'JavaScript aktivirt';
$L['cookiesenabled'] = 'Cookies aktiviert';
$L['blockip'] = 'IP blockieren';
$L['visitedpages'] = 'Besuchte Seiten';
$L['dataunavailable'] = 'Daten nicht verfügbar';
$L['last24hours'] = 'Der letzte Tag';
$L['lastmonth'] = 'Der Letzte Monat';
$L['lastyear'] = 'Das letzte Jahr';
$L['lastyears'] = 'Vergangene Jahre';
$L['hourspopularity'] = 'Popularität - Stunden';
$L['dayspopularity'] = 'Popularität - Tage';
$L['summary'] = 'Zusammenfassung';
$L['average'] = 'Durchschnittlich';
$L['least'] = 'Am wenigsten';
$L['month'] = 'Monat';
$L['year'] = 'Jahr';
$L['visits'] = 'Besuche';
$L['chartsview'] = 'Diagramm-Ansichte';
$L['showhidelevels'] = 'Zeigen / verbergen die Stuffen: das Maximum, der Durchschnitt und das Minimum';
$L['levelsmax'] = 'das Maximum';
$L['levelsaverage'] = 'der Durschnitt';
$L['levelsmin'] = 'das Minimum';
$L['unique'] = 'Individuelle Besuche';
$L['views'] = 'Wiederholte Besuche';
$L['unblockip'] = 'IP entsperren';
$L['unblockiprange'] = 'IP-Bereich entsperren';
$L['view'] = 'Ansicht';
$L['save'] = 'Speichern';
$L['defaults'] = 'Standardeinstellung';
$L['reset'] = 'Rücksetzen';
$L['whois'] = 'Whois';

$L['adminpass'] = 'Administratorkennwort';
$L['currentpass'] = 'Aktueles Kennwort';
$L['newpass'] = 'Neues Kennwort';
$L['repeatpass'] = 'Neues Kennwort wiederholen';
$L['changepass'] = 'Kennwort ändern';
$L['settings'] = 'Einstellungen';
$L['advanced'] = 'Erweiterte';
$L['filter'] = 'Filter';
$L['search'] = 'Suchen';
$L['showall'] = 'Alle anzeigen';
$L['registrationsamount'] = 'Eintrage insgesamt';
$L['meetingconditions'] = 'Beiträge, die deinen Kriterien entsprechen';
$L['showed'] = 'Angezeigte';
$L['default'] = 'Standardeinstellung';
$L['defaultvalue'] = 'Standardwert';
$L['valuetype0'] = 'Textsequenz';
$L['valuetype1'] = 'Logische Wert';
$L['valuetype2'] = 'Zahl';
$L['valuetype3'] = 'Tabelle, Elemente durch | getrennt';
$L['changedvalue'] = 'Wert des Feldes weicht von dem Standard-Wert ab';
$L['managebackups'] = 'Sicherheitskopien verwalten';
$L['selectbackup'] = 'Sicherheitskopie auswählen';
$L['nobackups'] = 'Keine Sicherheitskopie vorhanden';
$L['download'] = 'Herunterladen';
$L['delete'] = 'Löschen';
$L['restore'] = 'Wiederherstellen';
$L['compression'] = 'Datenkomprimierung';
$L['none'] = 'Keine';
$L['compressiontype'] = 'Art der Datenkomprimierung';
$L['createbackup'] = 'Sicherheitskopie erstellen';
$L['send'] = 'Senden';
$L['restorebackupfromhd'] = 'Sicherheitskopie aus der lokalen Festplatte laden';
$L['backuptypefull'] = 'Vollständig';
$L['backuptypedata'] = 'Nur gesammelte Daten';
$L['backuptypeuser'] = 'Benutzereinstellungen';
$L['ignoreruledesc'] = 'Mit Zeichen * Ende der Adresse ersetzen.';
$L['ignoredvisits'] = 'Ignorierte und blockierte besuche';
$L['ip'] = 'IP';
$L['lastua'] = 'Letzte UA';
$L['type'] = 'Typ';
$L['blocked'] = 'Blockiert';
$L['ignored'] = 'Ignoriert';
$L['export'] = 'Exportieren';
$L['show'] = 'Anzeigen';
$L['findregistration'] = 'Eintrag suchen (alle felder durchsuchen)';
$L['resultsperpage'] = 'Ergebnisse pro Seite';
$L['inperiod'] = 'Zeitraum';
$L['from'] = 'Von';
$L['to'] = 'Bis';
$L['browse'] = 'Durchsuchen';
$L['log'] = 'Protokoll';
$L['informations'] = 'Information';
$L['actions'] = 'Abläufe';
$L['phpversion'] = 'PHP-Version';
$L['estatsversion'] = '<em>eStats</em>-Version';
$L['database'] = 'Datenbank';
$L['databasemodule'] = 'Datenbankmodul';
$L['author'] = 'Autor';
$L['safemode'] = 'PHP Safe-Mode';
$L['serverload'] = 'Serverbelastung';
$L['collectedfrom'] = 'Daten gesammelt ab';
$L['datasize'] = 'Daten Größe';
$L['data'] = 'Daten';
$L['cache'] = 'Cache';
$L['backups'] = 'Sicherheitskopien';
$L['lastbackuptime'] = 'Letzte Sicherheitskopie-Datum';
$L['availablebackupsamount'] = 'Sicherheitskopien insgesamt';
$L['newversionavailable'] = 'Neue version erhältlich!';
$L['deactivatestats'] = 'Besucherstatistik deaktiviren';
$L['activatestats'] = 'Besucherstatistik aktieviren';
$L['deactivatemaintenance'] = 'Wartungsmodus deaktiviren';
$L['activatemaintenance'] = 'Wartungsmodus aktiviren';
$L['deactivateeditmode'] = 'Bearbeitungsmodus deaktiviren';
$L['activateeditmode'] = 'Bearbeitungsmodus aktiviren';
$L['resetall'] = 'Alle Daten löschen';
$L['resetdetailed'] = 'Ausführliche Statistik löschen';
$L['resetbackups'] = 'Sicherheitskopien löschen';
$L['resetcache'] = 'Cache löschen';
$L['resettable'] = 'Die gewählte Tabelle löschen';
$L['resetcreatebackup'] = 'Sicherheitskopie erstellen (nur Daten!)';
$L['enabled'] = 'Aktiviert';
$L['disabled'] = 'Deaktiviert';
$L['pluginsactivate'] = 'Um ein Plugin de-, aktivieren muss die Datei <em>config.php</em> aus Plugin-Ordner (z.B. <em>plugins/editor/config.php</em>) folgender Weise editiert werden: Variable <em>$Plugins[\'<strong>PLUGIN-NAME</strong>\']</em> auf <em>1</em> oder <em>0</em> setzen.';
$L['safemodewarn'] = '<em>PHP Safe-Mode</em> ist auf dem Server aktiviert!<br />
Das kann zu Probleme führen beim automatische erstellen von Ordner und Dateien.<br />
Das Problem kann durch Änderung des Besitzers oder manuelle Erstellung von Ordnern und Dateien gelöst werden.';
?>