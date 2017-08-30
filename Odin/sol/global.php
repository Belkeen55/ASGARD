<?php
	if(isset($_POST['action'])) {
		switch($_POST['action']) {
			case 'allumer'	:
				exec('/usr/bin/php /var/www/html/script/ledzacharieallumer.php');
				break;
			case 'eteindre' :
				exec('/usr/bin/php /var/www/html/script/ledzacharieeteindre.php');
				break;
		}
	}
?>
<div class="line">
	<div class="display_center">
		<?php
			$pieces_BDD = $bdd->query('SELECT Pieces.Id, Pieces.Nom 
												FROM Pieces, Equipements 
												WHERE DHT22 = 1
												AND Equipements.Id_Pieces = Pieces.Id');
			while($infos_piece = $pieces_BDD->fetch()) {
				$infos_sonde = donnees_piece_live($bdd, $infos_piece['Id']);
			//$infos = ['Tetat', 'temperature', 'Tideal', 'Hetat', 'humidite', 'Hideal', 'Retat', 'radiateur', 'reglage']
				if($infos_sonde['temperature'] <> -1) {
		?>
		<div class="inline-W200px">
			<a href="/Odin/sol.php?module=<?php echo strtolower($infos_piece['Nom']); ?>" class="black">
				<div class="titre">
					<div class="lefttitre"></div>
					<?php echo $infos_piece['Nom']; ?>
				</div>
			</a>
			<div class="cadre_center">
				<div class="liner"></div>
				<div class="colonne">
					<div class="line"><img src="/img/black/temperature<?php echo $infos_sonde['Tetat']; ?>.png" height="40"></img></div>
					<div class="liner"></div>
					<div class="line"><?php echo $infos_sonde['temperature']; ?>&deg;C</div>
				</div>
				<div class="lefttitre"></div>
				<div class="colonne">
					<div class="line"><img src="/img/black/humidity<?php echo $infos_sonde['Hetat']; ?>.png" height="40"></img></div>
					<div class="liner"></div>
					<div class="line"><?php echo $infos_sonde['humidite']; ?>%</div>
				</div>
				<div class="lefttitre"></div>	
				<div class="liner"></div>
			</div>
		</div>
		<div class="left1pct"></div>
		<?php
				}
				else {
		?>
		<div class="inline-W200px">
			<a href="/Odin/sol.php?module=<?php echo strtolower($infos_piece['Nom']); ?>" class="black">
				<div class="titre">
					<div class="lefttitre"></div>
					<?php echo $infos_piece['Nom']; ?>
				</div>
			</a>
			<div class="cadre_center">
				<div class="liner"></div>
				<div class="colonne">
					<div class="line">Equipement déconnecté</div>
					<div class="liner"></div>
				</div>
				<div class="liner"></div>
			</div>
		</div>
		<div class="left1pct"></div>
		<?php
				}
			}
			$pieces_BDD->closeCursor();
		?>
	</div>
</div>
<div class="liner"></div>
<div class="line">
	<div class="display_center">
		<div class="inline-W200px">
			<div class="titre">
				<div class="lefttitre"></div>
				Veilleuse Zacharie
			</div>
			<div class="cadre_center">
				<div class="liner"></div>
				<div class="colonne">
					<div class="line">Etat : </div>
					<div class="liner"></div>
					<div class="line">
						<form action="/Odin/sol.php" method="post">
							<input type="submit" value="Allumer"/>
							<input type="hidden" name="action" value="allumer">
						</form>
					</div>
					<div class="liner"></div>
					<form action="/Odin/sol.php" method="post">
							<input type="submit" value="Eteindre"/>
							<input type="hidden" name="action" value="eteindre">
						</form>
				</div>
				<div class="lefttitre"></div>	
				<div class="liner"></div>
			</div>
		</div>
		<div class="left1pct"></div>
	</div>
</div>
<div class="liner"></div>
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
					Pr&eacute;visions
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
					<div class="line"><?php echo $temperature2 . '&deg;C'; ?></img></div>
				</div>
				<div class="lefttitre"></div>
				<div class="liner"></div>						
			</div>
		</div>
	</div>
</div>