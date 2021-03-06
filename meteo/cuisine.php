<?php
	// ---- Redirection toutes les 10 secondes
	header('Refresh: 10; url=heure.php');
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- Chargement librairies
	include('../lib/simple_html_dom.php');
	
	// ---- Chargement des modules
	include('../lib/BDD.php');
	include('../lib/meteo.php');
	
	$infos = donnees_piece_BDD($bdd, 3);

?>
<link rel="stylesheet" href="/css/newstyle.css" />
<body class="ecran_noir">		
	<table class="full-screen">
		<tr>
			<td align="center">
				<table>
					<tr>
						<td colspan="4" align="center" valign="middle" class="taille1">Cuisine</td>
					</tr>
					<tr>
						<td>
							<img src="/img/vide.png" height="20">
						</td>
					</tr>
					<tr>
						<td class="taille1">
							Temp : 
						</td>
						<td class="taille1" align="right">
							<?php echo (int)$infos['temperature'] . ' C'; ?>
						</td>
						<td>
							<img src="/img/vide.png" height="20">
						</td>
						<td align="center" valign="middle">
							<img src="/img/temperature<?php echo $infos['Tetat']; ?>.png" height="80">
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<img src="/img/vide.png" height="10">
						</td>
					</tr>
					<tr>
						<td class="taille1">
							Hum : 
						</td>
						<td class="taille1" align="right">
							<?php echo (int)$infos['humidite'] . '%'; ?>
						</td>
						<td>
							<img src="/img/vide.png" height="20">
						</td>
						<td align="center" valign="middle">
							<img src="/img/humidity<?php echo $infos['Hetat']; ?>.png" height="80">
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<img src="/img/vide.png" height="10">
						</td>
					</tr>
					<tr>
						<td class="taille1">
							Radia : 
						</td>
						<td class="taille1" align="center">
							<?php echo (int)$infos['radiateur']; ?>
						</td>
						<td>
							<img src="/img/vide.png" height="20">
						</td>
						<td rowspan="2" align="center" valign="middle">
							<img src="/img/heater<?php echo $infos['Retat']; ?>.png" height="80">
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>