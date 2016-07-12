<!DOCTYPE html>
<?php
	// ---- Debut de session
	session_start();
	
	// ---- Debug
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// ---- Chargement modules
	include('../../modules/BDD.php');
?>
<html>
    <head>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="/css/style.css" />
        <title>ASGARD</title>
    </head>
    <body>
		<!-- Tableau de page -->
		<table class="page">
			<tr align="center">
				<td>
				
				</td>
				<td>
					<img src="/img/banniere.png" height="200">
				</td>
			</tr>
			<?php
				if ($_SESSION['login'])	{
					// ---- Si l'utilisateur est loggé
			?>
			<tr>
				<!-- Chargement du menu de navigation -->
				<td class='taillemenu' valign="top">
					<?php include('../menu.php'); ?>
				</td>
				<td align="center">
					<img src="/img/vide.png" height="50">
					<table border="1">
						<form action="joueurs.php" method="post">
						<tr>
							<td colspan="8" align="center">
								Nom
							</td>
							<td colspan="8" align="center">
								Note
							</td>
						</tr>
						<tr>
							<td colspan="8" align="center">
								<input type="text" name="nom" />
							</td>
							<td colspan="8" align="center">
								<input type="text" name="note" />
							</td>
						</tr>
						<tr>
							<td>
								<img src="/img/vide.png" height="30">
							</td>
						</tr>
						<tr>
							<td align="center">
								G
							</td>
							<td align="center">
								DD
							</td>
							<td align="center">
								DA
							</td>
							<td align="center">
								DG
							</td>
							<td align="center">
								MDD
							</td>
							<td align="center">
								MDA
							</td>
							<td align="center">
								MDG
							</td>
							<td align="center">
								MD
							</td>
							<td align="center">
								MA
							</td>
							<td align="center">
								MG
							</td>
							<td align="center">
								MOD
							</td>
							<td align="center">
								MOA
							</td>
							<td align="center">
								MOG
							</td>
							<td align="center">
								AD
							</td>
							<td align="center">
								AA
							</td>
							<td align="center">
								AG
							</td>
						</tr>
						<tr>
							<td align="center">
								<input type="checkbox" name="G" value="G">
							</td>
							<td align="center">
								<input type="checkbox" name="DD" value="DD">
							</td>
							<td align="center">
								<input type="checkbox" name="DA" value="DA">
							</td>
							<td align="center">
								<input type="checkbox" name="DG" value="DG">
							</td>
							<td align="center">
								<input type="checkbox" name="MDD" value="MDD">
							</td>
							<td align="center">
								<input type="checkbox" name="MDA" value="MDA">
							</td>
							<td align="center">
								<input type="checkbox" name="MDG" value="MDG">
							</td>
							<td align="center">
								<input type="checkbox" name="MD" value="MD">
							</td>
							<td align="center">
								<input type="checkbox" name="MA" value="MA">
							</td>
							<td align="center">
								<input type="checkbox" name="MG" value="MG">
							</td>
							<td align="center">
								<input type="checkbox" name="MOD" value="MOD">
							</td>
							<td align="center">
								<input type="checkbox" name="MOA" value="MOA">
							</td>
							<td align="center">
								<input type="checkbox" name="MOG" value="MOG">
							</td>
							<td align="center">
								<input type="checkbox" name="AD" value="AD">
							</td>
							<td align="center">
								<input type="checkbox" name="AA" value="AA">
							</td>
							<td align="center">
								<input type="checkbox" name="AG" value="AG">
							</td>
						</tr>
						<tr>
							<td>
								<img src="/img/vide.png" height="30">
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<input type="hidden" name="action" value="add" />
								<input type="submit" value="Ajouter" />
							</td>
						</tr>
						</form>
					</table>
					<?php
						}
						else
						{
							echo "<script type='text/javascript'>document.location.replace('../index.php');</script>";
						}
					?>
				</td>
			</tr>
		</table>

    </body>
</html>