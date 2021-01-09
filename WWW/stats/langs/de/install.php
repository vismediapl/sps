<?php
$L['install_step'] = 'Schritt %d von 3';
$L['install_introduction'] = 'Einleitung';
$L['install_greeting'] = '<strong>Willkommen!</strong><br /><br />
Der Setup-Assistent von eStats ermöglicht Ihnen schnelle und einfache Installation des eStats-Scripts auf Ihrem Server.<br />
Wählen Sie Datenbankmodul und Administratorkennwort.<br />
Nach dem Ausfüllen aller Felder drücken Sie <em>Weiter</em>, um das Script zu konfigurieren.';
$L['install_installation'] = 'Installierien';
$L['install_upgrade'] = 'Aktualisieren';
$L['install_action'] = 'Vorgang';
$L['install_permissions'] = 'Zugriffsrechte Test';
$L['install_notwritable'] = 'Nicht ausreichende Zugriffsrechte';
$L['install_notexists'] = 'Existiert nicht';
$L['install_ok'] = 'OK';
$L['install_continue'] = 'Weiter';
$L['install_continuewhatever'] = 'Trotzdem fortfahren';
$L['install_continueconfirm'] = 'Fortfahren kann zu unewartete Folgen führen!\nFortfahren auf eigene Gefahr!';
$L['install_continueselectdb'] = 'Datenbankmodul auswählen';
$L['install_nomodulesupported'] = 'Es wurde kein passende Datenbankmodul gefunden!';
$L['install_couldnotcontinue'] = 'Fortfahren ist nicht möglich!';
$L['install_toooldphp'] = 'PHP-Version ist nicht kompatibel!';
$L['install_aboutmodule'] = 'Modul-Informationen';
$L['install_modulenotsupported'] = 'Ausgewählte Datenbankmodul konnte nicht gefunden werden!<br />
Fortfahren kann zu unewartete Folgen führen!';
$L['install_adminpasstooshort'] = 'Administratorkennwort ist kürzer als 5 Zeichen. Aus Sicherheitsgründen wird es empfohlen das Passwort länger machen.';
$L['install_testconnection'] = 'Verbindung zur Datenbank testen';
$L['install_conectionerror'] = 'Verbindung zur Datebank fehlgeschlagen!';
$L['install_conectionsuccess'] = 'Verbindung zur Datenbank erfolgreich hergestellt..';
$L['install_directorieserror'] = 'Erstellen der Verzeichnisstruktur fehlgeschlagen!';
$L['install_directoriessuccess'] = 'Verzeichnisstruktur wurde erfolgreich erstellt.';
$L['install_databaseerror'] = 'Erstellen der Tabellenstruktur in der Datenbank fehlgeschlagen!';
$L['install_databasesuccess'] = 'Tabellenstruktur in der Datenbank erfolfreich angelegt.';
$L['install_couldnotsaveconfig'] = 'Konfigurationsdatei konnte nicht geschrieben werden!';
$L['install_saveconfigerror'] = 'Schreiben in die Konfigurationsdatei fehlgeschlagen!';
$L['install_saveconfigsuccess'] = 'Konfigurationsdatei erfolgreich geschrieben.';
$L['install_end'] = 'Installationsvorgang abschließen';
$L['install_mainend'] = 'Wichtigste Teil der Installation abgeschloßen';
$L['install_enddesc'] = 'Wenn die Installation erfolgreich durchgeführt wurde, bitte drücken sie <a href="%s"><strong>hier</strong></a> um die Konfiguration durchzuführen.<br />
<strong>Bitte <em>install.php</em> löschen!</strong>';
$L['install_executeactions'] = 'Um Installationvorgang abschließen führen Sie unten angegebene Handlungen aus';
$L['install_executesql'] = 'Kopieren Sie folgenden Code und führen Sie es mit dem entsprechenden Werkzeug aus, um Tabellenstruktur zu erzeugen. (Das Werkzeug hängt von ausgewählten Datenbankmodul ab.)';
$L['install_saveconfig'] = 'Kopieren Sie folgenden Code und speichern Sie es als <em>conf/config.php</em>';
$L['install_createdirs'] = 'Erstellen Sie Verzeichnisse <em>data/backups/</em> und <em>data/cache/</em> und setzen Sie Zugriffsrechte auf 777 (<em>CHMOD 777</em>).';
$L['install_select'] = 'Markieren';
$L['config_dbhost'] = 'Adresse des Datenbankservers';
$L['config_dbport'] = 'Datenbank-Port';
$L['config_dbuser'] = 'Datenbank-Benutzername';
$L['config_dbpass'] = 'Datenbank-Benutzerpasswort';
$L['config_dbname'] = 'Datenbankname';
$L['config_dbprefix'] = 'Prefix für Tabellen in der Datenbank';
$L['config_pconnect'] = 'Dauerhafte Verbindung zur Datenbank aufbauen';
$L['config_convertlogs'] = 'Alte Logprotokoll konvertieren';
$L['config_onlygeneratesql'] = 'Nur SQL-Statement generieren (ohne es auszuführen)';
$L['config_replacetables'] = 'Bestehende Tabellen überschreiben (nur wenn die Tabellen mit den gleichen Namen schon existieren)';
?>