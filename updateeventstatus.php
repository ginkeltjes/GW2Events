<?php


include('inc/database.php');
include('settings.php'); // Setting bestand met alleen database informatie
$DATABASE = new Database($SETTINGS[database_host], $SETTINGS[database_schema],  $SETTINGS[database_gebruiker], $SETTINGS[database_wachtwoord], '', $TABLES);

$url = "https://api.guildwars2.com/v1/events.json?world_id=2007";
$data = json_decode( file_get_contents($url), TRUE );

	foreach($data['events'] as $d2)
	{
		$event = $DATABASE->query("SELECT * FROM gw2_event_status WHERE event_id = '".$d2[event_id]."'");	
		if($event)
		{
			$DATABASE->query("UPDATE gw2_event_status SET state = '".$d2['state']."' WHERE event_id = '".$d2['event_id']."'");
		}
		else 
		{
			$DATABASE->query("INSERT INTO gw2_event_status (`world_id`, `map_id`, `event_id`, `state`) VALUES ('".$d2['world_id']."', '".$d2['map_id']."', '".$d2['event_id']."', '".$d2['state']."')");
		}
	}
	
	echo $DATABASE->querylog();
?>