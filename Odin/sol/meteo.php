<div class="line">
	<div class="display_center">
		<?php
			$result = meteo_act_BDD($bdd);
		?>		
		<div class="cadre_meteo">
			<a href="/Odin/sol.php?module=meteo" class="black">
				<div class="titre_sonde">
					<div class="lefttitre"></div>
					Meteo
				</div>
			</a>
			<div class="cadre_center">
				<div class="liner"></div>
				<div class="lefttitre"></div>	
				<div class="inline">
					<img src="/img/<?php echo $result['code']; ?>.png" class="image_meteo"></img>
				</div>
				<div class="lefttitre"></div>
				<div class="inline">
					<div class="valeur_sonde">
						<?php echo (int)$result['temperature'] . '&deg;C'; ?>
					</div>
				</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>	
			</div>
		</div>
		<div class="left1pct"></div>
		<?php
			// ---- Informations du matin
			$prev = 0;
			$date = date('Y-m-d H:i:s', mktime(9, 0, 0, date('m'), date('d'), date('Y')));
			$result = prevision_BDD($bdd, $date);
			if(isset($result)) {
				$prev++;
				$code1 = $result['code'];
				$temperature1 = (int)$result['temperature'];
				$periode1 = 'Ce matin';
			}
			$date = date('Y-m-d H:i:s', mktime(15, 0, 0, date('m'), date('d'), date('Y')));
			$result = prevision_BDD($bdd, $date);
			if(isset($result)) {
				if($prev == 1) {
					$code2 = $result['code'];
					$temperature2 = (int)$result['temperature'];
					$periode2 = 'Cet apr&egrave;s midi';	
				}
				else {
					$code1 = $result['code'];
					$temperature1 = (int)$result['temperature'];
					$periode1 = 'Cet apr&egrave;s midi';
				}
				$prev++;
			}
			if($prev<2){
				$date = date('Y-m-d H:i:s', mktime(9, 0, 0, date('m'), date('d')+1, date('Y')));
				$result = prevision_BDD($bdd, $date);
				if(isset($result)) {
					if($prev == 1) {
						$code2 = $result['code'];
						$temperature2 = (int)$result['temperature'];
						$periode2 = 'Demain matin';
					}
					else {
						$code1 = $result['code'];
						$temperature1 = (int)$result['temperature'];
						$periode1 = 'Demain matin';
					}	
					$prev++;
				}
			}
			if($prev<2){
				$date = date('Y-m-d H:i:s', mktime(15, 0, 0, date('m'), date('d')+1, date('Y')));
				$result = prevision_BDD($bdd, $date);
				if(isset($result)) {
					$code2 = $result['code'];
					$temperature2 = (int)$result['temperature'];
					$periode2 = 'Demain apr&egrave;s midi';												
					$prev++;
				}
			}
			if(!isset($code1) and !isset($temperature1)) {
				$code1 = 'na';
				$temperature1 = '--';
			}
			if(!isset($code2) and !isset($temperature2)) {
				$code2 = 'na';
				$temperature2 = '--';
			}
		?>
		<div class="cadre_prevision24">
			<a href="/Odin/sol.php?module=meteo" class="black">
				<div class="titre_sonde">
					<div class="lefttitre"></div>
					Pr&eacute;visions 24h
				</div>
			</a>
			<div class="cadre_center">
				<div class="liner"></div>
				<div class="lefttitre"></div>
				<div class="colonne">
					<div class="valeur_sonde"><?php echo $periode1; ?></div>
					<div class="line"><img src="/img/<?php echo $code1; ?>.png" class="image_meteo"></img></div>
					<div class="valeur_sonde"><?php echo $temperature1 . '&deg;C'; ?></div>
				</div>
				<div class="lefttitre"></div>
				<div class="colonne">
					<div class="valeur_sonde"><?php echo $periode2; ?></div>
					<div class="line"><img src="/img/<?php echo $code2; ?>.png" class="image_meteo"></img></div>
					<div class="valeur_sonde"><?php echo $temperature2 . '&deg;C'; ?></div>
				</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>						
			</div>
		</div>
	</div>
</div>
<div class="liner"></div>
<div class="liner"></div>
<div class="liner"></div>
<div class="line">
	<div class="display_center">
		<div class="cadre_previsionsemaine">
			<a href="/Odin/sol.php?module=meteo" class="black">
				<div class="titre_sonde">
					<div class="lefttitre"></div>
					Pr&eacute;visions de la semaine
				</div>
			</a>
			<div class="cadre_center">
				<div class="liner"></div>
				<div class="lefttitre"></div>
				<?php
					// ---- Informations du matin
					$i = 0;
					while($i < 5) {
						$date = date('Y-m-d H:i:s', mktime(12, 0, 0, date('m'), date('d') + $i, date('Y')));
						$result = prevision_BDD($bdd, $date);
						if(isset($result)) {
							$code = $result['code'];
							$meteo_BDD = $bdd->query('	SELECT DAY(Heurodatage), MIN(Temperature) AS Minimum, MAX(Temperature) AS Maximum
																FROM Meteo 
																WHERE DAY(\'' . $date . '\') = DAY(Heurodatage)
																AND Id <> 1
																GROUP BY DAY(Heurodatage)');
							$infos_meteo = $meteo_BDD->fetch();
							$mini = $infos_meteo['Minimum'];
							$maxi = $infos_meteo['Maximum'];
							$meteo_BDD->closeCursor();
							if($i == 0) {
								$jour = 'Aujourd\'hui';
							}
							else {
								$jour = date('l', mktime(12, 0, 0, date('m'), date('d') + $i, date('Y')));
								switch ($jour) {
	    							case 'Monday':
   	     							$jour = 'Lundi';
      	  							break;
    								case 'Tuesday':
        								$jour = 'Mardi';
        								break;
        							case 'Wednesday':
        								$jour = 'Mercredi';
        								break;
	        						case 'Thursday':
   	     							$jour = 'Jeudi';
      	  							break;
        							case 'Friday':
        								$jour = 'Vendredi';
        								break;
        							case 'Saturday':
        								$jour = 'Samedi';
        								break;
	        						case 'Sunday':
   	     							$jour = 'Dimanche';
      	  							break;
								}
							}
				?>
							<div class="colonne">
								<div class="valeur_previsions"><?php echo $jour ?></div>
								<div class="line"><img src="/img/<?php echo $code; ?>.png" class="image_meteo"></img></div>
								<div class="valeur_previsions"><?php echo (int)$mini . '&deg;C'; ?>/<?php echo (int)$maxi . '&deg;C'; ?></div>
							</div>
							<div class="lefttitre"></div>
				<?php
						}
						$i++;					
					}
				?>
				<div class="liner"></div>
			</div>
		</div>
	</div>
</div>