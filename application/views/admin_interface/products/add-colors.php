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
						<?=anchor('',"Цвета",array('class'=>'none backpath'));?><span class="divider">/</span>
					</li>
					<li class="active">
						Добавление
					</li>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
				<?php $this->load->view("forms/frmaddcolor");?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script src="<?=$baseurl;?>js/colorpicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#ColorCode").ColorPicker({
				onSubmit: function(hsb,hex,rgb,el){
					$(el).val(hex);
					$(el).ColorPickerHide();
				},
				onBeforeShow: function (){
					$(this).ColorPickerSetColor(this.value);
				}
			})
			.bind("keyup", function(){
				$(this).ColorPickerSetColor(this.value);
			});
		});
	</script>
</body>
</html>
