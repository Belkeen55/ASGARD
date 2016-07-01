<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- Chargement modules
	include("../../modules/BDD.php");
	
	$liste_joueurs = $bdd->query('	SELECT Formations.Poste, Joueurs.Nom, Joueurs.Note
									FROM Joueurs, Formations
									WHERE Formations.Joueur = Joueurs.Id
									AND Formations.Nom = \'' . $_POST['formation'] . '\'');
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
				if ($_SESSION['login'])	{
					// ---- Si l'utilisateur est loggé
			?>
			<tr>
				<!-- Chargement du menu de navigation -->
				<td class='taillemenu' valign="top" rowspan="2">
					<?php include('../menu.php'); ?>
				</td>
				<td align="center">
					<img src="/img/vide.png" height="50">
					<table border="1">
						<tr>
							<td colspan="3">
								<?php echo $_POST['formation']; ?>
							</td>
						</tr>
						<tr>
							<td>
								Poste
							</td>
							<td>
								Joueur
							</td>
							<td>
								Note
							</td>
						</tr>
						<?php
							while($infos_joueur = $liste_joueurs->fetch()) {
						?>
						<tr>
							<td>
								<?php echo $infos_joueur['Poste']; ?>
							</td>
							<td>
								<?php echo $infos_joueur['Nom']; ?>
							</td>
							<td>
								<?php echo $infos_joueur['Note']; ?>
							</td>
						</tr>
						<?php
							}
						?>
					</table>
			<?php				
				}
				else {
					echo "<script type='text/javascript'>document.location.replace('../../index.php');</script>";
				}
			?>
				</td>
			</tr>
		</table>
    </body>
</html>
