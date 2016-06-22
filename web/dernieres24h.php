<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- chargement des modules
	include("../modules/BDD.php");
	include("../modules/meteo.php");
?>
<html>
    <head>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="/css/style.css" />
        <title>ASGARD - 24 heures</title>
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
				if ($_SESSION['login'])	{
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
					<?php
						// ---- Chargement des données des dernière 24h de la piece chambre
						$reponse = last_24($bdd, 1);
					?>
						<tr>
							<td class="cadre">
								<table>
									<tr>
										<td colspan="5" align="center">
											<table>
												<tr>
													<td><img src="/img/bebe.png" height="64"></td>
													<td>Chambre</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td class="tableau">Heurodatage</td>
										<td class="tableau">Temp. Int</td>
										<td class="tableau">Temp. Ext</td>
										<td class="tableau">Humidite</td>
										<td class="tableau">Radiateur</td>
									</tr>
									<?php 
										while ($donnees = $reponse->fetch()) {
									?>
									<tr class="tableau">
										<td class="tableau" align="center">
											<?php echo $donnees['Heurodatage'];; ?>
										</td>
										<td class="tableau" align="center">
											<?php echo (int)$donnees['Tempint'];; ?>
										</td>
										<td class="tableau" align="center">
											<?php echo (int)$donnees['Tempext'];; ?>
										</td>
										<td class="tableau" align="center">
											<?php echo (int)$donnees['Humidite'];; ?>
										</td>
										<td class="tableau" align="center">
											<?php echo (int)$donnees['Radiateur'];; ?>
										</td>
									</tr>
									<?php 
										}
										$reponse->closeCursor(); 
									?>
								</table>
							</td>
						</tr>
					</table>
					<img src="/img/vide.png" height="50">
					<table>
					<?php
						// ---- Chargement des données des dernière 24h de la piece chambre
						$reponse = last_24($bdd, 2);
					?>
						<tr>
							<td class="cadre">
								<table>
									<tr>
										<td colspan="5" align="center">
											<table>
												<tr>
													<td><img src="/img/salon.png" width="64"></td>
													<td>Salon</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td class="tableau">Heurodatage</td>
										<td class="tableau">Temp. Int</td>
										<td class="tableau">Temp. Ext</td>
										<td class="tableau">Humidite</td>
										<td class="tableau">Radiateur</td>
									</tr>
									<?php 
										while ($donnees = $reponse->fetch()) {
									?>
									<tr class="tableau">
										<td class="tableau" align="center">
											<?php echo $donnees['Heurodatage'];; ?>
										</td>
										<td class="tableau" align="center">
											<?php echo (int)$donnees['Tempint'];; ?>
										</td>
										<td class="tableau" align="center">
											<?php echo (int)$donnees['Tempext'];; ?>
										</td>
										<td class="tableau" align="center">
											<?php echo (int)$donnees['Humidite'];; ?>
										</td>
										<td class="tableau" align="center">
											<?php echo (int)$donnees['Radiateur'];; ?>
										</td>
									</tr>
									<?php 
										}
										$reponse->closeCursor(); 
									?>
								</table>
							</td>
						</tr>
					</table>

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