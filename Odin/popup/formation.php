<?php
	$liste_joueurs = $bdd->query('	SELECT Formations.Poste, Joueurs.Nom, Joueurs.Note
									FROM Joueurs, Formations
									WHERE Formations.Joueur = Joueurs.Id
									AND Formations.Nom = \'' . $_GET['nom'] . '\'');
?>
<table border="1">
	<tr>
		<td colspan="3">
			<?php echo $_GET['nom']; ?>
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