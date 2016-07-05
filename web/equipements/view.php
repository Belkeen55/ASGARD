<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- Chargement modules
	include('../../modules/BDD.php');
	
	$equipements_BDD = $bdd->query('SELECT Id, Nom, Ip, Commentaires, Id_Pieces, Id_Type_Equip
									FROM Equipements
									WHERE Id = ' . $_POST['id']);
	$infos_equipement = $equipements_BDD->fetch();
	$equipements_BDD->closeCursor();
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
					<table>
						<form action="equipements.php" method="post">
						<tr>
							<td align="center">
								Nom
							</td>
							<td align="center">
								IP
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="nom" size="25" value="<?php echo $infos_equipement['Nom']; ?>" />
							</td>
							<td>
								<input type="text" name="ip" size="25" value="<?php echo $infos_equipement['Ip']; ?>" />
							</td>
						</tr>
						<tr>
							<td>
								<img src="/img/vide.png" height="30">
							</td>
						</tr>
						<tr>
							<td align="center">
								Location
							</td>
							<td align="center">
								Type
							</td>
						</tr>
						<tr>
							<td align="center">
								<select name="location">
									<?php
										$pieces_BDD = $bdd->query('	SELECT Id, Nom
																	FROM Pieces');
										while ($infos_piece = $pieces_BDD->fetch()) {
											if($infos_piece['Id'] == $infos_equipement['Id_Pieces']) {
												echo '<option value="' . $infos_piece['Id'] . '" selected>' . $infos_piece['Nom'] . '</option>';
											}
											else {
												echo '<option value="' . $infos_piece['Id'] . '">' . $infos_piece['Nom'] . '</option>';
											}
										}
										$pieces_BDD->closeCursor();
										
									?>
								</select>
							</td>
							<td align="center">
								<select name="type">
									<?php
										$type_equip_BDD = $bdd->query('	SELECT Id, Nom
																	FROM Type_Equip');
										while ($infos_type_equip = $type_equip_BDD->fetch()) {
											if($infos_type_equip['Id'] == $infos_equipement['Id_Type_Equip']) {
												echo '<option value="' . $infos_type_equip['Id'] . '" selected>' . $infos_type_equip['Nom'] . '</option>';
											}
											else {
												echo '<option value="' . $infos_type_equip['Id'] . '">' . $infos_type_equip['Nom'] . '</option>';
											}
										}
										$type_equip_BDD->closeCursor();
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
								Commentaires
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="commentaire" rows="1" cols="60"><?php echo $infos_equipement['Commentaires']; ?></textarea>
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
								<form action="equipements.php" method="post">
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