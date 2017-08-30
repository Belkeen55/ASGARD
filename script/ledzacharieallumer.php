<?php
	// Création d'une nouvelle ressource cURL
	$ch = curl_init();
	
	// Configuration de l'URL et d'autres options
	curl_setopt($ch, CURLOPT_URL, "http://zacharie/led/gestionledallumer.php");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	
	// Récupération de l'URL et affichage sur le naviguateur
	curl_exec($ch);
	
	// Fermeture de la session cURL
	curl_close($ch);
?>