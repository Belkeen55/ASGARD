<!/usr/bin/php>
<?php
	exec('sudo /usr/bin/apt update', $reponse);
?>
<form>
        <input type="text" name="update" value="<?php echo end($reponse); ?>" />
</form>