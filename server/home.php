<!DOCTYPE html>
<?php
	//----- Initialisation Session
	session_start();
	
	//----- Initialisation des librairies
	include('lib/simple_html_dom.php');
	
	//----- Connexion BDD
	include("modules/connexionBDD.php");
	
	//----- Tentative de connexion et génération du cookie
	$login = False;
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
	}
?>
<html>
    <head>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="/server/css/style.css" />
        <title>ASGARD - Home</title>
    </head>
    <body>
		<table class="page">
			<tr align="center">
				<td>
				
				</td>
				<td>
					<img src="/server/img/banniere.png" height="200">
				</td>
			</tr>
			<?php
				//----- Si loggué ou cookie
				if (($_COOKIE['infos'] == "BelkhomeLogin") OR ($login == True))
					{
			?>
			<tr>
				<td class='taillemenu' valign="top">
					<?php include('menu.php'); ?>
				</td>
				<td align="center">
					<?php
						$html = file_get_html('http://192.168.1.15');
						foreach($html->find('input[name=temperature]') as $element) 
							$temperature=$element->value;
						foreach($html->find('input[name=humidite]') as $element) 
							$humidite=$element->value;
						$reponse = $bdd->query('SELECT Id, Tempext 
												FROM Mesures
												WHERE Id_Pieces = 1
												ORDER BY Id DESC
												LIMIT 1');
						$donnees = $reponse->fetch();
						$api = $donnees['Tempext'];
						$reponse->closeCursor();
						$reponse = $bdd->query('SELECT Radiateur 
												FROM Radiateurs 
												WHERE Id_Pieces = 1');
						$donnees = $reponse->fetch();
						$radiateur = $donnees['Radiateur'];
						$reponse->closeCursor();
						$reponse = $bdd->query('SELECT T_ideal, H_ideal 
												FROM Pieces
												WHERE Id = 1');
						$donnees = $reponse->fetch();
						$Tideal = $donnees['T_ideal'];
						$Hideal = $donnees['H_ideal'];
						$reponse->closeCursor();
						$Tmin = $Tideal*0.9;
						$Tmax = $Tideal*1.1;
						$Hmin = $Hideal*0.8;
						$Hmax = $Hideal*1.2;
						if($temperature < $Tmin) 
						{
							$Tetat = 'low';
						}
						else
						{
							if(($temperature > $Tmin) AND ($temperature < $Tmax))
							{
								$Tetat = 'ok';
							}
							else
							{
								if($temperature > $Tmax)
								{
									$Tetat = 'high';
								}
							}
						}
						if($humidite < $Hmin) 
						{
							$Hetat = 'low';
						}
						else
						{
							if(($humidite > $Hmin) AND ($humidite < $Hmax))
							{
								$Hetat = 'ok';
							}
							else
							{
								if($humidite > $Hmax)
								{
									$Hetat = 'high';
								}
							}
						}
						$TRmin = (int)$temperature;
						$TRmax = (int)$temperature+1;
						$TiRmin = (int)$api;
						$TiRmax = (int)$api+1;
						$reponse = $bdd->query('SELECT Id_Pieces, AVG(Radiateur) as Reglage 
												FROM Mesures
												WHERE Id_Pieces = 1
												AND Tempint > ' . $TRmin . '
												AND Tempint < ' . $TRmax . '
												AND Tempext > ' . $TiRmin . '
												AND Tempext < ' . $TiRmax . '
												GROUP BY Id_Pieces');
						$lignes = $reponse->rowCount();
						if($lignes == 0)
						{
							$reglage = 'Pas dinformations';
						}
						else
						{
							$donnees = $reponse->fetch();
							$reglage = (int)$donnees['Reglage'];
							if($reglage-(int)$radiateur > 0)
							{
								$Retat = 'low';
							}
							else
							{
								if($reglage-(int)$radiateur < 0)
								{
									$Retat = 'high';
								}
								else
								{
									$Retat = 'ok';
								}
							}
						}
						$reponse->closeCursor();

					?>		
				<img src="/server/img/vide.png" height="50">
				<table>
					<tr>
						<td class="cadre">
							<table>
								<tr>
									<td rowspan="2" align="center" valign="middle"><img src="/server/img/temperature.png" height="32"></td>
									<td rowspan="3"><img src="/server/img/vide.png" height="32"></td>
									<td>Temperature exterieure</td>
								</tr>
								<tr>
									<td colspan="2" align="center"><?php echo $api . ' C'; ?></td>
								</tr>
							</table>
						</td>
						<td>
							<img src="/server/img/vide.png" widht="200">
						</td>
						<td class="cadre">
							<table>
								<tr>
									<td rowspan="8"><img src="/server/img/bebe.png" height="64"></td>
									<td rowspan="8" valign="middle"><h2>Chambre</h2></td>
									<td rowspan="8"><img src="/server/img/vide.png" height="32"></td>
									<td rowspan="2" align="center" valign="middle"><img src="/server/img/temperature<?php echo $Tetat; ?>.png" height="32"></td>
									<td rowspan="8"><img src="/server/img/vide.png" height="32"></td>
									<td align="center">Temperature</td>
									<td rowspan="8"><img src="/server/img/vide.png" height="32"></td>
									<td align="center">Tmp reco</td>
								</tr>
								<tr>
									<td colspan="2" align="center"><?php echo (int)$temperature . ' C'; ?></td>
									<td colspan="2" align="center"><?php echo (int)$Tideal . ' C'; ?></td>
								</tr>
								<tr>
									<td><img src="/server/img/vide.png" height="5"></td>
								</tr>
								<tr>
									<td rowspan="2" align="center" valign="middle"><img src="/server/img/humidity<?php echo $Hetat; ?>.png" height="32"></td>
									<td align="center">Humidite</td>
									<td align="center">Hum reco</td>
								</tr>
								<tr>
									<td colspan="2" align="center"><?php echo (int)$humidite . ' %'; ?></td>
									<td colspan="2" align="center"><?php echo (int)$Hideal . ' %'; ?></td>
								</tr>
								<tr>
									<td><img src="/server/img/vide.png" height="5"></td>
								</tr>
								<tr>
									<td rowspan="2" align="center" valign="middle"><img src="/server/img/heater<?php echo $Retat; ?>.png" height="32"></td>
									<td align="center">Radiateur</td>
									<td align="center">Reg reco</td>
								</tr>
								<tr>
									<td colspan="2" align="center"><?php echo (int)$radiateur; ?></td>
									<td colspan="2" align="center"><?php echo $reglage; ?></td>
								</tr>
							</table>
						</td>
					</tr>
					<?php
						$html = file_get_html('http://192.168.1.21');
						foreach($html->find('input[name=temperature]') as $element) 
							$temperature=$element->value;
						foreach($html->find('input[name=humidite]') as $element) 
							$humidite=$element->value;
						$reponse = $bdd->query('SELECT Id, Tempext 
												FROM Mesures
												WHERE Id_Pieces = 2
												ORDER BY Id DESC
												LIMIT 1');
						$donnees = $reponse->fetch();
						$api = $donnees['Tempext'];
						$reponse->closeCursor();
						$reponse = $bdd->query('SELECT Radiateur 
												FROM Radiateurs 
												WHERE Id_Pieces = 2');
						$donnees = $reponse->fetch();
						$radiateur = $donnees['Radiateur'];
						$reponse->closeCursor();
						$reponse = $bdd->query('SELECT T_ideal, H_ideal 
												FROM Pieces
												WHERE Id = 2');
						$donnees = $reponse->fetch();
						$Tideal = $donnees['T_ideal'];
						$Hideal = $donnees['H_ideal'];
						$reponse->closeCursor();
						$Tmin = $Tideal*0.9;
						$Tmax = $Tideal*1.1;
						$Hmin = $Hideal*0.8;
						$Hmax = $Hideal*1.2;
						if($temperature < $Tmin) 
						{
							$Tetat = 'low';
						}
						else
						{
							if(($temperature > $Tmin) AND ($temperature < $Tmax))
							{
								$Tetat = 'ok';
							}
							else
							{
								if($temperature > $Tmax)
								{
									$Tetat = 'high';
								}
							}
						}
						if($humidite < $Hmin) 
						{
							$Hetat = 'low';
						}
						else
						{
							if(($humidite > $Hmin) AND ($humidite < $Hmax))
							{
								$Hetat = 'ok';
							}
							else
							{
								if($humidite > $Hmax)
								{
									$Hetat = 'high';
								}
							}
						}
						$TRmin = (int)$temperature;
						$TRmax = (int)$temperature+1;
						$TiRmin = (int)$api;
						$TiRmax = (int)$api+1;
						$reponse = $bdd->query('SELECT Id_Pieces, AVG(Radiateur) as Reglage 
												FROM Mesures
												WHERE Id_Pieces = 2
												AND Tempint > ' . $TRmin . '
												AND Tempint < ' . $TRmax . '
												AND Tempext > ' . $TiRmin . '
												AND Tempext < ' . $TiRmax . '
												GROUP BY Id_Pieces');
						$lignes = $reponse->rowCount();
						if($lignes == 0)
						{
							$reglage = 'Pas dinformations';
						}
						else
						{
							$donnees = $reponse->fetch();
							$reglage = (int)$donnees['Reglage'];
							if($reglage-(int)$radiateur > 0)
							{
								$Retat = 'low';
							}
							else
							{
								if($reglage-(int)$radiateur < 0)
								{
									$Retat = 'high';
								}
								else
								{
									$Retat = 'ok';
								}
							}
						}
						$reponse->closeCursor();

					?>
					<tr>
						<td>
							<img src="/server/img/vide.png" height="70">
						</td>
					</tr>
					<tr>
						<td align="center" colspan="3">
							<table class="cadre">
								<tr>
									<td rowspan="8"><img src="/server/img/salon.png" width="64"></td>
									<td rowspan="8" valign="middle"><h2>Salon</h2></td>
									<td rowspan="8"><img src="/server/img/vide.png" height="32"></td>
									<td rowspan="2" align="center" valign="middle"><img src="/server/img/temperature<?php echo $Tetat; ?>.png" height="32"></td>
									<td rowspan="8"><img src="/server/img/vide.png" height="32"></td>
									<td align="center">Temperature</td>
									<td rowspan="8"><img src="/server/img/vide.png" height="32"></td>
									<td align="center">Tmp reco</td>
								</tr>
								<tr>
									<td colspan="2" align="center"><?php echo (int)$temperature . ' C'; ?></td>
									<td colspan="2" align="center"><?php echo (int)$Tideal . ' C'; ?></td>
								</tr>
								<tr>
									<td><img src="/server/img/vide.png" height="5"></td>
								</tr>
								<tr>
									<td rowspan="2" align="center" valign="middle"><img src="/server/img/humidity<?php echo $Hetat; ?>.png" height="32"></td>
									<td align="center">Humidite</td>
									<td align="center">Hum reco</td>
								</tr>
								<tr>
									<td colspan="2" align="center"><?php echo (int)$humidite . ' %'; ?></td>
									<td colspan="2" align="center"><?php echo (int)$Hideal . ' %'; ?></td>
								</tr>
								<tr>
									<td><img src="/server/img/vide.png" height="5"></td>
								</tr>
								<tr>
									<td rowspan="2" align="center" valign="middle"><img src="/server/img/heater<?php echo $Retat; ?>.png" height="32"></td>
									<td align="center">Radiateur</td>
									<td align="center">Reg reco</td>
								</tr>
								<tr>
									<td colspan="2" align="center"><?php echo (int)$radiateur; ?></td>
									<td colspan="2" align="center"><?php echo $reglage; ?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				</td>
				<td align="center">
					<?php
					}
						else
						{
							echo '<p>Mot de passe incorrect</p>';
							echo '<a href="http://darkynas.zapto.org">Retour</a>';
						}
					?>
				</td>
			</tr>
		</table>
    </body>
</html>