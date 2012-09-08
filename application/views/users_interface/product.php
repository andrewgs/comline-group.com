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

		<div id="main" class="substrate categories large">
			<aside class="sorting">
				<ul class="categories-list gender">
					<li <?=($urlparam[0] == 1)?'class="disabled"':'';?>><input type="checkbox" id="woman" class="chGender chInput" <?=($urlparam[0] == 1)?'disabled="disabled"':'checked="checked"';?> name="woman" value="0" /><label>Женская одежда</label></li>
					<li <?=($urlparam[0] == 0)?'class="disabled"':'';?>><input type="checkbox" id="man" class="chGender chInput" <?=($urlparam[0] == 0)?'disabled="disabled"':'checked="checked"';?> name="man" value="1" /><label>Мужская одежда</label></li>
				</ul>
				<ul class="categories-list brands">
				<?php for($i=0;$i<count($brands);$i++):?>
					<li <?=($urlparam[1] != $brands[$i]['id'])?'class="disabled"':'';?>><input type="checkbox" class="chInput" name="brand" <?=($urlparam[1] != $brands[$i]['id'])?'disabled="disabled"':'checked="checked"';?> value="<?=$brands[$i]['id'];?>" /><label><?=$brands[$i]['title'];?></label></li>
				<?php endfor;?>
				</ul>
				<ul class="categories-list category">
				<?php for($i=0;$i<count($category);$i++):?>
					<li <?=($urlparam[2] != $category[$i]['id'])?'class="disabled"':'';?>><input type="checkbox" class="chCategory chInput" name="category" <?=($urlparam[2] != $category[$i]['id'])?'disabled="disabled"':'checked="checked"';?> value="<?=$category[$i]['id'];?>" /><label><?=$category[$i]['title'];?></label></li>
				<?php endfor;?>
				</ul>
			</aside>
			<div class="product-page cf">
					<div class="photos cf">
						<div class="nav-links">
							<?=anchor('catalog/come-back/'.$this->uri->segment(2),'&laquo; Вернуться к списку товаров',array('id'=>'comeBack'));?>
						</div>
						<div class="main-photo">
						<?php for($i=0;$i<count($primages);$i++):?>
							<?php if($primages[$i]['main']):?>
							<img src="<?=$baseurl;?>productimage/viewimage/<?=$primages[$i]['id'];?>" />
							<?php endif;?>
						<?php endfor;?>
						</div>
						<div class="pager">
						<?php for($i=0;$i<count($primages);$i++):?>
							<?php if(!$primages[$i]['main']):?>
							<img src="<?=$baseurl;?>productimage/viewimage/<?=$primages[$i]['id'];?>" /><br />
							<?php endif;?>
						<?php endfor;?>
						</div>
					</div>
					<div class="attributes">
						<div class="nav-links">
							<a href="<?=($prslide['prew'])?$baseurl.'product/'.$this->uri->segment(2).'/'.$prslide['prew']:'#'?>" class="prSlide<?=(!$prslide['prew'])?' blockLink none':''?>" id="prPrew">&laquo;  Предыдущий</a> &nbsp;|&nbsp; <a href="<?=($prslide['next'])?$baseurl.'product/'.$this->uri->segment(2).'/'.$prslide['next']:'#'?>" class="prSlide<?=(!$prslide['next'])?' blockLink none':''?>" id="prNext">Следующий  &raquo;</a>
						</div>
						<h1 class="product-title"><?=$product['title'];?></h1>
						<span class="articul">арт.<?=$product['art'];?></span>
						<p class="attr">
							<strong>Состав:</strong> <?=$product['composition'];?>
						</p>
						<p class="attr">
							<strong>Цвет:</strong>
						<?php for($i=0;$i<count($prcolors);$i++):?>
							<span class="product-color" style="background: #<?=$prcolors[$i]['code'];?>;"> </span>
						<?php endfor;?>
						</p>
						<p>
							<strong>Размеры:</strong> <br />
						<?php for($i=0;$i<count($prsizes);$i++):?>
							<?=$prsizes[$i]['code'];?>
							<?php if($i+1<count($prsizes)):?>
								,
							<?php endif;?>
						<?php endfor;?>
						</p>
						<p>
							<strong>Описание:</strong> <br />
							<?=$product['text'];?>
						</p>
					</div>
				</div>
		</div>
	</div>
	<?php $this->load->view("users_interface/includes/footer");?>
	<?php $this->load->view("users_interface/includes/scripts");?>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".chInput").click(function(){$(this).attr('checked','checked');});
		});
	</script>
</body>
</html>