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
						Добавление
					</li>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
				<?php $this->load->view("forms/frmaddproduct");?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script src="<?=$baseurl;?>js/redactor.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".redactor").redactor();
			
			$(".chGender").click(function(){
				if($(".chGender:checkbox:checked").length == 0){$(this).attr('checked','checked');}
			});
			$(".chColor").click(function(){
				if($(".chColor:checkbox:checked").length == 0){$(this).attr('checked','checked');}
			});
			$(".chSize").click(function(){
				if($(".chSize:checkbox:checked").length == 0){$(this).attr('checked','checked');}
			});
		});
	</script>
</body>
</html>
