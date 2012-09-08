<?php for($i=0;$i<count($category);$i++):?>
	<h2><?=$category[$i]['title']?></h2>
	<div class="products-group cf">
	<?php for($j=0;$j<count($products);$j++):?>
		<?php if($products[$j]['category'] == $category[$i]['if']):?>
		<div class="product-preview">
			<img src="<?=$baseurl;?>productimage/viewimage/<?=$products[$i]['imgid'];?>" />
			<p class="title"><?=$products[$j]['title'];?></p>
			<p class="articul"><?=$products[$j]['brand'];?></p>
		</div>
		<?php endif;?>
	<?php endfor;?>
	</div>
<?php endfor;?>
