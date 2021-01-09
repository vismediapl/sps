<?php
require_once('config.php');
require_once('class.ico.php');
$path = pathinfo($_GET['src']);
$thumbnailed = array('gif', 'jpg', 'jpeg', 'png', 'txt', 'wbmp');
$mime = array('gif' => 'image/gif', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'txt' => 'image/png', 'wbmp' => 'image/png');
$maxw = 96;
$maxh = 96;
if (isset($path['extension']))
{
	if (!file_exists($path['dirname'].'/.th_'.$path['basename']))
	{
		if (in_array(strtolower($path['extension']), $thumbnailed))
		{
			switch (strtolower($path['extension']))
			{
				case 'gif':
					$imgs = imagecreatefromgif($_GET['src']);
					break;
				case 'jpg':
				case 'jpeg':
					$imgs = imagecreatefromjpeg($_GET['src']);
					break;
				case 'png':
					$imgs = imagecreatefrompng($_GET['src']);
					break;
				case 'txt':
					$imgs = imagecreate($maxw, $maxh);
					break;
				case 'wbmp':
					$imgs = imagecreatefromwbmp($_GET['src']);
					break;
			}
			
			if (strtolower($path['extension']) != 'txt')
			{
				$sx = imagesx($imgs);
				$sy = imagesy($imgs);
				if ($sx > $maxw || $sy > $maxh)
				{
					$scale = min($maxw / $sx, $maxh / $sy);
					$width = (int)($sx * $scale);
					$height = (int)($sy * $scale);
				}
				else
				{
					$width = $sx;
					$height = $sy;
				}
				$imgd = imagecreatetruecolor($maxw, $maxh);
				imagefill($imgd, 0, 0, imagecolorallocate($imgd, 255, 255, 255)); 
				imagecopyresampled($imgd, $imgs, ($maxw / 2) - ($width / 2), ($maxh / 2) - ($height / 2), 0, 0, $width, $height, $sx, $sy);
			}
			else
			{
				$imgd = imagecreatetruecolor($maxw, $maxh);
				imagefill($imgd, 0, 0, imagecolorallocate($imgd, 255, 255, 255));
				
				$f = fopen($_GET['src'], 'r');
				$src = fread($f, 4096);
				fclose($f);
				$src = explode("\n", $src);
				$top = 0;
				
				foreach ($src as $line)
				{
					$line = str_replace("\r", "", $line);
					$line = str_replace("\n", "", $line);
					$line = str_replace("\t", "    ", $line);
					imagestring($imgd, 1, 3, 3 + ($top * 9), $line, imagecolorallocate($imgd, 0, 0, 0));
					$top ++;
				}
			}
			
			switch (strtolower($path['extension']))
			{
				case 'gif':
					imagegif($imgd);
					if (!isset($config['cacheimages']) || $config['cacheimages'] === true)
						imagegif($imgd, $path['dirname'].'/.th_'.$path['basename']);
					break;
				case 'jpg':
				case 'jpeg':
					imagejpeg($imgd);
					if (!isset($config['cacheimages']) || $config['cacheimages'] === true)
						imagejpeg($imgd, $path['dirname'].'/.th_'.$path['basename'], 60);
					break;
				case 'png':
				case 'txt':
				case 'wbmp':
					imagepng($imgd);
					if (!isset($config['cacheimages']) || $config['cacheimages'] === true)
						imagepng($imgd, $path['dirname'].'/.th_'.$path['basename']);
					break;
			}
			imagedestroy($imgd);
		}
		else
		{
			header('Content-Type: image/png');
			if (file_exists('img/files/'.$path['extension'].'.ico'))
			{
				$ico = new Ico('img/files/'.strtoupper($path['extension']).'.ico');
				$icoimg = $ico->GetIcon(3);
				$icoinf = $ico->GetIconInfo(3);
				
				$imgd = imagecreatetruecolor($maxw, $maxh);
				imagefill($imgd, 0, 0, imagecolorallocate($imgd, 255, 255, 255)); 
				imagecopy($imgd, $icoimg, ($maxw / 2) - ($icoinf['Width'] / 2), ($maxh / 2) - ($icoinf['Height'] / 2), 0, 0, $icoinf['Width'], $icoinf['Height']);
				imagepng($imgd);
			}
			elseif (file_exists('img/files/'.$path['extension'].'.png'))
				readfile('img/files/'.$path['extension'].'.png');
			else
				readfile('img/files/default.png');
		}
	}
	else
	{
		header('Content-Type: '.$mime[$path['extension']]);
		readfile($path['dirname'].'/.th_'.$path['basename']);
	}
}
else
{
	header('Content-Type: image/png');
	readfile('img/files/default.png');
}
?>
