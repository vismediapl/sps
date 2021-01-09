<?php
function e_os ($String) {
         if (!$String) return (array ('?', ''));
         $Array = array (
	'Vista' => array (
		'windows nt 6.0',
		'winnt6.0'
		),
	'2003' => array (
		'windows nt 5.2',
		'winnt5.2'
		),
	'XP' => array (
		'windows nt 5.1',
		'winnt5.1',
		'windows xp',
		'winxp',
		'cygwin_nt-5.1'
		),
	'2000' => array (
		'windows nt 5.0',
		'winnt5.0',
		'windows 2000',
		'win2000'
		),
	'ME' => array (
		'windows me',
		'win9x 4.90',
		'win 9x 4.90',
		'winme'
		),
	'98' => array (
		'windows 98',
		'win98'
		),
	'95' => array (
		'windows 95',
		'win95'
		),
	'NT' => array (
		'windows nt',
		'winnt'
		),
	'CE' => array (
		'windows ce',
		'wince'
		)
	);
         reset ($Array);
         while (list ($Key, $Value) = each ($Array)) {
               $Var = reset ($Value);
               while ($Var) {
                     if (stristr ($String, $Var)) return (array ('Windows', $Key));
                     $Var = next ($Value);
                     }
               }
         if (stristr ($String, 'Linux')) {
            $Array = array (
	'CentOS',
	'Debian',
	'Gentoo',
	'Kanotix',
	'KateOS',
	'Knoppix',
	'Kubuntu',
	'Mandriva',
	'RedHat',
	'Slackware',
	'SuSE',
	'Ubuntu'
	);
            for ($i = 0, $c = count ($Array); $i < $c; $i++) if (stristr ($String, $Array[$i])) return (array ('Linux', $Array[$i]));
            return (array ('Linux', ''));
            }
         if (stristr ($String, 'macos') || stristr ($String, 'mac os x') || stristr ($String, 'mac_osx') || stristr ($String, 'os=mac')) return (array ('MacOS', 'X'));
         if (stristr ($String, 'symbian')) {
            preg_match('#SymbianOS\/([\w\+\-\.]+)#i', $String, $Version);
            return (array ('Symbian', $Version[1]));
            }
         if (stristr ($String, 'sun')) {
            preg_match('#sun[ \-]?os[ /]?([\d.]+)#i', $String, $Version);
            return (array ('Sun', $Version[1]));
            }
         if (stristr ($String, 'palm')) {
            preg_match('#Palm[ \-]?(Source|OS)[ /]?([\d.]+)#i', $String, $Version);
            return (array ('Palm', $Version[1]));
            }
	 $Array = array (
	'Amiga',
	'BeOS',
	'Darwin',
	'FreeBSD',
	'HP-UX',
	'NetBSD',
	'OpenBSD',
	'OS/2',
	'UnixWare',
	'Windows'
	);
         for ($i = 0, $c = count ($Array); $i < $c; $i++) if (stristr ($String, $Array[$i])) return (array ($Array[$i], ''));
         $Array = array (
	'Nokia[ ]?([\w\+\-\.]+)', 'Nokia',
	'samsung\-([\w\+\-\.]+)\/', 'Samsung',
	'SonyEricsson[ ]?([\w\+\-\.]+)', 'SonyEricsson',
	'', 'BenQ',
	'Panasonic\-?([\w\+\-\.]+)', 'Panasonic',
	'Philips\-([\w\+\-\@\.]+)', 'Philips',
	'Alcatel\-([0-9a-zA-Z\+\-\.]+)', 'Alcatel',
	'BlackBerry([\w\+\-\.]+)?\/', 'BlackBerry',
	'Acer\-([\w\+\-\.]+)', 'Acer',
	'Ericsson[ ]?([\w\+\-\.]+)', 'Ericsson',
	);
         for ($i = 1, $c = count ($Array); $i < $c; $i += 2) {
             if (strstr ($String, $Array[$i])) {
                preg_match ('#'.$Array[$i - 1].'#i', $String, $Version);
                return (array ('mobile', $Array[$i].($Version[1]?' - '.$Version[1]:'')));
                }
             }
         if (preg_match ('#mot\-([\w\+\-\.]+)?\/#i', $String, $Version)) return (array ('mobile', 'Motorola'.($Version[1]?' - '.$Version[1]:'')));
         if (preg_match ('#sie\-([\w\+\-\.]+)?\/#i', $String, $Version)) return (array ('mobile', 'Siemens'.($Version[1]?' - '.$Version[1]:'')));
         if (stristr ($String, 'mac')) return (array ('MacOS', 'Classic'));
         if (stristr ($String, 'photon')) return (array ('QNX', ''));
         return (array ('?', ''));
         }
?>