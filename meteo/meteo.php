<?php
	// ---- Redirection toutes les 10 secondes
	header('Refresh: 10; url=previsions.php');
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- Chargement des modules
	include('../modules/BDD.php');
	include('../modules/meteo.php');
	
	$result = meteo_act_BDD($bdd);
	
	// Gestion de l'absence d'informations dans la BDD et tentative de refresh
	if(!isset($result['temperature'])) {
		add_log($bdd, 204, 203);
		$meteo = meteo_act_live();
		if(isset($meteo)) {
			$bdd->exec('INSERT INTO Meteo(Id, Heurodatage, Code, Temperature, Humidite) 
						VALUES(1, NOW(), \'' . $meteo['code'] . '\', '. $meteo['temperature'] . ', ' . $meteo['humidite'] . ')');
		}
		$result = meteo_act_BDD($bdd);
	}
?>
<head>
	<link rel="stylesheet" href="/css/style.css" />
</head>	
<table class="page">
	<tr>
		<td align="center">
			<table>
				<tr>
					<td colspan="5" align="center" class="taille1">
						Meteo
					</td>
				</tr>
				<tr>
					<td>
						<img src="/img/vide.png" height="40">
					</td>
				</tr>
				<tr>
					<td rowspan="4"><img src="/img/<?php echo $result['code']; ?>.png" height=200></td>
					<td rowspan="4">
						<img src="/img/vide.png" height="40">
					</td>
				</tr>
				<tr>
					<td align="left" class="taille3">
						<h2><?php echo (int)$result['temperature'] . ' C'; ?></h2>
					</td>
				</tr>
				<tr>
					<td align="left" class="taille3">
						<h2><?php echo (int)$result['humidite'] . '%'; ?></h2>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>