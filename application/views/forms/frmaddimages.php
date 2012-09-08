<?=form_open_multipart($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>Форма добавления изображений товара</legend>
	<fieldset>
		<div class="span6">
			<div class="control-group">
				<label for="image" class="control-label">Картинка №1: </label>
				<div class="controls">
					<input type="file" class="input-file" name="image0" size="30">
				</div>
			</div>
			<div class="control-group">
				<label for="image" class="control-label">Картинка №2: </label>
				<div class="controls">
					<input type="file" class="input-file" name="image1" size="30">
				</div>
			</div>
			<div class="control-group">
				<label for="image" class="control-label">Картинка №3: </label>
				<div class="controls">
					<input type="file" class="input-file" name="image2" size="30">
				</div>
			</div>
			<div class="control-group">
				<label for="image" class="control-label">Картинка №4: </label>
				<div class="controls">
					<input type="file" class="input-file" name="image3" size="30">
				</div>
			</div>
			<div class="control-group">
				<label for="image" class="control-label">Картинка №5: </label>
				<div class="controls">
					<input type="file" class="input-file" name="image4" size="30">
				</div>
			</div>
		</div>
		<div class="span1">
		<?php for($i=0;$i<5;$i++):?>
			<div class="control-group">
				<div class="controls" style="margin-left: 0;">
					<label class="checkbox">
						<input type="checkbox" value="1" class="chInput" name="image<?=$i;?>">
					</label>
				</div>
			</div>
			<?php endfor;?>
		</div>
	</fieldset>
	<div class="form-actions">
		<button class="btn btn-success" type="submit" id="send" name="submit" value="send">Добавить</button>
		<button class="btn btn-inverse backpath" type="button">Отменить</button>
	</div>
<?= form_close(); ?>