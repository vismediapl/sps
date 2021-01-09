<?php
if (!defined ('eStats')) die ();
$Groups = array (
	'browsers' => 2,
	'vbrowsers' => 2,
	'oses' => 2,
	'voses' => 2,
	'websearchers' => 1,
	'robots' => 2,
	'screens' => 2,
	'flash' => 0,
	'java' => 0,
	'javascript' => 0,
	'cookies' => 0
	);
if (!include ('lib/block.php')) e_error ('lib/block.php', __FILE__, __LINE__);
?>