<?php
	include('SQL.php');
	
	function cryptage($passwd){
		return 'PASSWORD(\'rudy' . sha1($passwd) . 'laura\')';
	}
	
	function add_log($bdd, $code_add, $code_suppr) {
		$bdd->exec('DELETE FROM Logs 
					WHERE Id_Codes = ' . $code_add . '
					OR Id_Codes = ' . $code_suppr);
		$bdd->exec('INSERT INTO Logs(Heurodatage, Id_Codes) 
		VALUES(NOW(), ' . $code_add . ')');
	}
	function suppr_log($bdd) {
		$heurodatageold = date('Y-m-d H:i:s', mktime(date('H')-24, date('i'), date('s'), date('m'), date('d'), date('Y')));
		$bdd->exec('DELETE FROM Logs 
					WHERE Heurodatage < \'' . $heurodatageold . '\'');
		$heurodatageold = date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m')-1, date('d'), date('Y')));
		$bdd->exec('DELETE FROM Performances 
					WHERE Heurodatage < \'' . $heurodatageold . '\'');
	}
	
	function logs($bdd, $code) {
		$bdd->exec('INSERT INTO Logs(Heurodatage, Id_Codes) 
						VALUES(NOW(), ' . $code . ')');
	}
	
	function connect_bdd($serveur, $base, $login, $password) {
		$bdd = new PDO('mysql:host=' . $serveur . ';dbname='. $base . ';charset=utf8', $login, $password);
		return $bdd;
	}
	
	function structure_SQL($dbh) {
		// Création de table des utilisateurs
		$req = $dbh->exec(	"CREATE TABLE `utilisateurs` (
		    				`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
							`login` VARCHAR(255) UNIQUE NOT NULL ,
							`password` VARCHAR(255) NOT NULL)");
							
		$req = $dbh->exec(	"CREATE TABLE Typ_Equip(
					        `Id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					        `Nom` VARCHAR(255) UNIQUE NOT NULL ,
					        `Image` VARCHAR(255))");
					        
		$req = $dbh->exec(	"CREATE TABLE Pieces(
        					`Id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
        					`Nom` VARCHAR(255) UNIQUE NOT NULL ,
        					`T_ideal` DECIMAL(25,2) ,
        					`H_ideal` DECIMAL(25,2))");
        					
        $req = $dbh->exec(	"CREATE TABLE Equipements(
						    `Id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
						    `Nom` VARCHAR(255) UNIQUE NOT NULL ,
						    `Ip` VARCHAR(255) UNIQUE NOT NULL ,
						    `Commentaires` TEXT ,
						    `Id_Pieces` INT ,
						    `Id_Typ_Equip` INT NOT NULL)");

		$req = $dbh->exec(	"ALTER TABLE Equipements ADD CONSTRAINT FK_Equipements_Id_Pieces FOREIGN KEY (Id_Pieces) REFERENCES Pieces(Id)");
		$req = $dbh->exec(	"ALTER TABLE Equipements ADD CONSTRAINT FK_Equipements_Id_Typ_Equip FOREIGN KEY (Id_Typ_Equip) REFERENCES Typ_Equip(Id)");
		
	}
	
	$bdd = connect_bdd($serveurSQL, $baseSQL, $loginSQL, $passwordSQL);
?>