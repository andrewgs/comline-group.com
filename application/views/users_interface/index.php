<!DOCTYPE html>
<!-- /ht Paul Irish - http://front.ie/j5OMXi -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en"><!--<![endif]-->
	<?php $this->load->view("users_interface/includes/head");?>
	
<body>
	<div id="container" class="cf">
		<?php $this->load->view("users_interface/includes/header");?>
		
		<div id="main" role="main">
			<div class="slider-wrapper">
				<div class="slider">
					<img src="<?=$baseurl;?>images/banner-1.jpg" alt="Одежда для беременных" title="Always Land. Одежда для беременных">
					<img src="<?=$baseurl;?>images/banner-2.jpg" alt="Одежда для беременных" title="Always Land. Одежда для беременных">
				</div>
				<a id="left-arrow" href="#">Пред.</a>
				<a id="right-arrow" href="#">След.</a>
			</div>
			<ul id="categories-nav" class="cf">
			<?php for($i=0;$i<count($category);$i++):?>
				<li><?=anchor('category/'.$category[$i]['translit'],$category[$i]['title'],array('title'=>$category[$i]['title']));?></li>
			<?php endfor;?>
			</ul>
			<ul id="brands-nav">
				<?php for($i=0;$i<count($brands);$i++):?>
					<li>
						<?=anchor('brands/'.$brands[$i]['translit'],'<img src="'.$baseurl.'brands/viewimage/'.$brands[$i]['id'].'" /><br/><span class="underlined">'.$brands[$i]['title'].'</span>');?>
					</li>
				<?php endfor;?>
			</ul>
			<div id="content-area">
				<div class="column">
					<h2>Новости</h2>
					<ul class="news-items">
					<?php for($i=0;$i<count($news);$i++):?>
						<li>
							<h3><?=anchor('news/'.$news[$i]['translit'],$news[$i]['title']);?></h3>
							<p class="descr"><?=$news[$i]['text'];?></p>
							<img src="<?=$baseurl;?>news/viewimage/<?=$news[$i]['id'];?>" alt="" width="150"/><br/><br/>
							<?=anchor('news/'.$news[$i]['translit'],'Подробнее &raquo;',array('class'=>'more'));?>
							<p class="date"><?=$news[$i]['date'];?></p>
						</li>
					<?php endfor;?>
					</ul>
				</div>
				<div class="column">
					<h2>Акции</h2>
					<ul class="news-items">
						<?php for($i=0;$i<count($stock);$i++):?>
							<li>
								<h3><?=anchor('stock/'.$stock[$i]['translit'],$stock[$i]['title']);?></h3>
								<p class="descr"><?=$stock[$i]['text'];?></p>
								<img src="<?=$baseurl;?>stock/viewimage/<?=$stock[$i]['id'];?>" alt="" width="150" /><br/><br/>
								<?=anchor('stock/'.$stock[$i]['translit'],'Подробнее &raquo;',array('class'=>'more'));?>
								<p class="date"><?=$stock[$i]['date'];?></p>
							</li>
						<?php endfor;?>
					</ul>
				</div>
				<div class="column">
					<h4>Подписаться на новости</h4>
					<?php $this->load->view("forms/frmsubscribe");?>
					<p>Получайте уведомления о поступлениях товара, обновлениях новостей и новых акциях.</p>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view("users_interface/includes/footer");?>
	<?php $this->load->view("users_interface/includes/scripts");?>
	<script src="<?=$baseurl;?>js/libs/jquery.cycle.js"></script>
	<script src="<?=$baseurl;?>js/libs/jquery.easing.js"></script>
	<script type="text/javascript">
	 	$(document).ready(function(){
			$("div.slider").cycle({
				fx: 'fade',
				speed: '3000',
				easing: 'easeInOutExpo',
				timeout: 5000,
				next:'#right-arrow',
				prev:'#left-arrow' 
			});
		});
	</script>
</body>
</html>