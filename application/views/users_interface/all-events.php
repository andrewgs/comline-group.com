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
			<?php if($this->uri->segment(1) == 'all-news'):?>
				<h2>Новости</h2>
			<?php else:?>
				<h2>Акции</h2>
			<?php endif;?>
			<ul class="news-items">
			<?php for($i=0;$i<count($events);$i++):?>
				<li>
					<h3><?=$events[$i]['title'];?></h3>
					<p class="descr"><?=$events[$i]['text'];?></p>
				<?php if($events[$i]['type'] == 1):?>
				<?php if(!$events[$i]['noimage']):?>
					<img src="<?=$baseurl;?>news/viewimage/<?=$events[$i]['id'];?>" alt="" /><br/><br/>
				<?php endif;?>
					<?=anchor('news/'.$events[$i]['translit'],'Подробнее &raquo;',array('class'=>'more'));?>
				<?php else:?>
				<?php if(!$events[$i]['noimage']):?>
					<img src="<?=$baseurl;?>stock/viewimage/<?=$events[$i]['id'];?>" alt="" /><br/><br/>
				<?php endif;?>
					<?=anchor('stock/'.$events[$i]['translit'],'Подробнее &raquo;',array('class'=>'more'));?>
				<?php endif;?>
					<p class="date"><?=$events[$i]['date'];?></p>
				</li>
			<?php endfor;?>
			</ul>
			<?php if($pages): ?>
				<?=$pages;?>
			<?php endif;?>
		</div>
	</div>
	<?php $this->load->view("users_interface/includes/footer");?>
	<?php $this->load->view("users_interface/includes/scripts");?>
</body>
</html>