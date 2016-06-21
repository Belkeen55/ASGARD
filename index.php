<!DOCTYPE html>
<?php
	session_start();
?>
<html>
    <head>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="/css/style.css" />
        <title>ASGARD - Connexion</title>
    </head>
    <body>
		<table class="page">
			<tr>
				<td align="center" colspan="3">
					<img src="/img/banniere.png">
				</td>
			</tr>
			<?php
				if((isset($_COOKIE['infos'])) and ($_COOKIE['infos'] == 'BelkhomeLogin')) {
			?>
			<tr align="center">
				<td style="widht:30%">
					<img src="/img/vide.png" height="200">
				</td>
				<td>
					<form action="web\home.php" method="post">
					<table>
						<tr>
							<td>
								<input type="submit" value="Connexion" />
							</td>
						</tr>
					</table>
					</form>
				</td>
				<td style="widht:30%">
					<img src="/img/vide.png" height="200">
				</td>
			</tr>
			<tr>
				<td align="right" colspan="3">
					<img src="/img/Cc-by-nc-sa_icon.png">
				</td>
			</tr>
			<?php
				}
				else
				{
			?>
			<tr align="center">
				<td style="widht:30%">
					<img src="/img/vide.png" height="200">
				</td>
				<td>
					<form action="web\home.php" method="post">
					<table>
						<tr>
							<td>
								Identifiant :
							</td>
							<td>
								<input type="text" name="identifiant" />
							</td>
						</tr>
						<tr>
							<td>
								Mot de passe :
							</td>
							<td>
								<form action="web\home.php" method="post"><input type="password" name="mot_de_passe" />
							</td>
						</tr>
						<tr align="center">
							<td colspan="2">
								<input type="submit" value="Connexion" />
							</td>
						</tr>
					</table>
					</form>
				</td>
				<td style="widht:30%">
					<img src="/img/vide.png" height="200">
				</td>
			</tr>
			<tr>
				<td align="right" colspan="3">
					<img src="/img/Cc-by-nc-sa_icon.png">
				</td>
			</tr>
			<?php
				}
			?>
		</table>
    </body>
</html>