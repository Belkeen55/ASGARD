<?php
	if(!isset($_SESSION['login'])) {
		$_SESSION['login'] = false;
	}
	if(!$_SESSION['login']) {
		if(isset($_COOKIE['infos'])) {
			if($_COOKIE['infos'] == 'BelkhomeLogin') {
				$_SESSION['login'] = True;
			}
		}
		else {
			$equipements_BDD = $bdd->query('SELECT Id, Nom, Ip, Adresse, Commentaires, Clonage, Id_Pieces, Id_Typ_Equip, DHT22
											FROM Equipements
											WHERE Adresse = \'' . $_SERVER["REMOTE_ADDR"] . '\'');
			$volume = $equipements_BDD->rowCount();
			$equipements_BDD->closeCursor();
			if($volume <> 0) {
				$_SESSION['login'] = True;
			}
		}
		if(!$_SESSION['login']) {
			// ---- Si l'utilisateur est loggé
			echo "<script type='text/javascript'>document.location.replace('/index.php');</script>";
		}
	}
?>