<?php
$VProfile = '';
$Array = array ('unique', 'views', 'all');
$Num = (($Vars[1] == 'archive')?4:2);
if (!isset ($Vars[$Num]) || !in_array ($Vars[$Num], $Array)) $Vars[$Num] = $Charts['defaultview'];
for ($i = 0; $i < 3; $i++) $VProfile.= (($Array[$i] == $Vars[$Num])?'<strong>[%'.$Array[$i].'%]</strong>
':'<a href="'.$T['path'].$Vars[1].'/'.(($Vars[1] == 'archive')?$Vars[2].'/'.$Vars[3].'/':'').$Array[$i].'" tabindex="{tindex}">[%'.$Array[$i].'%]</a>
');
$Vars[$Num] = array_search ($Vars[$Num], $Array);
$VProfile = '<p class="vprofile">
%chartsview%:
'.$VProfile.'</p>
'.(($Charts['showlevels'] || $TConfig['simpleCharts'])?'':'<script type="text/javascript">
// <![CDATA[
a = document.getElementById(\'chart_{mode}\').getElementsByTagName(\'hr\');
for (i = 0; i < a.length; i++) a[i].style.display = \'none\';
// ]]>
</script>
');
e_theme ('chart');
function e_title_row ($Text, $Num, $Sum) {
         return ($Text.': '.e_number ($Num).' ('.($Sum?round (($Num / $Sum) * 100, 1):0).'%)<br />
');
         }
function e_bar ($Height, $Margin, $Mode, $Max, $Title) {
         return (e_parse ($GLOBALS['Theme']['chart-bar'], array (
	'height' => $Height,
	'margin' => $Margin,
	'class' => ($Mode?'uni':'all').($Max?' max':''),
	'title' => $Title,
	'simplebar' => ($GLOBALS['TConfig']['simpleCharts']?str_repeat ('&nbsp;<br />
', (int) (($Height / 150) * 10)):'')
	)));
         }
function e_level ($Reference, $Array, $Mode, $Num) {
         if ($GLOBALS['TConfig']['simpleCharts']) return ('');
         $Levels = '';
         $Keys = array ('max', 'average', 'min');
         for ($i = 0; $i < 3; $i++) $Levels.= '<hr style="margin-top:-'.(int) ((($Array[$i] / $Reference) * 150) + 2).'px;"'.($Mode?'':' class="uni"').' title="%'.($Mode?'visits':'unique').'% - %levels'.$Keys[$i].'%: '.round ($Array[$i], 2).'" id="level_'.$Num.'_'.$Mode.'_'.$i.'" />
';
         return ($Levels);
         }
function e_chart ($Array, $Mode, $Num) {
         $Chart = $Levels = $Scale = '';
         $MaxArray = array (max ($Array[0]), max ($Array[1]));
         $Max = $MaxArray[$Mode?1:0];
         $Sum = array (array_sum ($Array[0]), array_sum ($Array[1]));
         $Amount = count ($Array[0]);
         if ($Max) {
            $MinArray = array (min ($Array[0]), min ($Array[1]));
            $Levels = (($Mode != 1)?e_level ($Max, array ($MaxArray[0], (($Sum[0]) / $Amount), $MinArray[0]), 0, $Num):'').($Mode?e_level ($Max, array ($MaxArray[1], (($Sum[1]) / $Amount), $MinArray[1]), 1, $Num):'');
            for ($i = 10; $i > 0; $i--) $Scale.= e_number ($Max * $i / 10).'
';
            $Scale.= '<em>0</em>';
            }
         else $Scale = str_repeat ('
', 12);
         for ($i = 0; $i < $Amount; $i++) {
             $H = ($Max?array ((int) (($Array[0][$i] / $Max) * 150), (int) (($Array[1][$i] / $Max) * 150)):array (0, 0));
             $Chart.= e_parse ($GLOBALS['Theme']['chart-bars-container'], array (
	'class' => (($Mode == 2)?' class="combined"':''),
	'id' => 'bar_'.$Num.'_'.$i,
	'bars' => ($H[1]?(($H[0] && $Mode != 1)?e_bar ($H[0], ($Mode?($H[1] - $H[0]):0), 1, ($Array[0][$i] == $MaxArray[0]), '%unique%: '.$Array[0][$i]):'').($Mode?e_bar ($H[1], 0, 0, ($Array[1][$i] == $MaxArray[1]), '%views%: '.$Array[1][$i]):''):''),
	'desc' => (($GLOBALS['Charts']['showtooltips'] && !$GLOBALS['TConfig']['simpleCharts'] && (($Array[0][$i] && $Mode != 1) || ($Array[1][$i] && $Mode)))?'<span>
<em>%visits%:</em><br />
'.(($Mode != 1)?e_title_row ('%unique%', $Array[0][$i], $Sum[0]):'').($Mode?e_title_row ('%views%', $Array[1][$i], $Sum[1]):'').'</span>':'&nbsp;')

	));
             }
         return ($Chart.'<td class="scale">
<pre>'.$Scale.'</pre>
</td>
'.($GLOBALS['TConfig']['simpleCharts']?'':'</tr>
<tr>
<td colspan="'.$Amount.'" class="levels">
'.$Levels.'</td>
'));
         }
function e_summary ($Array, $Mode, $Num) {
         global $L, $Theme;
         $Rows = '';
         for ($i = 0; $i < 2; $i++) {
             $EArray = array (
	'maxjs' => implode (', ', array_keys ($Array[$i], ($Max = max ($Array[$i])))),
	'avgjs' => '',
	'minjs' => implode (', ', array_keys ($Array[$i], ($Min = min ($Array[$i])))),
	'sumjs' => '\'_\'',
	);
             $TArray = array (
	'text' => ($i?'%views%':'%unique%'),
	'sum' => e_number (array_sum ($Array[$i])),
	'max' => e_number ($Max),
	'avg' => e_number (array_sum ($Array[$i]) / count ($Array[$i])),
	'min' => e_number ($Min),
	);
             $z = 0;
             foreach ($EArray as $Key => $Value) {
                     $TArray[$Key] = '';
                     if ($Max && ($Mode != !$i || $Mode == 2)) for ($j = 0; $j < 2; $j++) $TArray[$Key].= ' onmouseo'.($j?'ut':'ver').'="highlightColumns (['.$Value.'], '.$Num.', '.$i.', '.$z.', '.(int) !$j.')"'.($j?' id="switch_'.$Num.'_'.$i.'_'.($z++).'"':'');
                     }
             $Rows.= e_parse ($Theme['chart-summary-row'], $TArray);
             }
         return (str_replace ('{rows}', $Rows, $Theme['chart-summary']));
         }
?>