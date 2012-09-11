<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>Форма добавления брендов</legend>
	<fieldset>
		<div class="control-group">
			<label for="title" class="control-label">Название: </label>
			<div class="controls">
				<input type="text" class="input-xlarge input-valid" name="title" value="<?=set_value('title');?>">
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="number" class="control-label">Номер: </label>
			<div class="controls">
				<input type="text" class="input-small input-valid digital" name="number" value="<?=set_value('number');?>">
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="code" class="control-label">Код цвета:</label>
			<div class="controls">
				<div class="input-prepend input-append">
					<span class="add-on">#</span><input type="text" class="input-small input-valid" value="<?=set_value('code');?>" id="ColorCode" name="code">
				</div>
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<button class="btn btn-success" type="submit" id="send" name="submit" value="send">Добавить</button>
		<button class="btn btn-inverse backpath" type="button">Отменить</button>
	</div>
<?= form_close(); ?>