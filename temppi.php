<!/usr/bin/php>
<?php
        exec('sudo /opt/vc/bin/vcgencmd measure_temp', $reponse);
        $temppi = substr($reponse[0], 5, 2);
		$fichier = file("/proc/loadavg");
		$cpu = explode(" ", $fichier[0]);
		$fichier = file("/proc/meminfo");
		$ram_libre = str_replace('MemAvailable:', '', $fichier[2]);
		$ram_total = str_replace('MemTotal:', '', $fichier[0]);
		
		exec('df -h', $reponse);
		$reponse = str_replace('/dev/root', '', $reponse[2]);
		$reponse = explode(" ", $reponse);
		$disk = str_replace('%', '', $reponse[13]);
?>
<form>
        <input type="text" name="temperature" value="<?php echo $temppi; ?>" />
		<input type="text" name="disque" value="<?php echo $disk ?>" />
		<input type="text" name="cpu" value="<?php echo round($cpu[0]*100, 2) ?>" />
		<input type="text" name="ram" value="<?php echo round((1-($ram_libre/$ram_total))*100, 0) ?>" />
</form>
