<?php


include('inc/database.php');
    $DATABASE = new Database('localhost', 'ginkeltjes_nl',  'ginkeltjes.nl', 'hobbykip', '', $TABLES);

$urleventnames = "https://api.guildwars2.com/v1/map_names.json";
$dataeventnames = json_decode( file_get_contents($urleventnames), TRUE );
	$DATABASE->query("TRUNCATE TABLE  `gw2_maps`");
	foreach($dataeventnames as $d2)
	{
		$DATABASE->query("INSERT INTO gw2_maps (`id`, `name`) VALUES ('".$d2[id]."', '".$DATABASE->injection($d2[name])."')");
	}
	
	echo $DATABASE->querylog();
?>