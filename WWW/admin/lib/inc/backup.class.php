<?php

class Backup {

  var $host;
  var $user;
  var $pass;
  var $db;
  var $type;
  var $names;
  var $int_db;
  var $create_db;
  
  function Backup($host='',$user='',$pass='',$db='',$type='mysql') {
    global $cfg;

    if($host=='') { $host=$cfg['sql_host']; $this->int_db=1; }
    if($user=='') { $user=$cfg['sql_user']; $this->int_db=1; }
    if($pass=='') { $pass=$cfg['sql_pass']; $this->int_db=1; }
    if($db=='') { $db=$cfg['sql_db']; $this->int_db=1; }
    
    $this->names = 'latin2';
    
    if($this->int_db!=1 && $type=='mysql') {
      $link = mysql_connect($host,$user,$pass);
      mysql_select_db($db);
    }
  
    $this->NewLine = "\r\n";
    
    $this->host=$host;
    $this->db=$db;
  
  }
  
  function SetNames($names) {
  
    $this->names = $names;
  
  }
  
  function DumpMySQL($path='',$file='') {
    global $cfg,$lang;
    
    $time=time();
  
    if($file=='') $file='backup_' . date("Y-m-d_H-i-s",$time);
    if($path=='') $path=$cfg['backuppath'];
    $filename=$path.$file;
    
    $file = $this->Open($filename);
    
    @chmod($path,0777);
    
    sql("SET NAMES ".$this->names);
    
    $sql_txt='# visCMS';
    if($cfg['version']!='') $sql_txt .= ' v'.$cfg['version'];
    $sql_txt .= $this->NewLine;
    $sql_txt .= '# www.vismedia.pl'.$this->NewLine;
    $sql_txt .= '# Database Dump'.$this->NewLine;
    $sql_txt .= '#'.$this->NewLine;
    $sql_txt .= '# '.$lang['backup_host'].': '.$this->host.$this->NewLine;
    $sql_txt .= '# '.$lang['backup_database'].': \''.$this->db.'\''.$this->NewLine;
    $sql_txt .= '# '.$lang['backup_generated'].': '.date("Y-m-d, H:i:s", $time).$this->NewLine;
    $sql_txt .= $this->NewLine.$this->NewLine;
    
    if($this->create_db==1) {
      $sql_txt .= 'CREATE DATABASE `'.$this->db.'` DEFAULT CHARACTER SET '.$this->names.';'.$this->NewLine;
      $sql_txt .= 'USE `'.$this->db.'`;'.$this->NewLine;
      $sql_txt .= $this->NewLine.$this->NewLine;
    }
    
  $this->Save($file,$sql_txt);
  unset($sql_txt);
    
  $col_res = sql("SHOW TABLE STATUS");
  while($fields = dbarray($col_res)) {
    $additional[$fields['Name']]='';
    if($fields['Engine']!='') $additional[$fields['Name']].=' ENGINE='.$fields['Engine'];
    $char_res = sql("SHOW COLLATION LIKE '".$fields['Collation']."'");
    if($fields2 = dbarray($char_res)) {
      $charset=$fields2['Charset'];
      if($fields2['Charset']!='') $additional[$fields['Name']].=' DEFAULT CHARSET='.$fields2['Charset'];
    }
    if($fields['Collation']!='') $additional[$fields['Name']].=' COLLATE='.$fields['Collation'];
    if($fields['Auto_increment']!='') $additional[$fields['Name']].=' AUTO_INCREMENT='.$fields['Auto_increment'];
    if($additional[$fields['Name']]!='') $additional[$fields['Name']].=' ';
  }
    

  $res = mysql_list_tables($this->db); 
  while(list($table_name) = dbarray($res)) { 
    $table_fields = array(); 
    
    sql('OPTIMIZE TABLE '.$table_name);
     
    $sql_txt .= '# -- ' . $this->NewLine; 
    $sql_txt .= '# -- '.$lang['backup_structure'].' ' . $table_name . $this->NewLine; 
    $sql_txt .= '# -- ' . $this->NewLine; 
     
    $sql_txt .= 'DROP TABLE IF EXISTS ' . $table_name . ';' . $this->NewLine; 
    $sql_txt .= 'CREATE TABLE ' . $table_name . ' ( ' . $this->NewLine; 
    $res2 = sql('SHOW FIELDS FROM ' . $table_name); 
    while($fields = dbarray($res2)) { 
        $sql_txt .= '   '; 
        $sql_txt .= '`'.$fields['Field'].'`' . ' ' . $fields['Type']; 
        if (!empty($fields['Default'])) { 
            $sql_txt .= ' DEFAULT "' . $fields['Default'] . '"'; 
        } 
         
        if ($fields['Null'] != 'Yes') { 
            $sql_txt .= ' NOT NULL'; 
        } 
         
        if (!empty($fields['Extra'])) { 
            $sql_txt .= ' ' . $fields['Extra']; 
        } 
         
        $sql_txt .= ',' . $this->NewLine; 
         
        $table_fields[] = $fields['Field']; 
    }
     
    $index = ''; 
    $res2 = sql('SHOW KEYS FROM ' . $table_name); 
    while ($keys = mysql_fetch_assoc($res2)) { 
        $kname = $keys['Key_name']; 
        if(($kname != 'PRIMARY') && ($keys['Non_unique'] == 0)) { 
            $kname = 'UNIQUE|' . $kname; 
        } 
         
        if(!is_array($index[$kname])) $index[$kname] = array(); 
        $index[$kname][] .= $keys['Column_name']; 
    }
     
    while(list($n, $columns) = @each($index)) { 
        if ($n == 'PRIMARY') { 
            $sql_txt .= '   PRIMARY KEY (`' . implode($columns, '`, `') . '`),'; 
        } 
        elseif (substr($n, 0, 6) == 'UNIQUE') { 
            $sql_txt .= '   UNIQUE `' . substr($n, 7) . '` (`' . implode($columns, '`, `') . '`),'; 
        } 
        else { 
            $sql_txt .= '   KEY `' . $n . '` (`' . implode($columns, '`, `') . '`),'; 
        } 
        $sql_txt .= $this->NewLine; 
    } 
     
    $sql_txt .= ')'.$additional[$table_name].';' . $this->NewLine;
    $sql_txt = str_replace(','.$this->NewLine.')'.$additional[$table_name].';', $this->NewLine.')'.$additional[$table_name].';', $sql_txt); 
    $sql_txt .= $this->NewLine . $this->NewLine; 
     
    $sql_txt .= '# -- ' . $this->NewLine; 
    $sql_txt .= '# -- '.$lang['backup_dates'].' ' . $table_name . $this->NewLine; 
    $sql_txt .= '# -- ' . $this->NewLine; 
    $d_res = sql('SELECT * FROM ' . $table_name); 
    while ($data = dbarray($d_res)) { 
        $sql_txt .= 'INSERT INTO `' . $table_name . '` (`' . implode('`, `', $table_fields) . '`) VALUES('; 
         
        $field_count = count($table_fields); 
        $f_data = array(); 
        for ($i = 0; $i < $field_count; $i++) { 
                $data[$i] = addslashes($data[$i]); 
            $f_data[] .= '"' . $data[$i] . '"'; 
        } 
        $sql_txt .= implode(', ', $f_data); 
        $sql_txt .= ');' . $this->NewLine; 
    } 
    $sql_txt .= $this->NewLine . $this->NewLine; 
    
  $sql_txt = str_replace(','.$this->NewLine.');', $this->NewLine.');', $sql_txt); 
  $this->Save($file,$sql_txt);
  unset($sql_txt);
  
  }
  
  $this->Close($file);
    
  
/*    $in = array("±","æ","ê","³","ñ","ó","¶","¼","¿");
    $out = array("&#261;","&#263;","&#281;","&#322;","&#324;","&#243;","&#347;","&#378;","&#380;");
    $sql_txt = str_replace($in,$out,$sql_txt);
    
    $in = array("¡","Æ","Ê","£","Ñ","Ó","¦","¬","¯");
    $out = array("&#260;","&#262;","&#280;","&#321;","&#323;","&#211;","&#346;","&#377","&#379;");
    $sql_txt = str_replace($in,$out,$sql_txt);
  
  $sql_txt = mb_convert_encoding($sql_txt, "UTF-8", "ISO-8859-2");*/

  
  
  }
  
  function Open($filename) {
  
    $filename.='.sql';
  
    if (extension_loaded('zlib')) {
      return gzopen($filename.".gz",'w');
    } else {
      return fopen($filename,'w');
    }
  
  }
  
  function Close($file) {
  
    if (extension_loaded('zlib')) {
      gzclose($file); 
    } else {
      fclose($file); 
    }
  
  }
  
  function Save($file,$sql_txt) {
  
    $filename.='.sql';
  
    if (extension_loaded('zlib')) {
      fwrite($file, $sql_txt);
    } else {
      fwrite($file, $sql_txt);
    }
  
  }
  
  function RestoreMySQL($filename) {
  
    $ext=end(explode(".",$filename));
    
    $a=$k=0;
    
  
    if ($ext=='gz') {
      $file = gzopen($filename,'r');
      while($line=fgets($file)) {
        if($sql_txt=='') {
          if(substr($line,0,6)=='INSERT') {
            $endOfLine=');'.$this->NewLine;
            $i=-4;
          } else {
            $endOfLine=';'.$this->NewLine;
            $i=-3;
          }
        }
        if(substr($line,0,1)!="#" && substr($line,0,2)!=$this->NewLine) $sql_txt.=$line;
        if(substr($line, $i)==$endOfLine) {
          $a++;
          $sql = sql($sql_txt);
          if($sql==true) {
            $k++;
          } else {
            if($sql==true) {
              $k++;
            }
          }
          $sql_txt=$endOfLine='';
        }
      }
      gzclose($file); 
    } else {
      $file = fopen($filename,'r');
      while($line=fgets($file)) {
        if($sql_txt=='') {
          if(substr($line,0,6)=='INSERT') {
            $endOfLine=');'.$this->NewLine;
            $i=-4;
          } else {
            $endOfLine=';'.$this->NewLine;
            $i=-3;
          }
        }
        if(substr($line,0,1)!="#" && substr($line,0,2)!=$this->NewLine) $sql_txt.=$line;
        if(substr($line, $i)==$endOfLine) {
          $a++;
          $sql = sql($sql_txt);
          if($sql==true) {
            $k++;
          } else {
            if($sql==true) {
              $k++;
            }
          }
          $sql_txt=$endOfLine='';
        }
      }
      fclose($file); 
    }
    
    if($k==$a) return true;
  
  }

}


?>