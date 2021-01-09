<?

global $module,$sub;

  echo '<div class="menulist">Administracja</div>';
  echo '<div class="menulist2"><ul class="menulist2">';
	echo '<li class="menulist2"><a href="./" class="menulist"><b>'.$lang['menulist_start'].'</b></a></li>';
	echo '<li class="menulist2"><a href="?module=help" class="menulist"><b>'.$lang['menulist_help'].'</b></a></li>';
	echo '<li class="menulist2"><a href="?module=licence" class="menulist"><b>'.$lang['menulist_licence'].'</b></a></li>';
	echo '<li class="menulist2"><a href="../stats/" class="menulist" target="_blank"><b>'.$lang['menulist_stats'].'</b></a></li>';
	echo '<li class="menulist2"><a href="../logout.php" class="menulist"><b>'.$lang['menulist_logout'].'</b></a><br /><br /></li>';
	if(auth()==2) {
	echo '<li class="menulist2"><a href="?module=admins" class="menulist"><b>'.$lang['menulist_admins'].'</b></a></li>';
	echo '<li class="menulist2"><a href="?module=configure" class="menulist"><b>'.$lang['menulist_configure'].'</b></a></li>';
	echo '<li class="menulist2"><a href="?module=tools" class="menulist"><b>'.$lang['menulist_tools'].'</b></a></li>';
	echo '<li class="menulist2"><a href="?module=messages" class="menulist"><b>'.$lang['menulist_messages'].'</b></a></li>';
	}
	echo '<li class="menulist2"><a href="?module=chpass" class="menulist"><b>'.$lang['menulist_chpass'].'</b></a><br /><br /></li>';
	echo '</ul></div>';

$c_module = sizeof($module);
for($i=1;$i<=$c_module;$i++) {
	if($lang['menulist_'.$module[$i]]!='') {
		echo '<div class="menulist"><a href="?module='.$module[$i].'" class="menulist"><b>'.$lang['menulist_'.$module[$i]].'</b></a></div>';
		$c_sub=sizeof($sub[$i]);
		echo '<div class="menulist2">';
		for($k=1;$k<=$c_sub;$k++) {
		  if($k==1) echo '<ul class="menulist2">';
			if($lang['menulist_'.$module[$i].'_'.$sub[$i][$k]]!='') echo '<li class="menulist2"><a href="?module='.$module[$i].'&amp;act='.$sub[$i][$k].'" class="menulist">'.$lang['menulist_'.$module[$i].'_'.$sub[$i][$k]].'</a></li>';
		  if($k==$c_sub) echo '</ul>';
		}
		echo '</div>';
	}
}
	

?>