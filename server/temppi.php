<!/usr/bin/php>
<?php
        exec('sudo /opt/vc/bin/vcgencmd measure_temp', $reponse);
        $temppi = substr($reponse[0], 5, 2);
?>
<form>
        <input type="text" name="temperature" value="<?php echo $temppi; ?>" />
</form>
