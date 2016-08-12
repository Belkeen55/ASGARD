<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL); 
	
	// ---- chargement des librairies
	include('../lib/BDD.php');
	
	if (!$_SESSION['login']) {
		// ---- Si l'utilisateur n'est pas loggé
		echo "<script type='text/javascript'>document.location.replace('../index.php');</script>";
	}
	else {
?>
			<html>
				<head>
					<?php include('commun/head.php'); ?>
				</head>
				<body class="ecran_blanc" <?php if(isset($_GET['close'])) { echo 'onunload="window.opener.location.reload(true);"'; } ?>>
					<div class="redline"></div>
					<div class="header">
						<?php include('commun/header.php'); ?>
					</div>
					<div class="main">
						<?php
							switch($_GET['action']) {
								case 'edit':
									switch($_GET['type']) {
										case 'equipement':
											include('popup/equipement.php');
											break;
										case 'joueur':
											include('popup/joueur.php');
											break;
										case 'formation':
											include('popup/formation.php');
											break;
										default:
											echo 'Erreur 1';
									}
									break;
								default:
								   echo 'Erreur 2';
							}
						?>
					</div>
				</body>
			</html>
<?php
	}
?>