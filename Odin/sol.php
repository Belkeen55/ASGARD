<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- chargement des librairies
	include('../lib/simple_html_dom.php');
	include('../lib/BDD.php');
	include('../lib/meteo.php');
	 /* pChart library inclusions */ 
 include("../lib/Pchart/class/pData.class.php"); 
 include("../lib/Pchart/class/pDraw.class.php"); 
 include("../lib/Pchart/class/pImage.class.php"); 
	
	if (!$_SESSION['login']) {
		// ---- Si l'utilisateur n'est pas loggé
		echo "<script type='text/javascript'>document.location.replace('../index.php');</script>";
	}
	else {
		$page = 'sol';
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
				<body>
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
					<div class="page">
						<?php
							if($module == 'global') {
								include('sol/global.php');
							}
							if(($module == 'chambre') or ($module == 'cuisine') or ($module == 'salon')) {
								include('sol/sonde.php');
							}
						?>
					</div>
				</body>
			</html>
<?php
	}
?>