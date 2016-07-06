<?php
	// ---- Redirection toutes les 10 secondes
	//header('Refresh: 10; url=meteo.php');
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
?>
<head>
	<link rel="stylesheet" href="/css/style.css" />
</head>	
<table class="page">
	<tr>
		<td>
			<img src="/img/vide.png" height="100">
		</td>
	</tr>
	<tr>
		<td align="center" class="taille3">
			<?php echo date('H') . ':' . date('i') ?>
		</td>
	</tr>
</table>