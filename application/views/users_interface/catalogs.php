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
		
		<div id="main" class="substrate large catalog">
			<div class="nav-links">
				<?=anchor('brands','&laquo; Вернуться к списку брендов');?>
			</div>
			<div class="brand-wrapper cf">
				<div class="brand-logo">
					<img src="<?=$baseurl;?>brands/viewimage/<?=$brand['id'];?>" /><br />
					<span class="underlined"><?=$brand['title'];?></span> <?=$brand['status_string'];?>
				</div>
				<ul class="catalog-list">
				<?php for($i=0;$i<count($catalogs);$i++):?>
					<li <?=($catalogs[$i]['translit'] == $this->uri->segment(5))?'class="active"':'';?>><?=anchor('catalogs/brands/'.$this->uri->segment(3).'/catalog/'.$catalogs[$i]['translit'],$catalogs[$i]['title']);?></li>
				<?php endfor;?>
				</ul>
			</div>
			<h1><?=$catalog['title'];?></h1>
			<p><?=$catalog['text'];?></p>
			<div class="catalog-content">
				<?=$catalog['html'];?>
			</div>
		</div>
	</div>
	<?php $this->load->view("users_interface/includes/footer");?>
	<?php $this->load->view("users_interface/includes/scripts");?>
</body>
</html>