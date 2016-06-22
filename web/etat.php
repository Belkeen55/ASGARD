<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- chargement des librairies
	include('../lib/simple_html_dom.php');
	
	function ping($ip_a_tester)
	{
			if(exec("ping ".$ip_a_tester." -w 1"))
		{
			return "on";
		}
		else
		{
			return "off";
		}
	}
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
									</tr>
									<tr>
										<td align="center" class="tableau">
											<img src="/img/raspberryon.png" title="WLAN : 192.168.1.22"><br>
											GIT
										</td>
										<td align="center" class="tableau">
											<?php 
												$connec = ping('192.168.1.22');
												echo $connec;
											?>
										</td>
										<td align="center" class="tableau">
											<?php
												if($connec == 'on')
												{
													$html = file_get_html('http://192.168.1.22/temppi.php');
													foreach($html->find('input[name=temperature]') as $element) 
													$temperature=$element->value;
													echo $temperature;
												}
												else
												{
													echo 'NA';
												}
											?>
										</td>
									</tr>
									<tr>
										<td align="center" class="tableau">
											<a href="brain.php"><img src="/img/raspberryon.png" title="LAN : 192.168.1.16 WLAN : 192.168.1.17"><br>
											Brain</a>
										</td>
										<td align="center" class="tableau">
											<?php 
												$connec = ping('192.168.1.16');
												echo $connec;
											?>
										</td>
										<td align="center" class="tableau">
											<?php
												if($connec == 'on')
												{
													$html = file_get_html('http://192.168.1.16/script/temppi.php');
													foreach($html->find('input[name=temperature]') as $element) 
														$temperature=$element->value;
													echo $temperature;
												}
												else
												{
													echo 'NA';
												}
											?>
										</td>
									</tr>
									<tr>
										<td align="center" class="tableau">
											<img src="/img/raspberryon.png" title="WLAN : 192.168.1.19"><br>
											Meteo
										</td>
										<td align="center" class="tableau">
											<?php 
												$connec = ping('192.168.1.19');
												echo $connec;
											?>
										</td>
										<td align="center" class="tableau">
											<?php
												if($connec == 'on')
												{
													$html = file_get_html('http://192.168.1.19/temppi.php');
													foreach($html->find('input[name=temperature]') as $element) 
														$temperature=$element->value;
													echo $temperature;
												}
												else
												{
													echo 'NA';
												}
											?>
										</td>
									</tr>
									<tr>
										<td align="center" class="tableau">
											<img src="/img/sondetempon.png" title="WLAN : 192.168.1.15"><br>
											S.Chambre
										</td>
										<td align="center" class="tableau">
											<?php 
												$connec = ping('192.168.1.15');
												echo $connec;
											?>
										</td>
										<td align="center" class="tableau">
											<?php
												if($connec == 'on')
												{
													$html = file_get_html('http://192.168.1.15');
													foreach($html->find('input[name=temperature]') as $element) 
														$temperature=$element->value;
													echo (int)$temperature;
												}
												else
												{
													echo 'NA';
												}
											?>
										</td>
									</tr>
									<tr>
										<td align="center" class="tableau">
											<img src="/img/sondetempon.png" title="WLAN : 192.168.1.21"><br>
											S.Salon
										</td>
										<td align="center" class="tableau">
											<?php 
												$connec = ping('192.168.1.21');
												echo $connec;
											?>
										</td>
										<td align="center" class="tableau">
											<?php
												if($connec == 'on')
												{
													$html = file_get_html('http://192.168.1.21');
													foreach($html->find('input[name=temperature]') as $element) 
														$temperature=$element->value;
													echo (int)$temperature;
												}
												else
												{
													echo 'NA';
												}
											?>
										</td>
									</tr>
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