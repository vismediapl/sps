<?php
if (!defined ('eStats')) die ();
function e_create_icon ($FileName) {
         $Ext = explode ('.', $FileName);
         $Ext = strtolower (end ($Ext));
         switch ($Ext) {
                case 'png':
                $Image = imagecreatefrompng ($FileName);
                break;
                case 'jpg':
                case 'jpeg':
                $Image = imagecreatefromjpeg ($FileName);
                break;
                case 'gif':
                $Image = imagecreatefromgif ($FileName);
                default:
                return ('error');
                }
         $Size = getimagesize ($FileName);
         if ($Size[0] > $Size[1]) $NSize = array (14, (($Size[1] * 14) / $Size[0]));
         else $NSize = array ((($Size[0] * 14) / $Size[1]), 14);
         $TImage = imagecreatetruecolor ($NSize[0], $NSize[1]);
         imagecopyresampled ($TImage, $Image, 0, 0, 0, 0, $NSize[0], $NSize[1], $Size[0], $Size[1]);
         imagecolortransparent ($TImage, imagecolorallocate ($TImage, 0, 0, 0));
         imagedestroy ($Image);
         if ($NSize[0] != 14 || $NSize[1] != 14) {
            if ($NSize[0] > $NSize[1]) $Dist = array (0, (int) ((14 - $NSize[1]) / 2));
            else $Dist = array ((int) ((14 - $NSize[0]) / 2), 0);
            $Image = imagecreatetruecolor (14, 14);
            imagefill ($Image, 0, 0, 5);
            imagecolortransparent ($Image, 5);
            imagecopymerge ($Image, $TImage, $Dist[0], $Dist[1], 0, 0, $NSize[0], $NSize[1], 100);
            $TImage = $Image;
            }
         imagetruecolortopalette ($TImage, 0, 256);
         unlink ($FileName);
         $FileName = 'data/temp/'.basename ($FileName).'.png';
         touch ($FileName);
         chmod ($FileName, 0666);
         imagepng ($TImage, $FileName);
         imagedestroy ($TImage);
         return ($FileName);
         }
if (!is_dir ('data/temp')) {
   mkdir ('data/temp', 0777);
   chmod ('data/temp', 0777);
   if (!is_writable ('data/temp')) $Info[] = array ($L['plugin_temperror'], 0);
   }
if (!function_exists ('gd_info')) $Info[] = array ($L['plugin_nogd'], 2);
$Image = '';
if (isset ($_FILES['Image']) && is_uploaded_file ($_FILES['Image']['tmp_name'])) {
   $Name = explode ('.', $_FILES['Image']['name']);
   if (in_array (end ($Name), array ('jpg', 'jpeg', 'png', 'gif'))) {
      move_uploaded_file ($_FILES['Image']['tmp_name'], 'data/temp/'.$_FILES['Image']['name']);
      if (($FileName = e_create_icon ('data/temp/'.$_FILES['Image']['name'])) != 'error') $Image = $FileName;
      }
   else $Info[] = array ($L['plugin_wrongfiletype'], 0);
   }
if (is_dir ('data/temp')) {
   $T['page'] = '<h3>%plugin_generatenew%</h3>
<form action="'.$_SERVER['PHP_SELF'].'" method="post" enctype="multipart/form-data">
<p>
<span>
<input type="file" name="Image" id="Image" tabindex="'.($TIndex++).'" />
<input type="submit" value="%send%" tabindex="'.($TIndex++).'" class="button" />
</span>
<label for="Image">%plugin_selectfile%</label>:
</p>
</form>
'.(($Image && is_file ($FileName))?'<p>
<strong>%plugin_generatedfile%:</strong><br />
<img src="'.$T['dpath'].$FileName.'" alt="" />
</p>
':'').'<h3>%plugin_manageexisting%</h3>
';
   if (isset ($_GET['delete']) && is_file ('data/temp/'.$_GET['delete'].'.png')) unlink ('data/temp/'.$_GET['delete'].'.png');
   clearstatcache ();
   $Files = glob ('data/temp/*.png', GLOB_BRACE);
   for ($i = 0, $c = count ($Files); $i < $c; $i++) $T['page'].= '<p>
<a href="'.$T['dpath'].$Files[$i].'" tabindex="'.($TIndex++).'">'.basename ($Files[$i], '.png').'</a>
<span>
<a href="{spath}{separator}delete='.urlencode (basename ($Files[$i], '.png')).'" tabindex="'.($TIndex++).'">%delete%</a>
</span>
</p>
';
   if (!$c) $T['page'].= '<p>
%none%.
</p>';
   }
else $T['page'] = '';
?>