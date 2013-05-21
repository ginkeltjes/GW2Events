<html>
	<head>
		
		<title>GW2 Event Status</title>
		<style>
			html
			{
				background #cccccc;
			}
			body
			{
				background: #cccccc;
				font-family: verdana;
				font-size: 10px;
				width: 1000px;
				margin: 0 auto;
			}
			table
			{
				width: 1024px; 
				border: 2px solid #000000; 
				text-align: left;
				background: #ffffff;
				margin-top: 5px;
			}
			th
			{
				background: #2270bf;
				font-size: 16px;
				padding: 10px;
				font-weight: bold;
				color: #ffffff;
			}
			td
			{
				font-size: 12px;
				border-bottom: 1px dashed #000000;
			}
			tr:hover
			{
				background-color: #ccc;
				color: #fff;
			}
			th:hover
			{
				cursor: pointer;
			}
			.maps
			{
				width: 150px;
				padding: 5px;
				color: #ffffff;
				background: #2270bf;
				height: 25px;
				font-size: 12px;
				float: left;
				margin-right: 3px;
				margin-bottom: 3px;
			}
			#eventstable
			{
				float: left;
			}
		</style>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script src="https://raw.github.com/joequery/Stupid-Table-Plugin/master/stupidtable.min.js"></script>
		<script>
		$(document).ready(function()
		{
			self.setInterval(function(){refresh()},60000);
		  });
		  
		function refresh()
  		{
			var map = <?php echo $_GET['map']; ?>+"";
		      $.ajax
		      ({
		         type: "POST",
		         url: "populatetable.php",
		         data: "map="+ map,
		         success: function(option)
		         {
		         	$('#eventstable').empty();
		           $("#eventstable").html(option);
		         }
		      });
		  
		    return false;
		}  
		  
		$(function(){
		      $("#simpleTable").stupidtable();
		   });
   
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-36994855-2', 'ginkeltjes.nl');
  ga('send', 'pageview');

</script>
	</head>
<body>
	<center>
<?php

//https://api.guildwars2.com/v1/map_names.json
//https://api.guildwars2.com/v1/event_names.json

include('inc/database.php');
include('settings.php'); // Setting bestand met alleen database informatie
$DATABASE = new Database($SETTINGS[database_host], $SETTINGS[database_schema],  $SETTINGS[database_gebruiker], $SETTINGS[database_wachtwoord], '', $TABLES);

if($_GET[map])
{
	$eventstatus = $DATABASE->query("SELECT * FROM gw2_event_status WHERE map_id = $_GET[map] ORDER BY event_id ASC");	
}
else
{
	$eventstatus = $DATABASE->query("SELECT * FROM gw2_event_status ORDER BY map_id ASC");
}

$maps = $DATABASE->query("SELECT * FROM gw2_maps");
echo "<a href='dynamic.php'><div class='maps'>Everything</div></a>";
echo "<a href='dragons.php'><div class='maps'>Dragons</div></a>";
foreach($maps as $m)
{
	echo "<a href='dynamic.php?map=$m[id]'><div class='maps'>".$m['name']."</div></a>";
}
echo "<div id='eventstable'>";

echo "<table id='simpleTable'><thead><tr><th data-sort='string'>Event</th><th data-sort='string'>Map</th><th data-sort='string'>Status</th></tr></thead>";
foreach($eventstatus as $d)
{
	$eventname = $DATABASE->query("SELECT name FROM gw2_events WHERE id = '".$d['event_id']."'");
	$eventname = $eventname[0];
	$eventname = $eventname['name'];
	
	$mapname = $DATABASE->query("SELECT name FROM gw2_maps WHERE id = '".$d['map_id']."'");
	$mapname = $mapname[0];
	$mapname = $mapname['name'];
	
	if($d[state] == 'Success')
	{
		$status = '<font style="color: #326e39; font-weight: bold;">'.$d[state].'</font>';
	}
	if($d[state] == 'Active')
	{
		$status = '<font style="color: #c77500; font-weight: bold;">'.$d[state].'</font>';
	}
	if($d[state] == 'Fail')
	{
		$status = '<font style="color: #cd4343; font-weight: bold;">'.$d[state].'</font>';
	}
	if($d[state] == 'Warmup')
	{
		$status = '<font style="color: #f29e26; font-weight: bold;">Inactive</font>';
	}
	if($d[state] == 'Preparation')
	{
		$status = '<font style="color: #f29e26; font-weight: bold;">'.$d[state].'</font>';
	}
	if($eventname != '' && $mapname != '')
	{
		echo "<tr><td>$eventname</td><td>$mapname</td><td>$status</td></tr>";
	}
}
echo "</table>";
echo "</div>";
?>
<div style='bottom: 5px;'>
	<script type="text/javascript"><!--
google_ad_client = "ca-pub-9435340088862159";
/* GW2 Events */
google_ad_slot = "3793536996";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
</center>
</body>
</html>