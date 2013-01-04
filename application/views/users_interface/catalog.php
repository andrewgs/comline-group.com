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
				<?php if($this->session->userdata('gender')):?>
					<li><input type="checkbox" id="woman" class="chGender chInput" <?=($this->session->userdata('gender') == 1)?'':'checked="checked"';?> name="woman" value="0" /><label>Женская одежда</label></li>
					<li><input type="checkbox" id="man" class="chGender chInput" <?=($this->session->userdata('gender') == 0)?'':'checked="checked"';?> name="man" value="1" /><label>Мужская одежда</label></li>
				<?php else:?>
					<li><input type="checkbox" id="woman" class="chGender chInput" checked="checked" name="woman" value="0" /><label>Женская одежда</label></li>
					<li><input type="checkbox" id="man" class="chGender chInput" checked="checked" name="man" value="1" /><label>Мужская одежда</label></li>
				<?php endif;?>
				</ul>
				<ul class="categories-list brands">
				<?php for($i=0;$i<count($brands);$i++):?>
					<li>
						<input type="checkbox" class="chBrands" name="brand<?=$brands[$i]['id'];?>" <?=($brands[$i]['checked'])? 'checked="checked"' : '';?> value="<?=$brands[$i]['id'];?>" /><label><?=$brands[$i]['title'];?></label>
						<ul>
					<?php for($j=0;$j<count($brseasons);$j++):?>
						<?php if($brseasons[$j]['brand'] == $brands[$i]['id']):?>
							<li>
								<input type="checkbox" class="chSeason" data-brand="<?=$brands[$i]['id'];?>" name="season<?=$brseasons[$j]['id'];?>" <?=($brands[$i]['checked'])? 'checked="checked"' : '';?> value="<?=$brseasons[$j]['season'];?>" /><label><?=$seasons[$brseasons[$j]['season']]['title'];?></label>
							</li>
						<?endif;?>
					<?php endfor;?>
						</ul>
					</li>
				<?php endfor;?>
				</ul>
				<ul class="categories-list category">
				<?php for($i=0;$i<count($category);$i++):?>
					<li><input type="checkbox" class="chCategory chInput" name="category<?=$i;?>" <?=($category[$i]['checked'] && !$category[$i]['disable'])? 'checked="checked"' : '';?> <?=($category[$i]['disable'])? 'disabled="disabled"' : '';?> value="<?=$category[$i]['id'];?>" /><label><?=$category[$i]['title'];?></label></li>
				<?php endfor;?>
				</ul>
				<div class="ajax_submit">
					<a href="#" class="none action-btn" id="Refresh">Поиск товаров</a>
				</div>
			</aside>
			<div id="backdrop"></div>
			<div id="loading"></div>
			<div class="products-by-categories" id="product-list"></div>
			<div class="clear"></div>
		<?php if(isset($about_category) && !empty($about_category)):?>
			<div class="category_content">
				<?=$about_category;?>
			</div>
		<?php endif;?>
		<noscript>
		<?php for($i=0;$i<count($product_category);$i++):?>
			<?php $exist = 0;?>
			<?php for($j=0;$j<count($products);$j++):?>
				<?php if($products[$j]['category'] == $product_category[$i]['id']):?>
					<?php $exist = 1;?>
				<?php endif;?>
			<?php endfor;?>
			<?php if($exist):?>
				<h2><?=$product_category[$i]['title'];?></h2>
				<div class="products-group cf">
				<?php for($j=0;$j<count($products);$j++):?>
					<?php if($products[$j]['category'] == $product_category[$i]['id']):?>
					<div class="product-preview">
						<a class="thumb" href="<?=$baseurl.'product/'.$products[$j]['gender'].'-'.$products[$j]['brand'].'-'.$products[$j]['category'].'-'.$products[$j]['id'].'/'.$products[$j]['translit'] ?>">
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
		<?php if($pages): ?>
			<?=$pages;?>
		<?php endif;?>
		</noscript>
		</div>
	</div>
	<?php $this->load->view("users_interface/includes/footer");?>
	<?php $this->load->view("users_interface/includes/scripts");?>
	<script src="<?=$baseurl;?>js/pagination.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			var page = 1;
			refresh_data(page);
			$(".chBrands").click(function(){
				var BrThis = $(this).val();
				if($(this).attr("checked")){$(".chSeason[data-brand='"+BrThis+"']").attr("checked","checked");
				}else{$(".chSeason[data-brand='"+BrThis+"']").removeAttr("checked");}
				var objGender = $(".chGender:checkbox:checked");
				var objBrands = $(".chBrands:checkbox:checked");
				if($(objBrands).length == 0){$(".chSeason[data-brand='"+BrThis+"']").attr("checked","checked");return false;}
				gender = $(objGender).serialize();
				brands = $(objBrands).serialize();
				calegory_list(gender,brands);
			});
			
			$("input:checkbox").click(function(){page = 1;})
			
			$(".chInput").click(function(){
				var objGender = $(".chGender:checkbox:checked");
				var objBrands = $(".chBrands:checkbox:checked");
				var objCategory = $(".chCategory:checkbox:checked").not(":disabled");
				if($(objGender).length == 0){$(this).attr('checked','checked'); return false;}
				if($(objBrands).length == 0){$(this).attr('checked','checked'); return false;}
//				gender = $(objGender).serialize();
//				brands = $(objBrands).serialize();
//				category = $(objCategory).serialize();
//				offer_list(gender,brands,category);
			});
			
			$(".chSeason").click(function(){
				var BrID = $(this).attr("data-brand");
				$(".chBrands[name='brand"+BrID+"']").attr('checked','checked');
				var SBLen = $(".chSeason[data-brand='"+BrID+"']:checked").length;
				if(SBLen == 0){$(this).attr('checked','checked'); return false;}
			});
			
			function refresh_data(){
				var gender = $(".chGender:checkbox:checked").serialize();
				var brands = $(".chBrands:checkbox:checked").serialize();
				var seasons = $(".chSeason:checkbox:checked").serialize();
				var category = $(".chCategory:checkbox:checked").not(":disabled").serialize();
				offer_list(gender,brands,seasons,category);
			}
			function offer_list(gender,brands,seasons,category){
				$("#backdrop").addClass("loading-backdrop");
				$("#loading").html('<span class="ajax_request">Загрузка данных...</span>').show();
				$("#product-list").load("<?=$baseurl;?>catalog/load-products",{'gender':gender,'brands':brands,'seasons':seasons,'category':category,'page':page},
					function(){
						$("#loading").hide();
						$("#backdrop").removeClass("loading-backdrop");
					}
				);
			}
			function calegory_list(gender,brands){
				$.post("<?=$baseurl;?>catalog/calegory-list",
					{'gender':gender,'brands':brands},
					function(data){
						$(".chCategory").attr("disabled","disabled");
						if(data.status){$.each(data.category, function(){$(".chCategory[value = "+this.id+"]").removeAttr("disabled");});}
//						refresh_data();
					},'json'
				);
			}
			
			$("#Refresh").click(function(){refresh_data();});
			
			$(".pagination li.active").live("click",function(){
				page = $(this).attr("data-page");
				$("html, body").animate({scrollTop:'0'},"slow");
				refresh_data();
			});
		});
	</script>
</body>
</html>