<!DOCTYPE html>
<?php
	session_start();
	include('lib/simple_html_dom.php');
?>
<html>
    <head>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="/server/css/style.css" />
        <title>ASGARD - Etat</title>
    </head>
    <body>
		<table class="page">
			<tr align="center">
				<td>
				
				</td>
				<td>
					<img src="/server/img/banniere.png" height="200">
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
						include('etat-code.php');
						}
						else
						{
							echo '<p>Mot de passe incorrect</p>';
							echo '<a href="http://darkynas.zapto.org">Retour</a>';
						}
					?>
				</td>
			</tr>
		</table>
    </body>
</html>