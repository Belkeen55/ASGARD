<?php
	header('Refresh: 10; url=chambre.php');
	include("modules/connexionBDD.php");
?>
<head>
	<link rel="stylesheet" href="css/style.css" />
</head>	
<table class="page">
	<tr>
		<td align="center">
			<table>
				<tr>
					<td colspan="5" align="center" class="taille1">
						Previsions
					</td>
				</tr>
				<tr>
					<td>
						<img src="img/vide.png" height="30">
					</td>
				</tr>
				<tr>
					<td>
					
					</td>
				<?php
					$prev = 0;
					$date = date('Y-m-d H:i:s', mktime(9, 0, 0, date('m'), date('d'), date('Y')));
					$reponse = $bdd->query('SELECT Heurodatage, Code, Temperature
											FROM Meteo
											WHERE Heurodatage = \'' . $date . '\'');
					$lignes = $reponse->rowCount();
					if($lignes == 1){
						$donnees = $reponse->fetch();
						$temperature = $donnees['Temperature'];
						$code = $donnees['Code'];
						$heurodatage = $donnees['Heurodatage'];
						$reponse->closeCursor();
						$prev++;
				?>
<td>					
					<table>
							<tr>
								<td align="center" class="taille2">
									Matin
								</td>
							</tr>
							<tr>
								<td align="center">
									<img src="img/<?php echo $code; ?>.png" width="140">
								</td>
							</tr>
							<tr>
								<td align="center" class="taille2">
									<?php echo (int)$temperature ?> C
								</td>
							</tr>
						</table>
					</td>
					<td>
						<img src="img/vide.png" height="40">
					</td>
					
				<?php	
					}
					$date = date('Y-m-d H:i:s', mktime(15, 0, 0, date('m'), date('d'), date('Y')));
					$reponse = $bdd->query('SELECT Heurodatage, Code, Temperature
											FROM Meteo
											WHERE Heurodatage = \'' . $date . '\'');
					$lignes = $reponse->rowCount();
					if($lignes == 1){
						$donnees = $reponse->fetch();
						$temperature = $donnees['Temperature'];
						$code = $donnees['Code'];
						$heurodatage = $donnees['Heurodatage'];
						$reponse->closeCursor();
						$prev++;
				?>
<td>					
					<table>
							<tr>
								<td align="center" class="taille2">
									Ap. Midi
								</td>
							</tr>
							<tr>
								<td align="center">
									<img src="img/<?php echo $code; ?>.png" width="140">
								</td>
							</tr>
							<tr>
								<td align="center" class="taille2">
									<?php echo (int)$temperature ?> C
								</td>
							</tr>
						</table>
					</td>
					<td>
						<img src="img/vide.png" height="40">
					</td>
					
				<?php
					}
					if($prev<2){
						$date = date('Y-m-d H:i:s', mktime(9, 0, 0, date('m'), date('d')+1, date('Y')));
						$reponse = $bdd->query('SELECT Heurodatage, Code, Temperature
												FROM Meteo
												WHERE Heurodatage = \'' . $date . '\'');
						$lignes = $reponse->rowCount();
						if($lignes == 1){
							$donnees = $reponse->fetch();
							$temperature = $donnees['Temperature'];
							$code = $donnees['Code'];
							$heurodatage = $donnees['Heurodatage'];
							$reponse->closeCursor();
							$prev++;
				?>
						<td>
						<table>
							<tr>
								<td align="center" class="taille2">
									D. Matin
								</td>
							</tr>
							<tr>
								<td align="center">
									<img src="img/<?php echo $code; ?>.png" width="140">
								</td>
							</tr>
							<tr>
								<td align="center" class="taille2">
									<?php echo (int)$temperature ?> C
								</td>
							</tr>
						</table>
					</td>
					<?php
						if($prev==2){
					?>
					<td>
						<img src="img/vide.png" height="40">
					</td>
					
				<?php
						}
						}
					}
					if($prev<2){
						$date = date('Y-m-d H:i:s', mktime(15, 0, 0, date('m'), date('d')+1, date('Y')));
						$reponse = $bdd->query('SELECT Heurodatage, Code, Temperature
												FROM Meteo
												WHERE Heurodatage = \'' . $date . '\'');
						$lignes = $reponse->rowCount();
						if($lignes == 1){
							$donnees = $reponse->fetch();
							$temperature = $donnees['Temperature'];
							$code = $donnees['Code'];
							$heurodatage = $donnees['Heurodatage'];
							$reponse->closeCursor();
							$prev++;
				?>
							<td>
							<table>
							<tr>
								<td align="center" class="taille2">
									D. Ap.Midi
								</td>
							</tr>
							<tr>
								<td align="center">
									<img src="img/<?php echo $code; ?>.png" width="140">
								</td>
							</tr>
							<tr>
								<td align="center" class="taille2">
									<?php echo (int)$temperature ?> C
								</td>
							</tr>
						</table>
						</td>
						<td>
						<img src="img/vide.png" height="40">
					</td>
				<?php
						}
					}
				?>
					
				</tr>
			</table>
		</td>
	</tr>
</table>