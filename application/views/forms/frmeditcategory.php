<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>Форма редактирования категории товаров</legend>
	<fieldset>
		<div class="control-group">
			<label for="title" class="control-label">Название: </label>
			<div class="controls">
				<input type="text" class="span7 input-valid" name="title" value="<?=$category['title'];?>"/>
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="showitem" class="control-label">&nbsp;</label>
			<div class="controls">
				<label class="checkbox">
					<input type="checkbox" value="1" id="showitem" name="showitem" <?=($category['showitem'])? 'checked="checked"': '';?>/>
					Показывать категорию товара</label>
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<button class="btn btn-success" type="submit" id="send" name="submit" value="send">Сохранить</button>
		<button class="btn btn-inverse backpath" type="button">Отменить</button>
	</div>
<?= form_close(); ?>