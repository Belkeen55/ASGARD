<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- Chargement modules
	include("../../modules/BDD.php");
	
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
					<?php
						$bdd->exec('UPDATE Formations SET Joueur = 0');
						// ---- Extraction de toutes les formations
						$liste_formations = $bdd->query('	SELECT Nom 
															FROM Formations 
															GROUP BY Nom');
						// ---- Pour chaque formation
						while($nom_formation = $liste_formations->fetch()) {
							// ---- Extraction de tous les postes qui composent la formation
							$liste_postes = $bdd->query('	SELECT Id, Poste 
															FROM Formations 
															WHERE Nom = \'' . $nom_formation['Nom'] . '\'');
							// ---- Pour chaque poste de la formation
							while($nom_poste = $liste_postes->fetch()) {
								// ---- Recherche du meilleur joueur
								$liste_joueurs = $bdd->query('	SELECT Id, Nom, Note 
																FROM Joueurs
																WHERE `' . $nom_poste['Poste'] . '` = 1
																AND Selection = 0
																AND Indisponible = 0
																ORDER BY Note DESC
																LIMIT 1');
								if($liste_joueurs) {
									$nom_joueur = $liste_joueurs->fetch();
									$bdd->exec('UPDATE Joueurs SET Selection = 1 WHERE Id = ' . $nom_joueur['Id']);
									$bdd->exec('UPDATE Formations SET Joueur = ' . $nom_joueur['Id'] . ' WHERE Id = ' . $nom_poste['Id']);
									$liste_joueurs->closeCursor();
								}
							}
							$bdd->exec('UPDATE Joueurs SET Selection = 0');
							$liste_postes->closeCursor();
						}
						$liste_formations->closeCursor();
						$liste_compositions = $bdd->query('	SELECT Formations.Nom, AVG(Joueurs.Note) AS Moyenne
															FROM Joueurs, Formations
															WHERE Formations.Joueur = Joueurs.Id
															GROUP BY Formations.Nom
															ORDER BY Moyenne DESC');
					?>
					<table border="1">
						<tr>
							<td>
								Formation
							</td>
							<td>
								Moyenne
							</td>
							<td>
								Voir
							</td>
						</tr>
						<?php
							while($infos_composition = $liste_compositions->fetch()) {
						?>
						<form action="composition.php" method="post">
						<tr>
							<td>
								<?php echo $infos_composition['Nom']; ?>
							</td>
							<td>
								<?php echo $infos_composition['Moyenne']; ?>
							</td>
							<td>
								<input type="hidden" name="formation" value="<?php echo $infos_composition['Nom']; ?>" />
								<input type="submit" value="Voir" />
							</td>
						</tr>
						</form>
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
