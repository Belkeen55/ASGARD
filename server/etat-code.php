<?php
	include("modules/connexionBDD.php");
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
	exec('sudo /opt/vc/bin/vcgencmd measure_temp', $reponse);
	$temppi = substr($reponse[0], 5, 2);
?>		
<img src="/server/img/vide.png" height="50">
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
						<img src="/server/img/raspberryon.png" title="WLAN : 192.168.1.22"><br>
						Meteo
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
						<a href="brain.php"><img src="/server/img/raspberryon.png" title="LAN : 192.168.1.16 WLAN : 192.168.1.17"><br>
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
								$html = file_get_html('http://192.168.1.16/server/temppi.php');
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
						<img src="/server/img/raspberryon.png" title="WLAN : 192.168.1.19"><br>
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
								$html = file_get_html('http://192.168.1.19/server/temppi.php');
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
						<img src="/server/img/sondetempon.png" title="WLAN : 192.168.1.15"><br>
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
						<img src="/server/img/sondetempon.png" title="WLAN : 192.168.1.21"><br>
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