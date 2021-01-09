<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr valign="middle">
		<td class="header_td_bg">Kontrahenci</td>
	</tr>
</table>

<br />

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?=$cfg['googlemaps'];?>"
  type="text/javascript"></script>
<script type='text/javascript'>
	<!-- 
		var map;
		var markers=[];
		
		var default_icon = new GIcon();
		default_icon.image = '';
		default_icon.iconSize = new GSize(20,34);
		default_icon.shadow = '';
		default_icon.shadowSize = new GSize(0,0);
		default_icon.iconAnchor = new GPoint(16,16);
		default_icon.infoWindowAnchor = new GPoint(16,16);
		
		function redraw(checkbox,category)
		{	
			if(document.getElementById(checkbox).checked)
				HideCategory(category,true);
			else
				HideCategory(category,false);
		}

		function WindowContent(address)
		{
			return '<span style="color: #000000;"><b><u>'+address+'</u></b></span><br /><br /><b><?=$_SERVER['HTTP_HOST'];?></b></span><br />';
		}
		
		function HideCategory(category,show)
		{
			for(var i=0; i<markers.length; i++)
			{
				if(markers[i].category==category)
				{
					if(show==true)
						markers[i].show();
					else
						markers[i].hide();
				}
			}
		}
		
		function AddMarker(address,category,lat,lng)
		{
			
			var ico = new GIcon(default_icon);
			ico.image = 'themes/<?=$cfg['theme'];?>/gfx/map/'+category+'.png';
			
			var point = new GLatLng(lat,lng);
			var marker = new GMarker(point,{icon: ico, title: address});

			marker.category = category;
			markers.push(marker);
			map.addOverlay(marker);
			GEvent.addListener(marker,'click',function()
			{
				marker.openInfoWindowHtml(WindowContent(address));
			});
			
		}
		
		function load()
		{
			if(GBrowserIsCompatible())  
			{
				map = new GMap2(document.getElementById("map"));
				map.addControl(new GLargeMapControl());
				map.addControl(new GScaleControl());
				map.addControl(new GOverviewMapControl());
				map.addControl(new GMapTypeControl());
				map.setCenter(new GLatLng(52.150000,18.850000),6)
				
<?

$sqlA=sql("SELECT point,GoogleMaps_lat,GoogleMaps_lng FROM viscms_contractors WHERE GoogleMaps_lat!='0' AND GoogleMaps_lng!='0' GROUP BY point ORDER BY id");
while(list($address,$lat,$lng)=dbrow($sqlA)) {

?>	AddMarker('<?=$address;?>','city','<?=$lat;?>','<?=$lng;?>');
<?
}
?>

			}
		}

	-->
	</script>

<div align="center">
	<div id='map' style='width: 600px; height: 450px; border: 1px solid black; background: gray;'></div>
</div>

