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
	
	function connect_bdd($login, $password) {
		$bdd = new PDO('mysql:host=mysql;dbname=ASGARD;charset=utf8', $login, $password);
		return $bdd;
	}
	
	$bdd = connect_bdd($loginSQL, $passwordSQL);
?>