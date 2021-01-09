<?

function body_on() {
	
$optional = ' onload="document.onmousemove = mysz;"';

echo "<body".$optional.">\n";

}

function body_off() {

echo "</body>\n\n";

}

?>
