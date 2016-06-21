<!/usr/bin/php>
<?php
	include('/var/www/html/modules/connexionBDD.php');
	$reponse = $bdd->query('SELECT Id 
							FROM Mesures 
							WHERE YEAR(Heurodatage) = YEAR(NOW())
							AND MONTH(Heurodatage) = MONTH(NOW())
							AND DAY(Heurodatage) = DAY(NOW())
							AND HOUR(Heurodatage) = HOUR(NOW())');
	$donnees = $reponse->rowCount();
	if($donnees<2) {
		$heurodatage = date('d-m-Y H:i:s');
		echo $heurodatage . '-> connexion BDD /n';
		include('add_DHT.php');
	}
	$reponse->closeCursor();
?>
