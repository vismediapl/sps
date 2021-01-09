<?php
if (isset ($Vars[3])) {
   if (is_file ('plugins/'.$Vars[3].'/plugin.php')) {
      include ('plugins/'.$Vars[3].'/config.php');
      if (!$Plugins[$Vars[3]]) {
         $Info[] = array ($L['announce_disabledplugin'], 0);
         unset ($Vars[3]);
         }
      }
   else unset ($Vars[3]);
   }
if (!isset ($Vars[3])) {
   $T['page'] = e_announce ($L['pluginsactivate'], 3);
   $Plugins = glob ('plugins/*', GLOB_ONLYDIR);
   for ($i = 0, $c = count ($Plugins); $i < $c; $i++) {
       include ($Plugins[$i].'/config.php');
       $PName = basename ($Plugins[$i]);
       $T['page'].= '<p>
<strong><em>'.($i + 1).'</em></strong>. <a href="'.$T['path'].'admin/plugins/'.$PName.$Path['suffix'].'" tabindex="'.($TIndex++).'"><strong>'.ucfirst (str_replace ('_', ' ', $PName)).'</strong></a> <a href="'.$PluginInfo[$PName]['url'].'" tabindex="'.($TIndex++).'" title="%author%: '.$PluginInfo[$PName]['author'].'">v'.$PluginInfo[$PName]['version'].' - '.$PluginInfo[$PName]['status'].'</a> ('.e_date ('d.m.Y H:i:s', $PluginInfo[$PName]['time']).') <strong class="'.($Plugins[$PName]?'green':'red').'">[%'.($Plugins[$PName]?'enabled':'disabled').'%]</strong><br />
&nbsp;&nbsp;&nbsp;&nbsp;'.$Description[$PName][isset ($Description[$PName][$Vars[0]])?$Vars[0]:'en'].'
</p>
';
       }
   if (!$c) $T['page'].= '<p>
%none%.
</p>';
   }
else {
     include ('plugins/'.$Vars[3].'/langs/'.(is_file ('plugins/'.$Vars[3].'/langs/'.$Vars[0].'.php')?$Vars[0]:'en').'.php');
     $T['title'].= ': '.$Titles['plugins_'.$Vars[3]][0];
     include ('plugins/'.$Vars[3].'/plugin.php');
     }
?>