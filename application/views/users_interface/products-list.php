<?php for($i=0;$i<count($category);$i++):?>
	<?php $exist = 0;?>
	<?php for($j=0;$j<count($products);$j++):?>
		<?php if($products[$j]['category'] == $category[$i]['id']):?>
			<?php $exist = 1;?>
		<?php endif;?>
	<?php endfor;?>
	<?php if($exist):?>
		<h2><?=$category[$i]['title'];?></h2>
		<div class="products-group cf">
		<?php for($j=0;$j<count($products);$j++):?>
			<?php if($products[$j]['category'] == $category[$i]['id']):?>
			<div class="product-preview">
				<img src="<?=$baseurl;?>productimage/viewimage/<?=$products[$j]['imgid'];?>" />
				<p class="title"><?=anchor('product/'.$products[$j]['gender'].'-'.$products[$j]['brand'].'-'.$products[$j]['category'].'/'.$products[$j]['translit'],$products[$j]['title']);?></p>
				<p class="articul"><?=$products[$j]['btitle'];?></p>
			</div>
			<?php endif;?>
		<?php endfor;?>
		</div>
	<?php endif;?>
	
<?php endfor;?>