<?=form_open_multipart($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>Форма редактирования изображений</legend>
	<fieldset>
		<div class="control-group">
			<label for="image" class="control-label">Картинка: </label>
			<div class="controls">
				<input type="file" class="input-file" name="image" size="30">
				<p class="help-block">Изображение должно быть не менее 960px по ширене</p>
			</div>
		</div>
		<div class="control-group">
			<label for="title" class="control-label">Название: </label>
			<div class="controls">
				<input type="text" class="input-xlarge input-valid" name="title" value="<?=$image['title'];?>">
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="link" class="control-label">Ссылка: </label>
			<div class="controls">
				<input type="text" class="input-xlarge input-valid" name="link" value="<?=$image['link'];?>">
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="sort" class="control-label">Пордковый номер: </label>
			<div class="controls">
				<input type="text" class="span1 digital" name="sort" value="<?=($image['sort'] == 100000)? '':$image['sort'];?>">
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<button class="btn btn-success" type="submit" id="send" name="submit" value="send">Добавить</button>
		<button class="btn btn-inverse backpath" type="button">Отменить</button>
	</div>
<?= form_close(); ?>