<!/usr/bin/php>
<?php
	include('lib/simple_html_dom.php');
	
	$bdd = new PDO('mysql:host=localhost;dbname=ASGARD;charset=utf8', 'root', 'shiva77680');
	
	$dom = new DomDocument();
	$dom->load('http://api.openweathermap.org/data/2.5/weather?id=2972444&APPID=f2b5d95b18acabcaf7284639eb989fb8&mode=xml&units=metric');
	$balise = $dom->getElementsByTagName("temperature");
	foreach($balise as $valeur)
		$tempext=$valeur->getAttribute("value");
	
	$balise = $dom->getElementsByTagName("humidity");
	foreach($balise as $valeur)
		$humext=$valeur->getAttribute("value");
	
	$balise = $dom->getElementsByTagName("weather");
	foreach($balise as $valeur)
		$code=$valeur->getAttribute("icon");

	$pieces = $bdd->query('	SELECT Id 
							FROM Pieces');
	
	while($donnees_pieces = $pieces->fetch()) {
		
		$sondes = $bdd->query('	SELECT Ip
								FROM Equipements
								WHERE Id_Type_Equip = 2
								AND Id_Pieces = ' . $donnees_pieces['Id']);
		
		$lignes = $sondes->rowCount();
		
		if($lignes != 0) {
			$donnees_sondes = $sondes->fetch();
		
			$html = file_get_html('http://' . $donnees_sondes['Ip']);

			foreach($html->find('input[name=temperature]') as $element) 
			$temperature=$element->value;

			foreach($html->find('input[name=humidite]') as $element) 
			$humidite=$element->value;
		}
		
		$sondes->closeCursor();
		
		if(($temperature > 0) AND ($humidite > 0)) {
			$reponse = $bdd->query('SELECT Radiateur 
									FROM Radiateurs 
									WHERE Id_Pieces = ' . $donnees_pieces['Id']);
			$donnees = $reponse->fetch();
			$radiateur = $donnees['Radiateur'];
			$reponse->closeCursor();
		}
		
		if(isset($tempext)){
			$bdd->exec('INSERT INTO Mesures(Heurodatage, Tempint, Tempext, Radiateur, Humidite, Id_Pieces) 
						VALUES(NOW(), ' . $temperature . ', '. $tempext . ', ' . $radiateur . ', '. $humidite . ', ' . $donnees_pieces['Id'] . ')');
		}
	}
	
	$pieces->closeCursor();
	
	$dom->load('http://api.openweathermap.org/data/2.5/forecast?id=2972444&APPID=f2b5d95b18acabcaf7284639eb989fb8&mode=xml&units=metric');
	$prevision = $dom->getElementsByTagName("time");
	
	if((!empty($prevision)) AND (isset($tempext))){
		$bdd->exec('TRUNCATE TABLE Meteo');
		$bdd->exec('INSERT INTO Meteo(Id, Heurodatage, Code, Temperature, Humidite) 
					VALUES(1, NOW(), \'' . $code . '\', '. $tempext . ', ' . $humext . ')');
		$i = 1;
		foreach($prevision as $infos) {
			$heuro=$infos->getAttribute("from");
			
			$balise = $infos->getElementsByTagName("temperature");
			foreach($balise as $valeur)
				$tempprev=$valeur->getAttribute("value");
			
			$balise = $infos->getElementsByTagName("symbol");
			foreach($balise as $valeur)
				$codeprev=$valeur->getAttribute("var");
				
			$balise = $infos->getElementsByTagName("humidity");
			foreach($balise as $valeur)
				$humprev=$valeur->getAttribute("value");
			
			$i = $i + 1;
			if(isset($heuro)){
				$bdd->exec('INSERT INTO Meteo(Id, Heurodatage, Code, Temperature, Humidite) 
							VALUES(' . $i . ', \'' . $heuro . '\', \'' . $codeprev . '\', '. $tempprev . ', ' . $humprev . ')');
			}
		}
	}
?>
