<!DOCTYPE html>
<html lang="en">
	<?=$this->load->view("admin_interface/includes/head");?>
	
<body>
	<div class="container">
		<div class="row">
			<div style="width:650px; margin:50px 0 0 150px;">
				<?php $this->load->view("forms/frmlogin");?>
			</div>
		</div>
	</div>
	<?php $this->load->view('admin_interface/includes/scripts');?>
</body>
</html>