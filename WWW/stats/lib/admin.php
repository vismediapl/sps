<?php
function e_backups () {
         $BSize = 0;
         $Backups = array_reverse (glob ('data/backups/*.{data,full,user}.sql.bak', GLOB_BRACE));
         for ($i = 0, $c = count ($Backups); $i < $c; $i++) $BSize += filesize ($Backups[$i]);
         return (array ($BSize, $c));
         }
function e_cache_size () {
         $CSize = 0;
         $Files = glob ('data/cache/*.dat');
         for ($i = 0, $c = count ($Files); $i < $c; $i++) $CSize += filesize ($Files[$i]);
         return ($CSize);
         }
function e_config_row ($Desc, $ID, $Value, $Type) {
         $EID = str_replace (array ('[', ']'), array ('_', mt_rand (0, 10000000)), $ID);
         return (e_parse ($GLOBALS['Theme']['config-row'], array (
	'form' => (!is_numeric ($Type)?$Type:((!$Type || $Type == 3)?'<textarea rows="1" cols="25" name="'.$ID.'" id="F_'.$EID.'" tabindex="'.($GLOBALS['TIndex']++).'"'.($Type?' title="%valuetype3%"':'').'>'.htmlspecialchars (($Type == 3)?implode ('|', $Value):$Value).'</textarea>':(($Type == 1)?'<input type="checkbox" name="'.$ID.'" id="F_'.$EID.'" value="1" tabindex="'.($GLOBALS['TIndex']++).'"'.($Value?' checked="checked"':'').' />':'<input name="'.$ID.'" id="F_'.$EID.'" value="'.htmlspecialchars ($Value).'" tabindex="'.($GLOBALS['TIndex']++).'" />'))),
	'desc' => $Desc,
	'fid' => (!is_numeric ($Type)?'':'F_').$EID
	)));
         }
function e_option_row ($Array, $Key, $ID, $Value, $Desc) {
         $Name = $ID;
         $ID = str_replace ('|', '_', $ID);
         $Array[0] = str_replace (array ('%', '{', '}'), array ('&#037;', '&#123;', '&#125;'), htmlspecialchars ($Array[0]));
         if (is_array ($Value)) $Value = implode ('|', $Value);
         $Value = str_replace (array ('%', '{', '}'), array ('&#037;', '&#123;', '&#125;'), htmlspecialchars ($Value));
         return (e_parse ($GLOBALS['Theme']['option-row'], array (
	'id' => $ID,
	'changed' => (($Array[0] == (is_array ($Value)?implode ('|', $Value):$Value))?'':' class="changed" title="%changedvalue%"'),
	'form' => ((!$Array[1] || $Array[1] == 3)?'<textarea rows="1" cols="25" name="'.$Name.'" id="F_'.$ID.'" tabindex="'.($GLOBALS['TIndex']++).'" title="%valuetype'.$Array[1].'%" onkeydown="checkDefault (\''.$ID.'\', \''.str_replace (array ("\r\n", "\n"), array ('\r\n', '\n'), $Array[0]).'\', '.(int) ($Array[1] == 1).')">'.$Value.'</textarea>':(($Array[1] == 1)?'<input type="checkbox" name="'.$Name.'" id="F_'.$ID.'" value="1" tabindex="'.($GLOBALS['TIndex']++).'"'.($Value?' checked="checked"':'').' title="%valuetype1%" onchange="checkDefault (\''.$ID.'\', \''.$Array[0].'\', '.(int) ($Array[1] == 1).')" />':'<input name="'.$Name.'" id="F_'.$ID.'" value="'.$Value.'" tabindex="'.($GLOBALS['TIndex']++).'" title="%valuetype2%" onkeydown="checkDefault (\''.$ID.'\', \''.$Array[0].'\', '.(int) ($Array[1] == 1).')" />')),
	'default' => str_replace (array ("\r\n", "\n"), array ('\r\n', '\n'), $Array[0]),
	'mode' => (int) ($Array[1] == 1),
	'defaultvalue' => $Array[0],
	'tindex' => ($GLOBALS['TIndex']++),
	'option' => $Key,
	'desc' => ($Desc?'<br />
<i>'.$Desc.'</i>':'')
	)));
         }
?>