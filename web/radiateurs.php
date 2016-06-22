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
	
	// ---- Si un post est dispo, on met à jour la BSS
	if(isset($_POST['conf_radiateur']))
	{
		$bdd->exec('UPDATE Radiateurs SET Radiateur =' . $_POST['conf_radiateur'] . ' WHERE Id_Pieces = ' . $_POST['piece']);
	}
?>
<html>
    <head>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="/css/style.css" />
        <title>ASGARD - Radiateurs</title>
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
							<td>
								<table class="cadre">
								<?php
									$radiateur = etat_radiateur($bdd, 1);
								?>
									<tr>
										<td rowspan="4" align="center" valign="middle"><img src="/img/bebe.png" height="64"></td>
										<td rowspan="4"><img src="/img/vide.png" height="32"></td>
										<td align="center">Radiateur chambre</td>
									</tr>
									<tr>
										<form action="radiateurs.php" method="post">
										<td colspan="2" align="center"><input type="range" name="conf_radiateur" value="<?php echo $radiateur; ?>" max="5" min="0" step="1" oninput="document.getElementById('AfficheRange').textContent=value" /></td>
									</tr>
									<tr>
										<td align="center">
											<span id="AfficheRange"><?php echo (int)$radiateur; ?></span>
										</td>
									</tr>
									<tr>
										<td align="center">
											<input type="submit" value="Enregistrer" />
											<input type="hidden" name="piece" value="1" />
											</form>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<td rowspan="4"><img src="/img/vide.png" height="75"></td>
							</td>
						</tr>
						<?php
							$reponse = $bdd->query('SELECT Radiateur 
										FROM Radiateurs 
										WHERE Id_Pieces = 2');
							$donnees = $reponse->fetch();
							$radiateur = $donnees['Radiateur'];
							$reponse->closeCursor();
						?>		
						<tr>
							<td>
								<table class="cadre">
									<tr>
										<td rowspan="4" align="center" valign="middle"><img src="/img/salon.png" width="64"></td>
										<td rowspan="4"><img src="/img/vide.png" height="32"></td>
										<td align="center">Radiateur salon</td>
									</tr>
									<tr>
										<form action="radiateurs.php" method="post">
										<td colspan="2" align="center"><input type="range" name="conf_radiateur" value="<?php echo $radiateur; ?>" max="5" min="0" step="1" oninput="document.getElementById('AfficheRange2').textContent=value" /></td>
									</tr>
									<tr>
										<td align="center">
											<span id="AfficheRange2"><?php echo (int)$radiateur; ?></span>
										</td>
									</tr>
									<tr>
										<td align="center">
											<input type="submit" value="Enregistrer" />
											<input type="hidden" name="piece" value="2" />
											</form>
										</td>
									</tr>
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