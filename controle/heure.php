<?php
	// ---- Redirection toutes les 10 secondes
	header('Refresh: 60; url=alertes.php');
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
?>
<head>
	<link rel="stylesheet" href="/css/newstyle.css" />
</head>
<body class="ecran_noir">	
	<div class="Heure_Fimafeng">
		<?php echo date('H') . ':' . date('i') ?>
	</div>
</body>