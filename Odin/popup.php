<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL); 
	
	// ---- chargement des librairies
	include('../lib/BDD.php');
	include('commun/connect.php');
?>
	<html>
		<head>
			<?php include('commun/head.php'); ?>
		</head>
		<body class="ecran_clair" <?php if(isset($_GET['close'])) { echo 'onunload="window.opener.location.reload(true);"'; } ?>>
			<div class="redline"></div>
			<div class="header">
				<?php include('commun/header.php'); ?>
			</div>
			<div class="contenu">
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
								case 'piece':
									include('popup/piece.php');
									break;
								case 'type':
									include('popup/type.php');
									break;
								case 'utilisateurs':
									include('popup/utilisateurs.php');
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