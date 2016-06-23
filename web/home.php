<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- chargement des librairies
	include('../lib/simple_html_dom.php');

	// ---- chargement des modules
	include('../modules/BDD.php');
	include('../modules/meteo.php');
	
?>
<html>
    <head>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="/css/style.css" />
        <title>ASGARD - Home</title>
    </head>
    <body>
		<!-- Tableau de page -->
		<table class="page">
			<tr align="center">
				<td>
				
				</td>
				<td>
					<img src="/img/banniere.png" height="200">
				</td>
			</tr>
			<?php
				if ($_SESSION['login']) {
					// ---- Si l'utilisateur est loggé
			?>
			<tr>
				<!-- Chargement du menu de navigation -->
				<td class='taillemenu' valign="top">
					<?php include('menu.php'); ?>
				</td>
				<td align="center">
					<img src="/img/vide.png" height="50">
					<table>
						<tr>
							<td class="cadre">
								<!-- Temperature exterieure -->
								<table>
									<tr>
										<td rowspan="2" align="center" valign="middle"><img src="/img/temperature.png" height="32"></td>
										<td rowspan="3"><img src="/img/vide.png" height="32"></td>
										<td>Temperature exterieure</td>
									</tr>
									<tr>
										<td colspan="2" align="center"><?php echo temperature_exterieure_BDD($bdd) . ' C'; ?></td>
									</tr>
								</table>
							</td>
							<td>
								<img src="/img/vide.png" widht="200">
							</td>
							<td class="cadre">
								<table>
								<?php
									// ---- Recuperation des donnees de la chambre
									$infos_piece = donnees_piece_live($bdd, 1);
								?>		
									<tr>
										<td rowspan="8"><img src="/img/bebe.png" height="64"></td>
										<td rowspan="8" valign="middle"><h2>Chambre</h2></td>
										<td rowspan="8"><img src="/img/vide.png" height="32"></td>
										<td rowspan="2" align="center" valign="middle"><img src="/img/temperature<?php echo $infos_piece['Tetat']; ?>.png" height="32"></td>
										<td rowspan="8"><img src="/img/vide.png" height="32"></td>
										<td align="center">Temperature</td>
										<td rowspan="8"><img src="/img/vide.png" height="32"></td>
										<td align="center">Tmp reco</td>
									</tr>
									<tr>
										<td colspan="2" align="center"><?php echo (int)$infos_piece['temperature'] . ' C'; ?></td>
										<td colspan="2" align="center"><?php echo (int)$infos_piece['Tideal'] . ' C'; ?></td>
									</tr>
									<tr>
										<td><img src="/img/vide.png" height="5"></td>
									</tr>
									<tr>
										<td rowspan="2" align="center" valign="middle"><img src="/img/humidity<?php echo $infos_piece['Hetat']; ?>.png" height="32"></td>
										<td align="center">Humidite</td>
										<td align="center">Hum reco</td>
									</tr>
									<tr>
										<td colspan="2" align="center"><?php echo (int)$infos_piece['humidite'] . ' %'; ?></td>
										<td colspan="2" align="center"><?php echo (int)$infos_piece['Hideal'] . ' %'; ?></td>
									</tr>
									<tr>
										<td><img src="/img/vide.png" height="5"></td>
									</tr>
									<tr>
										<td rowspan="2" align="center" valign="middle"><img src="/img/heater<?php echo $infos_piece['Retat']; ?>.png" height="32"></td>
										<td align="center">Radiateur</td>
										<td align="center">Reg reco</td>
									</tr>
									<tr>
										<td colspan="2" align="center"><?php echo (int)$infos_piece['radiateur']; ?></td>
										<td colspan="2" align="center"><?php echo $infos_piece['reglage']; ?></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<img src="/img/vide.png" height="70">
							</td>
						</tr>
						<tr>
							<td align="center" colspan="3">
								<table class="cadre">
									<?php
										// ---- Recuperation des donnees du salon
										$infos_piece = donnees_piece_live($bdd, 2);
									?>		
									<tr>
										<td rowspan="8"><img src="/img/salon.png" height="64"></td>
										<td rowspan="8" valign="middle"><h2>Salon</h2></td>
										<td rowspan="8"><img src="/img/vide.png" height="32"></td>
										<td rowspan="2" align="center" valign="middle"><img src="/img/temperature<?php echo $infos_piece['Tetat']; ?>.png" height="32"></td>
										<td rowspan="8"><img src="/img/vide.png" height="32"></td>
										<td align="center">Temperature</td>
										<td rowspan="8"><img src="/img/vide.png" height="32"></td>
										<td align="center">Tmp reco</td>
									</tr>
									<tr>
										<td colspan="2" align="center"><?php echo (int)$infos_piece['temperature'] . ' C'; ?></td>
										<td colspan="2" align="center"><?php echo (int)$infos_piece['Tideal'] . ' C'; ?></td>
									</tr>
									<tr>
										<td><img src="/img/vide.png" height="5"></td>
									</tr>
									<tr>
										<td rowspan="2" align="center" valign="middle"><img src="/img/humidity<?php echo $infos_piece['Hetat']; ?>.png" height="32"></td>
										<td align="center">Humidite</td>
										<td align="center">Hum reco</td>
									</tr>
									<tr>
										<td colspan="2" align="center"><?php echo (int)$infos_piece['humidite'] . ' %'; ?></td>
										<td colspan="2" align="center"><?php echo (int)$infos_piece['Hideal'] . ' %'; ?></td>
									</tr>
									<tr>
										<td><img src="/img/vide.png" height="5"></td>
									</tr>
									<tr>
										<td rowspan="2" align="center" valign="middle"><img src="/img/heater<?php echo $infos_piece['Retat']; ?>.png" height="32"></td>
										<td align="center">Radiateur</td>
										<td align="center">Reg reco</td>
									</tr>
									<tr>
										<td colspan="2" align="center"><?php echo (int)$infos_piece['radiateur']; ?></td>
										<td colspan="2" align="center"><?php echo $infos_piece['reglage']; ?></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
				<td align="center">
					<?php
					}
						else
						{
							echo "<script type='text/javascript'>document.location.replace('../index.php');</script>";
						}
					?>
				</td>
			</tr>
		</table>
    </body>
</html>