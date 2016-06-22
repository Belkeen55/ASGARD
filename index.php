<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- Chargement des modules
	include('modules/connexionBDD.php');
	include('modules/testlogin.php');

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
		}
		$_SESSION['login'] = True;
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
		<link rel="stylesheet" href="/css/style.css" />
        <title>ASGARD - Connexion</title>
    </head>
    <body>
	
		<!-- Tableau de page -->
		<table class="page">
			<tr>
				<td align="center" colspan="3">
					<img src="/img/banniere.png">
				</td>
			</tr>
			<?php
				if($_SESSION['login']) {
					// ---- Si l'utilisateur est loggé
			?>
			<tr align="center">
				<td style="widht:30%">
					<img src="/img/vide.png" height="200">
				</td>
				<td>
					<!-- On renvoit vers les pages web de BRAIN -->
					<form action="web/home.php" method="post">
					<table>
						<tr>
							<td align="center">
								Bienvenue BELKEEN
							</td>
						</tr>
						<tr>
							<td align="center">
								<input type="submit" value="Connexion" />
							</td>
						</tr>
					</table>
					</form>
				</td>
				<td style="widht:30%">
					<img src="/img/vide.png" height="200">
				</td>
			</tr>
			<tr>
				<td align="right" colspan="3">
					<img src="/img/Cc-by-nc-sa_icon.png">
				</td>
			</tr>
			<?php
				}
				else
				{
				// ---- Si l'utilisateur n'est pas loggé
			?>
			<tr align="center">
				<td style="widht:30%">
					<img src="/img/vide.png" height="200">
				</td>
				<td>
					<!-- On renvoit vers la même page avec des POST -->
					<form action="index.php" method="post">
					<table>
						<tr>
							<td>
								Identifiant :
							</td>
							<td>
								<input type="text" name="identifiant" />
							</td>
						</tr>
						<tr>
							<td>
								Mot de passe :
							</td>
							<td>
								<input type="password" name="mot_de_passe" />
							</td>
						</tr>
						<tr align="center">
							<td colspan="2">
								<input type="submit" value="Connexion" />
							</td>
						</tr>
					</table>
					</form>
				</td>
				<td style="widht:30%">
					<img src="/img/vide.png" height="200">
				</td>
			</tr>
			<tr>
				<td align="right" colspan="3">
					<img src="/img/Cc-by-nc-sa_icon.png">
				</td>
			</tr>
			<?php
				}
			?>
		</table>
    </body>
</html>