<?

global $cfg;

$vars = explode(',',$_GET['act']);
$var_1 = $vars[0];
$var_2 = $vars[1];
$var_3 = $vars[2];

if($var_1=='click' && is_numeric($var_2)) {
	
	$sql = sql("SELECT goto,clicked FROM viscms_advertising WHERE id=".$var_2);
	if(list($goto,$clicked)=dbrow($sql)) {

		$block = $_COOKIE['ads_'.$var_2];
	
		if($block!=1) {
			$clicked++;
			$sqlUP = sql("UPDATE viscms_advertising SET clicked='".$clicked."' WHERE id=".$var_2);
			setcookie('ads_'.$var_2,1,time()+86400);
		}
		
		if($goto!='') header("Location: ".$goto);
		else header("Location: index.php");

	}

}

?>