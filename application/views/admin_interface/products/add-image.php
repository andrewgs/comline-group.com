<!DOCTYPE html>
<html lang="en">
<?php $this->load->view("admin_interface/includes/head-color");?>
<body>
	<?php $this->load->view("admin_interface/includes/header");?>
	<div class="container">
		<div class="row">
			<div class="span9">
				<ul class="breadcrumb">
					<li>
						<?=anchor('',"Продукты",array('class'=>'none backpath'));?><span class="divider">/</span>
					</li>
					<li>
						<?=anchor('admin-panel/actions/products/productid/'.$this->uri->segment(5).'/images',"Изображения продукта");?><span class="divider">/</span>
					</li>
					<li class="active">
						<?=$product;?><span class="divider">/</span>Добавление изображения
					</li>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
				<?php $this->load->view("forms/frmaddimages");?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".chInput").click(function(){
				if($(".chInput:checkbox:checked").length == 0){$(this).attr('checked','checked');}
				if($(".chInput:checkbox:checked").length >= 2){$(".chInput").removeAttr('checked');$(this).attr('checked','checked');}
			});
		});
	</script>
</body>
</html>
