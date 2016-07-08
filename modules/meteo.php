<?php
	function add_previsions_BDD($bdd) {
		$dom = new DomDocument();
		if($dom->load('http://api.openweathermap.org/data/2.5/forecast?id=2972444&APPID=f2b5d95b18acabcaf7284639eb989fb8&mode=xml&units=metric')) {
			$prevision = $dom->getElementsByTagName("time");
			if($prevision->length != 0){
				$bdd->exec('DELETE FROM Meteo WHERE Id <> 1');
				$i = 2;
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
					
					if(isset($heuro)){
						$bdd->exec('INSERT INTO Meteo(Id, Heurodatage, Code, Temperature, Humidite) 
									VALUES(' . $i . ', \'' . $heuro . '\', \'' . $codeprev . '\', '. $tempprev . ', ' . $humprev . ')');
					}
					$i = $i + 1;
				}
				add_log($bdd, 3);
			}
			else {
				add_log($bdd, 5);
			}
		}
		else {
			add_log($bdd, 5);
		}
		
		
	}
	
	function donnees_sonde_live($ip) {
		$html = file_get_html('http://' . $ip);
		foreach($html->find('input[name=temperature]') as $element) 
		$temperature=$element->value;
		foreach($html->find('input[name=humidite]') as $element) 
		$humidite=$element->value;
		$donnees = [
			'temperature' => $temperature,
			'humidite' => $humidite
		];
		return $donnees;
	}
	
	function donnees_sonde_BDD($bdd, $ip) {
		$equipements_BDD = $bdd->query('SELECT Mesures.Id, Mesures.Tempint, Mesures.Humidite 
										FROM Mesures, Equipements 
										WHERE Equipements.Ip = \'' . $ip . '\' 
										AND Mesures.Id_Pieces = Equipements.Id_Pieces
										ORDER BY Mesures.Id DESC
										LIMIT 1');
		$infos_equipement = $equipements_BDD->fetch();
		$donnees = [
			'temperature' => $infos_equipement['Tempint'],
			'humidite' => $infos_equipement['Humidite']
		];
		$equipements_BDD->closeCursor();
		return $donnees;
	}
	
	function meteo_act_live() {
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
		$meteo = [
			'temperature' => $tempext,
			'humidite' => $humext,
			'code' => $code
		];
		return $meteo;
	}
	
	function meteo_act_BDD($bdd) {
		$reponse = $bdd->query('SELECT Code, Temperature, Humidite
								FROM Meteo
								WHERE Id = 1');
		$donnees = $reponse->fetch();
		$reponse->closeCursor();
		$result = [
			'temperature' => $donnees['Temperature'],
			'humidite' => $donnees['Humidite'],
			'code' => $donnees['Code']
		];
		return $result;
	}
	
	function prevision_BDD($bdd, $date) {
		$reponse = $bdd->query('SELECT Heurodatage, Code, Temperature
								FROM Meteo
								WHERE Heurodatage = \'' . $date . '\'');
		$lignes = $reponse->rowCount();
		if($lignes == 1){
			$donnees = $reponse->fetch();
			$temperature = $donnees['Temperature'];
			$code = $donnees['Code'];
			$heurodatage = $donnees['Heurodatage'];
			$reponse->closeCursor();
			$result = [
				'temperature' => $donnees['Temperature'],
				'code' => $donnees['Code']
			];
			return $result;
		}
	}
	
	function temperature_exterieure_BDD($bdd) {
		$reponse = $bdd->query('SELECT Id, Tempext 
					FROM Mesures
					WHERE Id_Pieces = 1
					ORDER BY Id DESC
					LIMIT 1');
		$donnees = $reponse->fetch();
		$reponse->closeCursor();
		$api = $donnees['Tempext'];
		return $api;
	}
	
	function etat_radiateur_BDD($bdd, $piece) {
		$reponse = $bdd->query('SELECT Radiateur 
								FROM Radiateurs 
								WHERE Id_Pieces = ' . $piece);
		$donnees = $reponse->fetch();
		$radiateur = $donnees['Radiateur'];
		$reponse->closeCursor();
		return $radiateur;
	}
	
	function last_24($bdd, $piece) {
		$heurodatage = date('Y-m-d H:i:s');
		$heurodatage24H = date('Y-m-d H:i:s', mktime(date('H')-24, date('i'), date('s'), date('m'), date('d'), date('Y')));
		$reponse = $bdd->query('SELECT *
								FROM Mesures 
								WHERE Heurodatage BETWEEN \'' . $heurodatage24H . '\' AND \'' . $heurodatage . '\'
								AND Id_Pieces = ' . $piece);
		return $reponse;
	}
	
	function donnees_piece_live($bdd, $piece) {
		$reponse = $bdd->query('SELECT Ip 
								FROM Equipements 
								WHERE Id_Type_Equip = 2
								AND Id_Pieces = ' . $piece);
		$donnees = $reponse->fetch();
		$ip = $donnees['Ip'];
		$reponse->closeCursor();
		$infos_sonde = donnees_sonde_live($ip);
		$reponse = $bdd->query('SELECT Radiateur 
								FROM Radiateurs 
								WHERE Id_Pieces = ' . $piece);
		$donnees = $reponse->fetch();
		$radiateur = $donnees['Radiateur'];
		$reponse->closeCursor();
		$reponse = $bdd->query('SELECT T_ideal, H_ideal 
								FROM Pieces
								WHERE Id = ' . $piece);
		$donnees = $reponse->fetch();
		$Tideal = $donnees['T_ideal'];
		$Hideal = $donnees['H_ideal'];
		$reponse->closeCursor();
		$Tmin = $Tideal*0.9;
		$Tmax = $Tideal*1.1;
		$Hmin = $Hideal*0.8;
		$Hmax = $Hideal*1.2;
		if($infos_sonde['temperature'] < $Tmin) 
		{
			$Tetat = 'low';
		}
		else
		{
			if(($infos_sonde['temperature'] > $Tmin) AND ($infos_sonde['temperature'] < $Tmax))
			{
				$Tetat = 'ok';
			}
			else
			{
				if($infos_sonde['temperature'] >= $Tmax)
				{
					$Tetat = 'high';
				}
			}
		}
		if($infos_sonde['humidite'] < $Hmin) 
		{
			$Hetat = 'low';
		}
		else
		{
			if(($infos_sonde['humidite'] > $Hmin) AND ($infos_sonde['humidite'] < $Hmax))
			{
				$Hetat = 'ok';
			}
			else
			{
				if($infos_sonde['humidite'] > $Hmax)
				{
					$Hetat = 'high';
				}
			}
		}
		$TRmin = (int)$infos_sonde['temperature'];
		$TRmax = (int)$infos_sonde['temperature']+1;
		$TiRmin = (int)temperature_exterieure_BDD($bdd);
		$TiRmax = (int)temperature_exterieure_BDD($bdd)+1;
		$reponse = $bdd->query('SELECT Id_Pieces, AVG(Radiateur) as Reglage 
								FROM Mesures
								WHERE Id_Pieces = ' . $piece . ' 
								AND Tempint > ' . $TRmin . '
								AND Tempint < ' . $TRmax . '
								AND Tempext > ' . $TiRmin . '
								AND Tempext < ' . $TiRmax . '
								GROUP BY Id_Pieces');
		$lignes = $reponse->rowCount();
		if($lignes == 0)
		{
			$reglage = 'NA';
			$Retat = 'ok';
		}
		else
		{
			$donnees = $reponse->fetch();
			$reglage = (int)$donnees['Reglage'];
			if($reglage-(int)$radiateur > 0)
			{
				$Retat = 'low';
			}
			else
			{
				if($reglage-(int)$radiateur < 0)
				{
					$Retat = 'high';
				}
				else
				{
					$Retat = 'ok';
				}
			}
		}
		$reponse->closeCursor();
		$infos = [
			'Tetat' => $Tetat,
			'temperature' => $infos_sonde['temperature'],
			'Tideal' => $Tideal,
			'Hetat' => $Hetat,
			'humidite' => $infos_sonde['humidite'],
			'Hideal' => $Hideal,
			'Retat' => $Retat,
			'radiateur' => $radiateur,
			'reglage' => $reglage
		];
		return $infos;
	}
	
	function donnees_piece_BDD($bdd, $piece) {
		$reponse = $bdd->query('SELECT Ip 
								FROM Equipements 
								WHERE Id_Type_Equip = 2
								AND Id_Pieces = ' . $piece);
		$donnees = $reponse->fetch();
		$ip = $donnees['Ip'];
		$reponse->closeCursor();
		$infos_sonde = donnees_sonde_BDD($bdd, $ip);
		$reponse = $bdd->query('SELECT Radiateur 
								FROM Radiateurs 
								WHERE Id_Pieces = ' . $piece);
		$donnees = $reponse->fetch();
		$radiateur = $donnees['Radiateur'];
		$reponse->closeCursor();
		$reponse = $bdd->query('SELECT T_ideal, H_ideal 
								FROM Pieces
								WHERE Id = ' . $piece);
		$donnees = $reponse->fetch();
		$Tideal = $donnees['T_ideal'];
		$Hideal = $donnees['H_ideal'];
		$reponse->closeCursor();
		$Tmin = $Tideal*0.9;
		$Tmax = $Tideal*1.1;
		$Hmin = $Hideal*0.8;
		$Hmax = $Hideal*1.2;
		if($infos_sonde['temperature'] < $Tmin) 
		{
			$Tetat = 'low';
		}
		else
		{
			if(($infos_sonde['temperature'] > $Tmin) AND ($infos_sonde['temperature'] < $Tmax))
			{
				$Tetat = 'ok';
			}
			else
			{
				if($infos_sonde['temperature'] >= $Tmax)
				{
					$Tetat = 'high';
				}
			}
		}
		if($infos_sonde['humidite'] < $Hmin) 
		{
			$Hetat = 'low';
		}
		else
		{
			if(($infos_sonde['humidite'] > $Hmin) AND ($infos_sonde['humidite'] < $Hmax))
			{
				$Hetat = 'ok';
			}
			else
			{
				if($infos_sonde['humidite'] > $Hmax)
				{
					$Hetat = 'high';
				}
			}
		}
		$TRmin = (int)$infos_sonde['temperature'];
		$TRmax = (int)$infos_sonde['temperature']+1;
		$TiRmin = (int)temperature_exterieure_BDD($bdd);
		$TiRmax = (int)temperature_exterieure_BDD($bdd)+1;
		$reponse = $bdd->query('SELECT Id_Pieces, AVG(Radiateur) as Reglage 
								FROM Mesures
								WHERE Id_Pieces = ' . $piece . ' 
								AND Tempint > ' . $TRmin . '
								AND Tempint < ' . $TRmax . '
								AND Tempext > ' . $TiRmin . '
								AND Tempext < ' . $TiRmax . '
								GROUP BY Id_Pieces');
		$lignes = $reponse->rowCount();
		if($lignes == 0)
		{
			$reglage = 'Pas dinformations';
			$Retat = 'ok';
		}
		else
		{
			$donnees = $reponse->fetch();
			$reglage = (int)$donnees['Reglage'];
			if($reglage-(int)$radiateur > 0)
			{
				$Retat = 'low';
			}
			else
			{
				if($reglage-(int)$radiateur < 0)
				{
					$Retat = 'high';
				}
				else
				{
					$Retat = 'ok';
				}
			}
		}
		$reponse->closeCursor();
		$infos = [
			'Tetat' => $Tetat,
			'temperature' => $infos_sonde['temperature'],
			'Tideal' => $Tideal,
			'Hetat' => $Hetat,
			'humidite' => $infos_sonde['humidite'],
			'Hideal' => $Hideal,
			'Retat' => $Retat,
			'radiateur' => $radiateur,
			'reglage' => $reglage
		];
		return $infos;
	}	
?>