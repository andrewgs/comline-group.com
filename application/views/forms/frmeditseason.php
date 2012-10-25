<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>Форма редактирования сезонной коллекции</legend>
	<fieldset>
		<div class="control-group">
			<label for="title" class="control-label">Название: </label>
			<div class="controls">
				<input type="text" class="input-xlarge input-valid" name="title" value="<?=$season['title'];?>"/>
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<button class="btn btn-success" type="submit" id="send" name="submit" value="send">Сохранить</button>
		<button class="btn btn-inverse backpath" type="button">Отменить</button>
	</div>
<?= form_close(); ?>