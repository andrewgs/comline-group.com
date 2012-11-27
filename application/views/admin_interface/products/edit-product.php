<!DOCTYPE html>
<html lang="en">
<?php $this->load->view("admin_interface/includes/head");?>
<body>
	<?php $this->load->view("admin_interface/includes/header");?>
	<div class="container">
		<div class="row">
			<div class="span9">
				<ul class="breadcrumb">
					<li>
						<?=anchor('',"Продукты",array('class'=>'none backpath'));?><span class="divider">/</span>
					</li>
					<li class="active">
						Редактирование
					</li>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
				<?php $this->load->view("forms/frmeditproduct");?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script src="<?=$baseurl;?>js/redactor.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".redactor").redactor();
			$("#SetBrand").val(<?=$product['brand'];?>);
			
			$(".product-li").click(function(){
				var nav = $(this).attr("data-nav");
				var number = $(this).index();
				$(".dispnone").hide();
				$("#"+nav).show();
				$(".product-li").removeClass('inactive').addClass('active');
				$(".product-li").not(this).removeClass('active').addClass('inactive');
			});
				
			$(".dispnone").not(':first').hide();
			$(".chGender").click(function(){check('chGender',this);});
			$(".chCategory").click(function(){check('chCategory',this);});
			$(".chColor").click(function(){check('chColor',this);});
			$(".chSize").click(function(){check('chSize',this);});
			function check(objects,obj){if($("."+objects+":checkbox:checked").length == 0){$(obj).attr('checked','checked');}}
		});
	</script>
</body>
</html>
