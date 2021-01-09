<?

$link = @mysql_connect($cfg['sql_host'],$cfg['sql_user'],$cfg['sql_pass']);
$base = @mysql_select_db ($cfg['sql_db']);
if(!$link) die(include("errors/unavailable.html"));

function sql($query="") {
 return mysql_query($query);
}

function sqlfree($query="") {
 return mysql_free_result($query);
}

function sqlv($q,$pole,$domyslnie=false) {
 $dane=sql($q);
 if (!$dane) return $domyslnie;
 if (!isset($dane[0][$pole])) return $domyslnie;
 sqlfree($dane);
 return $dane[0][$pole];
}

function dbinsertid() {
 return mysql_insert_id();
}

function dbrow($param) {
 return mysql_fetch_row($param);
}

function dbarray($param) {
 return mysql_fetch_array($param);
}

function dbquery($query="") {
 $ret=sql($query);
 return $ret;
}

function dbclose() {
global $link;
 $ret=mysql_close($link);
 $ret=false; 
}

$sql0 = sql("SELECT `option`,`value` FROM viscms_config");
while(list($op,$va) = dbrow($sql0)) $cfg[$op] = $va;

?>
