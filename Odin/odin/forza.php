<div class="line">
	<div class="display_center">
		<span>
			<div class="bouton_appli">
				<a href="/Odin/odin.php?module=forza&vue=dashboard" class="black">
					<div class="titre_bouton_appli">
						<div class="lefttitre"></div>
						Dashboard
					</div>
				</a>
			</div>
			<div class="left1pct"></div>
			<div class="bouton_appli">
				<a href="/Odin/odin.php?module=forza&vue=voitures" class="black">
					<div class="titre_bouton_appli">
						<div class="lefttitre"></div>
						Voitures
					</div>
				</a>
			</div>
			<div class="left1pct"></div>
			<div class="bouton_appli">
				<a href="/Odin/odin.php?module=forza&vue=reglages" class="black">
					<div class="titre_bouton_appli">
						<div class="lefttitre"></div>
						Reglages
					</div>
				</a>
			</div>
			<div class="left1pct"></div>
			<div class="bouton_appli">
				<a href="/Odin/odin.php?module=forza&vue=tours" class="black">
					<div class="titre_bouton_appli">
						<div class="lefttitre"></div>
						Tours
					</div>
				</a>
			</div>
		</span>
	</div>
</div>
<div class="line">
	<div class="display_left">
		<?php
			switch ($_GET['vue']) {
				case 'dashboard':
					include('odin/forza_dashboard.php');
					break;
				case 'voitures':
					include('odin/forza_voitures.php');
					break;
				case 'reglages':
					include('odin/forza_reglages.php');
					break;
				case 'tours':
					include('odin/forza_tours.php');
					break;
				case 'ajout_tour':
					include('odin/forza_ajout_tour.php');
					break;
				case 'nouveau_reglage':
					include('odin/forza_nouveau_reglage.php');
					break;
			}
		?>
	</div>
</div>