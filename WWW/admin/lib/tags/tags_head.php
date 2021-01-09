<?

function head() {
global $cfg,$lang,$language; 

echo "<head>\n"
    ."<meta http-equiv=\"content-type\" content=\"text/html; charset=".$lang['charset']."\" />\n"
    ."<meta http-equiv=\"content-Language\" content=\"".$language."\" />\n"
    ."<meta name=\"Keywords\" content=\"".$lang['keywords']."\" />\n"
    ."<meta name=\"Description\" content=\"".$lang['description']."\" />\n"
    ."<meta name=\"Copyright\" content=\"VISMEDIA => www.vismedia.pl\" />\n"
    ."<meta name=\"Author\" content=\"VISMEDIA => www.vismedia.pl\" />\n"
    ."<meta name=\"Robots\" content=\"noindex,follow\" />\n"
    ."<link href=\"../favicon.ico\" rel=\"SHORTCUT ICON\" />\n"
    ."<link rel=\"stylesheet\" href=\"themes/".$cfg['theme']."/style.css\" type=\"text/css\" />\n"
    ."<title>".$lang['title']."</title>\n"
    ."<script type=\"text/javascript\" src=\"../lib/js/lytebox/lytebox.js\"></script>\n"
    ."<link rel=\"stylesheet\" href=\"../lib/js/lytebox/lytebox.css\" media=\"screen\" />\n"
    ."<script type=\"text/javascript\" src=\"../lib/js/color_picker/302pop.js\"></script>\n"
    ."<script type=\"text/javascript\" src=\"../lib/js/kalendarz.js\"></script>\n"
    ."<script type=\"text/javascript\" src=\"../lib/js/dropdownmenu.js\"></script>\n"
    ."<script type=\"text/javascript\" src=\"../lib/js/functions.js\"></script>\n"
    ."</head>\n\n";
	
}

?>