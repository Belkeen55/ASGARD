<?php
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
<img src="/img/vide.png" height="50">
<table>
	<tr>
		<td class="cadre">
			<table>
				<tr>
					<td>
					
					</td>
					<td align="center" valign="top">
						<img src="/img/raspberry<?php echo ping('192.168.1.22') ?>.png" title="WLAN : 192.168.1.22"><br>
						GIT
					</td>
					<td>
					
					</td>
				</tr>
				<tr>
					<td>
					
					</td>
					<td align="center">
						<img src="/img/Tverticalwifi.png">
					</td>
					<td>
					
					</td>
				</tr>
				<tr>
					<td>
					
					</td>
					<td align="center">
						<img src="/img/raspberry<?php echo ping('192.168.1.16') ?>.png" title="WLAN : 192.168.1.16"><br>
						Brain</a>
					</td>
					<td>
					
					</td>
				</tr>
				<tr>
					<td align="center">
						<img src="/img/T-135.png">
					</td>
					<td align="center">
						<img src="/img/Tverticalwifi.png">
					</td>
					<td align="center">
						<img src="/img/W-67.png">
					</td>
				</tr>
				<tr>
					<td align="center" valign="top">
						<img src="/img/raspberry<?php echo ping('192.168.1.19') ?>.png" title="WLAN : 192.168.1.19"><br>
						Meteo
					</td>
					<td align="center" valign="top">
						<img src="/img/sondetemp<?php echo ping('192.168.1.15') ?>.png" title="WLAN : 192.168.1.15"><br>
						S.Chambre
					</td>
					<td align="center" valign="top">
						<img src="/img/sondetemp<?php echo ping('192.168.1.21') ?>.png" title="WLAN : 192.168.1.21"><br>
						S.Salon
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>