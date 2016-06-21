<!DOCTYPE html>
<?php
	session_start();
?>
<html>
    <head>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="/css/style.css" />
        <title>ASGARD - Radiateurs</title>
    </head>
    <body>
		<table class="page">
			<tr align="center">
				<td>
				
				</td>
				<td>
					<img src="/img/banniere.png" height="200">
				</td>
			</tr>
			<?php
				if ($_COOKIE['infos'] == "BelkhomeLogin")
					{
			?>
			<tr>
				<td class='taillemenu' valign="top">
					<?php include('menu.php'); ?>
				</td>
				<td align="center">
					<?php
						include('connexions-code.php');
						}
						else
						{
							echo '<p>Mot de passe incorrect</p>';
							echo '<a href="/index.php">Retour</a>';
						}
					?>
				</td>
			</tr>
		</table>

    </body>
</html>