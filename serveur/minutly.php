<!/usr/bin/php>
<?php
	// ---- Chargement des librairies
	include('/var/www/html/lib/simple_html_dom.php');
	include('/var/www/html/lib/BDD.php');
	
	// ---- On teste la présence de mesure de moins d'une heure
	$equipements_BDD = $bdd->query('SELECT Id, Ip, DHT22, Id_Pieces 
									FROM Equipements');
	while($infos_equipement = $equipements_BDD->fetch()) {
		$DHT22Temp = '';
		$html = file_get_html('http://' . $infos_equipement['Ip'] . '/script/systeme.php');
		foreach($html->find('input[name=cpu]') as $element) 
		$cpu=$element->value;
		foreach($html->find('input[name=ram]') as $element) 
		$ram=$element->value;
		foreach($html->find('input[name=disque]') as $element) 
		$disque=$element->value;
		foreach($html->find('input[name=temperature]') as $element) 
		$temperature=$element->value;
		foreach($html->find('input[name=DHT22Temp]') as $element) 
		$DHT22Temp=$element->value;
		if($DHT22Temp != '') {
			foreach($html->find('input[name=DHT22Hum]') as $element) 
			$DHT22Hum=$element->value;
			$heurodatage = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m')+1, date('d'), date('Y')));
			$bdd->exec('INSERT INTO `Mesures`(`Id`, `Heurodatage`, `Tempint`, `Humidite`, `Id_Pieces`) 
						VALUES (null,\'' . $heurodatage . '\',' . $DHT22Temp . ',' . $DHT22Hum . ',' . $infos_equipement['Id_Pieces'] . ')');
			$bdd->exec('UPDATE Equipements
						SET DHT22 = 1
						WHERE Id = ' . $infos_equipement['Id']);
		} 
		else {
			$bdd->exec('UPDATE Equipements
						SET DHT22 = 0
						WHERE Id = ' . $infos_equipement['Id']);
		}
		$bdd->exec('INSERT INTO Performances(Heurodatage, Cpu, Ram, Temperature, Disque, Id_Equipements) 
					VALUES(NOW(), ' . $cpu . ', ' . $ram . ', ' . $temperature . ', ' . $disque . ', ' . $infos_equipement['Id'] . ')');
	}
	$equipements_BDD->closeCursor();
?>
