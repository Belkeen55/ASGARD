<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- Chargement modules
	include("../../modules/BDD.php");
	
	// ---- Gestion du POST
	if(isset($_POST['action'])) {
		if($_POST['action'] == 'add') {
			$bdd->exec('INSERT INTO Equipements(Nom, Ip, Commentaires, Id_Pieces, Id_Type_Equip) 
						VALUES(\'' . str_replace('\'', '\'\'', $_POST['nom']) . '\', 
							\'' . $_POST['ip'] . '\', \'' . str_replace('\'', '\'\'', $_POST['commentaire']) . '\', ' . $_POST['location'] . ', 
							' . $_POST['type'] . ')');
		}
		if($_POST['action'] == 'update') {
			$bdd->exec('UPDATE Equipements
						SET Nom = \'' . str_replace('\'', '\'\'', $_POST['nom']) . '\', 
						Ip = \'' . $_POST['ip'] . '\', 
						Commentaires = \'' . str_replace('\'', '\'\'', $_POST['commentaire']) . '\', 
						Id_Pieces = ' . $_POST['location'] . ', 
						Id_Type_Equip = ' . $_POST['type'] . '
						WHERE Id = ' . $_POST['id']);
		}
		if($_POST['action'] == 'clonage') {
			$clonage = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m')+1, date('d'), date('Y')));
			$bdd->exec('UPDATE Equipements
						SET Clonage = \'' . $clonage . '\' 
						WHERE Id = ' . $_POST['id']);
			add_log($bdd, $_POST['id'] + 300, $_POST['id']);
		}
	}
?>
<html>
    <head>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="/css/style.css" />
        <title>ASGARD</title>
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
					<table>
						<tr>
							<td>
								Gestion des equipements
							</td>
						</tr>
						<tr>
							<td align="center">
								<form action="add.php" method="post">
									<input type="submit" value="Ajout" />
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
								Liste des equipements
							</td>
						</tr>
						<tr>
							<td>
								Nom
							</td>
							<td>
								Ip
							</td>
							<td>
								Commentaire
							</td>
							<td>
								Location
							</td>
							<td>
								Type
							</td>
						</tr>
						<?php
							$equipements_BDD = $bdd->query('SELECT 	Equipements.Id, Equipements.Nom, Equipements.Ip, Equipements.Commentaires, 
																	Pieces.Nom AS Location, Type_Equip.Nom AS Type
															FROM Equipements, Pieces, Type_Equip
															WHERE Equipements.Id_Pieces = Pieces.Id
															AND Equipements.Id_Type_Equip = Type_Equip.Id');
							while($infos_equipement = $equipements_BDD->fetch()) {
							?>
						<tr>
							<td align="center">
								<?php echo $infos_equipement['Nom']; ?>
							</td>
							<td align="center">
								<?php echo $infos_equipement['Ip']; ?>
							</td>
							<td align="center">
								<?php echo $infos_equipement['Commentaires']; ?>
							</td>
							<td align="center">
								<?php echo $infos_equipement['Location']; ?>
							</td>
							<td align="center">
								<?php echo $infos_equipement['Type']; ?>
							</td>
							<td>
								<form action="view.php" method="post">
									<input type="hidden" name="id" value="<?php echo $infos_equipement['Id']; ?>" />
									<input type="submit" value="Ouvrir" />
								</form>
							</td>
						</tr>
						<?php
							}
							$equipements_BDD->closeCursor();
						?>
					</table>
					<?php
						}
						else
						{
							echo "<script type='text/javascript'>document.location.replace('../../index.php');</script>";
						}
					?>
				</td>
			</tr>
		</table>

    </body>
</html>