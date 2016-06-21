<?php
	header('Refresh: 10; url=previsions.php');
	include('../modules/connexionBDD.php');
	$reponse = $bdd->query('SELECT Code, Temperature, Humidite
							FROM Meteo
							WHERE Id = 1');
	$donnees = $reponse->fetch();
	$api = $donnees['Temperature'];
	$code = $donnees['Code'];
	$humidite = $donnees['Humidite'];
	$reponse->closeCursor();
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
					<td rowspan="4"><img src="/img/<?php echo $code; ?>.png" height=200></td>
					<td rowspan="4">
						<img src="/img/vide.png" height="40">
					</td>
				</tr>
				<tr>
					<td align="left" class="taille3">
						<h2><?php echo (int)$api . ' C'; ?></h2>
					</td>
				</tr>
				<tr>
					<td align="left" class="taille3">
						<h2><?php echo (int)$humidite . '%'; ?></h2>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>