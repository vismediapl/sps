<?

###############################
#           SPU-CMS           #
############-------############
#         SPU Systems         #
#       www.spu.com.pl        #
#      biuro@spu.com.pl       #
############-------############
#          Kalendarz          #
#      calendar.class.php     #
#     ostatnia modyfikacja    #
#          2008-04-01         #
###############################

class Calendar {
	
	var $day,$current_day,$current_month,$current_year,$today,$markers;
	
	function HowManyDays($m,$y) {
		$chd = array('',31,28,31,30,31,30,31,31,30,31,30,31);
		if($m==2 && $y%4==0) $chd[2]=29;
		return $chd[$m];
	}
	
	function FirstDay($month,$year) {
		return date("w",mktime(12,0,0,$month,1,$year));
	}
	
	function DayOfWeek($DayOfWeek) {
		return $DayOfWeek%7;
	}
	
	function Weeks($fday,$hmd) {
		for($i=0;$i<$hmd;$i++) {
			if($this->DayOfWeek($fday+$i)==1) $mondays++;
		}
		if($fday!=1) $mondays++;
		return $mondays;
	}
	
	function Draw($month,$year,$fday,$weeks,$wdt) {
		global $lang,$today,$markers;
		
		$n=0;
		
		if($fday==0) $fday=7;
		
		echo '<table style="width: '.$wdt.'px;" cellpadding="1" cellspacing="1">
	<tr>
		<td align="center" colspan="9" style="font-weight: bold; text-decoration: underline; font-size: 14px; color: #404040;">'.$lang['month_'.$month].' '.$year.'</td>
	</tr>
	<tr>
		<td colspan="9" style="height: 10px;"></td>
	</tr>
	<tr align="center" style="background: #e5e1da;">
		<td colspan="9"><table style="width: 100%;" cellpadding="0" cellspacing="0"><tr><td width="1%"></td>
';
		for($i=1;$i<=7;$i++) {
			if($i==7) $dayclass = ' color: #f00;';
			else $dayclass=' color: #404040;';
			echo '		<td align="center" width="14%" style="font-weight: bold; text-decoration: underline;'.$dayclass.'">'.$lang['day_'.$i].'</td>
';
		}
		
echo '		<td width="1%"></td></tr></table>
	
	</td>
	</tr>
	<tr>
		<td colspan="9" style="height: 10px;"></td>
	</tr>
';
		
		for($w=0;$w<$weeks;$w++) {
			echo '	<tr align="center">
		<td></td>
';
			
			for($i=1;$i<=7;$i++) {
				
				if(($w==0 && $i<$fday) || ($w==($weeks-1) && $n>=$this->HowManyDays($month,$year)))
					echo '		<td></td>
';
				else {
					$n++;
					if($i==7) {
						$dayclass = ' color: #f00;';
						$cca = '2';
					}
					else {
						$dayclass=' color: #202020;';
						$cca = '';
					}
					for($m=0;$m<count($markers);$m++) {
						if($markers[$m][0]==$year && $markers[$m][1]==$month && $markers[$m][2]==$n) {
							if($markers[$m][3]=='') $markers[$m][3]=' border: black solid 1px;';
							$mstyle=' '.$markers[$m][3];
							if($markers[$m][4]!='') $mtitle = ' title="'.str_replace("]["," | ",$markers[$m][4]).'"';
							else $mtitle='';
							if($markers[$m][5]!='') {
								$a1='<a href="'.$markers[$m][5].'" class="calendar_class_a'.$cca.'">';
								$a2='</a>';
							} else {
								$a1='<a href="#" class="calendar_class_a'.$cca.'">';
								$a2='</a>';
							}
							break;
						}
						else $a1=$a2=$mtitle=$mstyle='';
					}
					if($today[0]==1 && $today[3]==$n && $today[2]==intval($month) && $today[1]==$year) $todayclass = ' border: red solid 2px;';
					else $todayclass = '';
					echo '		<td style="font-weight: bold;'.$dayclass.$todayclass.$mstyle.'"'.$mtitle.'>'.$a1.$n.$a2.'</td>
';
				}
			}
			
			echo '		<td align="center" width="1%"></td>
	</tr>
';
		}
	
echo '</table>

<br /><br />

';
	}

	function Start($month=null,$year=null) {
		global $current_month,$current_year;
		
		if($month!=null) $current_month=$month;
		if($year!=null) $current_year=$year;
		
	}
	
	function Calendar() {
		global $day,$current_day,$current_month,$current_year,$today,$markers;
		
		$current_date = date("w-d-n-Y");
		list($day,$current_day,$current_month,$current_year)=explode("-",$current_date);
		
		$today = array(0,$current_year,$current_month,$current_day);
		
		$markers = array();
	}

	function ShowCalendar($how_many,$width) {
		global $day,$current_day,$current_month,$current_year,$markers;
		
		$day = $this->FirstDay($current_month,$current_year);
		
		$it=$current_month-1;

		for($i=0;$i<$how_many;$i++) {
			++$it;
	
			$month[$i] = ($current_month+$i)%12;
			if($month[$i]==0) $month[$i]=12;
	
			$year[$i] = $current_year+floor($it/12);
			if($it%12==0) $year[$i]-=1;
			$this->Draw($month[$i],$year[$i],$this->DayOfWeek($day),$this->Weeks($this->DayOfWeek($day),$this->HowManyDays($month[$i],$year[$i])),$width);
			$day+=$this->HowManyDays($month[$i],$year[$i]);
		}
		
	}
	
	function TodayOn() {
		global $today;
		$today[0] = 1;
	}
	
	function TodayOff() {
		global $today;
		$today[0] = 0;
	}
	
	function Marker($year,$month,$day,$style=false,$title=false,$url=false) {
		global $markers;
		
		$count = count($markers);
		$markers[$count] = array($year,$month,$day,$style,$title,$url);
	}
	
};

?>