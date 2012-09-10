<!DOCTYPE html>
<html lang="en">
<?php $this->load->view("admin_interface/includes/head");?>
<body>
	<?php $this->load->view("admin_interface/includes/header");?>
	<div class="container">
		<div class="row">
			<div class="span9">
				<ul class="breadcrumb">
					<li class="active">
						<?=anchor($this->uri->uri_string(),"Редактирование текстов");?>
					</li>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
				<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
				<fieldset>
					<div class="control-group">
						<label for="title" class="control-label"><?=$text['lname1'];?>: </label>
						<div class="controls">
							<textarea rows="10" class="span7 redactor" name="<?=$text['fname1'];?>"><?=$text['vname1'];?></textarea>
						</div>
					</div>
				<?php if(isset($text['fname2'])):?>
					<div class="control-group">
						<label for="title" class="control-label"><?=$text['lname2'];?>: </label>
						<div class="controls">
							<textarea rows="10" class="span7 redactor" name="<?=$text['fname2'];?>"><?=$text['vname2'];?></textarea>
						</div>
					</div>
				<?php endif;?>
				</fieldset>
				<div class="form-actions">
					<button class="btn btn-success" type="submit" id="send" name="submit" value="send">Сохранить</button>
				</div>
			<?= form_close(); ?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
</body>
</html>
