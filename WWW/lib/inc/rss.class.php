<?

class RSS {
	
	var $src;
	
	function RSS($src='rss.xml') {
		
		$this->src=$src;
		
	}
	
	function ChangeChars($string) {
		
		$pl_iso = array('&quot;','&ecirc;', '&oacute;', '&plusmn;', '&para;', '&sup3;', '&iquest;', '&frac14;', '&aelig;', '&ntilde;', '&Ecirc;', '&Oacute;', '&iexcl;', '&brvbar;', '&pound;', '&not;', '&macr;', '&AElig;', '&Ntilde;',"&bdquo;","&rdquo;","&ndash;","&nbsp;","&#8220;","&#8221;","&#8222;","&#8211;","&hellip;");   
		$entitles = array('"','&ecirc;', 'ó', '&plusmn;', '&para;', '&sup3;', '&iquest;', '&frac14;', '&aelig;', '&ntilde;', '&Ecirc;', '&Oacute;', '&iexcl;', '&brvbar;', '&pound;', '&not;', '&macr;', '&AElig;', '&Ntilde;','"','"','-',' ','"','"','"','-',"...");
		$return = str_replace($pl_iso,$entitles,$string);
		
		return strip_tags(str_replace("<br />","\n",$return));
		
	}
	
	function Generate() {
		global $cfg;
		
if($cfg['rssitems']!=0 && is_numeric($cfg['rssitems'])) {
	$clause = " LIMIT 0,".$cfg['rssitems'];
}
		
$fp=fopen($this->src,'w+');

$xml='<?xml version="1.0" encoding="iso-8859-2" ?>
<rss version="2.0">
 <channel>
 <lastBuildDate>'.date("r").' GMT</lastBuildDate>
  <title>Studio Profilaktyki Spo³ecznej</title>
  <link>http://www.sps.org.pl</link>
  <description><![CDATA[Kna³ RSS Studio Profilaktyki Spo³ecznej]]></description>
  <language>pl</language>
  <copyright>VISMEDIA</copyright>
  <managingEditor>VISMEDIA www.vismedia.pl</managingEditor>
  <webMaster>VISMEDIA www.vismedia.pl</webMaster>
  <ttl>60</ttl>
  <pubDate>'.date("r").' GMT</pubDate>
';

fputs($fp,$xml);

$sql=sql("SELECT id,title,description,date,category,author,type,type_id FROM viscms_rss ORDER BY date DESC".$clause);
while(list($id,$title,$description,$date,$category,$author,$type,$type_id)=dbrow($sql)) {
	
	if($type=='article') $type='articles';

$xml='   <item>
     <title>'.str_replace("&","&amp;",$title).'</title>
     <link>'.$cfg['address'].'/a'.$type_id.'_'.mod_rewrite($title).'.html</link>
     <pubDate>'.date("r",$date).' GMT</pubDate>
     <description><![CDATA['.str_replace("\n"," ",str_replace("&","&amp;",$description)).']]></description>
     <category>'.$category.'</category>
     <author>'.$author.'</author>
   </item>
';

fputs($fp,$xml);	
	
}

$xml=' </channel>
</rss>';

fputs($fp,$xml);

fclose($fp);

	}
	
	function ToDb($type,$type_id,$title,$description,$date,$category,$language_id,$author) {
		$sql=sql("INSERT INTO viscms_rss (type,type_id,title,description,date,category,language_id,author) VALUES('".$type."','".$type_id."','".$this->ChangeChars($title)."','".$this->ChangeChars($description)."','".$date."','".$category."','".$language_id."','".$this->ChangeChars($author)."')");
		if($sql==true) return true;
		else return false;
	}

	function Delete($type,$type_id) {
		$sql=sql("DELETE FROM viscms_rss WHERE type='".$type."' AND type_id='".$type_id."'");
		if($sql==true) return true;
		else return false;
	}
	
}

?>