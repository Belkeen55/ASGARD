<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- Chargement modules
	include('../../modules/BDD.php');
	
	$joueurs_BDD = $bdd->query('SELECT *
								FROM Joueurs
								WHERE Id = ' . $_POST['id']);
	$infos_joueur = $joueurs_BDD->fetch();
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
				<td class='taillemenu' valign="top">
					<?php include('../menu.php'); ?>
				</td>
				<td align="center">
					<img src="/img/vide.png" height="50">
					<table border="1">
						<form action="joueurs.php" method="post">
						<tr>
							<td colspan="8" align="center">
								Nom
							</td>
							<td colspan="8" align="center">
								Note
							</td>
						</tr>
						<tr>
							<td colspan="8" align="center">
								<input type="text" name="nom" value="<?php echo $infos_joueur["Nom"]; ?>" />
							</td>
							<td colspan="8" align="center">
								<input type="text" name="note" value="<?php echo $infos_joueur["Note"]; ?>" />
							</td>
						</tr>
						<tr>
							<td>
								<img src="/img/vide.png" height="30">
							</td>
						</tr>
						<tr>
							<td align="center">
								G
							</td>
							<td align="center">
								DD
							</td>
							<td align="center">
								DA
							</td>
							<td align="center">
								DG
							</td>
							<td align="center">
								MDD
							</td>
							<td align="center">
								MDA
							</td>
							<td align="center">
								MDG
							</td>
							<td align="center">
								MD
							</td>
							<td align="center">
								MA
							</td>
							<td align="center">
								MG
							</td>
							<td align="center">
								MOD
							</td>
							<td align="center">
								MOA
							</td>
							<td align="center">
								MOG
							</td>
							<td align="center">
								AD
							</td>
							<td align="center">
								AA
							</td>
							<td align="center">
								AG
							</td>
						</tr>
						<tr>
							<td align="center">
								<input type="checkbox" name="G" value="G" <?php if($infos_joueur['G'] == 1) { echo 'checked'; } ?> >
							</td>
							<td align="center">
								<input type="checkbox" name="DD" value="DD" <?php if($infos_joueur['DD'] == 1) { echo 'checked'; } ?>>
							</td>
							<td align="center">
								<input type="checkbox" name="DA" value="DA" <?php if($infos_joueur['DA'] == 1) { echo 'checked'; } ?>>
							</td>
							<td align="center">
								<input type="checkbox" name="DG" value="DG" <?php if($infos_joueur['DG'] == 1) { echo 'checked'; } ?>>
							</td>
							<td align="center">
								<input type="checkbox" name="MDD" value="MDD" <?php if($infos_joueur['MDD'] == 1) { echo 'checked'; } ?>>
							</td>
							<td align="center">
								<input type="checkbox" name="MDA" value="MDA" <?php if($infos_joueur['MDA'] == 1) { echo 'checked'; } ?>>
							</td>
							<td align="center">
								<input type="checkbox" name="MDG" value="MDG" <?php if($infos_joueur['MDG'] == 1) { echo 'checked'; } ?>>
							</td>
							<td align="center">
								<input type="checkbox" name="MD" value="MD" <?php if($infos_joueur['MD'] == 1) { echo 'checked'; } ?>>
							</td>
							<td align="center">
								<input type="checkbox" name="MA" value="MA" <?php if($infos_joueur['MA'] == 1) { echo 'checked'; } ?>>
							</td>
							<td align="center">
								<input type="checkbox" name="MG" value="MG" <?php if($infos_joueur['MG'] == 1) { echo 'checked'; } ?>>
							</td>
							<td align="center">
								<input type="checkbox" name="MOD" value="MOD" <?php if($infos_joueur['MOD'] == 1) { echo 'checked'; } ?>>
							</td>
							<td align="center">
								<input type="checkbox" name="MOA" value="MOA" <?php if($infos_joueur['MOA'] == 1) { echo 'checked'; } ?>>
							</td>
							<td align="center">
								<input type="checkbox" name="MOG" value="MOG" <?php if($infos_joueur['MOG'] == 1) { echo 'checked'; } ?>>
							</td>
							<td align="center">
								<input type="checkbox" name="AD" value="AD" <?php if($infos_joueur['AD'] == 1) { echo 'checked'; } ?>>
							</td>
							<td align="center">
								<input type="checkbox" name="AA" value="AA" <?php if($infos_joueur['AA'] == 1) { echo 'checked'; } ?>>
							</td>
							<td align="center">
								<input type="checkbox" name="AG" value="AG" <?php if($infos_joueur['AG'] == 1) { echo 'checked'; } ?>>
							</td>
						</tr>
						<tr>
							<td>
								<img src="/img/vide.png" height="30">
							</td>
						</tr>
						<tr>
							<td colspan="8" align="center">
								Indisponible
							</td>
						</tr>
						<tr>
							<td align="center">
								<input type="checkbox" name="indisponible" value="1" <?php if($infos_joueur['Indisponible'] == 1) { echo 'checked'; } ?>>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<input type="hidden" name="action" value="update" />
								<input type="hidden" name="id" value="<?php echo $infos_joueur["Id"]; ?>" />
								<input type="submit" value="Modifier" />
							</td>
							</form>
							<td>
								<form action="joueurs.php" method="post">
									<input type="hidden" name="action" value="delete" />
									<input type="hidden" name="id" value="<?php echo $infos_joueur["Id"]; ?>" />
									<input type="submit" value="Supprimer" />
								</form>
							</td>
						</tr>
					</table>
					<?php
							$joueurs_BDD->closeCursor();
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