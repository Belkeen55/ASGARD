<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- Chargement modules
	include("../../modules/BDD.php");
	
	function position($tableau, $poste, $nb) {
		if($tableau[$poste] == 1) {
			if($nb != 0) {
				echo ', ' . $poste;
			}
			else {
				echo $poste;
				++$nb;
			}
		}
		return $nb;
	}
	
	function utile($variable) {
		if(isset($variable)) {
			return $variable;
		}
		else {
			return 0;
		}
	}
	
	// ---- Gestion du POST
	if(isset($_POST['action'])) {
		if(isset($_POST['G'])) {
			$G = 1;
		}
		else {
			$G = 0;
		}
		
		if(isset($_POST['DD'])) {
			$DD = 1;
		}
		else {
			$DD = 0;
		}
		
		if(isset($_POST['DA'])) {
			$DA = 1;
		}
		else {
			$DA = 0;
		}
		
		if(isset($_POST['DG'])) {
			$DG = 1;
		}
		else {
			$DG = 0;
		}
		
		if(isset($_POST['MDD'])) {
			$MDD = 1;
		}
		else {
			$MDD = 0;
		}
		
		if(isset($_POST['MDA'])) {
			$MDA = 1;
		}
		else {
			$MDA = 0;
		}
		
		if(isset($_POST['MDG'])) {
			$MDG = 1;
		}
		else {
			$MDG = 0;
		}
		if(isset($_POST['MD'])) {
			$MD = 1;
		}
		else {
			$MD = 0;
		}
		
		if(isset($_POST['MA'])) {
			$MA = 1;
		}
		else {
			$MA = 0;
		}
		
		if(isset($_POST['MG'])) {
			$MG = 1;
		}
		else {
			$MG = 0;
		}
		
		if(isset($_POST['MOD'])) {
			$MOD = 1;
		}
		else {
			$MOD = 0;
		}
		
		if(isset($_POST['MOA'])) {
			$MOA = 1;
		}
		else {
			$MOA = 0;
		}
		
		if(isset($_POST['MOG'])) {
			$MOG = 1;
		}
		else {
			$MOG = 0;
		}
		if(isset($_POST['AD'])) {
			$AD = 1;
		}
		else {
			$AD = 0;
		}
		if(isset($_POST['AA'])) {
			$AA = 1;
		}
		else {
			$AA = 0;
		}
		if(isset($_POST['AG'])) {
			$AG = 1;
		}
		else {
			$AG = 0;
		}
		if(isset($_POST['indisponible'])) {
			$indisponible = 1;
		}
		else {
			$indisponible = 0;
		}
		if($_POST['action'] == 'add') {
			$bdd->exec('INSERT INTO Joueurs(Nom, Note, G, DD, DA, DG, MDD, MDA, MDG, MD, MA, MG, `MOD`, MOA, MOG, AD, AA, AG, 
											Selection, Indisponible) 
						VALUES(\'' . $_POST['nom'] . '\',' . $_POST['note'] . ', ' . $G . ', ' . $DD . ', '
								. $DA . ', ' . $DG . ', ' . $MDD . ', ' . $MDA . ', ' 
								. $MDG . ', ' . $MD . ', ' . $MA . ', ' . $MG . ', ' 
								. $MOD . ', ' . $MOA . ', ' . $MDG . ', ' . $AD . ', ' 
								. $AA . ', ' . $AG . ', 0, 0)');
		}
		if($_POST['action'] == 'update') {
			$bdd->exec('UPDATE Joueurs
						SET Nom = \'' . $_POST['nom'] . '\', 
						Note = ' . $_POST['note'] . ', 
						G = ' . $G . ', 
						DD = ' . $DD . ',
						DA = ' . $DA . ', 
						DG = ' . $DG . ', 
						MDD = ' . $MDD . ',
						MDA = ' . $MDA . ', 
						MDG = ' . $MDG . ', 
						MD = ' . $MD . ',
						MA = ' . $MA . ', 
						MG = ' . $MG . ', 
						`MOD` = ' . $MOD . ',
						MOA = ' . $MOA . ', 
						MOG = ' . $MOG . ', 
						AD = ' . $AD . ',
						AA = ' . $AA . ', 
						AG = ' . $AG . ', 
						Selection = 0, 
						Indisponible = ' . $indisponible . ' 
						WHERE Id = ' . $_POST['id']);
		}
		if($_POST['action'] == 'delete') {
			$bdd->exec('DELETE FROM Joueurs WHERE Id = ' . $_POST['id']);
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
					<?php include('../menu.php'); ?>
				</td>
				<td align="center">
					<img src="/img/vide.png" height="50">
					<table>
						<tr>
							<td>
								Gestion des joueurs
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
								Liste des Joueurs
							</td>
						</tr>
						<tr>
							<td>
								Joueur
							</td>
							<td>
								Note
							</td>
							<td>
								Positions
							</td>
							<td>
								Indisponible
							</td>
							<td>
								Action
							</td>
						</tr>
						<?php
							$joueurs_BDD = $bdd->query('	SELECT *
															FROM Joueurs');
							while($infos_joueur = $joueurs_BDD->fetch()) {
							?>
						<tr>
							<td align="center">
								<?php echo $infos_joueur['Nom']; ?>
							</td>
							<td align="center">
								<?php echo $infos_joueur['Note']; ?>
							</td>
							<td align="center">
								<?php 
									$nb = position($infos_joueur, 'G', 0);
									$nb = position($infos_joueur, 'DD', $nb);
									$nb = position($infos_joueur, 'DA', $nb);
									$nb = position($infos_joueur, 'DG', $nb);
									$nb = position($infos_joueur, 'MD', $nb);
									$nb = position($infos_joueur, 'MA', $nb);
									$nb = position($infos_joueur, 'MG', $nb);
									$nb = position($infos_joueur, 'MDD', $nb);
									$nb = position($infos_joueur, 'MDA', $nb);
									$nb = position($infos_joueur, 'MDG', $nb);
									$nb = position($infos_joueur, 'MOD', $nb);
									$nb = position($infos_joueur, 'MOA', $nb);
									$nb = position($infos_joueur, 'MOG', $nb);
									$nb = position($infos_joueur, 'AD', $nb);
									$nb = position($infos_joueur, 'AA', $nb);
									$nb = position($infos_joueur, 'AG', $nb);
								?>
							</td>
							<td align="center">
								<?php echo $infos_joueur['Indisponible']; ?>
							</td>
							<td>
								<form action="view.php" method="post">
									<input type="hidden" name="id" value="<?php echo $infos_joueur['Id']; ?>" />
									<input type="submit" value="Modifier" />
								</form>
							</td>
						</tr>
						<?php
							}
							$joueurs_BDD->closeCursor();
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