<!DOCTYPE html>
<!-- /ht Paul Irish - http://front.ie/j5OMXi -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en"><!--<![endif]-->
	<?php $this->load->view("users_interface/includes/head");?>
	
<body>
	<div class="container cf">
		<?php $this->load->view("users_interface/includes/header");?>
		
		<div id="main" class="substrate">
			<ul id="brands-list">
			<?php for($i=0;$i<count($brands);$i++):?>
				<li>
					<img src="<?=$baseurl;?>brands/viewimage/<?=$brands[$i]['id'];?>" /><br />
					<span class="underlined"><?=$brands[$i]['title'];?></span> <?=$brands[$i]['status_string'];?>
					<?=$brands[$i]['text'];?>
				<?php if($brands[$i]['catalogs']):?>
					<?=anchor('catalogs/brands/'.$brands[$i]['translit'],'Просмотреть каталоги &raquo;');?>
				<?php endif;?>
					<?=anchor('catalog/brands/'.$brands[$i]['translit'],'Продукция бренда &raquo;');?>
				</li>
			<?php endfor;?>
			</ul>
		</div>
	</div>
	<?php $this->load->view("users_interface/includes/footer");?>
	<?php $this->load->view("users_interface/includes/scripts");?>
</body>
</html>