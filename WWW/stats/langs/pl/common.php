<?php
$Titles['install'] = array (
	'Instalator'
	);
$Titles['archive'] = array (
	'Archiwum statystyk',
	'Dane archiwalne',
	'Archiwum'
	);
$Titles['detailed'] = array (
	'Statystyki szczegółowe',
	'Dane ostatnich gości',
	'Szczegółowe'
	);
$Titles['details'] = array (
	'Szczegóły wizyty #%d'
	);
$Titles['general'] = array (
	'Statystyki ogólne',
	'Podsumowanie statystyk',
	'Ogólne'
	);
$Titles['technical'] = array (
	'Dane techniczne',
	'Przeglądarki, systemy, roboty sieciowe, itd.',
	'Techniczne'
	);
$Titles['time'] = array (
	'Statystyki czasowe',
	'Liczba wizyt z ostatniej doby, miesiąca i roku',
	'Czasowe'
	);
$Titles['login'] = array (
	'Logowanie'
	);
$Titles['admin'] = array (
	'Administracja',
	'Administracja statystyk',
	'Admin'
	);
$Titles['main'] = array (
	'Strona główna',
	'Strona główna administracji'
	);
$Titles['configuration'] = array (
	'Konfiguracja',
	'Konfiguracja statystyk'
	);
$Titles['advanced'] = array (
	'Zaawansowane',
	'Zaawansowana konfiguracja'
	);
$Titles['blacklist'] = array (
	'Czarna lista',
	'Zarządzaj czarną listą'
	);
$Titles['backups'] = array (
	'Kopie zapasowe',
	'Zarządzanie kopiami zapasowymi'
	);
$Titles['reset'] = array (
	'Resetowanie',
	'Resetowanie danych'
	);
$Titles['logs'] = array (
	'Logi',
	'Przeglądanie logów'
	);
$Titles['plugins'] = array (
	'Wtyczki',
	'Wtyczki rozszerzające funkcjonalność panelu'
	);
$Titles['documentation'] = array (
	'Dokumentacja',
	'Dokumentacja online'
	);
$Titles['forum'] = array (
	'Forum projektu',
	'Oficjalne forum projektu'
	);

$Months = array (
	array ('Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'),
	array ('STY', 'LUT', 'MAR', 'KWI', 'MAJ', 'CZE', 'LIP', 'SIE', 'WRZ', 'PAŹ', 'LIS', 'GRU')
	);

$Days = array (
	array ('Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'),
	array ('NIE', 'PON', 'WTO', 'ŚRO', 'CZW', 'PIĄ', 'SOB')
	);

$Log[0] = 'eStats zostało zainstalowane';
$Log[1] = 'Wersja eStats została zmieniona';
$Log[2] = 'Konfiguracja została zmieniona';
$Log[10] = 'Administrator zalogował się';
$Log[11] = 'Nieudana próba logowania do panelu';
$Log[12] = 'Hasło administratora zostało zmienione';
$Log[13] = 'Nieudana próba zmiany hasła administratora';
$Log[14] = 'Użytkownik zalogował się';
$Log[15] = 'Nieudana próba logowania użytkownika';
$Log[20] = 'Wykonana została kopia zapasowa';
$Log[21] = 'Nieudana próba wykonania kopii zapasowej';
$Log[22] = 'Usunięto kopię zapasową';
$Log[23] = 'Nieudana próba usunięcia kopii zapasowej';
$Log[24] = 'Przywrócono dane z kopii zapasowej';
$Log[25] = 'Nieudana próba przywrócenia danych z kopii zapasowej';
$Log[30] = 'Usunięto dane szczegółowe';
$Log[31] = 'Usunięto całość danych';
$Log[32] = 'Usunięto kopie zapasowe';
$Log[33] = 'Usunięto cache';
$Log[34] = 'Usunięto dane z wybranej tabeli';

$L['announce_couldnotloadfile'] = 'Nie można załadować pliku!';
$L['announce_couldnotconnect'] = 'Nie można połączyć się z bazą danych!';
$L['announce_notsupprotedmodule'] = 'Ten moduł nie jest obsługiwany na tym serwerze!';
$L['announce_unfinishedtranslation'] = 'To tłumaczenie (%s) nie jest kompletne!';
$L['announce_needjs'] = 'Aktywna obsługa JavaScript jest niezbędna do prawidłowego działania tego narzędzia!';
$L['announce_differentpass'] = 'Podane hasła różnią się!';
$L['announce_disabledplugin'] = 'Ta wtyczka nie jest aktywna!';
$L['announce_adminboarddisabled'] = 'Panel administracyjny został wyłączony!';
$L['announce_wrongpass'] = 'Błędne hasło!';
$L['announce_statsdisabled'] = 'Statystyki są nieaktywne.';
$L['announce_removeinstall.php'] = 'Plik <em>install.php</em> powinien zostać usunięty po zakończeniu instalacji!';
$L['announce_maintenance'] = 'Strona niedostępna z powodu konserwacji.';
$L['announce_maintenanceadmin'] = 'Tryb konserwacji aktywny!<br />
Jeśli wylogujesz się przed jego wyłączeniem, to nie będziesz mógł się zalogować, aby go deaktywować!';
$L['announce_ipblocked'] = 'Ten adres IP został zablokowany!';
$L['announce_refresh'] = 'Nie możesz tak szybko przeładowywać strony!';
$L['announce_newversion'] = 'Dostępna jest nowa wersja (%s)!';
$L['announce_groupdisabled'] = 'Ta grupa jest nieaktywna!';
$L['announce_groupcollectingdisabled'] = 'Zbieranie danych dla tej grupy zostało wyłączone!';
$L['announce_couldnotcheckversion'] = 'Nie można sprawdzić dostępności nowej wersji!';
$L['announce_unstableversion'] = 'Jest to wersja testowa <em>eStats</em> (status: <em>%s</em>).<br />
Jej funkcjonalność może być niepełna, może także działać nieprawidłowo i być niekompatybilna z nowszymi wersjami!<br />
<strong style="text-decoration:underline;">Używasz jej na własne ryzyko!</strong>';

$L['confirm_defaults'] = 'Czy na pewno chcesz przywrócić domyślne?';
$L['confirm_save'] = 'Czy na pewno chcesz zapisać zmiany?';
$L['confirm_restore'] = 'Czy na pewno chcesz przywrócić dane?';
$L['confirm_delete'] = 'Czy na pewno chcesz usunąć dane?';
$L['confirm_ipblock'] = 'Czy na pewno chcesz zbanować ten adres IP?';
$L['confirm_referrerblock'] = 'Czy na pewno chcesz wykluczyć to źródło?';
$L['confirm_keywordblock'] = 'Czy na pewno chcesz wykluczyć to słowo kluczowe / frazę?';

$L['logout'] = 'Wyloguj się';
$L['maintenance'] = 'Konserwacja strony';
$L['accesdenied'] = 'Brak dostępu';
$L['critical'] = 'Błąd krytyczny!';
$L['enablecollectdata'] = 'Aktywuj zbieranie danych';
$L['disablemaintenace'] = 'Wyłącz tryb konserwacji';
$L['information'] = 'Informacja';
$L['error'] = 'Błąd';
$L['warning'] = 'Ostrzeżenie';
$L['success'] = 'Sukces';
$L['sites'] = 'Popularność stron';
$L['langs'] = 'Języki';
$L['oses'] = 'Systemy';
$L['browsers'] = 'Przeglądarki';
$L['robots'] = 'Roboty sieciowe';
$L['hosts'] = 'Hosty';
$L['referrers'] = 'Źródła';
$L['keywords'] = 'Słowa kluczowe';
$L['screens'] = 'Rozdzielczości ekranu';
$L['flash'] = 'Wtyczka Flash';
$L['java'] = 'Java';
$L['javascript'] = 'JavaScript';
$L['cookies'] = 'Cookies';
$L['vbrowsers'] = 'Wersje przeglądarek';
$L['voses'] = 'Wersje systemów';
$L['websearchers'] = 'Wyszukiwarki';
$L['statsfor'] = 'Statystyki dla';
$L['selectlang'] = 'Wybierz język';
$L['selecttheme'] = 'Wybierz motyw';
$L['debug'] = 'Debugowanie';
$L['pagegeneration'] = 'Czas generowania strony: %.3lf (s)';
$L['gototop'] = 'Przejdź do góry';
$L['change'] = 'Zmień';
$L['pass'] = 'Hasło';
$L['loginto'] = 'Zaloguj';
$L['remember'] = 'Zapamiętaj';
$L['datafromcache'] = 'Dane pochodzą z <em>cache</em>, odświeżone: %s.';
$L['showdatafor'] = 'Pokaż dane dla';
$L['of'] = 'z';
$L['itemsamount'] = 'Liczba pozycji (obecnie: %d)';
$L['groupdatacollectingenabled'] = 'Zbieranie danych dla grupy aktywne';
$L['online'] = 'Online';
$L['lastweek'] = 'Ostatni tydzień';
$L['lasthour'] = 'Ostatnia godzina';
$L['excluded'] = 'Wykluczone';
$L['most'] = 'Najwięcej';
$L['averageperday'] = 'Średnio dziennie';
$L['averageperhour'] = 'Średnio w ciągu godziny';
$L['sum'] = 'Razem';
$L['directentries'] = 'Wejścia bezpośrednie';
$L['mobile'] = 'Urządzenia przenośne';
$L['yes'] = 'Tak';
$L['no'] = 'Nie';
$L['unknown'] = 'Brak danych';
$L['blockreferrer'] = 'Zablokuj zliczanie tego źródła';
$L['unblockreferrer'] = 'Odblokuj zliczanie tego źródła';
$L['blockkeyword'] = 'Zablokuj zliczanie tego słowa kluczowego / frazy';
$L['all'] = 'Wszystkie';
$L['firstvisit'] = 'Pierwsza wizyta';
$L['lastvisit'] = 'Ostatnia wizyta';
$L['visitamount'] = 'Liczba wizyt';
$L['referrer'] = 'Strona odsyłająca';
$L['host'] = 'Host';
$L['userinfo'] = 'Konfiguracja';
$L['date'] = 'Data';
$L['site'] = 'Strona';
$L['seedetails'] = 'Zobacz szczegóły tej wizyty';
$L['legend'] = 'Legenda';
$L['yourvisit'] = 'Twoja wizyta';
$L['onlinevisitors'] = 'Goście online (ostatnie pięć minut)';
$L['hiderobots'] = 'Ukryj roboty sieciowe';
$L['showrobots'] = 'Pokaż roboty sieciowe';
$L['proxy'] = 'Proxy';
$L['browser'] = 'Przeglądarka';
$L['os'] = 'System operacyjny';
$L['lang'] = 'Język';
$L['screenresolution'] = 'Rozdzielczość';
$L['flashversion'] = 'Wersja wtyczki Flash';
$L['javaenabled'] = 'Java aktywna';
$L['jsenabled'] = 'JavaScript aktywny';
$L['cookiesenabled'] = 'Cookies aktywne';
$L['blockip'] = 'Zablokuj ten IP';
$L['visitedpages'] = 'Odwiedzone strony';
$L['dataunavailable'] = 'Dane niedostępne';
$L['last24hours'] = 'Ostatnia doba';
$L['lastmonth'] = 'Ostatni miesiąc';
$L['lastyear'] = 'Ostatni rok';
$L['lastyears'] = 'Ostatnie lata';
$L['hourspopularity'] = 'Popularność godzin';
$L['dayspopularity'] = 'Popularność dni tygodnia';
$L['summary'] = 'Podsumowanie';
$L['average'] = 'Średnio';
$L['least'] = 'Najmniej';
$L['month'] = 'Miesiąc';
$L['year'] = 'Rok';
$L['visits'] = 'Odwiedziny';
$L['chartsview'] = 'Widok wykresów odwiedzin';
$L['showhidelevels'] = 'Pokaż / ukryj poziomy maksimum, średniej i minimum';
$L['levelsmax'] = 'maksimum';
$L['levelsaverage'] = 'średnia';
$L['levelsmin'] = 'minimum';
$L['unique'] = 'Unikalne';
$L['views'] = 'Odsłony';
$L['unblockip'] = 'Odblokuj IP';
$L['unblockiprange'] = 'Odblokuj zakres IP';
$L['view'] = 'Podgląd';
$L['save'] = 'Zapisz';
$L['defaults'] = 'Domyślne';
$L['reset'] = 'Resetuj';
$L['whois'] = 'Whois';

$L['adminpass'] = 'Hasło administratora';
$L['currentpass'] = 'Obecne hasło';
$L['newpass'] = 'Nowe hasło';
$L['repeatpass'] = 'Powtórz hasło';
$L['changepass'] = 'Zmień hasło';
$L['settings'] = 'Ustawienia';
$L['advanced'] = 'Zaawansowane';
$L['filter'] = 'Filtr';
$L['search'] = 'Szukaj';
$L['showall'] = 'Pokaż wszystkie';
$L['registrationsamount'] = 'Razem wpisów';
$L['meetingconditions'] = 'Spełniających warunki';
$L['showed'] = 'Wyświetlane';
$L['default'] = 'Domyślnie';
$L['defaultvalue'] = 'Domyślna wartość';
$L['valuetype0'] = 'Ciąg tekstowy';
$L['valuetype1'] = 'Wartość logiczna';
$L['valuetype2'] = 'Liczba';
$L['valuetype3'] = 'Tablica, elementy rozdzielone przez |';
$L['changedvalue'] = 'Wartość pola jest różna od domyślnej';
$L['managebackups'] = 'Zarządzaj kopiami zapasowymi';
$L['selectbackup'] = 'Wybierz kopię zapasową';
$L['nobackups'] = 'Brak kopii zapasowych';
$L['download'] = 'Pobierz';
$L['delete'] = 'Usuń';
$L['restore'] = 'Przywróć';
$L['compression'] = 'Kompresja';
$L['none'] = 'Brak';
$L['compressiontype'] = 'Rodzaj kompresji pobieranego pliku';
$L['createbackup'] = 'Utwórz kopię zapasową';
$L['send'] = 'Wyślij';
$L['restorebackupfromhd'] = 'Przywróć kopię zapasową zapisaną na dysku';
$L['backuptypefull'] = 'Pełny';
$L['backuptypedata'] = 'Tylko zebrane dane';
$L['backuptypeuser'] = 'Użytkownika';
$L['ignoreruledesc'] = 'Użyj * aby zastąpić końcową część adresu.';
$L['ignoredvisits'] = 'Zignorowane i zablokowane wizyty';
$L['ip'] = 'IP';
$L['lastua'] = 'Ostatni UA';
$L['type'] = 'Typ';
$L['blocked'] = 'Zablokowana';
$L['ignored'] = 'Zignorowana';
$L['export'] = 'Eksportuj';
$L['show'] = 'Wyświetl';
$L['findregistration'] = 'Znajdź wpis (przeszukiwane wszystkich pól)';
$L['resultsperpage'] = 'Wyników na stronę';
$L['inperiod'] = 'W okresie';
$L['from'] = 'Od';
$L['to'] = 'Do';
$L['browse'] = 'Przeglądaj';
$L['log'] = 'Log';
$L['informations'] = 'Informacje';
$L['actions'] = 'Akcje';
$L['phpversion'] = 'Wersja PHP';
$L['estatsversion'] = 'Wersja <em>eStats</em>';
$L['database'] = 'Baza danych';
$L['databasemodule'] = 'Moduł bazy danych';
$L['author'] = 'Autor';
$L['safemode'] = 'Tryb bezpieczny PHP';
$L['serverload'] = 'Obciążenie serwera';
$L['collectedfrom'] = 'Dane zbierane od';
$L['datasize'] = 'Rozmiar danych';
$L['data'] = 'Dane';
$L['cache'] = 'Cache';
$L['backups'] = 'Kopie zapasowe';
$L['lastbackuptime'] = 'Data wykonania ostatniej kopii zapasowej';
$L['availablebackupsamount'] = 'Liczba dostępnych kopii zapasowych';
$L['newversionavailable'] = 'Dostępna jest nowa wersja!';
$L['deactivatestats'] = 'Deaktywuj statystyki';
$L['activatestats'] = 'Uaktywnij statystyki';
$L['deactivatemaintenance'] = 'Deaktywuj tryb konserwacji';
$L['activatemaintenance'] = 'Uaktywnij tryb konserwacji';
$L['deactivateeditmode'] = 'Deaktywuj tryb edycji';
$L['activateeditmode'] = 'Uaktywnij tryb edycji';
$L['resetall'] = 'Usuń wszystkie dane statystyk';
$L['resetdetailed'] = 'Zresetuj statystyki szczegółowe';
$L['resetbackups'] = 'Usuń kopie zapasowe';
$L['resetcache'] = 'Zresetuj cache';
$L['resettable'] = 'Wyczyść wybraną tabelę';
$L['resetcreatebackup'] = 'Utwórz kopię zapasową (tylko dane)';
$L['enabled'] = 'Aktywna';
$L['disabled'] = 'Wyłączona';
$L['pluginsactivate'] = 'Aby (de)aktywować wtyczkę należy wyedytować plik <em>config.php</em> z jej katalogu (np. <em>plugins/editor/config.php</em>) i ustawić wartość zmiennej <em>$Plugins[\'<strong>NAZWA WTYCZKI</strong>\']</em> na <em>1</em> lub <em>0</em>.';
$L['safemodewarn'] = '<em>Tryb bezpieczny PHP</em> został aktywowany na serwerze!<br />
Może to powodować problemy w przypadku automatycznego tworzenia plików i katalogów.<br />
Rozwiązaniem jest zmiana ich właściciela lub ich ręczne utworzenie.';
?>