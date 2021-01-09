<?='<?xml version="1.0" encoding="utf-8"?>'."\n"?>
<!DOCTYPE html PUBLIC "-//mls//DTD XHTML 1.1 with IFrame and Target//EN" "http://localhost/_own/fckmfb/dtd/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl">
<head>
	<title>Przeglądarka plików FCK/MFB - Uploader</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="QuickSilver Internet Solutions, http://www.quicksilver.pl" />
	<meta name="author" content="Marcin Laber, m(dot)laber(at)quicksilver(dot)pl" />
</head>

<body>
<script type="text/javascript">
	top.document.getElementById("fileBox").disabled = false;
	top.document.getElementById("btnSubmit").disabled = false;
	top.document.getElementById("fileBox").value = "";
<?
require_once('config.php');
if (isset($_GET['folder']) && is_uploaded_file($_FILES['upload']['tmp_name']))
{
	$_FILES['upload']['name'] = str_replace("'", '', iconv('utf-8', 'ascii//TRANSLIT', $_FILES['upload']['name']));
	$nname = $config['root'].$config['path'].$_GET['folder'].'/'.$_FILES['upload']['name'];
	$nnamef = $_FILES['upload']['name'];
	$change = false;
	if (file_exists($nname))
	{
		$path = pathinfo($nname);
		$fname = substr($path['basename'], 0, strrpos($path['basename'], '.'));
		$change = true;
		$idx = 1;
		while (file_exists($config['root'].$config['path'].$_GET['folder'].'/'.$fname.' ('.$idx.')'.(isset($path['extension']) ? '.'.$path['extension'] : '')))
			$idx ++;
		$nname = $config['root'].$config['path'].$_GET['folder'].'/'.$fname.' ('.$idx.')'.(isset($path['extension']) ? '.'.$path['extension'] : '');
		$nnamef = $fname.' ('.$idx.')'.(isset($path['extension']) ? '.'.$path['extension'] : '');
	}
	move_uploaded_file($_FILES['upload']['tmp_name'], $nname);
?>
	top.getFiles(top.document.getElementById("cfolder").value);
<? if ($change === true) { ?>
	alert('Plik o nazwie "<?=$_FILES['upload']['name']?>" już istnieje.\nNowy plik został zapisany pod nazwą "<?=$nnamef?>"');
<? } else { ?>
	alert('Plik "<?=$_FILES['upload']['name']?>" został wysłany.');
<? } 
}
else
{
?>
	alert('Wystąpił błąd podczas wysyłania pliku.');
<?
}
?>
</script>
</body>
