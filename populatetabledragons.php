<?php
include('inc/database.php');
$DATABASE = new Database('localhost', 'ginkeltjes_nl',  'ginkeltjes.nl', 'hobbykip', '', $TABLES);

$eventstatus = $DATABASE->query("SELECT * FROM gw2_event_status WHERE event_id IN (SELECT event_id FROM gw2_dragons)");	


echo "<table id='simpleTable'><thead><tr><th data-sort='string'>Event</th><th data-sort='string'>Map</th><th data-sort='string'>Status</th></tr></thead>";
foreach($eventstatus as $d)
{
	$eventname = $DATABASE->query("SELECT name FROM gw2_events WHERE id = '".$d['event_id']."'");
	$eventname = $eventname[0];
	$eventname = $eventname['name'];
	
	$mapname = $DATABASE->query("SELECT name FROM gw2_maps WHERE id = '".$d['map_id']."'");
	$mapname = $mapname[0];
	$mapname = $mapname['name'];
	
	$dragonname = $DATABASE->query("SELECT * FROM gw2_dragons WHERE event_id = '".$d['event_id']."'");
	$dragonname = $dragonname[0];
	
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
		echo "<tr><td>".$dragonname['name']."</td><td>$mapname</td><td>$status</td></tr>";
	}
}
echo "</table>";

?>