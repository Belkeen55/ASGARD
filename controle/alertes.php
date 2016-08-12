<?php
	// ---- Redirection toutes les 10 secondes
	header('Refresh: 60; url=heure.php');
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- Chargement des modules
	include('/var/www/html/lib/BDD.php');
	
	$logs_BDD = $bdd->query('SELECT Logs.Heurodatage, Codes.Commentaire, Equipements.Nom
							 FROM Logs, Codes, Equipements
							 WHERE Logs.Id_Codes = Codes.Id
							 AND Equipements.Id = Codes.Id_Equipements
							 AND Codes.Warning = 1');
	$nb_warning = $logs_BDD->rowCount();
	if($nb_warning == 0) {
		echo "<script type='text/javascript'>document.location.replace('heure.php');</script>";
	}
	else {
?>
<head>
	<link rel="stylesheet" href="/css/newstyle.css" />
</head>	
<body class="ecran_noir">
	<div class="line_H10px"></div>
	<table>
		<?php
			while($infos_log = $logs_BDD->fetch()) {
		?>
		<div class="font_15px">
			<?php echo $infos_log['Nom'] . ' >> ' . $infos_log['Commentaire'] ?>
		</div>
		<?php
			}
	}
	$logs_BDD->closeCursor();
?>
</body>