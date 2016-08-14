<?php
	// ---- Redirection toutes les 10 secondes
	header('Refresh: 60; url=heure.php');
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- Chargement des modules
	include('/var/www/html/lib/BDD.php');

	// < 100 => Clonage à faire
	// < 200 > 100 => informations inexploitables
	// < 300 > 200 => Clonage OK
	// < 400 > 300 => Information OK
	// < 500 > 400 => Systeme à jour
	// < 600 > 500 => MAJ disponible
?>
<head>
	<link rel="stylesheet" href="/css/newstyle.css" />
</head>	
<body class="ecran_noir">
<?php
	$equipements_BDD = $bdd->query('	SELECT *
							 					FROM Equipements');
	while($infos_equipement = $equipements_BDD->fetch()) {
		$nb_warning = 0;	
		$logs_BDD = $bdd->query('	SELECT Logs.Heurodatage, Equipements.Nom, Logs.Id_Codes
								 			FROM Logs, Equipements, Codes
								 			WHERE Equipements.Id = Codes.Id_Equipements
								 			AND Codes.Id = Logs.Id_Codes
								 			AND Logs.Id_Codes < 100 
								 			AND Codes.Id_Equipements = ' . $infos_equipement['Id']);
		$nb_warning = $logs_BDD->rowCount();
		$logs_BDD->closeCursor();
		$logs_BDD = $bdd->query('	SELECT Logs.Heurodatage, Equipements.Nom, Logs.Id_Codes
								 			FROM Logs, Equipements, Codes
								 			WHERE Equipements.Id = Codes.Id_Equipements
								 			AND Codes.Id = Logs.Id_Codes
								 			AND (Logs.Id_Codes < 200 AND Logs.Id_Codes > 100)  
								 			AND Equipements.Id = ' . $infos_equipement['Id']);
		$nb_warning = $logs_BDD->rowCount() + $nb_warning;
		$logs_BDD->closeCursor();
		$logs_BDD = $bdd->query('	SELECT Logs.Heurodatage, Equipements.Nom, Logs.Id_Codes
								 			FROM Logs, Equipements, Codes
								 			WHERE Equipements.Id = Codes.Id_Equipements
								 			AND Codes.Id = Logs.Id_Codes
								 			AND (Logs.Id_Codes < 600 AND Logs.Id_Codes > 500)  
								 			AND Equipements.Id = ' . $infos_equipement['Id']);
		$nb_warning = $logs_BDD->rowCount() + $nb_warning;
		$logs_BDD->closeCursor();		
?>
			
				<?php 
					 
					if($nb_warning == 0) {
				?>
	<div>
		<div class="inline-W90px">
			<div class="font_15px">
				<?php echo $infos_equipement['Nom']; ?>
			</div>
		</div>
		<div class="OK"></div>
	</div>
				<?php
					}
					else {
				?>
	<div>
		<div class="inline-W90px">
			<div class="font_15px">
				<?php echo $infos_equipement['Nom']; ?>	
			</div>
		</div>
		<div class="KO"></div>
	</div>		
		<?php
					}
	}
	$equipements_BDD->closeCursor();
?>
		</body>