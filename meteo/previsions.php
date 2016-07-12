<?php
	// ---- Redirection toutes les 10 secondes
	header('Refresh: 10; url=chambre.php');
	
	// ---- Debug
	//ini_set('display_errors', 1);
	//error_reporting(E_ALL);
	
	// ---- Chargement des modules
	include('../modules/BDD.php');
	include('../modules/meteo.php');
	
	// ---- Test de présence de données
	$meteo_BDD = $bdd->query('	SELECT Id 
								FROM Meteo 
								WHERE Id = 2');
	$nb_lignes = $meteo_BDD->rowCount();
	if($nb_lignes == 0) {
		add_log($bdd, 202, 201);
		add_previsions_BDD($bdd);
	}
	$meteo_BDD->closeCursor();
	
	// ---- Verification du dernier rafraichissement
	$logs_BDD = $bdd->query('	SELECT * 
								FROM Logs 
								WHERE (Id_Codes = 202 OR Id_Codes = 201)
								ORDER BY Heurodatage DESC
								LIMIT 1');
	$infos_log = $logs_BDD->fetch();
	if($infos_log['Id_Codes'] == 202) {
		add_log($bdd, 202, 201);
		add_previsions_BDD($bdd);
	}
	$logs_BDD->closeCursor();
?>
<head>
	<link rel="stylesheet" href="/css/style.css" />
</head>	
<table class="page">
	<tr>
		<td align="center">
			<table>
				<tr>
					<td colspan="5" align="center" class="taille1">
						Previsions
					</td>
				</tr>
				<tr>
					<td>
						<img src="/img/vide.png" height="30">
					</td>
				</tr>
				<tr>
					<td>
					
					</td>
					<td>					
						<?php
							// ---- Informations du matin
							$prev = 0;
							$date = date('Y-m-d H:i:s', mktime(9, 0, 0, date('m'), date('d'), date('Y')));
							$result = prevision_BDD($bdd, $date);
							if(isset($result)) {
								$prev++;
						?>
						<table>
							<tr>
								<td align="center" class="taille2">
									Matin
								</td>
							</tr>
							<tr>
								<td align="center">
									<img src="/img/<?php echo $result['code']; ?>.png" width="140">
								</td>
							</tr>
							<tr>
								<td align="center" class="taille2">
									<?php echo (int)$result['temperature'] ?> C
								</td>
							</tr>
						</table>
					</td>
					<td>
						<img src="/img/vide.png" height="40">
					</td>
					<td>					
						<?php
							}
							// ---- Informations de l'après midi
							$date = date('Y-m-d H:i:s', mktime(15, 0, 0, date('m'), date('d'), date('Y')));
							$result = prevision_BDD($bdd, $date);
							if(isset($result)) {
								$prev++;
						?>
						<table>
							<tr>
								<td align="center" class="taille2">
									Ap. Midi
								</td>
							</tr>
							<tr>
								<td align="center">
									<img src="/img/<?php echo $result['code']; ?>.png" width="140">
								</td>
							</tr>
							<tr>
								<td align="center" class="taille2">
									<?php echo (int)$result['temperature'] ?> C
								</td>
							</tr>
						</table>
					</td>
					<td>
						<img src="/img/vide.png" height="40">
					</td>
					<td>
						<?php
							}
							// ---- Informations du lendemain matin
							if($prev<2){
								$date = date('Y-m-d H:i:s', mktime(9, 0, 0, date('m'), date('d')+1, date('Y')));
								$result = prevision_BDD($bdd, $date);
								if(isset($result)) {
									$prev++;
						?>
						<table>
							<tr>
								<td align="center" class="taille2">
									D. Matin
								</td>
							</tr>
							<tr>
								<td align="center">
									<img src="/img/<?php echo $result['code']; ?>.png" width="140">
								</td>
							</tr>
							<tr>
								<td align="center" class="taille2">
									<?php echo (int)$result['temperature'] ?> C
								</td>
							</tr>
						</table>
					</td>
					<td>
						<img src="/img/vide.png" height="40">
					</td>
					<td>
						<?php
								}
							}
							// ---- Informations du lendemain aprsè midi
							if($prev<2){
								$date = date('Y-m-d H:i:s', mktime(15, 0, 0, date('m'), date('d')+1, date('Y')));
								$result = prevision_BDD($bdd, $date);
								if(isset($result)) {
									$prev++;
						?>
						<table>
							<tr>
								<td align="center" class="taille2">
									D. Ap.Midi
								</td>
							</tr>
							<tr>
								<td align="center">
									<img src="/img/<?php echo $result['code']; ?>.png" width="140">
								</td>
							</tr>
							<tr>
								<td align="center" class="taille2">
									<?php echo (int)$result['temperature'] ?> C
								</td>
							</tr>
						</table>
					</td>
					<td>
						<img src="/img/vide.png" height="40">
					</td>
						<?php
								}
							}
							if($prev<2) {
								add_logs($bdd, 202, 201);
							}
						?>
				</tr>
			</table>
		</td>
	</tr>
</table>