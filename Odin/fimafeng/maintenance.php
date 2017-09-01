<?php
	//----------------------------------------------------------------------------------
	//			Recuperation des informations de l'equipement dispo en BDD
	//----------------------------------------------------------------------------------
	$equipements_BDD = $bdd->query('SELECT Equipements.Nom, MAJ.Etat
									FROM Equipements, MAJ
									WHERE Equipements.Id = MAJ.Id');
	$nombre_equipements = $equipements_BDD->rowCount();
?>
<div class="liner"></div>
<div class="line">
	<div class="display_center">
		<div class="inline-W350px">
			<div class="titre">
				<div class="lefttitre"></div>
				<div class="inline-45pct-left">Mise à jour à faire</div>
			</div>			
			<div class="cadre_left">
				<div class="liner"></div>
				<div class="lefttitre"></div>
					<div class="colonne">
						<?php
							if($nombre_equipements != 0) {
								while($infos_equipement = $equipements_BDD->fetch()) {
						?>
											<div class="line"><?php echo $infos_equipement['Nom'] . ' : ' . $infos_equipement['Etat']; ?></div>
						<?php
								}
								$equipements_BDD->closeCursor();
							}
						?>
					</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>
			</div>
		</div>
		<div class="inline-W250px">
			<div class="titre">
				<div class="lefttitre"></div>
				<div class="inline-45pct-left">Surcharge CPU</div>
			</div>			
			<div class="cadre_left">
				<div class="liner"></div>
				<div class="lefttitre"></div>
					<div class="colonne">
						<?php
							$equipements_BDD = $bdd->query('SELECT Equipements.Nom, CPU_Warning.Etat
															FROM Equipements, CPU_Warning
															WHERE Equipements.Id = CPU_Warning.Id');
							$nombre_equipements = $equipements_BDD->rowCount();
							if($nombre_equipements != 0) {
								while($infos_equipement = $equipements_BDD->fetch()) {
						?>
									<div class="line"><?php echo $infos_equipement['Nom'] . ' : ' . $infos_equipement['Etat'] . '%'; ?></div>
						<?php
								}
							}
							$equipements_BDD->closeCursor();
						?>
					</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>
			</div>
		</div>
		<div class="inline-W250px">
			<div class="titre">
				<div class="lefttitre"></div>
				<div class="inline-45pct-left">Surcharge RAM</div>
			</div>			
			<div class="cadre_left">
				<div class="liner"></div>
				<div class="lefttitre"></div>
					<div class="colonne">
						<?php
							$equipements_BDD = $bdd->query('SELECT Equipements.Nom, Ram_Warning.Etat
															FROM Equipements, Ram_Warning
															WHERE Equipements.Id = Ram_Warning.Id');
							$nombre_equipements = $equipements_BDD->rowCount();
							if($nombre_equipements != 0) {
								while($infos_equipement = $equipements_BDD->fetch()) {
						?>
									<div class="line"><?php echo $infos_equipement['Nom'] . ' : ' . $infos_equipement['Etat'] . '%'; ?></div>
						<?php
								}
							}
							$equipements_BDD->closeCursor();
						?>
					</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>
			</div>
		</div>
		<div class="inline-W250px">
			<div class="titre">
				<div class="lefttitre"></div>
				<div class="inline-45pct-left">Uptime</div>
			</div>			
			<div class="cadre_left">
				<div class="liner"></div>
				<div class="lefttitre"></div>
					<div class="colonne">
						<?php
							$equipements_BDD = $bdd->query('SELECT Equipements.Nom, Uptime_Warning.Etat
															FROM Equipements, Uptime_Warning
															WHERE Equipements.Id = Uptime_Warning.Id');
							$nombre_equipements = $equipements_BDD->rowCount();
							if($nombre_equipements != 0) {
								while($infos_equipement = $equipements_BDD->fetch()) {
						?>
									<div class="line"><?php echo $infos_equipement['Nom'] . ' : ' . $infos_equipement['Etat'] . '%'; ?></div>
						<?php
								}
							}
							$equipements_BDD->closeCursor();
						?>
					</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>
			</div>
		</div>
	</div>
</div>