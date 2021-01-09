<?php
$L['install_step'] = 'Krok %d z 3';
$L['install_introduction'] = 'Wprowadzenie';
$L['install_greeting'] = '<strong>Witaj w instalatorze eStats!</strong><br /><br />
Skrypt ten umożliwia szybkie i łatwe zainstalowanie eStats na Twoim serwerze.<br />
Wybierz typ bazy danych i hasło administratora.<br />
Gdy wypełnisz pola kliknij przycisk <em>Kontynuuj</em> aby dokonać konfiguracji.';
$L['install_installation'] = 'Instalacja';
$L['install_upgrade'] = 'Aktualizacja';
$L['install_action'] = 'Działanie';
$L['install_permissions'] = 'Test uprawnień';
$L['install_notwritable'] = 'Brak praw do zapisu';
$L['install_notexists'] = 'Nie istnieje';
$L['install_ok'] = 'OK';
$L['install_continue'] = 'Kontynuuj';
$L['install_continuewhatever'] = 'Kontynuuj mimo wszystko';
$L['install_continueconfirm'] = 'Kontynuacja pomimo błędów grozi nieoczekiwanymi rezultatami!\nKontynuujesz na własne ryzyko!';
$L['install_continueselectdb'] = 'Wybierz z listy moduł do instalacji';
$L['install_nomodulesupported'] = 'Brak wsparcia dla żadnego z dostępnych modułów!';
$L['install_couldnotcontinue'] = 'Nie można kontynuować!';
$L['install_toooldphp'] = 'Zbyt stara wersja PHP!';
$L['install_aboutmodule'] = 'Informacje o module';
$L['install_modulenotsupported'] = 'Ten typ bazy danych nie jest obsługiwany na tym serwerze!<br />
Kontynuacja instalacji może doprowadzić do nieoczekiwanych rezultatów!';
$L['install_adminpasstooshort'] = 'Hasło administratora posiada mniej niż pięć znaków - dla większego bezpieczeństwa zaleca się wybranie dłuższego hasła.';
$L['install_testconnection'] = 'Testuj połączenie z bazą danych';
$L['install_conectionerror'] = 'Błąd podczas próby połączenia z bazą danych!';
$L['install_conectionsuccess'] = 'Połączenie nawiązane pomyślnie.';
$L['install_directorieserror'] = 'Wystąpiły problemy podczas tworzenia struktury katalogów!';
$L['install_directoriessuccess'] = 'Struktura katalogów utworzona pomyślnie.';
$L['install_databaseerror'] = 'Wystąpiły problemy podczas tworzenia struktury bazy danych!';
$L['install_databasesuccess'] = 'Struktura bazy danych utworzona pomyślnie.';
$L['install_couldnotsaveconfig'] = 'Plik konfiguracyjny nie mógł zostać zapisany!';
$L['install_saveconfigerror'] = 'Wystąpił problem z zapisem pliku konfiguracyjnego!';
$L['install_saveconfigsuccess'] = 'Plik konfiguracyjny zapisany pomyślnie.';
$L['install_end'] = 'Zakończenie instalacji';
$L['install_mainend'] = 'Główna część instalacji zakończona';
$L['install_enddesc'] = 'Jeśli nie pozostały żadne czynności do wykonania, przejdź do strony <a href="%s"><strong>konfiguracji</strong></a> i dokonaj ustawień po instalacyjnych.<br />
<strong>Pamiętaj aby usunąć plik <em>install.php</em>!</strong>';
$L['install_executeactions'] = 'W celu dokończenia instalacji wykonaj poniższe czynności';
$L['install_executesql'] = 'Skopiuj poniższy kod i wykonaj go za pomocą odpowiedniego narzędzia (w zależności od wybranego typu bazy danych) w celu utworzenia struktury bazy danych';
$L['install_saveconfig'] = 'Skopiuj poniższy kod i zapisz go jako plik <em>conf/config.php</em>';
$L['install_createdirs'] = 'Utwórz katalogi <em>data/backups/</em> oraz <em>data/cache/</em> oraz nadaj im prawa do zapisu (<em>CHMOD 777</em>).';
$L['install_select'] = 'Zaznacz';
$L['config_dbhost'] = 'Host bazy danych';
$L['config_dbport'] = 'Port bazy danych';
$L['config_dbuser'] = 'Użytkownik bazy danych';
$L['config_dbpass'] = 'Hasło użytkownika bazy danych';
$L['config_dbname'] = 'Nazwa bazy danych';
$L['config_dbprefix'] = 'Prefiks tabel bazy danych';
$L['config_pconnect'] = 'Używaj stałego połączenia z bazą danych';
$L['config_convertlogs'] = 'Konwertuj stare logi';
$L['config_onlygeneratesql'] = 'Jedynie wygeneruj kod SQL (bez wykonania)';
$L['config_replacetables'] = 'Zastępuj istniejące tabele (jeśli już istnieją o takiej nazwie)';
?>