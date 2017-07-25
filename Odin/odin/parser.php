<!/usr/bin/php>
<?php
	// ---- Chargement des librairies
	include('/var/www/html/lib/simple_html_dom.php');
	
	$i = 0;
	
	$html = file_get_html('extract.html');
	foreach($html->find('fieldset') as $magasin) {
		$i = $i + 1;
		$nom_magasin = $magasin->find('a', 0)->outertext;
?>
<p>
	<table border=1>
		<tr>
			<th>
				Magasin
			</th>
			<th>
				Produit
			</th>
			<th>
				Vente
			</th>
			<th>
				Commande
			</th>
			<th>
				Reception
			</th>
			<th>
				Stock
			</th>
			<th>
				Estimation
			</th>
		</tr>
	<?php
		foreach($magasin->find('div[class=superior_prd_rep]') as $produit) {
			$info_produit = $produit->outertext;
			$cut = stripos($info_produit, '>');
			$stock = substr($info_produit, 37, $cut-38);
			$pos_purchased = stripos($stock, ' purchased');
			$ordered = substr($stock, 8, $pos_purchased - 8);
			$ordered = str_replace(' ', '', $ordered);
			$pos_sold = stripos($stock, ' sold');
			$purchased = substr($stock, $pos_purchased + 10, $pos_sold - $pos_purchased - 10);
			$purchased = str_replace(' ', '', $purchased);
			$pos_stock = stripos($stock, ' in stock');
			$sold = substr($stock, $pos_sold + 5, $pos_stock - $pos_sold - 5);
			$sold = str_replace(' ', '', $sold);
			$pos_parent = stripos($stock, ' (');
			$instock = substr($stock, $pos_stock + 9, $pos_parent - $pos_stock - 9);
			$instock = str_replace(' ', '', $instock);
			$pos_weeks = stripos($stock, ' wks');
			$wks = substr($stock, $pos_parent + 4, $pos_weeks - $pos_parent - 4);
			$wks = str_replace(' ', '', $wks);
			$pos_alt = stripos($info_produit, 'alt="');
			$pos_alt_fin = stripos($info_produit, '" width="32"');
			$alt = substr($info_produit, $pos_alt + 5, $pos_alt_fin - $pos_alt - 5)
?>
	<tr>
		<td>
			<?php echo $nom_magasin; ?>
		</td>
		<td>
			<?php echo $alt; ?>
		</td>
		<td<?php if($sold == 0) { echo ' BGCOLOR="#ccffaa"'; } ?>>
			<?php echo $sold; ?>
		</td>
		<td<?php if(($ordered == 0) AND ($wks < 5)) { echo ' BGCOLOR="#ccffaa"'; } ?>>
			<?php echo $ordered; ?>
		</td>
		<td<?php if($ordered > $purchased) { echo ' BGCOLOR="#ccffaa"'; } ?>>
			<?php echo $purchased; ?>
		</td>
		<td<?php if($instock == 0) { echo ' BGCOLOR="#ccffaa"'; } ?>>
			<?php echo $instock; ?>
		</td>
		<td <?php if((($wks < 2) OR ($wks > 4)) AND ($ordered <> 0)) { echo ' BGCOLOR="#ccffaa"'; } ?>>
			<?php echo $wks; ?>
		</td>
	</tr>

<?php
		}
?>
</table>
</p>
<?php
	}
?>
