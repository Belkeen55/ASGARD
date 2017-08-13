<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	//if(!file_exists('../lib/SQL.php')) {
	//	echo "<script type='text/javascript'>document.location.replace('installation/installation.php');</script>";
	//}
	// ---- Chargement des modules
	include('lib/BDD.php');

	// ---- Tentative de connexion et génération du cookie
	$_SESSION['login'] = False;
	if((isset($_POST['mot_de_passe'])) AND (isset($_POST['identifiant']))) {
		$reponse = $bdd->query('SELECT Id 
								FROM Utilisateurs 
								WHERE Login = \'' . $_POST['identifiant'] . '\'
								AND Password = ' . cryptage($_POST['mot_de_passe']));
		$donnees = $reponse->rowCount();
		if($donnees!=0) {
			setcookie('infos', 'BelkhomeLogin', time() + 365*24*3600, null, null, false, true);
			$login = True;
			$_SESSION['login'] = True;
		}
	}
	if((isset($_COOKIE['infos'])) AND ($_SESSION['login'] == False)) {
		if($_COOKIE['infos'] == 'BelkhomeLogin') {
			$_SESSION['login'] = True;
		}
	}
?>
<html>
    <head>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="/css/newstyle.css" />
        <title>ASGARD - Connexion</title>
    </head>
    <body class="ecran_noir">
	
		<!-- Tableau de page -->
		<div class="contenu">
			<div class="line">
				<div class="display_center">
					<div style="height:325px">
						<img style="height:325px" src="/img/giphy.gif">
					</div>
				<div>
			</div>
			<div class="line"
				<div class="display_center">
					<div class="taille1">ASGARD</div>
				</div>
			</div>
			<?php
				if($_SESSION['login']) {
					// ---- Si l'utilisateur est loggé
					echo "<script type='text/javascript'>document.location.replace('Odin/odin.php');</script>";
				}
				else
				{
				// ---- Si l'utilisateur n'est pas loggé
			?>
			<div class="liner"></div>
			<div class="line">
				<div class="display_center">
					<!-- On renvoit vers la même page avec des POST -->
					<form action="index.php" method="post">
						<div class="line">
							Identifiant :
						</div>
						<div class="line">
							<input type="text" name="identifiant" />
						</div>
						<div class="liner"></div>
						<div class="line">
							Mot de passe :
						</div>
						<div class="line">
							<input type="password" name="mot_de_passe" />
						</div>
						<div class="liner"></div>
						<div class="line">
							<input type="submit" value="Connexion" />
						</div>
					</form>
				</div>
			</div>
			<div class="liner"></div>
			<div class="line">
				<div class="display_right"><img src="/img/Cc-by-nc-sa_icon.png"></div>
			</div>
			<?php
				}
			?>
		</div>
    </body>
</html>
