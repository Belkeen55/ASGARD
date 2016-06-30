<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- Chargement modules
	include("../modules/BDD.php");
	
	// ---- Gestion du POST
	if(isset($_POST['action'])) {
		if($_POST['action'] == 'add') {
			$bdd->exec('INSERT INTO Taches(Heurodatage, Titre, Commentaires, Id_Devs, Id_Etapes, Id_Modules) 
						VALUES(NOW(), \'' . str_replace('\'', '\'\'', $_POST['titre']) . '\', \'' . str_replace('\'', '\'\'', $_POST['commentaire']) . '\', ' . $_POST['type'] . ', 1, ' . $_POST['module'] . ')');
		}
		if($_POST['action'] == 'update') {
			if($_POST['etape'] == 6) {
				$bdd->exec('UPDATE Taches
							SET Titre = \'' . str_replace('\'', '\'\'', $_POST['titre']) . '\', 
							Commentaires = \'' . str_replace('\'', '\'\'', $_POST['commentaire']) . '\', 
							Id_Devs = ' . $_POST['type'] . ', 
							Id_Modules = ' . $_POST['module'] . ',
							Id_Etapes = ' . $_POST['etape'] . ', 
							Deploiement = NOW() 
							WHERE Id = ' . $_POST['id']);
			}
			else {
				$bdd->exec('UPDATE Taches
							SET Titre = \'' . str_replace('\'', '\'\'', $_POST['titre']) . '\', 
							Commentaires = \'' . str_replace('\'', '\'\'', $_POST['commentaire']) . '\', 
							Id_Devs = ' . $_POST['type'] . ', 
							Id_Modules = ' . $_POST['module'] . ',
							Id_Etapes = ' . $_POST['etape'] . ' 
							WHERE Id = ' . $_POST['id']);
			}
		}
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
				if ($_SESSION['login'])	{
					// ---- Si l'utilisateur est loggé
			?>
			<tr>
				<!-- Chargement du menu de navigation -->
				<td class='taillemenu' valign="top" rowspan="2">
					<?php include('menu.php'); ?>
				</td>
				<td align="center">
					<img src="/img/vide.png" height="50">
					<table>
						<tr>
							<td>
								Gestion des tickets
							</td>
						</tr>
						<tr>
							<td align="center">
								<form action="tickets/add.php" method="post">
									<input type="submit" value="Ajout ticket" />
								</form>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center">
					<table border="1">
						<tr>
							<td colspan="8">
								Liste des tickets
							</td>
						</tr>
						<tr>
							<td>
								Id
							</td>
							<td>
								Creation
							</td>
							<td>
								Titre
							</td>
							<td>
								Module
							</td>
							<td>
								Type
							</td>
							<td>
								Etat
							</td>
							<td>
								Deploiement
							</td>
							<td>
								Action
							</td>
						</tr>
						<?php
							$tickets_BDD = $bdd->query('	SELECT Taches.Id, Taches.Heurodatage, Taches.Titre, Modules.Nom AS Module, Devs.Nom AS Type, Etapes.Nom AS Etape, Taches.Deploiement
															FROM Taches, Modules, Devs, Etapes
															WHERE Taches.Id_Devs = Devs.Id
															AND Taches.Id_Etapes = Etapes.Id
															AND Taches.Id_Modules = Modules.Id');
							while($infos_ticket = $tickets_BDD->fetch()) {
							?>
						<tr>
							<td align="center">
								<?php echo $infos_ticket['Id']; ?>
							</td>
							<td align="center">
								<?php echo $infos_ticket['Heurodatage']; ?>
							</td>
							<td align="center">
								<?php echo $infos_ticket['Titre']; ?>
							</td>
							<td align="center">
								<?php echo $infos_ticket['Module']; ?>
							</td>
							<td align="center">
								<?php echo $infos_ticket['Type']; ?>
							</td>
							<td align="center">
								<?php echo $infos_ticket['Etape']; ?>
							</td>
							<td align="center">
								<?php 
									if($infos_ticket['Deploiement'] == NULL) {
										echo 'NA';
									}
									else
									{
										echo $infos_ticket['Deploiement']; 
									}
								?>
							</td>
							<td>
								<form action="tickets/view.php" method="post">
									<input type="hidden" name="id" value="<?php echo $infos_ticket['Id']; ?>" />
									<input type="submit" value="Ouvrir" />
								</form>
							</td>
						</tr>
						<?php
							}
							$tickets_BDD->closeCursor();
						?>
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