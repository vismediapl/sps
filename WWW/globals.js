/* ########################################################################
#	Funkcja: 	NoSpam 
#	Autor: 		Pawe� W�glarz (Agencja Medi�w Interaktywnych GREEN LEMON)
#
#	Wszelkie prawa Zastrze�one 2000-2007 
#												www.greenlemon.pl
#
###########################################################################
*/

function nospam() {
if (!document.getElementsByTagName) return;
var anchors = document.getElementsByTagName("a");
for (var i=0; i<anchors.length; i++) {
var anchor = anchors[i];
if (anchor.getAttribute("href") && anchor.getAttribute("rel")=="mail")
anchor.href = anchor.getAttribute("href").replace('(at)','@');
}
}



window.onload = nospam;