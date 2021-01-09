<?php /* Smarty version 2.6.13, created on 2006-06-20 14:16:52
         compiled from browser.tpl */ ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="utf-8"<?php echo '?>'; ?>

<!DOCTYPE html PUBLIC "-//mls//DTD XHTML 1.1 with IFrame and Target//EN" "http://localhost/_own/fckmfb/dtd/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl">
<head>
	<title>Przeglądarka plików FCK/MFB</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="QuickSilver Internet Solutions, http://www.quicksilver.pl" />
	<meta name="author" content="Marcin Laber, m(dot)laber(at)quicksilver(dot)pl" />
	<link href="img/mfb.css" rel="stylesheet" type="text/css" title="Styl standardowy" media="screen" />
	<!--[if IE]><link href="img/mfb-ie.css" rel="stylesheet" type="text/css" title="Styl standardowy dla IE" media="screen" /><![endif]-->
	<script type="text/javascript" src="js/behaviour.js"></script>
	<script type="text/javascript" src="js/prototype.js"></script>
	<script type="text/javascript" src="js/mfb.js"></script>
</head>

<body>
<div id="loading"><div></div></div>
<form action="upload.php" method="post" id="upForm" enctype="multipart/form-data" target="ifUpload">
<table cellspacing="0" id="ft">
<tr>
	<td id="top" colspan="2">
	</td>
</tr>
<tr>
	<td class="dirs">
		<div id="left">
		</div>
	</td>
	<td>
		<div id="right">
		</div>
	</td>
</tr>
<tr>
	<td class="newdir">
		<a href="#" onclick="createFolder(); return false" id="newfolderbtn"><img src="img/d.gif" alt="" /> Utwórz katalog</a>
	</td>
	<td class="upload">
		Wyślij plik do obecnego katalogu: 
		<input type="file" name="upload" id="fileBox" />
		<input type="hidden" id="cfolder" name="cfolder" value="" />
		<input type="button" value="Wyślij" onclick="uploadFile()" title="Wyślij plik do obecnego katalogu" id="btnSubmit" />
		<input type="button" value="CFC" onclick="clearFileCache()" title="Usuń tymczasowe pliki miniaturek" />
	</td>
</tr>
</table>
</form>
<iframe name="ifUpload"></iframe>
</body>
</html>
