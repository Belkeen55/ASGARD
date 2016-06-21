<!DOCTYPE html>
<?php
	session_start();
		include("../modules/connexionBDD.php");
	$heurodatage = date('Y-m-d H:i:s');
	$heurodatage24H = date('Y-m-d H:i:s', mktime(date('H')-24, date('i'), date('s'), date('m'), date('d'), date('Y')));
	$reponse = $bdd->query('SELECT *
							FROM Mesures 
							WHERE Heurodatage BETWEEN \'' . $heurodatage24H . '\' AND \'' . $heurodatage . '\'
							AND Id_Pieces = 1');
?>
<html>
    <head>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="/css/style.css" />
        <title>ASGARD - 24 heures</title>
    </head>
    <body>
		<table class="page">
			<tr align="center">
				<td>
				
				</td>
				<td>
					<img src="/img/banniere.png" height="200">
				</td>
			</tr>
			<?php
				if ($_COOKIE['infos'] == "BelkhomeLogin")
					{
			?>
			<tr>
				<td class='taillemenu' valign="top">
					<?php include('menu.php'); ?>
				</td>
				<td align="center">
					<img src="/img/vide.png" height="50">
					<table>
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
					<?php
						$reponse = $bdd->query('SELECT *
												FROM Mesures 
												WHERE Heurodatage BETWEEN \'' . $heurodatage24H . '\' AND \'' . $heurodatage . '\'
												AND Id_Pieces = 2');
					?>
					<table>
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
							echo '<p>Mot de passe incorrect</p>';
							echo '<a href="/index.php">Retour</a>';
						}
					?>
				</td>
			</tr>
		</table>
    </body>
</html>