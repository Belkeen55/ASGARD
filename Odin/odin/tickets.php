<div class="line">
	<div class="display_left">
		<?php
			if((isset($_GET['id'])) AND (!isset($_GET['action']))) {
				include('odin/ticketsview.php');
			}
			else {
				include('odin/ticketslist.php');
			}
		?>
	</div>
</div>