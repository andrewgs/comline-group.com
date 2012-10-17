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
					<li><input type="checkbox" class="chBrands" name="brand<?=$i;?>" <?=($brands[$i]['checked'])? 'checked="checked"' : '';?> value="<?=$brands[$i]['id'];?>" /><label><?=$brands[$i]['title'];?></label></li>
				<?php endfor;?>
				</ul>
				<ul class="categories-list category">
				<?php for($i=0;$i<count($category);$i++):?>
					<li><input type="checkbox" class="chCategory chInput" name="category<?=$i;?>" <?=($category[$i]['checked'] && !$category[$i]['disable'])? 'checked="checked"' : '';?> <?=($category[$i]['disable'])? 'disabled="disabled"' : '';?> value="<?=$category[$i]['id'];?>" /><label><?=$category[$i]['title'];?></label></li>
				<?php endfor;?>
				</ul>
			</aside>
			<div class="products-by-categories" id="product-list"></div>
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
				var objGender = $(".chGender:checkbox:checked");
				var objBrands = $(".chBrands:checkbox:checked");
				if($(objBrands).length == 0){return false;}
				gender = $(objGender).serialize();
				brands = $(objBrands).serialize();
				calegory_list(gender,brands);
			});
			
			$(".chInput").click(function(){
				var objGender = $(".chGender:checkbox:checked");
				var objBrands = $(".chBrands:checkbox:checked");
				var objCategory = $(".chCategory:checkbox:checked").not(":disabled");
				if($(objGender).length == 0){$(this).attr('checked','checked'); return false;}
				if($(objBrands).length == 0){$(this).attr('checked','checked'); return false;}
				gender = $(objGender).serialize();
				brands = $(objBrands).serialize();
				category = $(objCategory).serialize();
				offer_list(gender,brands,category);
			});
			
			function refresh_data(){
				var gender = $(".chGender:checkbox:checked").serialize();
				var brands = $(".chBrands:checkbox:checked").serialize();
				var category = $(".chCategory:checkbox:checked").not(":disabled").serialize();
				offer_list(gender,brands,category);
			}
			function offer_list(gender,brands,category){
				$("#product-list").html('<span class="ajax_request">Загрузка данных...</span>').show();
				$("#product-list").load("<?=$baseurl;?>catalog/load-products",{'gender':gender,'brands':brands,'category':category,'page':page});
			}
			function calegory_list(gender,brands){
				$.post("<?=$baseurl;?>catalog/calegory-list",
					{'gender':gender,'brands':brands},
					function(data){
						$(".chCategory").attr("disabled","disabled");
						$.each(data.category, function(){$(".chCategory[value = "+this.id+"]").removeAttr("disabled");});
						page = 1;refresh_data();
					},'json'
				);
			}
			$(".pagination li.active").live("click",function(){
				page = $(this).attr("data-page");
				refresh_data();
			});
		});
	</script>
</body>
</html>