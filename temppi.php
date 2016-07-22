<!/usr/bin/php>
<?php
        exec('sudo /opt/vc/bin/vcgencmd measure_temp', $rep_cmd_temp);
        $temppi = substr($rep_cmd_temp[0], 5, 2);
		
		$rep_cmd_cpu = file("/proc/loadavg");
		$cpu = explode(" ", $rep_cmd_cpu[0]);
		
		$rep_cmd_ram = file("/proc/meminfo");
		$ram_libre = str_replace('MemAvailable:', '', $rep_cmd_ram[2]);
		$ram_total = str_replace('MemTotal:', '', $rep_cmd_ram[0]);
		
		exec('df -h', $rep_cmd_disk);
		$rep_cmd_disk = str_replace('/dev/root', '', $rep_cmd_disk[1]);
		$rep_cmd_disk = explode("%", $rep_cmd_disk);
		$rep_cmd_disk = explode(" ", $rep_cmd_disk[0]);
		$dernier = count($rep_cmd_disk) - 1;
		$disk = $rep_cmd_disk[$dernier];
		
		exec('uptime -p', $rep_cmd_uptime);
		$rep_cmd_uptime = str_replace('up ', '', $rep_cmd_uptime);
		$rep_cmd_uptime = str_replace('days', 'jours', $rep_cmd_uptime);
		$rep_cmd_uptime = str_replace('day', 'jour', $rep_cmd_uptime);
		$rep_cmd_uptime = str_replace('hours', 'heures', $rep_cmd_uptime);
		$rep_cmd_uptime = str_replace('hour', 'heure', $rep_cmd_uptime);
		$rep_cmd_uptime = str_replace('weeks', 'semaines', $rep_cmd_uptime);
		$rep_cmd_uptime = str_replace('week', 'semaine', $rep_cmd_uptime);
		$rep_cmd_uptime = explode(", ", $rep_cmd_uptime[0]);
		$nb = count($rep_cmd_uptime);
		$i = 1;
		$uptime = $rep_cmd_uptime[0] . ', ';
		while($i <= $nb) {
			$uptime = $uptime . $rep_cmd_uptime[$i];
			if($i < $nb-1) {
				$uptime = $uptime . ', ';
			}
			$i++;
		}
?>
<form>
        <input type="text" name="temperature" value="<?php echo $temppi; ?>" />
		<input type="text" name="disque" value="<?php echo $disk ?>" />
		<input type="text" name="cpu" value="<?php echo round($cpu[0]*100, 2) ?>" />
		<input type="text" name="ram" value="<?php echo round((1-($ram_libre/$ram_total))*100, 0) ?>" />
		<input type="text" name="uptime" value="<?php echo $uptime; ?>" />
</form>
