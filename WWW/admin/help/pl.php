<?

###############################
#           SPU-CMS           #
############-------############
#         SPU Systems         #
#       www.spu.com.pl        #
#      biuro@spu.com.pl       #
###############################

## MODULE: HELP, LANGUAGE: PL ##

global $faq;

$faq = array();

$question = "Jakie wymagania musi spe�nia� serwer, aby zainstalowa� visCMS?";
$answer = "Serwer musi by� wyposa�ony w j�zyk PHP 4 lub nowszy oraz baz� danych MySQL 4 lub nowsz�";
array_push($faq,array($question,$answer));

$question = "Dane kontakowe do administratora visCMS";
$answer = "VISMEDIA, 30-434 Krak�w, ul. Go�dzikowa 4";
array_push($faq,array($question,$answer));


###############

$abc = array_rand($faq);
echo '<b><i>'.$faq[$abc][0].'</i></b><br />'.$faq[$abc][1].'<br />';
echo '<div align="right"><i>Wi�cej na <a href="http://www.vismedia.pl"><i>www.vismedia.pl</i></a></i></div>';

?>