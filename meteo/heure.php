<?php
	// ---- Redirection toutes les 10 secondes
	header('Refresh: 10; url=meteo.php');
?>
<head>
	<link rel="stylesheet" href="/css/style.css" />
</head>	
<table class="page">
	<tr>
		<td>
			<img src="/img/vide.png" height="50">
		</td>
	</tr>
	<tr>
		<td align="center" class="taille1">
			<?php echo date('d') . '-' . date('M') . '-' . date('Y') ?>
		</td>
	</tr>
	<tr>
		<td align="center" class="taille1">
			<?php echo date('H') . ':' . date('i') ?>
		</td>
	</tr>
</table>