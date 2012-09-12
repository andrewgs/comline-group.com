<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>Форма редактирования каталога</legend>
	<fieldset>
		<div class="control-group">
			<label for="title" class="control-label" style="text-align: left;">Название: </label>
			<div class="controls">
				<input type="text" class="input-xlarge input-valid" name="title" value="<?=$catalog['title'];?>">
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="text">Описание: </label>
			<div class="controls" style=" margin-left: 0px;">
				<textarea rows="10" class="span9 input-valid redactor" name="text"><?=$catalog['text'];?></textarea>
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="html">HTML-код: </label>
			<div class="controls" style=" margin-left: 0px;">
				<textarea rows="10" class="input-valid mrkRedactor" name="html"><?=$catalog['html'];?></textarea>
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<button class="btn btn-success" type="submit" id="send" name="submit" value="send">Сохранить</button>
		<button class="btn btn-inverse backpath" type="button">Отменить</button>
	</div>
<?= form_close(); ?>