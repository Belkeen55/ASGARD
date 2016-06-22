<?php
	include('SQL.php');
	
	function connect_bdd($login, $password) {
		$bdd = new PDO('mysql:host=localhost;dbname=ASGARD;charset=utf8', $login, $password);
		return $bdd;
	}
	
	function cryptage($passwd){
		return 'PASSWORD(\'rudy' . sha1($passwd) . 'laura\')';
	}
	
	$bdd = connect_bdd($loginSQL, $passwordSQL);
?>