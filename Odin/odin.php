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
		$page = 'odin';
		if(isset($_GET['module'])) {
			$module = $_GET['module'];
		}			
		else {				
			$module = 'global';
		}	
?>
			<html>
				<head>
					<?php include('commun/head.php'); ?>
				</head>
				<body class="ecran_clair">
					<div class="redline"></div>
					<div class="header">
						<?php include('commun/header.php'); ?>
					</div>
					<div class="menu">
						<?php include('commun/menu.php'); ?>
					</div>
					<div class="submenu">
						<?php include('commun/submenu.php'); ?>
					</div>
					<div class="contenu">
						<?php
							switch ($module) {
								case 'global':
									include('odin/global.php');
									break;
								case 'smworld':
									include('odin/smworld.php');
									break;
								case 'tickets':
									include('odin/tickets.php');
									break;
							}
						?>
					</div>
				</body>
			</html>
<?php
	}
?>