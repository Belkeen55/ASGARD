<?php
	include('SQL.php');
	
	function connect_bdd($login, $password) {
		$bdd = new PDO('mysql:host=localhost;dbname=ASGARD;charset=utf8', $login, $password);
		return $bdd;
	}
	
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
	function suppr_log($bdd, $code) {
		$bdd->exec('DELETE FROM Logs 
					WHERE Id_Codes = ' . $code);
	}
	
	function logs($bdd, $code) {
		$bdd->exec('INSERT INTO Logs(Heurodatage, Id_Codes) 
						VALUES(NOW(), ' . $code . ')');
	}
	
	$bdd = connect_bdd($loginSQL, $passwordSQL);
?>