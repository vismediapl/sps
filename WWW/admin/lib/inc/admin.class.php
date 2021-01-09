<?

// poziomy
class Levels {
	
	var $class;
	var $classHeader;
	var $color;
	var $levels;
	
	function Levels($class='levelClass',$color='#a7a7a7',$classHeader='levelClassHeader') {
		
		$this->class=$class;
		$this->classHeader=$classHeader;
		$this->color=$color;
		$this->levels=array();
		
	}
	
	function SetClass($class='levelClass') {
		
		$this->class=$class;
		
	}
	
	function SetClassHeader($class='levelClassHeader') {
		
		$this->classHeader=$class;
		
	}
	
	function SetColor($color='#a7a7a7') {
		
		$this->color=$color;
		
	}
	
	function AddLevel($name='',$link='') {
	
	  $array_tmp = array($name,$link);
    array_push($this->levels,$array_tmp);
  
  }
	
	function Show() {
	
	  if($this->class!='') $class=' class="'.$this->class.'"';
	  if($this->color!='') $color=' style="color: '.$this->color.'"';
    echo '<div'.$class.'>';
    echo '<span'.$color.'>visCMS: </span>';
    $count = count($this->levels);
    for($i=0;$i<$count;$i++) {
      if($this->levels[$i][0]!='') {
        if($this->levels[$i][1]!='' && $i!=($count-1)) {
          $a1='<a href="'.$this->levels[$i][1].'"'.$class.'>';
          $a2='</a>';
        } else $a1=$a2='';
        if($i==($count-1)) {
          $b1='<b>';
          $b2='</b>';
        } else $b1=$b2='';
        if($n!=0) echo ' &raquo; ';
        echo $a1.$b1.$this->levels[$i][0].$b2.$a2;
        $n++;
      }
    }
    echo '</div>';
  
  }
	
	function ShowHead($text='') {
	
	  if($text=='') {
	     $arr = end($this->levels);
	     $text = $arr[0];
	  }
	  
	  if($this->classHeader!='') $classHeader=' class="'.$this->classHeader.'"';
	  
	  $msg = $_COOKIE['msg'];
    setcookie('msg',$msg,time()-60);
    $msg = str_replace("\\","",$msg);
	  
    echo '<div'.$classHeader.'><table width="100%" cellspacing="2" cellpadding="0"'.$classHeader.'><tr><td width="30%"'.$classHeader.'>'.strtoupperpl($text).'</td><td width="40%" align="center" class="messageH">'.$msg.'</td><td width="30%" align="right" class="iconsH">'.$this->icons.'</td></table></div>';
  
  }
  
  function AddIcon($type='',$link='',$alt='') {
    global $cfg;
    
    if($type!='' && $link!='') {
      $this->icons .= '<a href="'.$link.'" title="'.$alt.'"><img src="themes/'.$cfg['theme'].'/gfx/icons/'.$type.'.gif" border="0" alt="'.$alt.'" /></a>';
    }
  }
	
}


########################################################################################################################

// linki

class HeaderLinks {
	
	var $class;
	var $links;
	
	function HeaderLinks($class='headerLinks') {
		
		$this->class=$class;
		$this->links=array();
		
	}
	
	function SetClass($class='headerLinks') {
		
		$this->class=$class;
		
	}
	
	function AddLink($name='',$link='') {
	
	  $array_tmp = array($name,$link);
    array_push($this->links,$array_tmp);
  
  }
	
	function Show() {
	
	  if($this->class!='') $class=' class="'.$this->class.'"';
	  
    echo '<div'.$class.'>';
    $count = count($this->links);
    for($i=0;$i<$count;$i++) {
      if($this->links[$i][0]!='') {
        if($this->links[$i][1]!='') {
          $a1='<a href="'.$this->links[$i][1].'"'.$class.'>';
          $a2='</a>';
        } else $a1=$a2='';
        if($n!=0) echo ' | ';
        echo $a1.$this->links[$i][0].$a2;
        $n++;
      }
    }
    echo '</div>';
  
  }
	
}


########################################################################################################################

// tabela

class Table {
	
	var $class;
	var $text;
	var $headers;
	var $aligns;
	var $valigns;
	var $width;
	
	function Table($class='TableClass',$classHeader='TableClassHd',$cellspacing=0,$cellpadding=0,$border=0) {
		
		$this->class=$class;
		$this->classHeader=$classHeader;
		$this->headers=array();
		$this->text=array();
		$this->aligns=array();
		$this->valigns=array();
		$this->width=array();
		$this->cellspacing=intval($cellspacing);
		$this->cellpadding=intval($cellpadding);
		$this->border=intval($border);
		
	}
	
	function SetClass($class='headerLinks') {
		$this->class=$class;
	}
	
	function NewCell($header='',$width=100,$HeaderAlign='left',$ValueAlign='left',$HeaderValign='top',$ValueValign='top') {
    array_push($this->headers,$header);
    
    if($HeaderAlign!='left' && $HeaderAlign!='center' && $HeaderAlign!='right') $HeaderAlign='left';
    if($ValueAlign!='left' && $ValueAlign!='center' && $ValueAlign!='right') $ValueAlign='left';
    if($HeaderValign!='top' && $HeaderValign!='middle' && $HeaderValign!='bottom') $HeaderValign='top';
    if($ValueValign!='top' && $ValueValign!='middle' && $ValueValign!='bottom') $ValueValign='top';
    
    $aligns = array($HeaderAlign,$ValueAlign);
    array_push($this->aligns,$aligns);
    
    $valigns = array($HeaderValign,$ValueValign);
    array_push($this->valigns,$valigns);
    
    if($width<1) $width=100;
    array_push($this->width,$width);
  }
	
	function CellValue($value=array()) {
    array_push($this->text,$value);
  }
	
	function ShowCheck($active,$link) {
	 global $cfg;
	  if($active==1) $q='yes';
	  else $q='no';
    return '<a href="'.$link.'"><img src="themes/'.$cfg['theme'].'/gfx/show_'.$q.'.gif" alt="" border="0" /></a>';
  }
	
	
	function Show() {
	 global $cfg;
	
	  if($this->class!='') $class=' class="'.$this->class.'"';
	  if($this->classHeader!='') $classHeader=' class="'.$this->classHeader.'"';
	  
    $count2 = count($this->text);
	  
	  echo $this->quote_before;
	  
	  if($count2>0) {
    echo '<table cellspacing="'.$this->cellspacing.'" cellpadding="'.$this->cellpadding.'" border="'.$this->border.'"'.$class.'>';
    // naglowki
    echo '<tr'.$classHeader.'>';
      $count = count($this->headers);
      for($i=0;$i<$count;$i++) {
        echo '<td style="width: '.$this->width[$i].'px;" align="'.$this->aligns[$i][0].'" valign="'.$this->valigns[$i][0].'">'.$this->headers[$i].'</td>';
      }
    echo '</tr>';
    echo '<tr><td colspan="'.$count.'" style="height: 2px; background-image: url(\'themes/'.$cfg['theme'].'/gfx/separator.gif\'); background-repeat: repeat-x;"></td></tr>';
    // wartosci
    for($i=0;$i<$count2;$i++) {
      echo '<tr>';
      for($j=0;$j<$count;$j++) {
        echo '<td align="'.$this->aligns[$j][1].'" valign="'.$this->valigns[$j][1].'"'.$class.'><div style="width: '.$this->width[$j].'px; overflow: hidden;">'.$this->text[$i][$j].'</div></td>';
      }
      echo '</tr>';
    }
    echo '<tr><td colspan="'.$count.'" style="height: 2px; background-image: url(\'themes/'.$cfg['theme'].'/gfx/separator.gif\'); background-repeat: repeat-x;"></td></tr>';
    echo '</table>';
    }
	  echo $this->quote_afrer;
  
  }
	
	function Ret() {
	 global $cfg;
	
	  if($this->class!='') $class=' class="'.$this->class.'"';
	  if($this->classHeader!='') $classHeader=' class="'.$this->classHeader.'"';
	  
	  $return = $this->quote_before;
    $return .= '<table cellspacing="'.$this->cellspacing.'" cellpadding="'.$this->cellpadding.'" border="'.$this->border.'"'.$class.'>';
    // naglowki
    $return .= '<tr'.$classHeader.'>';
      $count = count($this->headers);
      for($i=0;$i<$count;$i++) {
        $return .= '<td style="width: '.$this->width[$i].'px;" align="'.$this->aligns[$i][0].'" valign="'.$this->valigns[$i][0].'">'.$this->headers[$i].'</td>';
      }
    $return .= '</tr>';
    $return .= '<tr><td colspan="'.$count.'" style="height: 2px; background-image: url(\'themes/'.$cfg['theme'].'/gfx/separator.gif\'); background-repeat: repeat-x;"></td></tr>';
    // wartosci
    $count2 = count($this->text);
    for($i=0;$i<$count2;$i++) {
      $return .= '<tr>';
      for($j=0;$j<$count;$j++) {
        $return .= '<td align="'.$this->aligns[$j][1].'" valign="'.$this->valigns[$j][1].'"'.$class.'><div style="width: '.$this->width[$j].'px; overflow: hidden;">'.$this->text[$i][$j].'</div></td>';
      }
      $return .= '</tr>';
    }
    $return .= '<tr><td colspan="'.$count.'" style="height: 2px; background-image: url(\'themes/'.$cfg['theme'].'/gfx/separator.gif\'); background-repeat: repeat-x;"></td></tr>';
    $return .= '</table>';
	  $return .= $this->quote_afrer;
    
    return $return;
  
  }
  
  // dodanie nowego dowolnego pola (np. tekst)
  function QuoteBeforeTable($text='') {
   global $cfg,$language;
    $text = '<div style="padding-left: 7px;"><div style="padding: 100px 0px 10px 10px; width: 710px; overflow: hidden; background-image: url(\'themes/'.$cfg['theme'].'/gfx/language/'.$language.'/quote_bg.gif\'); background-repeat: no-repeat;">'.$text.'</div></div>';
    $this->quote_before=$text;
  }
  
  // dodanie nowego dowolnego pola (np. tekst)
  function QuoteAfterTable($text='') {
   global $cfg,$language;
    $text = '<div style="padding-left: 7px;"><div style="padding: 100px 0px 10px 10px; width: 710px; overflow: hidden; background-image: url(\'themes/'.$cfg['theme'].'/gfx/language/'.$language.'/quote_bg.gif\'); background-repeat: no-repeat;">'.$text.'</div></div>';
    $this->quote_afrer=$text;
  }
	
}


########################################################################################################################

// select

class Select {
	
	var $class;
	var $text;
	var $id;
	
	function Select($id=0) {
		
		$this->id=$id;
		$this->text=array();
		
	}
	
	function Add($name='',$link='',$additional='') {
		
		$array=array($name,$link,$additional);
		array_push($this->text,$array);
		
	}
	
	function Ret() {
		
		$return = '<script type="text/javascript">
    var menu'.$this->id.'=new Array()
';
		
	  if($this->class!='') $class=' class="'.$this->class.'"';
	  
    $count = count($this->text);
		for($i=0;$i<$count;$i++) {
		  $return .= 'menu'.$this->id.'['.$i.']=\'<a href="'.$this->text[$i][1].'"'.$this->text[$i][2].'>'.$this->text[$i][0].'</a>\'';
		  $return .= "\n";
		}
		$return .= '</script>

    <table cellspacing="0" cellpadding="0" border="0">
      <tr>
        <td class="select_bg" onclick="return clickreturnvalue()" onmouseover="dropdownmenu(this, event, menu'.$this->id.', \'150px\')" onmouseout="delayhidemenu()">Wybierz akcjê</td>
      </tr>
    </table>

';
		
		return $return;
	}
	
}


########################################################################################################################

// strzalki

class Arrows {

  var $up;
  var $down;
		
	function Up($position,$max=0,$link='') {
		global $cfg;
		
		if($position!=$max) $this->up = '<a href="'.$link.'"><img src="themes/'.$cfg['theme'].'/gfx/icons/up-active.gif" alt="" border="0" /></a>';
    else $this->up = '<img src="themes/'.$cfg['theme'].'/gfx/icons/up-unactive.gif" alt="" border="0" />';
		
	}
		
	function Down($position,$min=0,$link='') {
		global $cfg;
		
		if($position!=$min) $this->down = '<a href="'.$link.'"><img src="themes/'.$cfg['theme'].'/gfx/icons/down-active.gif" alt="" border="0" /></a>';
    else $this->down = '<img src="themes/'.$cfg['theme'].'/gfx/icons/down-unactive.gif" alt="" border="0" />';
		
	}
	
	function Ret() {
		
		return $this->up.$this->down;
	}
	
}


########################################################################################################################

// numery stron

class Pages {

  var $pages;
  var $limit;
  var $pageshow;
  var $currentpage;
  var $separator;
  var $link;
  
  function Pages($currentpage=1, $link='',$limit='10',$separator=',') {
    $this->limit=intval($limit);
    $this->Sql();
    $this->PageShow();
    $this->currentpage=intval($currentpage);
    $this->link=$link;
    $this->separator=$separator;
  }
  
  function Limit($limit=10) {
    $this->limit=intval($limit);
  }
  
  function PageShow($pageshow=5) {
    $this->pageshow=$pageshow;
  }
		
	function Sql($query='') {
	  if($query!='') {
		  $sqlJ = sql($query);
      $this->pages = ceil(mysql_num_rows($sqlJ)/$this->limit);
    }
	}
		
	function CurrentPage($q=1) {
	  $this->currentpage=intval($q);
	}
		
	function SetLink($link='') {
    $this->link=$link;
	}
		
	function SetSep($separator=',') {
    $this->separator=$separator;
	}
		
	function AddExt($ext=',') {
    $this->ext=$ext;
	}
	
	function Show() {
	 global $cfg;
	 
if($this->pages>1) {
	 
	 $q=$this->currentpage;
	 $link=$this->link;
	 $sep=$this->separator;
	 $pages=$this->pages;
		
    if($q==1) $num_of_pages = '<img src="themes/'.$cfg['theme'].'/gfx/sleft.gif" border="0" alt="" alt="" /> ';
    else $num_of_pages = '<a href="'.$link.$sep.($q-1).$this->ext.'"><img src="themes/'.$cfg['theme'].'/gfx/sleft.gif" border="0" alt="" /></a> ';

if($this->pages > $this->pageshow) {

	if($q>3 && ($q-2)<$pages) $num_of_pages.= ' ... ';
	
	if($q==$pages) $num_of_pages.= '<a href="'.$link.$sep.($q-4).'">'.($q-4).$this->ext.'</a> <a href="'.$link.$sep.($q-3).$this->ext.'">'.($q-3).'</a>  ';
	if($q==$pages-1) $num_of_pages.= '<a href="'.$link.$sep.($q-3).'">'.($q-3).$this->ext.'</a>  ';
	
	for($i=$q-2;$i<=$q+2;$i++) {
	  if($i>0 && $i<=$pages) {
		if($i==$q) $strcl = $i.' '; 
		else $strcl = '<a href="'.$link.$sep.$i.$this->ext.'">'.$i.'</a>  ';
		$num_of_pages.=$strcl;		
	  }
	}
		if(($q-2)==-1) $num_of_pages.= '<a href="'.$link.$sep.$i.$this->ext.'">'.$i.'</a> <a href="'.$link.$sep.($i+1).$this->ext.'">'.($i+1).'</a>  ';
		if(($q-2)==0) $num_of_pages.= '<a href="'.$link.$sep.$i.$this->ext.'">'.$i.'</a> ';
	if(($q+2)<$pages) $num_of_pages.= ' ... ';
}
else {
	for($i=1;$i<=$pages;$i++) {
		if($i==$q) $strcl = $i.' '; 
		else $strcl = '<a href="'.$link.$sep.$i.$this->ext.'">'.$i.'</a>  ';
		$num_of_pages.=$strcl;
	}
}

if($q==$pages) $num_of_pages.= '<img src="themes/'.$cfg['theme'].'/gfx/sright.gif" border="0" alt="" /> ';
else $num_of_pages.= '<a href="'.$link.$sep.($q+1).$this->ext.'"><img src="themes/'.$cfg['theme'].'/gfx/sright.gif" border="0" alt="" /></a> ';

$num_of_pages = '<div align="center">'.$num_of_pages.'</div>';

echo $num_of_pages;
}
		
	}
	
}

?>