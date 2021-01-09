<?php
//======eVisualConfirm v2.0.01======
// Author: Emdek
// Licence: GPL
// http://emdek.cba.pl
// 2006-07-21 14:31:18 CEST
session_start ();
header ('Content-type: image/png');
header ('Expires: '.gmdate ('r', 0));
header ('Last-Modified: '.gmdate ('r'));
header ('Cache-Control: no-store, no-cache, must-revalidate');
header ('Pragma: no-cache');
$Textures = glob ('textures/*.jpg');
$Fonts = glob ('fonts/*.ttf');
$Texture = imagecreatefromjpeg ($Textures[mt_rand (0, count ($Textures) - 1)]);
$Width = 20 + (30 * strlen ($_SESSION['e_VCText']));
$Image = imagecreatetruecolor ($Width, 60);
imagecopyresampled ($Image, $Texture, 0, 0, 0, 0, $Width, 60, 165, 60);
imagedestroy ($Texture);
for ($i = 0; $i < strlen ($_SESSION['e_VCText']); $i++) imagettftext ($Image, mt_rand (22, 26), mt_rand (- 10, 10), (10 + (30 * $i)), (30 + (mt_rand (0, 10))), imagecolorallocatealpha ($Image, mt_rand (0, 28), mt_rand (0, 28), mt_rand (0, 28), 25), $Fonts[mt_rand (0, count ($Fonts) - 1)], $_SESSION['e_VCText'][$i]);
if ($_SESSION['DHeight'] && $_SESSION['DHeight'] != 50) {
   $NWidth = ($_SESSION['DHeight'] / 50) * $Width;
   $TImage = imagecreatetruecolor ($NWidth, $_SESSION['DHeight']);
   imagecopyresampled ($TImage, $Image, 0, 0, 0, 0, $NWidth, $_SESSION['DHeight'], $Width, 50);
   $Image = $TImage;
   }
imagepng ($Image);
imagedestroy ($Image);
?>