<div class="line">
	<div class="display_left">
		<?php
			if((isset($_GET['id'])) AND (!isset($_GET['action']))) {
				include('odin/ticketsview.php');
			}
			else {
				if((isset($_GET['action'])) AND ($_GET['action'] == 'add')) {
					include('odin/ticketsadd.php');
				}
				else {
					include('odin/ticketslist.php');
				}
			}
		?>
	</div>
</div>