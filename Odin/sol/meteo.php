<div class="line">
	<div class="display_center">
		<?php
			$result = meteo_act_BDD($bdd);
		?>		
		<div class="inline-H146px">
			<a href="/Odin/sol.php?module=meteo" class="black">
				<div class="titre">
					<div class="lefttitre"></div>
					Meteo
				</div>
			</a>
			<div class="cadre_center">
				<div class="liner"></div>
				<div class="lefttitre"></div>	
				<div class="inline">
					<img src="/img/<?php echo $result['code']; ?>.png" height=78></img>
				</div>
				<div class="lefttitre"></div>
				<div class="inline">
					<div class="t1">
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
		<div class="inline-H146px">
			<a href="/Odin/sol.php?module=meteo" class="black">
				<div class="titre">
					<div class="lefttitre"></div>
					Pr&eacute;visions 24h
				</div>
			</a>
			<div class="cadre_center">
				<div class="liner"></div>
				<div class="lefttitre"></div>
				<div class="colonne">
					<div class="line"><?php echo $periode1; ?></div>
					<div class="line"><img src="/img/<?php echo $code1; ?>.png" height=60></img></div>
					<div class="line"><?php echo $temperature1 . '&deg;C'; ?></div>
				</div>
				<div class="lefttitre"></div>
				<div class="colonne">
					<div class="line"><?php echo $periode2; ?></div>
					<div class="line"><img src="/img/<?php echo $code2; ?>.png" height=60></img></div>
					<div class="line"><?php echo $temperature2 . '&deg;C'; ?></div>
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
		<div class="inline-H146px">
			<a href="/Odin/sol.php?module=meteo" class="black">
				<div class="titre">
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
								<div class="line"><?php echo $jour ?></div>
								<div class="line"><img src="/img/<?php echo $code; ?>.png" height=60></img></div>
								<div class="line"><?php echo (int)$mini . '&deg;C'; ?>/<?php echo (int)$maxi . '&deg;C'; ?></div>
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
<div class="liner"></div>
<div class="liner"></div>
<div class="liner"></div>
<div class="line">
	<div class="full-screen">
		<a href="/Odin/fimafeng.php?module=sol" class="black">
			<div class="titre">
				<div class="lefttitre"></div>
				Logs
			</div>
		</a>
		<div class="cadre_left">
			<div class="liner"></div>
			<?php
				$logs_BDD = $bdd->query('	SELECT Logs.Heurodatage, Codes.Commentaire, Codes.Warning, Equipements.Nom 
											FROM Logs, Equipements, Codes
											WHERE Logs.Id_Codes = Codes.Id
											AND Codes.Id_Equipements = Equipements.Id
											AND (Codes.Id > 200 AND Codes.Id < 300)
											ORDER BY Logs.Heurodatage');
				while($infos_log = $logs_BDD->fetch()) {
					if($infos_log['Warning']) {
						$warning = 'KO';
					}
					else {
						$warning = 'OK';
					}
			?>
					<div class="line">
						<img src="/img/log_<?php echo $warning; ?>.png" height=10></img>
						<?php echo $infos_log['Heurodatage']; ?> : <?php echo $infos_log['Nom']; ?> >> <?php echo $infos_log['Commentaire']; ?>
					</div>
			<?php
				}
				$logs_BDD->closeCursor();
			?>
			<div class="liner"></div>
		</div>
	</div>
</div>