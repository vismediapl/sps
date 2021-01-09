<?php

class Form {

  var $action;
  var $method;
  var $enctype;
  var $name;
  var $fields;
  var $width;
  var $height;
  var $submit;
  var $hiddens;
  var $dotted;
  var $fck;
  var $bold;
  var $header;
  var $before;
  var $any_text;
  var $languages;
  var $ml;

  // konstruktor
  function Form($action="",$method="get",$enctype="multipart/form-data",$name='',$function='') {
    $this->action=$action;
    $this->languages();
    $this->function=$function;
    
    $this->height=20;
    
    if($method=='post' || $method=='POST') $this->method='post';
    else $this->method='get';
    
    if($name=='') $this->name='form';
    else $this->name=$name;
    
    $this->enctype=$enctype;
    
    $this->fields=array();
    $this->width=array();
    $this->hiddens=array();
    $this->submit=array("",""," align=\"center\"");
    
  }
  
  // ustawienie akcji formularza
  function SetAction($action='') {
    $this->action=$action;
  }
  
  // ustawienie metody
  function SetMethod($method='') {
    $this->method=$method;
  }
  
  // ustawianie Enctype
  function SetEnctype($enctype='') {
    $this->enctype=$enctype;
  }
  
  // ustawienie nazwy formularza
  function SetName($name='') {
    $this->name=$name;
  }
  
  // ustawienia dodatkowych funkcji formularza
  function SetFunction($function='') {
    $this->function=$function;
  }
  
  // ustawienia bolda
  function SetBold($bold=0) {
    if($bold==1) $bold='bold';
    else $bold='normal';
    $this->bold=$bold;
  }
  
  // ustawienie nag³ówka
  function SetHeader($left='',$right='',$align='left',$bold=1) {
    
    if($left!='' || $right!='') {
      if($bold==1) $bold='bold';
      else $bold='normal';
      if($align!='center' && $align!='right') $align='left';
      $align=' align="'.$align.'"';
    
      if($this->width[0]!='') {
        $width_l=' width: '.$this->width[0].';';
        $width_r=' width: '.$this->width[1].';';
      }
    
      $header = '    <tr valign="top">';
      $header .= "\n";
      $header .= '      <td style="font-weight: '.$bold.';'.$width_l.'" class="bt-0"'.$align.'>'.$left.'</td>';
      $header .= "\n";
      $header .= '      <td style="font-weight: '.$bold.'; padding-left: 1px;'.$width_r.'" class="bt-0">'.$right.'</td>';
      $header .= "\n";
      $header .= '    </tr>';
      $header .= "\n";
      $this->header=$header;
    }
  }
  
  // wyswietlenie formularza
  function Show() {
    global $cfg,$language;
  
    if($this->function!='') $this->function=' '.$this->function;
    
      if($this->bold==1) $bold='bold';
      else $bold='normal';
  
    if($this->width[0]!='') {
      $width_l=' width: '.$this->width[0].';';
      $width_r=' width: '.$this->width[1].';';
    }
    
    $hiddens='';
    for($i=0;$i<count($this->hiddens);$i++) {
      $hiddens .= '<input type="hidden" name="'.$this->hiddens[$i][0].'" value="'.$this->hiddens[$i][1].'" />';
    }
  
    echo '<form name="'.$this->name.'" action="'.$this->action.'" method="'.$this->method.'" enctype="'.$this->enctype.'"'.$this->function.'>';
    echo "\n";
    if($this->fck!='') {
      echo $this->fck;
      echo "\n";
    }
    
    if($this->before!='') {
      echo '<div width="100%">'.$this->before.'</div>';
      echo "\n";
    }
    
    $count = count($this->fields);
    if($count>0) {
    echo '  <table width="100%" cellspacing="7" cellpadding="5" style="border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC;">';
    echo "\n";
    echo $this->header;
    
    for($i=0;$i<count($this->fields);$i++) {
    
      if($i%2==0) $this->bt=1;
      else $this->bt=2;
      
      echo '    <tr valign="top" style="height: '.$this->height.'px;">';
      echo "\n";
      echo '      <td style="font-weight: '.$this->bold.';'.$width_l.'" class="bt-'.$this->bt.'">'.$this->fields[$i][0].'</td>';
      echo "\n";
      echo '      <td style="padding-left: 5px;'.$width_r.'" class="bt-'.$this->bt.'">'.$this->fields[$i][1].'</td>';
      echo "\n";
      echo '    </tr>';
      echo "\n";
    }
    
    if($this->any_text!='') {
      echo '    <tr valign="top">';
      echo "\n";
      echo '      <td colspan="2">'.$this->any_text.'</td>';
      echo "\n";
      echo '    </tr>';
      echo "\n";
    }
    echo '  </table>';
    echo "\n";
    }
    if($this->submit[0]!='') {
      if($this->submit[1]!='img')
        echo '<div'.$this->submit[2].'><input type="submit" value="'.$this->submit[0].'"'.$this->submit[1].' /></div>';
      else
        echo '<div'.$this->submit[2].'><input type="image" src="themes/'.$cfg['theme'].'/gfx/language/'.$language.'/input_'.$this->submit[0].'.gif" style="border: 0px;" /></div>';
      echo "\n";
    }
    echo $hiddens.$this->after.'</form>';
  
  }
  
  // dodanie nowego dowolnego pola (np. tekst)
  function AddAnyFieldBeforeTable($text='') {
    
    $this->before=$text;
  }
  
  // dodanie nowego dowolnego pola (np. tekst)
  function QuoteBeforeTable($text='') {
   global $cfg,$language;
    $text = '<div style="padding-left: 7px;"><div style="padding: 100px 0px 10px 10px; width: 710px; overflow: hidden; background-image: url(\'themes/'.$cfg['theme'].'/gfx/language/'.$language.'/quote_bg.gif\'); background-repeat: no-repeat;">'.$text.'</div></div>';
    $this->before=$text;
  }
  
  // dodanie nowego dowolnego pola (np. tekst)
  function QuoteAfterTable($text='') {
   global $cfg,$language;
    $text = '<div style="padding-left: 7px;"><div style="padding: 100px 0px 10px 10px; width: 710px; overflow: hidden; background-image: url(\'themes/'.$cfg['theme'].'/gfx/language/'.$language.'/quote_bg.gif\'); background-repeat: no-repeat;">'.$text.'</div></div>';
    $this->after=$text;
  }
  
  // dodanie nowego dowolnego pola (np. tekst)
  function AddAnyFieldAfterTable($text='') {
    
    $this->any_text=$text;
  }
  
  // dodanie nowego dowolnego pola (np. tekst)
  function AddAnyField($title='',$text='') {
    
    $field=array();
    $field[0] = $title;
    $field[1] = $text;
    
    array_push($this->fields,$field);
  }
  
  // dodanie nowego dowolnego pola (np. tekst)
  function AddColorField($title='',$name='',$value='') {
    
    if($value!='') $value_style = 'style="background: '.$value.';"';
    else $value_style = 'style="background: #ffffff;"';
    
    $field=array();
    $field[0] = $title;
    $field[1] = '<input type="button" onclick="pickerPopup302(\''.$name.'\',\'sample_'.$name.'\');" value="wybierz" />&nbsp;<input type="text" id="'.$name.'" name="'.$name.'" size="9" value="'.$value.'" />&nbsp;<input type="text" id="sample_'.$name.'" size="1" value="" '.$value_style.'disabled="disabled" />';
    
    array_push($this->fields,$field);
  }
  
  // dodanie nowego pola has³a INPUT
  function AddPasswordInput($title='',$name='',$value='',$options='',$additional='') {
  
    if($options!='') $options=' '.$options;
    else $options=' style="width: 100%;"';
    if($additional!='') $additional='<br />'.$additional;
    
    $field=array();
    $field[0] = $title;
    $field[1] = '<input type="password" name="'.$name.'" value="'.$value.'"'.$options.' />'.$additional;
    
    array_push($this->fields,$field); 
    
  }
  
  // dodanie nowego pola tekstowego INPUT
  function AddTextInput($title='',$name='',$value='',$options='',$additional='') {
    global $cfg;
  
    if($options!='') $options=' '.$options;
    elseif($additional=='') $options=' style="width: 100%;"';
    if($additional!='') $additional=' '.$additional;
    
    $field=array();
    $field[0] = $title;
    
    // jesli wystepuje wiecej niz 1 jezyk
    if($this->ml>0) {
      $count = count($this->languages);
      
      if($count>1) {
        $field[1] = '<table width="100%" cellspacing="3" cellpadding="3">';
        for($i=0;$i<$count;$i++) {
          $field[1] .= '<tr valign="top"><td style="width: 18px;"><img src="themes/'.$cfg['theme'].'/gfx/flags/'.$this->languages[$i].'.gif" alt="" /></td><td><input type="text" name="'.$name.'_lang-'.$this->languages[$i].'" value="'.$value[$this->languages[$i]].'"'.$options.' /></td></tr>';
        }
        $field[1] .= '</table>';
        if($additional!='') $field[1] .= '<br />'.$additional;
      } else {
        $field[1] .= '<input type="text" name="'.$name.'_lang-'.$this->languages[0].'" value="'.$value[$this->languages[0]].'"'.$options.' />'; // jesli jest tylko 1 jezyk
        if($additional!='') $field[1] .= '<br />'.$additional;
      }
      
    } else $field[1] = '<input type="text" name="'.$name.'" value="'.$value.'"'.$options.' />'.$additional; // gdy wylaczone Multi language
    
    array_push($this->fields,$field);
  }
  
  // dodanie nowego pola z plikiem INPUT
  function AddFileInput($title='',$name='',$size='20',$file_del='',$options='',$additional='') {
    global $cfg;
  
    if($options!='') $options=' '.$options;
    elseif($additional=='') $options=' style="width: 100%;"';
    if($additional!='') $additional=' '.$additional;
    
    $field=array();
    $field[0] = $title;
      
    $field[1] = '<input type="file" name="'.$name.'" size="'.intval($size).'"'.$options.' />'.$additional;
    if($file_del!='') {
	     $field[1] .= $file_del;
    }
    
    array_push($this->fields,$field);
  }
  
  function FileInputDel($name='',$path='',$file='') {
    global $cfg,$lang;
    
    if(file_exists($path.$file) && $file!='') {
	     $text = '<br /><input type="checkbox" name="'.$name.'" value="1" /> '.$lang['delete'];
    }
    
    return $text;
  }
  
  // dodanie nowego pola tekstowego INPUT z kalendarzem
  function AddTextInputWithCalendar($title='',$name='',$value='',$options='',$additional='') {
  global $cfg;
  
    if($options!='') $options=' '.$options;
    if($additional!='') $additional=' '.$additional;
    
    $field=array();
    $field[0] = $title;    
    $field[1] = '<input type="text" name="'.$name.'" value="'.$value.'"'.$options.' />'.$additional.' <img onclick="showKal('.$this->name.'.'.$name.')" src="themes/'.$cfg['theme'].'/gfx/cal.gif"/>';
    
    array_push($this->fields,$field);
  }
  
  // dodanie nowego pola tekstowego TEXTAREA
  function AddTextarea($title='',$name='',$value='',$options='',$additional='') {
    global $cfg;
    
    if($options!='') $options=' '.$options;
    elseif($additional=='') $options=' style="width: 100%;"';
    if($additional!='') $additional=' '.$additional;
    
    $field=array();
    $field[0] = $title;
    
    // jesli wystepuje wiecej niz 1 jezyk
    if($this->ml>0) {
      $count = count($this->languages);
      
      if($count>1) {
        $field[1] = '<table width="100%" cellspacing="3" cellpadding="3">';
        for($i=0;$i<$count;$i++) {
          $field[1] .= '<tr valign="top"><td style="width: 18px;"><img src="themes/'.$cfg['theme'].'/gfx/flags/'.$this->languages[$i].'.gif" alt="" /></td><td><textarea name="'.$name.'_lang-'.$this->languages[$i].'"'.$options.'>'.$value[$this->languages[$i]].'</textarea></td></tr>';
        }
        $field[1] .= '</table>';
      } else $field[1] .= '<textarea name="'.$name.'_lang-'.$this->languages[0].'"'.$options.'>'.$value[$this->languages[0]].'</textarea>'; // gdy wystepuje tylko 1 jezyk
      
    } else $field[1] = '<textarea name="'.$name.'"'.$options.'>'.$value.'</textarea>'.$additional; // gdy wylaczone Multi language
    
    array_push($this->fields,$field);
  }
  
  // dodanie nowego pola SELECT
  function AddSelect($title='',$name='',$items=array(),$selected=0,$options='',$additional='') {

    if($options!='') $options=' '.$options;
    elseif($additional=='') $options=' style="width: 100%;"';
    if($additional!='') $additional=' '.$additional;

    $field=array();
    $field[0] = $title;
    $field[1] = '
        <select name="'.$name.'"'.$options.'>
';

    for($i=0;$i<count($items);$i++) {
      if($items[$i][1]==$selected) $s=' selected="selected"'; else $s='';
      if(!is_array($items[$i])) {
        $tmp=$items[$i];
        $items[$i]=array($tmp,$tmp);
      }
      $field[1] .= '          <option value="'.$items[$i][1].'"'.$s.'>'.$items[$i][0].'</options>';
      $field[1] .= "\n";
    }
        
$field[1] .= '        </select>
      '.$additional;

    array_push($this->fields,$field);
  }

  // dodanie nowego pola wyboru CHECKBOX
  function AddCheckboxInput($title='',$name='',$items=array(),$checked=0,$location='v',$options='') {
    if($options!='') $options=' '.$options;
    $options_=$options;
    
    $field=array();
    $field[0] = $title;
    if($location=='h') $sp = "&nbsp;&nbsp;";
    else $sp = "<br />";

    for($i=0;$i<count($items);$i++) {
      if($items[$i][1]==$checked) $c=' checked="checked"'; else $c='';
      if(!is_array($items[$i])) {
        $tmp=$items[$i];
        $items[$i]=array($tmp,$tmp);
      }
      $options_=str_replace("(p)","(".$items[$i][1].")",$options);
      $field[1] .= '      <label for="'.$i.'"><input id="'.$i.'" type="checkbox" name="'.$name.'" value="'.$items[$i][1].'"'.$c.$options_.' /> '.$items[$i][0].'</label>'.$sp;
      $field[1] .= "\n";
    }
    
    array_push($this->fields,$field);
  }
  
  // dodanie nowego pola wyboru RADIO
  function AddRadioInput($title='',$name='',$items=array(),$checked=0,$location='v',$options='') {
    if($options!='') $options=' '.$options;
    $options_=$options;
    
    $field=array();
    $field[0] = $title;
    if($location=='h') $sp = "&nbsp;&nbsp;";
    else $sp = "<br />";

    for($i=0;$i<count($items);$i++) {
      if($items[$i][1]==$checked) $c=' checked="checked"'; else $c='';
      if(!is_array($items[$i])) {
        $tmp=$items[$i];
        $items[$i]=array($tmp,$tmp);
      }
      $options_=str_replace("(p)","(".$items[$i][1].")",$options);
      $field[1] .= '      <label for="'.$i.'"><input id="'.$i.'" type="radio" name="'.$name.'" value="'.$items[$i][1].'"'.$c.$options_.' /> '.$items[$i][0].'</label>'.$sp;
      $field[1] .= "\n";
    }
    
    array_push($this->fields,$field);
  }
  
  // ustawienie szerokosci kolumn tabeli
  function SetWidths($left='50%',$right='50%') {
    $this->width=array($left,$right);
  }
  
  // ustawienie wysokosci wiersza tabeli
  function SetHeight($height='30') {
    $this->height=30;
  }
  
  // ustawienie pola INPUT - SUBMIT
  function SetSubmit($text='',$options='',$tdstyle=' align="center" style="padding: 5px;"') {
    $this->submit=array($text,$options,$tdstyle);
  }
  
  // ustawienie pola INPUT - SUBMIT jako IMG
  function SetSubmitImg($type='save',$tdstyle=' align="center" style="padding: 5px;"') {
    $this->submit=array($type,'img',$tdstyle);
  }
  
  // dodanie nowego pola ukrytego
  function AddHidden($name='',$value='') {
    if($name!='' && $value!='') {
      $hidden=array($name,$value);
      array_push($this->hiddens,$hidden);
    }
  }
  
  // ustawienie ¶ciezki do FCKEditor
  function FCK($path='fckeditor/fckeditor.js', $dotted='../') {
    $this->fck='<script type="text/javascript" src="'.$dotted.$path.'"></script>';
    $this->dotted=$dotted;
  }
  
  // dodanie nowego pola FCKEditor
  function AddFCK($title='',$name='',$value='',$type='visCMS',$height=300,$language='pl') {
    global $cfg;
  
    $field=array();
    
    $field[0]=$title;
    
    // jesli wystepuje wiecej niz 1 jezyk
    if($this->ml>0) {
    
      $count = count($this->languages);
      
      if($count>1) {
        $field[1] = '<table width="100%" cellspacing="3" cellpadding="3">';
        for($i=0;$i<$count;$i++) {
        
          $base_arguments = array();

          $base_arguments['Value'] = $value[$this->languages[$i]];
          foreach($base_arguments as $key => $valuea) {
            if(!is_bool($valuea)) {
              $valuea = '"' . preg_replace("/[\r\n]+/", '" + $0"', addslashes($valuea)) . '"';
            }
          }
        
          $field[1] .= '<tr valign="top"><td style="width: 18px;"><img src="themes/'.$cfg['theme'].'/gfx/flags/'.$this->languages[$i].'.gif" alt="" /></td><td>
<script type="text/javascript">
var oFCKeditor = new FCKeditor(\''.$name.'_lang-'.$this->languages[$i].'\');
oFCKeditor.BasePath = "'.$this->dotted.'fckeditor/";
oFCKeditor.InstanceName = "'.$name.'_lang-'.$this->languages[$i].'";
oFCKeditor.Height = "'.$height.'";
oFCKeditor.Width = "100%";
oFCKeditor.Value = '.$valuea.';
oFCKeditor.ToolbarSet = "'.$type.'";
oFCKeditor.Config[ "DefaultLanguage" ] = "'.$language.'" ;
oFCKeditor.Create();
</script>
</td></tr>';
        }
        $field[1] .= '</table>';
      } else {
          $base_arguments = array();

          $base_arguments['Value'] = $value[$this->languages[0]];
          foreach($base_arguments as $key => $valuea) {
            if(!is_bool($valuea)) {
              $valuea = '"' . preg_replace("/[\r\n]+/", '" + $0"', addslashes($valuea)) . '"';
            }
          }
        
          $field[1] = '<script type="text/javascript">
var oFCKeditor = new FCKeditor(\''.$name.'_lang-'.$this->languages[0].'\');
oFCKeditor.BasePath = "'.$this->dotted.'fckeditor/";
oFCKeditor.InstanceName = "'.$name.'_lang-'.$this->languages[0].'";
oFCKeditor.Height = "'.$height.'";
oFCKeditor.Width = "100%";
oFCKeditor.Value = '.$valuea.';
oFCKeditor.ToolbarSet = "'.$type.'";
oFCKeditor.Config[ "DefaultLanguage" ] = "'.$language.'" ;
oFCKeditor.Create();
</script>';
      }
      
    } else {

        $base_arguments = array();

        $base_arguments['Value'] = $value;
        foreach($base_arguments as $key => $valuea) {
          if(!is_bool($valuea)) {
            $valuea = '"' . preg_replace("/[\r\n]+/", '" + $0"', addslashes($valuea)) . '"';
          }
        }
        
          $field[1] = '<script type="text/javascript">
var oFCKeditor = new FCKeditor(\''.$name.'\');
oFCKeditor.BasePath = "'.$this->dotted.'fckeditor/";
oFCKeditor.InstanceName = "'.$name.'";
oFCKeditor.Height = "'.$height.'";
oFCKeditor.Width = "100%";
oFCKeditor.Value = '.$valuea.';
oFCKeditor.ToolbarSet = "'.$type.'";
oFCKeditor.Config[ "DefaultLanguage" ] = "'.$language.'" ;
oFCKeditor.Create();
</script>';
    
} // gdy wylaczone Multi language

    array_push($this->fields,$field);
    
  }
  
  // ustawienie wielu jêzyków
  function Languages() {
    $this->languages=array();
    $sqlLang = sql("SELECT id FROM viscms_languages ORDER BY id ASC");
    while(list($id)=dbrow($sqlLang)) {
      array_push($this->languages,$id);
    }
  }
  
  // ustawienie wielu jêzyków
  function MultiLanguage($on=1) {
  
    if($on==1) $this->ml=1;
    else $this->ml=0;
    
  }

}

?>