<?php
$Schema = array (
	'configuration' => 'CREATE TABLE "'.$DBPrefix.'configuration" ("name" varchar(50) NOT NULL, "value" text, "mode" smallint NOT NULL, PRIMARY KEY ("name"))',
	'logs' => 'CREATE TABLE "'.$DBPrefix.'logs" ("time" int NOT NULL, "log" smallint NOT NULL, "info" text)',
	'daysofweekpopularity' => 'CREATE TABLE "'.$DBPrefix.'daysofweekpopularity" ("day" smallint NOT NULL, "uni" int NOT NULL, "all" int NOT NULL, PRIMARY KEY ("day"))',
	'hourspopularity' => 'CREATE TABLE "'.$DBPrefix.'hourspopularity" ("hour" smallint NOT NULL, "uni" int NOT NULL, "all" int NOT NULL, PRIMARY KEY ("hour"))',
	'archive' => 'CREATE TABLE "'.$DBPrefix.'archive" ("date" date NOT NULL, "uni" int NOT NULL, "all" int NOT NULL, PRIMARY KEY ("date"))',
	'visitors' => 'CREATE TABLE "'.$DBPrefix.'visitors" ("uid" int NOT NULL, "ip" text NOT NULL, "ua" text NOT NULL, "host" text NOT NULL, "referrer" text NOT NULL, "lang" text NOT NULL, "js" text NOT NULL, "cookies" text NOT NULL, "flash" text NOT NULL, "java" text NOT NULL, "screen" text NOT NULL, "info" smallint NOT NULL, "robot" varchar(50) NOT NULL, "proxy" varchar(50) NOT NULL, "proxyip" varchar(50) NOT NULL, "firsttime" int NOT NULL, "lasttime" int NOT NULL, "visits" int NOT NULL, PRIMARY KEY ("uid"))',
	'details' => 'CREATE TABLE "'.$DBPrefix.'details" ("uid" int NOT NULL, "sid" text NOT NULL, "time" int NOT NULL)',
	'ignored' => 'CREATE TABLE "'.$DBPrefix.'ignored" ("lastall" int NOT NULL, "lastuni" int NOT NULL, "first" int NOT NULL, "ip" varchar(20) NOT NULL, "uni" int NOT NULL, "all" int NOT NULL, "ua" text NOT NULL, "type" smallint NOT NULL, PRIMARY KEY  ("ip", "type"))',
	'hours' => 'CREATE TABLE "'.$DBPrefix.'hours" ("time" timestamp NOT NULL, "uni" int NOT NULL, "all" int NOT NULL, PRIMARY KEY ("time"))',
	'browsers' => 'CREATE TABLE "'.$DBPrefix.'browsers" ("date" date NOT NULL, "name" text NOT NULL, "num" int NOT NULL, "version" text NOT NULL)',
	'oses' => 'CREATE TABLE "'.$DBPrefix.'oses" ("date" date NOT NULL, "name" text NOT NULL, "num" int NOT NULL, "version" text NOT NULL)',
	'sites' => 'CREATE TABLE "'.$DBPrefix.'sites" ("date" date NOT NULL, "name" text NOT NULL, "num" int NOT NULL, "address" text NOT NULL)'
	);
$DBTables = array ('cookies', 'flash', 'hosts', 'java', 'javascript', 'keywords', 'langs', 'referrers', 'robots', 'screens', 'websearchers');
for ($i = 0; $i < count ($DBTables); $i++) $Schema[$DBTables[$i]] = 'CREATE TABLE "'.$DBPrefix.$DBTables[$i].'" ("date" date NOT NULL, "name" text NOT NULL, "num" int NOT NULL)';
?>