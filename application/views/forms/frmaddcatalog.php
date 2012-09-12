<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>Форма добавления каталога</legend>
	<fieldset>
		<div class="control-group">
			<label for="title" class="control-label" style="text-align: left;">Название: </label>
			<div class="controls">
				<input type="text" class="input-xlarge input-valid" name="title" value="<?=set_value('title');?>">
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="text">Описание: </label>
			<div class="controls" style=" margin-left: 0px;">
				<textarea rows="10" class="span9 input-valid redactor" name="text"><?=set_value('text');?></textarea>
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="html">HTML-код: </label>
			<div class="controls" style=" margin-left: 0px;">
				<textarea rows="10" class="input-valid mrkRedactor" name="html"><?=set_value('html');?></textarea>
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<button class="btn btn-success" type="submit" id="send" name="submit" value="send">Добавить</button>
		<button class="btn btn-inverse backpath" type="button">Отменить</button>
	</div>
<?= form_close(); ?>