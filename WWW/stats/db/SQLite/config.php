<?php
$TConnection = 0;
$Available = function_exists ('sqlite_query');
$COptions = array (
	'PConnect' => array (0, 0)
	);
$About = array (
	'pl' => 'Moduł wykorzystuje bazę danych SQLite (testowany na wersji 2.8).<br />
Alternatywa dla innych baz danych, gdy nie są dostępne.',
	'en' => 'This module uses SQLite database (tested on 2.8 version).<br />
Alternative for other databases if it are not available.'
	);
?>