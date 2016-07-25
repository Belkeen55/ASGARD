<?php
	if(isset($_GET['nom'])) {
		if(isset($_GET['G'])) {
			$G = 1;
		}
		else {
			$G = 0;
		}
		
		if(isset($_GET['DD'])) {
			$DD = 1;
		}
		else {
			$DD = 0;
		}
		
		if(isset($_GET['DA'])) {
			$DA = 1;
		}
		else {
			$DA = 0;
		}
		
		if(isset($_GET['DG'])) {
			$DG = 1;
		}
		else {
			$DG = 0;
		}
		
		if(isset($_GET['MDD'])) {
			$MDD = 1;
		}
		else {
			$MDD = 0;
		}
		
		if(isset($_GET['MDA'])) {
			$MDA = 1;
		}
		else {
			$MDA = 0;
		}
		
		if(isset($_GET['MDG'])) {
			$MDG = 1;
		}
		else {
			$MDG = 0;
		}
		if(isset($_GET['MD'])) {
			$MD = 1;
		}
		else {
			$MD = 0;
		}
		
		if(isset($_GET['MA'])) {
			$MA = 1;
		}
		else {
			$MA = 0;
		}
		
		if(isset($_GET['MG'])) {
			$MG = 1;
		}
		else {
			$MG = 0;
		}
		
		if(isset($_GET['MOD'])) {
			$MOD = 1;
		}
		else {
			$MOD = 0;
		}
		
		if(isset($_GET['MOA'])) {
			$MOA = 1;
		}
		else {
			$MOA = 0;
		}
		
		if(isset($_GET['MOG'])) {
			$MOG = 1;
		}
		else {
			$MOG = 0;
		}
		if(isset($_GET['AD'])) {
			$AD = 1;
		}
		else {
			$AD = 0;
		}
		if(isset($_GET['AA'])) {
			$AA = 1;
		}
		else {
			$AA = 0;
		}
		if(isset($_GET['AG'])) {
			$AG = 1;
		}
		else {
			$AG = 0;
		}
		if(isset($_GET['indisponible'])) {
			$indisponible = 1;
		}
		else {
			$indisponible = 0;
		}
		if(isset($_GET['update'])) {
			$bdd->exec('UPDATE Joueurs
						SET Nom = \'' . $_GET['nom'] . '\', 
						Note = ' . $_GET['note'] . ', 
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
						WHERE Id = ' . $_GET['id']);
		}
		if(isset($_GET['add'])) {
			$bdd->exec('INSERT INTO Joueurs(Nom, Note, G, DD, DA, DG, MDD, MDA, MDG, MD, MA, MG, `MOD`, MOA, MOG, AD, AA, AG, 
											Selection, Indisponible) 
						VALUES(\'' . $_GET['nom'] . '\',' . $_GET['note'] . ', ' . $G . ', ' . $DD . ', '
								. $DA . ', ' . $DG . ', ' . $MDD . ', ' . $MDA . ', ' 
								. $MDG . ', ' . $MD . ', ' . $MA . ', ' . $MG . ', ' 
								. $MOD . ', ' . $MOA . ', ' . $MOG . ', ' . $AD . ', ' 
								. $AA . ', ' . $AG . ', 0, 0)');
		}
		echo "<script type='text/javascript'>window.close();</script>";
	}
	if(isset($_GET['supprimer'])) {
		$bdd->exec('DELETE FROM Joueurs WHERE Id = ' . $_GET['id']);
		echo "<script type='text/javascript'>window.close();</script>";
	}
	if(isset($_GET['retour'])) {
		echo "<script type='text/javascript'>window.close();</script>";
	}
	if(isset($_GET['id'])) {
		$joueurs_BDD = $bdd->query('SELECT *
									FROM Joueurs
									WHERE Id = ' . $_GET['id']);
		$infos_joueur = $joueurs_BDD->fetch();
		$joueurs_BDD->closeCursor();
	}
	if(isset($_GET['create'])) {
		$nom = '';
		$note = '';
		$G = '';
		$DD = '';
		$DA = '';
		$DG = '';
		$MDD = '';
		$MDA = '';
		$MDG = '';
		$MD = '';
		$MA = '';
		$MG = '';
		$MOD = '';
		$MOA = '';
		$MOG = '';
		$AD = '';
		$AA = '';
		$AG = '';
		$indisponible = '';
		$libelle = 'Create';
	}
	else {
		$nom = $infos_joueur['Nom'];
		$note = $infos_joueur['Note'];
		$G = $infos_joueur['G'];
		$DD = $infos_joueur['DD'];
		$DA = $infos_joueur['DA'];
		$DG = $infos_joueur['DG'];
		$MDD = $infos_joueur['MDD'];
		$MDA = $infos_joueur['MDA'];
		$MDG = $infos_joueur['MDG'];
		$MD = $infos_joueur['MD'];
		$MA = $infos_joueur['MA'];
		$MG = $infos_joueur['MG'];
		$MOD = $infos_joueur['MDD'];
		$MOA = $infos_joueur['MOA'];
		$MOG = $infos_joueur['MOG'];
		$AD = $infos_joueur['AD'];
		$AA = $infos_joueur['AA'];
		$AG = $infos_joueur['AG'];
		$indisponible = $infos_joueur['Indisponible'];
		$libelle = 'Update';
	}
?>
<div class="liner"></div>
<div class="line">
	<form action="popup.php" method="get">
	<div class="inline-20-Left">Nom</div>
	<div class="inline-20-Left">
		<input type="text" name="nom" size="25" value="<?php echo $nom; ?>">
	</div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">Note</div>
	<div class="inline-20-Left"><input type="text" name="note" size="25" value="<?php echo $note; ?>"></div>
</div>
<div class="liner"></div>
<div class="line">
	<table>
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
				<input type="checkbox" name="G" value="G" <?php if($G == 1) { echo 'checked'; } ?> >
			</td>
			<td align="center">
				<input type="checkbox" name="DD" value="DD" <?php if($DD == 1) { echo 'checked'; } ?>>
			</td>
			<td align="center">
				<input type="checkbox" name="DA" value="DA" <?php if($DA == 1) { echo 'checked'; } ?>>
			</td>
			<td align="center">
				<input type="checkbox" name="DG" value="DG" <?php if($DG == 1) { echo 'checked'; } ?>>
			</td>
			<td align="center">
				<input type="checkbox" name="MDD" value="MDD" <?php if($MDD == 1) { echo 'checked'; } ?>>
			</td>
			<td align="center">
				<input type="checkbox" name="MDA" value="MDA" <?php if($MDA == 1) { echo 'checked'; } ?>>
			</td>
			<td align="center">
				<input type="checkbox" name="MDG" value="MDG" <?php if($MDG == 1) { echo 'checked'; } ?>>
			</td>
			<td align="center">
				<input type="checkbox" name="MD" value="MD" <?php if($MD == 1) { echo 'checked'; } ?>>
			</td>
			<td align="center">
				<input type="checkbox" name="MA" value="MA" <?php if($MA == 1) { echo 'checked'; } ?>>
			</td>
			<td align="center">
				<input type="checkbox" name="MG" value="MG" <?php if($MG == 1) { echo 'checked'; } ?>>
			</td>
			<td align="center">
				<input type="checkbox" name="MOD" value="MOD" <?php if($MOD == 1) { echo 'checked'; } ?>>
			</td>
			<td align="center">
				<input type="checkbox" name="MOA" value="MOA" <?php if($MOA == 1) { echo 'checked'; } ?>>
			</td>
			<td align="center">
				<input type="checkbox" name="MOG" value="MOG" <?php if($MOG == 1) { echo 'checked'; } ?>>
			</td>
			<td align="center">
				<input type="checkbox" name="AD" value="AD" <?php if($AD == 1) { echo 'checked'; } ?>>
			</td>
			<td align="center">
				<input type="checkbox" name="AA" value="AA" <?php if($AA == 1) { echo 'checked'; } ?>>
			</td>
			<td align="center">
				<input type="checkbox" name="AG" value="AG" <?php if($AG == 1) { echo 'checked'; } ?>>
			</td>
		</tr>
	</table
</div>
<div class="liner"></div>
<div class="line">
	<div class="inline-20-Left">Repos</div>
	<div class="inline-20-Left">
		<input type="checkbox" name="indisponible" value="1" <?php if($indisponible == 1) { echo 'checked'; } ?>>
	</div>
</div>
<div class="liner"></div>
<div class="display_center">
	<div class="line">
		<div class="inline">
			<?php
				if(isset($_GET['id'])) {
			?>
				<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"> 
			<?php
				}
			?>
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="type" value="joueur">
			<input type="hidden" name="close" value="TRUE">
			<?php
				if(isset($_GET['id'])) {
			?>
				<input type="hidden" name="update" value="TRUE">
			<?php
				}
				else {
			?>
				<input type="hidden" name="add" value="TRUE">
			<?php
				}
			?>
			<input type="submit" value="<?php echo $libelle; ?>">
			</form>
		</div>
		<?php
			if(isset($_GET['id'])) {
		?>
		<div class="inline">
			<form action="popup.php" method="get">
				<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
				<input type="hidden" name="action" value="edit">
				<input type="hidden" name="type" value="joueur">
				<input type="hidden" name="supprimer" value="TRUE">
				<input type="hidden" name="close" value="TRUE">
				<input type="submit" value="Supprimer">
			</form>
		</div>
		<?php
			}
		?>
		<div class="inline">
			<form action="popup.php" method="get">
				<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
				<input type="hidden" name="action" value="edit">
				<input type="hidden" name="type" value="joueur">
				<input type="hidden" name="retour" value="TRUE">
				<input type="submit" value="Annuler">
			</form>
		</div>
	</div>
</div>