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
				<a class="thumb" href="<?='product/'.$products[$j]['gender'].'-'.$products[$j]['brand'].'-'.$products[$j]['category'].'-'.$products[$j]['id'].'/'.$products[$j]['translit'] ?>">
					<img src="<?=$baseurl;?>productimage/viewimage/<?=$products[$j]['imgid'];?>" />
				</a>
				<p class="title">
					<?=anchor('product/'.$products[$j]['gender'].'-'.$products[$j]['brand'].'-'.$products[$j]['category'].'-'.$products[$j]['id'].'/'.$products[$j]['translit'],$products[$j]['title']);?>
					<span class="articul"><?=$products[$j]['btitle'];?></span><br/>
					<span class="articul"><?=$products[$j]['stitle'];?></span>
				</p>
			</div>
			<?php endif;?>
		<?php endfor;?>
		</div>
	<?php endif;?>
<?php endfor;?>
<?php
if($pages > 1):
	$first = FALSE;
	$last = FALSE;
	if($page == 1):
		$first = TRUE;
		$from = 0;
	endif;
	if($page == $pages):
		$last = TRUE;
	endif;
	$start = 1; $stop = $pages;
	if($page >= 4):
		$start = $page - 3;
	endif;
	if($pages > ($page+3)):
		$stop = $page+3;
	endif;
	?>
	<div class="pagination">
		<ul>
			<li class="<?=($first)?'inactive':'active';?>" data-page="1">В начало</li>
			<li class="<?=($first)?'inactive':'active';?>" data-page="<?=(($page-1)==0)?1:$page-1;?>">Пред.</li>
		<?php for($i=$start;$i<=$stop;$i++):?>
			<li class="<?=($i==$page)?'curpage':'active';?>" data-page="<?=$i?>"><?=$i?></li>
		<?php endfor;?>
			<li class="<?=($last)?'inactive':'active';?>" data-page="<?=$page+1;?>">След.</li>
			<li class="<?=($last)?'inactive':'active';?>" data-page="<?=$pages;?>">В конец</li>
		</ul>
	</div>
<?php endif;?>