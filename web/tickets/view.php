<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- Chargement modules
	include('../../modules/BDD.php');
	
	$tickets_BDD = $bdd->query('SELECT Id, Heurodatage, Titre, Id_Modules, Id_Devs, Id_Etapes, Deploiement, Commentaires
								FROM Taches
								WHERE Id = ' . $_POST['id']);
	$infos_ticket = $tickets_BDD->fetch();
	$tickets_BDD->closeCursor();
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
				<td class='taillemenu' valign="top">
					<?php include('../menu.php'); ?>
				</td>
				<td align="center">
					<img src="/img/vide.png" height="50">
					<table>
						<form action="../tickets.php" method="post">
						<tr>
							<td colspan="2" align="center">
								Titre
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="text" name="titre" size="50" value="<?php echo $infos_ticket['Titre']; ?>" />
							</td>
						</tr>
						<tr>
							<td>
								<img src="/img/vide.png" height="30">
							</td>
						</tr>
						<tr>
							<td align="center">
								Module
							</td>
							<td align="center">
								Type
							</td>
						</tr>
						<tr>
							<td align="center">
								<select name="module">
									<?php
										$modules_BDD = $bdd->query('SELECT Id, Nom
																	FROM Modules');
										while ($infos_module = $modules_BDD->fetch()) {
											if($infos_module['Id'] == $infos_ticket['Id_Modules']) {
												echo '<option value="' . $infos_module['Id'] . '" selected>' . $infos_module['Nom'] . '</option>';
											}
											else {
												echo '<option value="' . $infos_module['Id'] . '">' . $infos_module['Nom'] . '</option>';
											}
										}
										$modules_BDD->closeCursor();
										
									?>
								</select>
							</td>
							<td align="center">
								<select name="type">
									<?php
										$devs_BDD = $bdd->query('	SELECT Id, Nom
																	FROM Devs');
										while ($infos_dev = $devs_BDD->fetch()) {
											if($infos_dev['Id'] == $infos_ticket['Id_Devs']) {
												echo '<option value="' . $infos_dev['Id'] . '" selected>' . $infos_dev['Nom'] . '</option>';
											}
											else {
												echo '<option value="' . $infos_dev['Id'] . '">' . $infos_dev['Nom'] . '</option>';
											}
										}
										$devs_BDD->closeCursor();
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<img src="/img/vide.png" height="30">
							</td>
						</tr>
						<tr>
							<td colspan="2">
								Description
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="commentaire" rows="10" cols="50"><?php echo $infos_ticket['Commentaires']; ?></textarea>
							</td>
						</tr>
						<tr>
							<td>
								<img src="/img/vide.png" height="30">
							</td>
						</tr>
						
						<tr>
							<td align="center">
								Etat
							</td>
						</tr>
						<tr>
							<td align="center">
								<select name="etape">
									<?php
										$etapes_BDD = $bdd->query('SELECT Id, Nom
																	FROM Etapes');
										while ($infos_etape = $etapes_BDD->fetch()) {
											if($infos_etape['Id'] == $infos_ticket['Id_Etapes']) {
												echo '<option value="' . $infos_etape['Id'] . '" selected>' . $infos_etape['Nom'] . '</option>';
											}
											else {
												echo '<option value="' . $infos_etape['Id'] . '">' . $infos_etape['Nom'] . '</option>';
											}
										}
										$etapes_BDD->closeCursor();
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<img src="/img/vide.png" height="30">
							</td>
						</tr>
						<tr>
							<td align="center">
								<input type="hidden" name="action" value="update" />
								<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>" />
								<input type="submit" value="Update" />
								</form>
							</td>
							<td align="center">
								<form action="../tickets.php" method="post">
									<input type="submit" value="Retour" />
								</form>
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