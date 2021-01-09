<?

function head() {
global $cfg,$lang,$language,$language_id,$SubEx;

$title=$lang['title'];

if($_GET['module']=='static') {
	$vars = explode(',',$_GET['act']);
	$var_1 = $vars[0];
	$var_2 = $vars[1];

	if($var_1=='show') {
		if(is_numeric($var_2)) {
			$sql = sql("SELECT title FROM viscms_static WHERE ident=".$var_2." AND language_id=".$language_id);
			if(list($tt) = dbrow($sql)) $title = $tt.' - '.$title;
		}
	}
} elseif($_GET['module']=='articles') {
	$vars = explode(',',$_GET['act']);
	$var_1 = $vars[0];
	$var_2 = $vars[1];

	if($var_1=='show') {
		if(is_numeric($var_2)) {
			$sql = sql("SELECT title FROM viscms_articles WHERE id=".$var_2." AND active=1 AND language_id=".$language_id);
			if(list($tt) = dbrow($sql)) $title = $tt.' - '.$title;
		}
	}
}

echo "<head>\n"
    ."<meta http-equiv=\"content-type\" content=\"text/html; charset=".$lang['charset']."\" />\n"
    ."<meta http-equiv=\"content-Language\" content=\"".$language."\" />\n"
    ."<meta name=\"Keywords\" content=\"".$lang['keywords']."\" />\n"
    ."<meta name=\"Description\" content=\"".$lang['description']."\" />\n"
    ."<meta name=\"Copyright\" content=\"VISMEDIA => www.vismedia.pl\" />\n"
    ."<meta name=\"Author\" content=\"VISMEDIA => www.vismedia.pl\" />\n"
    ."<meta name=\"Robots\" content=\"index,follow\" />\n"
    ."<link href=\"favicon.ico\" rel=\"SHORTCUT ICON\" />\n"
    ."<title>".$title."</title>\n"
    ."<script type=\"text/javascript\" src=\"lib/js/functions.js\"></script>\n"
    ."<script type=\"text/javascript\" src=\"lib/js/clock.js\"></script>\n"
    ."<link rel=\"stylesheet\" type=\"text/css\" href=\"lib/js/multimenu/style.css\" />\n"
    ."<script type=\"text/javascript\" src=\"lib/js/multimenu/ie5.js\"></script>\n"
    ."<script type=\"text/javascript\" src=\"lib/js/multimenu/DropDownMenuX.js\"></script>\n"
    ."<script type=\"text/javascript\" src=\"lib/js/dropdownmenu.js\"></script>\n"
    ."<script type=\"text/javascript\" src=\"lib/js/flashJs/FLRelease1.js\"></script>\n"
    ."<script type=\"text/javascript\" src=\"lib/js/flashJs/FLRelease2.js\"></script>\n"
    ."<script type=\"text/javascript\" src=\"lib/js/lightbox/prototype.js\"></script>\n"
    ."<script type=\"text/javascript\" src=\"lib/js/lightbox/scriptaculous.js?load=effects\"></script>\n"
    ."<script type=\"text/javascript\" src=\"lib/js/lightbox/lightbox.js\"></script>\n"
    ."<link rel=\"stylesheet\" href=\"lib/js/lightbox/css/lightbox.css\" media=\"screen\" />\n"
    ."<link rel=\"stylesheet\" href=\"themes/".$cfg['theme']."/style.css\" type=\"text/css\" />\n"
    ."<bgsound src=\"Kolenda 1.mp3\">\n"
    ."</head>\n\n";
    
}

?>