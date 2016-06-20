<?php
	header('Refresh: 10; url=salon.php');
	include("modules/connexionBDD.php");
	$reponse = $bdd->query('SELECT Id, Tempext, Tempint, Humidite 
							FROM Mesures
							WHERE Id_Pieces = 1
							ORDER BY Id DESC
							LIMIT 1');
	$donnees = $reponse->fetch();
	$api = $donnees['Tempext'];
	$temperature = $donnees['Tempint'];
	$humidite = $donnees['Humidite'];
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
		if((($temperature > $Tmin) AND ($temperature < $Tmax)) OR ($temperature == $Tmax))
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
<link rel="stylesheet" href="css/style.css" />		
<table class="page">
	<tr>
		<td align="center">
			<table>
				<tr>
					<td colspan="4" align="center" valign="middle" class="taille1">Chambre</td>
				</tr>
				<tr>
					<td>
						<img src="img/vide.png" height="20">
					</td>
				</tr>
				<tr>
					<td class="taille1">
						Temp : 
					</td>
					<td class="taille1" align="right">
						<?php echo (int)$temperature . ' C'; ?>
					</td>
					<td>
						<img src="img/vide.png" height="20">
					</td>
					<td align="center" valign="middle">
						<img src="img/temperature<?php echo $Tetat; ?>.png" height="80">
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<img src="img/vide.png" height="10">
					</td>
				</tr>
				<tr>
					<td class="taille1">
						Hum : 
					</td>
					<td class="taille1" align="right">
						<?php echo (int)$humidite . '%'; ?>
					</td>
					<td>
						<img src="img/vide.png" height="20">
					</td>
					<td align="center" valign="middle">
						<img src="img/humidity<?php echo $Hetat; ?>.png" height="80">
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<img src="img/vide.png" height="10">
					</td>
				</tr>
				<tr>
					<td class="taille1">
						Radia : 
					</td>
					<td class="taille1" align="center">
						<?php echo (int)$radiateur; ?>
					</td>
					<td>
						<img src="img/vide.png" height="20">
					</td>
					<td rowspan="2" align="center" valign="middle">
						<img src="img/heater<?php echo $Retat; ?>.png" height="80">
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>