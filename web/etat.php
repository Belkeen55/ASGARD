<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- chargement des librairies
	include('../lib/simple_html_dom.php');
	include('../modules/network.php');
	include("../modules/BDD.php");
	$equipements_BDD = $bdd->query('SELECT 	Equipements.Id, Equipements.Nom, Equipements.Ip, Equipements.Commentaires, Pieces.Nom AS Location, 
											Type_Equip.Id AS Type, Type_Equip.Image
									FROM Equipements, Pieces, Type_Equip
									WHERE Equipements.Id_Pieces = Pieces.Id
									AND Equipements.Id_Type_Equip = Type_Equip.Id');
?>
<html>
    <head>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="/css/style.css" />
        <title>ASGARD - Etat</title>
    </head>
    <body>
		<!-- Tableau de page -->
		<table class="page">
			<tr align="center">
				<td>
				
				</td>
				<td>
					<img src="/img/banniere.png" height="200">
				</td>
			</tr>
			<?php
				if ($_SESSION['login'])	{
					// ---- Si l'utilisateur est loggé
			?>
			<tr>
				<!-- Chargement du menu de navigation -->
				<td class='taillemenu' valign="top">
					<?php include('menu.php'); ?>
				</td>
				<td align="center">
					<img src="/img/vide.png" height="50">
					<table>
						<tr>
							<td class="cadre">
								<table>
									<tr>
										<td align="center" class="tableau">
											Objet
										</td>
										<td align="center" class="tableau">
											Connexion
										</td>
										<td align="center" class="tableau">
											Temperature
										</td>
										<td align="center" class="tableau">
											D. libre
										</td>
										<td align="center" class="tableau">
											Charge CPU
										</td>
										<td align="center" class="tableau">
											R. Libre
										</td>
									</tr>
									<?php
										while($infos_equipement = $equipements_BDD->fetch()) {
											$connec = ping($infos_equipement['Ip']);
									?>
									<tr>
										<td align="center" class="tableau">
											<img src="<?php echo $infos_equipement['Image']; echo $connec;?>.png" title="WLAN : <?php echo $infos_equipement['Ip']; ?>"><br>
											<?php echo $infos_equipement['Nom']; ?>
										</td>
										<td align="center" class="tableau">
											<?php 
												echo $connec;
											?>
										</td>
										<td align="center" class="tableau">
											<?php
												if($connec == 'on')
												{
													if($infos_equipement['Type'] == 1) {
														$temperature = -1;
														$html = file_get_html('http://' . $infos_equipement['Ip'] . '/temppi.php');
														foreach($html->find('input[name=temperature]') as $element) 
														$temperature=$element->value;
														echo $temperature . '°C';
													}
													if($infos_equipement['Type'] == 2) {
														$html = file_get_html('http://' . $infos_equipement['Ip']);
														foreach($html->find('input[name=temperature]') as $element) 
														$temperature=$element->value;
														echo (int)$temperature . '°C';
													}
												}
												else
												{
													echo 'NA';
												}
											?>
										</td>
										<td align="center" class="tableau">
											<?php
												if($connec == 'on')
												{
													if($infos_equipement['Type'] == 1) {
														$disque = -1;
														$html = file_get_html('http://' . $infos_equipement['Ip'] . '/temppi.php');
														foreach($html->find('input[name=disque]') as $element) 
														$disque=$element->value;
														echo $disque . ' Go';
													}
													if($infos_equipement['Type'] == 2) {
														echo 'NA';
													}
												}
												else
												{
													echo 'NA';
												}
											?>
										</td>
										<td align="center" class="tableau">
											<?php
												if($connec == 'on')
												{
													if($infos_equipement['Type'] == 1) {
														$cpu = -1;
														$html = file_get_html('http://' . $infos_equipement['Ip'] . '/temppi.php');
														foreach($html->find('input[name=cpu]') as $element) 
														$cpu=$element->value;
														echo $cpu . '%';
													}
													if($infos_equipement['Type'] == 2) {
														echo 'NA';
													}
												}
												else
												{
													echo 'NA';
												}
											?>
										</td>
										<td align="center" class="tableau">
											<?php
												if($connec == 'on')
												{
													if($infos_equipement['Type'] == 1) {
														$ram = -1;
														$html = file_get_html('http://' . $infos_equipement['Ip'] . '/temppi.php');
														foreach($html->find('input[name=ram]') as $element) 
														$ram=$element->value;
														echo $ram . ' Mo';
													}
													if($infos_equipement['Type'] == 2) {
														echo 'NA';
													}
												}
												else
												{
													echo 'NA';
												}
											?>
										</td>
									</tr>
									<?php
										}
									?>
								</table>
							</td>
						</tr>
					</table>
					<?php
						}
						else
						{
							echo "<script type='text/javascript'>document.location.replace('../index.php');</script>";
						}
					?>
				</td>
			</tr>
		</table>
    </body>
</html>