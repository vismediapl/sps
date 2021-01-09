<?


// MENU
class MenuList {
	var $id, $name, $lang, $SubEx;
	
	function MenuList($menu) {
		global $language,$module,$var_2,$i,$links,$lang_id,$menu_id,$SubEx;
		$sqlLang = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
		list($lang_id)=dbrow($sqlLang);
		
		$module=$_GET['module'];
		
		if($module=='pub' || $module=='club') $module='clubs_pubs';
		elseif($module=='restaurant') $module='restaurants';
		elseif($module=='cafe') $module='cafes';
		elseif($module=='company') $module='companies';
		elseif($module=='entertainment') $module='entertainments';
		elseif($module=='event') $module='events';
		
		$menu_id=$menu;
		
		$vars = explode(',',$_GET['act']);
		$var_1 = $vars[0];
		$var_2 = $vars[1];
		
		if(intval($var_2)=='') $var_2=0;
		
		$sql = sql("SELECT ident,name,type,type_id FROM viscms_menu_links WHERE menu_id='".$menu."' AND parent=0 AND language_id='".$lang_id."' ORDER BY position ASC");
		$links = mysql_num_rows($sql);
		if($links!=0) echo "\n<ul class=\"MenuList1\">";
		while(list($identT,$nameT,$typeT,$type_idT) = dbrow($sql)) {
			$this->id=$identT;
			$this->name=$nameT;
			$this->type=$typeT;
			$this->type_id=$type_idT;
			$this->WriteMenu(1);
			if($this->type==addslashes($module) && $this->type_id==intval($var_2)) $this->SubMenu();
			elseif($SubEx!=1) {
				if($module=='static') {
					$sqlSub = sql("SELECT ident FROM viscms_menu_links WHERE menu_id='".$menu_id."' AND parent='".$this->id."' AND type='static' AND type_id='".intval($var_2)."' AND language_id='".$lang_id."' ORDER BY position ASC");
					if(mysql_num_rows($sqlSub)!=0) $this->SubMenu();
				}
			} elseif($SubEx==1) {
				if($this->type==addslashes($module)) $this->SubMenu();
			}
		}
		//if($module=='static' && $module==$this->type) $this->SubMenu();
		if($links!=0) echo "\n</ul>\n";
	}
	
	function WriteMenu($level) {
		global $cfg,$i,$links,$module,$var_2,$cs,$lang,$SubEx,$language;

		/*if($this->type==addslashes($module) && $this->type_id==intval($var_2) && $SubEx!=1) {
			$bold_s = '<b>';
			$bold_f = '</b>';
		} else $bold_s=$bold_f='';*/
		
		$goto=$this->type;
		if($this->type_id!=0) {
				$goto.='-';
				switch($this->type) {
					case 'articles':
						$goto.='category';
						break;
					case 'static':
						$goto.='show';
						break;
					case 'catalog':
						$goto.='show';
						break;
					case 'gallery':
						$goto.='show';
						break;
				}
				if($goto==$this->type.'-') $goto.='link';
				$goto.='-'.$this->type_id;
		}
		
		echo "\n	";
		if($level==1)
		echo '<li class="MenuList'.$level.'" style="background-image: url(\'themes/'.$cfg['theme'].'/gfx/bgbutton.gif\'); background-repeat: no-repeat; height: 30px; padding-left: 11px; padding-top: 3px;"><a href="'.$goto.'.php" class="MenuList" style="font-family: Verdana; font-size: 10px; font-weight: bold;">'.strtoupperpl($this->name).'</a></li>';
		else
		echo '<li class="MenuList'.$level.'"><a href="'.$goto.'.php" class="MenuList">'.$bold_s.$this->name.$bold_f.'</a></li>';
	}
	
	function SubMenu() {
		global $cfg,$lang_id,$menu_id,$cs;
		
		$cs=0;

		$sql = sql("SELECT ident,name,type,type_id FROM viscms_menu_links WHERE menu_id='".$menu_id."' AND parent='".$this->id."' AND language_id='".$lang_id."' ORDER BY position ASC");
		while(list($identT,$nameT,$typeT,$type_idT) = dbrow($sql)) {
			$this->id=$identT;
			$this->name=$nameT;
			$this->type=$typeT;
			$this->type_id=$type_idT;
			$this->WriteMenu(2);
		}
		
	}

}


// LINKS
class LinksList {
	var $id, $name;
	
	function LinksList($links,$howmany) {
		global $language,$lang_id;
		$sqlLang = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
		list($lang_id)=dbrow($sqlLang);
		
		$sql = sql("SELECT name,url FROM viscms_links_items WHERE links_id='".$links."' AND language_id='".$lang_id."' ORDER BY position ASC LIMIT 0,".$howmany);
		$links_ = mysql_num_rows($sql);
		if($links_!=0) echo "\n<ul class=\"LinksList\">";
		while(list($nameT,$urlT) = dbrow($sql)) {
			$this->name=$nameT;
			$this->url=$urlT;
			$this->WriteMenu();
		}
		if($links_!=0) echo "\n</ul>\n";
	}
	
	function WriteMenu() {
		global $cfg;
		
		echo "\n	";
		echo '<li class="LinksList"><a href="'.$this->url.'" class="LinksList">'.$this->name.'</a></li>';
	}
	
}


// ADVERTISING
class ads {
	
	function ads($id) {
		global $language,$lang_id;
		$sqlLang = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
		list($lang_id)=dbrow($sqlLang);
		
		$sql = sql("SELECT id,type,url,goto,width_a,height_a,showed,clicked FROM viscms_advertising WHERE ident='".$id."' AND language_id='".$lang_id."' AND url!='' AND url!='http://' AND (`limit`=0 OR `limit`>showed) ORDER BY rand()");
		if(list($idT,$typeT,$urlT,$gotoT,$width_aT,$height_aT,$showedT,$clickedT) = dbrow($sql)) {
			$this->id=$idT;
			$this->type=$typeT;
			$this->url=$urlT;
			$this->goto=$gotoT;
			$this->width=$width_aT;
			$this->height=$height_aT;
			$this->showed=$showedT;
			$this->clicked=$clickedT;
			
				if($this->type=='image') $this->adsImage();
				elseif($this->type=='flash') $this->adsFlash();
				
			$this->CountShowed();
		}
	}
	
	function adsImage() {
		global $cfg;
		
		if($this->goto!='' && $this->goto!='http://') {
			$a1='<a href="ads-click-'.$this->id.'.php" target="_blank">';
			$a2='</a>';
		}

		echo '<span style="font-size: 3px;">&nbsp;</span><br />'.$a1.'<img src="'.$this->url.'" width="'.$this->width.'" height="'.$this->height.'" alt="" border="0" />'.$a2.'<br /><span style="font-size: 3px;">&nbsp;</span>';
		
	}
	
	function adsFlash() {
		global $cfg;

		echo '<span style="font-size: 3px;">&nbsp;</span><br /><noscript>
    <object data="'.$this->url.'"
            width="'.$this->width.'" height="'.$this->height.'" type="application/x-shockwave-flash">
     <param name="allowScriptAccess" value="sameDomain" />
     <param name="movie" value="'.$this->url.'" />
     <param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />
    </object>
</noscript>
<script type="text/javascript">
//<!--
AC_RunFlContentX ("src","'.$this->url.'","quality","high","bgcolor","#ffffff","width","'.$this->width.'","height","'.$this->height.'","name","flash","align","middle","allowscriptaccess","sameDomain");
//-->
</script><br /><span style="font-size: 3px;">&nbsp;</span>';
		
	}

	function CountShowed() {
		global $cfg;

		$this->showed++;
		
		$sqlUP = sql("UPDATE viscms_advertising SET showed='".$this->showed."' WHERE id=".$this->id);
		
	}

	
	
	
}


// FREE SPACE
class FreeSpace {
	
	function FreeSpace($id) {
		global $language,$lang_id;
		$sqlLang = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
		list($lang_id)=dbrow($sqlLang);
		
		$sql = sql("SELECT id,content,width FROM viscms_freespace WHERE ident='".$id."' AND language_id='".$lang_id."' AND content!=''");
		if(list($idT,$contentT,$widthT) = dbrow($sql)) {
			$this->id=$idT;
			$this->content=$contentT;
			$this->width=$widthT;
			
			$this->WriteText();
		}
	}
	
	function WriteText() {
		global $cfg;

		echo '<div align="left"><table align="center" style="width: '.$this->width.'px;"><tr valign="top"><td>'.$this->content.'</td></tr></table></div>';
		
	}	

}


// YOUTUBE
class YouTube {
	
	function YouTube($id) {
		global $language,$lang_id;
		$sqlLang = sql("SELECT id FROM viscms_languages WHERE code='".$language."'");
		list($lang_id)=dbrow($sqlLang);
		
		$sql = sql("SELECT id,url,width,width_a,height_a,showed,content FROM viscms_youtube WHERE ident='".$id."' AND language_id='".$lang_id."' AND url!='' AND url!='http://' AND (`limit`=0 OR `limit`>showed) ORDER BY rand()");
		if(list($idT,$urlT,$widthT,$width_aT,$height_aT,$showedT,$contentT) = dbrow($sql)) {
			$this->id=$idT;
			$this->url=$urlT;
			$this->widthB=$widthT;
			$this->width=$width_aT;
			$this->height=$height_aT;
			$this->showed=$showedT;
			$this->content=$contentT;
			
			$this->ShowMovie();
				
			$this->CountShowed();
		}
	}
	
	function ShowMovie() {
		global $cfg;
		
$in=array('http://www.youtube.com/v/','http://pl.youtube.com/v/','http://youtube.com/v/','http://www.youtube.com/watch?v=','http://pl.youtube.com/watch?v=','http://youtube.com/watch?v=');
$this->url=str_replace($in,'',$this->url);

		echo '<table style="width: '.$this->widthB.'px;"><tr valign="top"><td style="width: '.($this->width+15).'px; text-align: left;"><noscript>
    <object data="http://www.youtube.com/v/'.$this->url.'&amp;rel=1&amp;color1=0xd6d6d6&amp;color2=0xf0f0f0&amp;border=0"
            width="'.$this->width.'" height="'.$this->height.'" type="application/x-shockwave-flash">
     <param name="allowScriptAccess" value="sameDomain" />
     <param name="movie" value="http://www.youtube.com/v/'.$this->url.'&amp;rel=1&amp;color1=0xd6d6d6&amp;color2=0xf0f0f0&amp;border=0" />
     <param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />
    </object>
</noscript>
<script type="text/javascript">
//<!--
AC_RunFlContentX ("src","http://www.youtube.com/v/'.$this->url.'&amp;rel=1&amp;color1=0xd6d6d6&amp;color2=0xf0f0f0&amp;border=0","quality","high","bgcolor","#ffffff","width","'.$this->width.'","height","'.$this->height.'","name","flash","align","middle","allowscriptaccess","sameDomain");
//-->
</script></td><td>'.$this->content.'</td></tr></table>';
		
	}
	
	function CountShowed() {
		global $cfg;

		$this->showed++;
		
		$sqlUP = sql("UPDATE viscms_youtube SET showed='".$this->showed."' WHERE id=".$this->id);
		
	}

	
	
	
}


?>