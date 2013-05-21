<?php


include('inc/database.php');
include('settings.php'); // Setting bestand met alleen database informatie
$DATABASE = new Database($SETTINGS[database_host], $SETTINGS[database_schema],  $SETTINGS[database_gebruiker], $SETTINGS[database_wachtwoord], '', $TABLES);

$urleventnames = "https://api.guildwars2.com/v1/event_names.json";
$dataeventnames = json_decode( file_get_contents($urleventnames), TRUE );
	$DATABASE->query("TRUNCATE TABLE  `gw2_events`");
	foreach($dataeventnames as $d2)
	{
		$DATABASE->query("INSERT INTO gw2_events (`id`, `name`) VALUES ('".$d2[id]."', '".$d2[name]."')");
	}
	
	echo $DATABASE->querylog();
?>