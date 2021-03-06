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
	include("../lib/Pchart/class/pData.class.php"); 
	include("../lib/Pchart/class/pDraw.class.php"); 
	include("../lib/Pchart/class/pImage.class.php"); 
	include('commun/connect.php');

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
						if($module == 'global') {
							include('sol/global.php');
						}
						if(($module == 'chambre zacharie') or ($module == 'chambre parents') or ($module == 'salon')) {
							include('sol/sonde.php');
						}
						if($module == 'interrupteurs') {
							include('sol/interrupteurs.php');
						}
						if($module == 'meteo') {
							include('sol/meteo.php');
						}
						if($module == 'toutespieces') {
							include('sol/sondes.php');
						}
					?>
				</div>
			</body>
		</html>
