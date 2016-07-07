<!/usr/bin/php>
<?php
        exec('sudo /opt/vc/bin/vcgencmd measure_temp', $reponse);
        $temppi = substr($reponse[0], 5, 2);
		$fichier = file("/proc/loadavg");
		$cpu = explode(" ", $fichier[0]);
		$fichier = file("/proc/meminfo");
		$ram = str_replace('MemAvailable:', '', $fichier[2]);
?>
<form>
        <input type="text" name="temperature" value="<?php echo $temppi; ?>" />
		<input type="text" name="disque" value="<?php echo round(disk_free_space("/")/1000000000, 2) ?>" />
		<input type="text" name="cpu" value="<?php echo round($cpu[0]*100, 2) ?>" />
		<input type="text" name="ram" value="<?php echo round($ram/1000, 0) ?>" />
</form>
