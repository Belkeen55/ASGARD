<div class="line">
	<div class="display_center">
		<?php
			$pieces_BDD = $bdd->query('	SELECT Distinct Id_Pieces 
										FROM Mesures');
			$nombre_pieces = $pieces_BDD->rowCount();
			$heurodatage = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y')));
			$heurodatage5 = date('Y-m-d H:i:s', mktime(date('H'), date('i')-5, date('s'), date('m'), date('d'), date('Y')));
			if($nombre_pieces != 0) {
				while($infos_piece = $pieces_BDD->fetch()) {
					$mesures_BDD = $bdd->query('	SELECT Mesures.Id, Mesures.Tempint, Mesures.Humidite, Pieces.Nom, Mesures.Heurodatage 
													FROM Mesures, Pieces 
													WHERE Mesures.Id_Pieces = ' . $infos_piece['Id_Pieces'] . ' 
													AND Mesures.Id_Pieces = Pieces.Id 
													AND Mesures.Heurodatage BETWEEN \'' . $heurodatage5 . '\' AND \'' . $heurodatage . '\' 
													ORDER BY Mesures.Id DESC 
													LIMIT 1');
					$nombre_mesures = $mesures_BDD->rowCount();
					if($nombre_mesures != 0) {
						$infos_mesure = $mesures_BDD->fetch();
						$reponse = $bdd->query('SELECT T_ideal, H_ideal 
												FROM Pieces
												WHERE Id = ' . $infos_piece['Id_Pieces']);
						$donnees = $reponse->fetch();
						$Tideal = $donnees['T_ideal'];
						$Hideal = $donnees['H_ideal'];
						$reponse->closeCursor();
						$Tmin = $Tideal*0.9;
						$Tmax = $Tideal*1.1;
						$Hmin = $Hideal*0.8;
						$Hmax = $Hideal*1.2;
						if($infos_mesure['Tempint'] <= $Tmin) 
						{
							$Tetat = 'low';
						}
						else
						{
							if(($infos_mesure['Tempint'] > $Tmin) AND ($infos_mesure['Tempint'] < $Tmax))
							{
								$Tetat = 'ok';
							}
							else
							{
								if($infos_mesure['Tempint'] >= $Tmax)
								{
									$Tetat = 'high';
								}
							}
						}
						if($infos_mesure['Humidite'] < $Hmin) 
						{
							$Hetat = 'low';
						}
						else
						{
							if(($infos_mesure['Humidite'] > $Hmin) AND ($infos_mesure['Humidite'] < $Hmax))
							{
								$Hetat = 'ok';
							}
							else
							{
								if($infos_mesure['Humidite'] > $Hmax)
								{
									$Hetat = 'high';
								}
							}
						}
						$reponse->closeCursor();
		?>
						<div class="cadre_sonde">
							<a href="/Odin/sol.php?module=<?php echo strtolower($infos_mesure['Nom']); ?>" class="black">
								<div class="titre_sonde">
									<div class="lefttitre"></div>
									<?php echo $infos_mesure['Nom']; ?>
								</div>
							</a>
							<div class="cadre_center">
								<div class="liner"></div>
								<div class="colonne">
									<div class="line"><img src="/img/black/temperature<?php echo $Tetat; ?>.png" class="image_sonde"></img></div>
									<div class="liner"></div>
									<div class="valeur_sonde"><?php echo $infos_mesure['Tempint']; ?>&deg;C</div>
								</div>
								<div class="lefttitre"></div>
								<div class="colonne">
									<div class="line"><img src="/img/black/humidity<?php echo $Hetat; ?>.png" class="image_sonde"></img></div>
									<div class="liner"></div>
									<div class="valeur_sonde"><?php echo $infos_mesure['Humidite']; ?>%</div>
								</div>
								<div class="lefttitre"></div>	
								<div class="liner"></div>
							</div>
						</div>
						<div class="left1pct"></div>
		<?php
					}
					$mesures_BDD->closeCursor();
				}
				$pieces_BDD->closeCursor();
			}
		?>
<div class="liner"></div>
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
					Pr&eacute;visions
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
					<div class="valeur_sonde"><?php echo $temperature2 . '&deg;C'; ?></img></div>
				</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>						
			</div>
		</div>
	</div>
</div>