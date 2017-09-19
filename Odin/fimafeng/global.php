<div class="line">
	<div class="display_center">
		<?php
			$equipements_BDD = $bdd->query('SELECT 	Equipements.Id, Equipements.Nom, Equipements.Ip
											FROM Equipements');
			
			$Settings = array("R"=>255, "G"=>255, "B"=>255, "Dash"=>0, "DashR"=>255, "DashG"=>255, "DashB"=>255);
			$progressOptions = array("Width"=>165, "Height"=>15, "R"=>134, "G"=>209, "B"=>27, "Surrounding"=>20, "BoxBorderR"=>0, "BoxBorderG"=>0, "BoxBorderB"=>0, "BoxBackR"=>255, "BoxBackG"=>255, "BoxBackB"=>255, "RFade"=>255, "GFade"=>0, "BFade"=>0, "ShowLabel"=>TRUE, "LabelPos"=>LABEL_POS_LEFT);
			while($infos_equipement = $equipements_BDD->fetch()) {
		?>
		<div class="cadre_performances">
			<a href="/Odin/fimafeng.php?module=detail&id=<?php echo $infos_equipement['Id']; ?>" class="black">
				<div class="titre_sonde">
					<div class="lefttitre"></div>
					<?php echo $infos_equipement['Nom']; ?> 
				</div>
			</a>
			<div class="cadre_left">
				<div class="liner"></div>
				<div class="lefttitre"></div>
					<div class="donnees_performances">
						<div class="line">IP : <?php echo $infos_equipement['Ip']; ?></div>
						<div class="line"><div class="libelle_performances">Temp : </div><div class="barre_performances"><img src="progresstemp<?php echo $infos_equipement['Id']; ?>.png" class="graphique_barre_performances" /></div></div>
						<div class="line"><div class="libelle_performances">CPU : </div><div class="barre_performances"><img src="progresscpu<?php echo $infos_equipement['Id']; ?>.png" class="graphique_barre_performances" /></div></div>
						<div class="line"><div class="libelle_performances">RAM : </div><div class="barre_performances"><img src="progressram<?php echo $infos_equipement['Id']; ?>.png" class="graphique_barre_performances" /></div></div>
						<div class="line"><div class="libelle_performances">ROM : </div><div class="barre_performances"><img src="progressrom<?php echo $infos_equipement['Id']; ?>.png" class="graphique_barre_performances" /></div></div>
					</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>
			</div>
		</div>
		<div class="left1pct"></div>
		<?php
			}
			$equipements_BDD->closeCursor();
		?>
	</div>
</div>
<div class="liner"></div>