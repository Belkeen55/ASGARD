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
	include('../lib/network.php');
	include("../lib/Pchart/class/pDraw.class.php"); 
	include("../lib/Pchart/class/pImage.class.php"); 
	include("../lib/Pchart/class/pData.class.php");  
	include("../lib/Pchart/class/pPie.class.php"); 
 
	
	if (!$_SESSION['login']) {
		// ---- Si l'utilisateur n'est pas logg�
		echo "<script type='text/javascript'>document.location.replace('../index.php');</script>";
	}
	else {
		$page = 'fimafeng';
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
							switch ($module) {
								case 'global':
									include('fimafeng/global.php');
									break;
								default:
								   include('fimafeng/equipement.php');
							}
						?>
					</div>
				</body>
			</html>
<?php
	}
?>