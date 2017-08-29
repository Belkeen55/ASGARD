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
        <?php
        	$ua = $_SERVER['HTTP_USER_AGENT'];
			if (preg_match('/iphone/i',$ua) || preg_match('/android/i',$ua) || preg_match('/blackberry/i',$ua) || preg_match('/symb/i',$ua) || preg_match('/ipad/i',$ua) || preg_match('/ipod/i',$ua) || preg_match('/phone/i',$ua) ) {
				//echo "<LINK rel="stylesheet" type="text/css" href="smartphones.css">";
				echo '<link rel="stylesheet" href="/css/mobile.css" />';
			}
			else {
				echo '<link rel="stylesheet" href="/css/newstyle.css" />';
			}
		?>
        <title>ASGARD - Connexion</title>
    </head>
    <body class="ecran_sombre">
	
		<!-- Tableau de page -->
		<div class="contenu">
			<div class="line">
				<div class="display_center">
					<div class="logo-big">
						<img class="logo-big" src="/img/giphy.gif">
					</div>
				<div>
			</div>
			<div class="line"
				<div class="display_center">
					<div class="policetitre">ASGARD</div>
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
							<div class="policetexte">Identifiant :</div>
						</div>
						<div class="line">
							<input class="champ" type="text" name="identifiant" />
						</div>
						<div class="liner"></div>
						<div class="line">
							<div class="policetexte">Mot de passe :</div>
						</div>
						<div class="line">
							<input class="champ" type="password" name="mot_de_passe" />
						</div>
						<div class="liner"></div>
						<div class="liner"></div>
						<div class="line">
							<input class="boutonConnexion" type="submit" value="Connexion" />
						</div>
					</form>
				</div>
			</div>
			<div class="liner"></div>
			<div class="line">
				<div class="display_right">
					<img class="ccbyncsa" src="/img/Cc-by-nc-sa_icon.png">
				</div>
			</div>
			<?php
				}
			?>
		</div>
    </body>
</html>
