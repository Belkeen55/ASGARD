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
		$rep_cmd_disk = explode(" ", $rep_cmd_disk);
		$disk = str_replace('%', '', $rep_cmd_disk[13]);
		
		exec('uptime', $rep_cmd_uptime);
		$rep_cmd_uptime = explode(" ", $rep_cmd_uptime[0]);
		$uptime_jour = $rep_cmd_uptime[3];
		$uptime_hrmin = explode(":", $rep_cmd_uptime[6]);
		$uptime_heure = $uptime_hrmin[0];
		$uptime_minute = $uptime_hrmin[1];
		$uptime = $uptime_jour . ' jour(s), ' . $uptime_heure . 'h et ' . $uptime_minute . 'min';
		
?>
<form>
        <input type="text" name="temperature" value="<?php echo $temppi; ?>" />
		<input type="text" name="disque" value="<?php echo $disk ?>" />
		<input type="text" name="cpu" value="<?php echo round($cpu[0]*100, 2) ?>" />
		<input type="text" name="ram" value="<?php echo round((1-($ram_libre/$ram_total))*100, 0) ?>" />
		<input type="text" name="uptime" value="<?php echo $uptime ?>" />
</form>
