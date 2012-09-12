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
			<h1><?=$events['title'];?></h1>
		<?php if($events['type'] == 1):?>
			<?php if(!$events['noimage']):?>
			<img src="<?=$baseurl;?>news/viewimage/<?=$events['id'];?>" alt="" width="150"/><br/><br/>
			<?php endif;?>
		<?php else:?>
			<?php if(!$events['noimage']):?>
			<img src="<?=$baseurl;?>stock/viewimage/<?=$events['id'];?>" alt="" width="150"/><br/><br/>
			<?php endif;?>
		<?php endif;?>
			<p class="descr"><?=$events['text'];?></p>
			<p class="date"><?=$events['date'];?></p>
			<?php if($this->uri->segment(1) == 'news'):?>
				<?=anchor('all-news','Весь список &raquo;',array('class'=>'more'));?>
			<?php else:?>
				<?=anchor('all-stock','Весь список &raquo;',array('class'=>'more'));?>
			<?php endif;?>
		</div>
	</div>
	<?php $this->load->view("users_interface/includes/footer");?>
	<?php $this->load->view("users_interface/includes/scripts");?>
</body>
</html>