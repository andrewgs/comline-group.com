<?=form_open_multipart($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>Форма редактирования новости</legend>
	<fieldset>
		<div class="control-group">
			<label for="title" class="control-label">Название: </label>
			<div class="controls">
				<input type="text" class="span7 input-valid" name="title" value="<?=$event['title'];?>">
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="content" class="control-label">Содержание: </label>
			<div class="controls">
				<textarea rows="10" class="span7 input-valid redactor" name="text"><?=$event['text'];?></textarea>
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="image" class="control-label">Изображение: </label>
			<div class="controls">
				<input type="file" class="input-file" name="image" size="50">
				<span class="help-inline" style="display:none;">&nbsp;</span>
				<p class="help-block">Поддерживаются форматы: JPG,PNG,GIF</p>
			</div>
		</div>
		<div class="control-group">
			<label for="image" class="control-label">Текущее изображение: </label>
			<div class="controls">
			<?php if($event['type'] == 1):?>
				<img src="<?=$baseurl;?>news/viewimage/<?=$event['id'];?>" alt="" width="150"/><br/><br/>
			<?php else:?>
				<img src="<?=$baseurl;?>stock/viewimage/<?=$event['id'];?>" alt="" width="150"/><br/><br/>
			<?php endif;?>
			</div>
		</div>
		<div class="control-group">
			<label for="showitem" class="control-label">&nbsp;</label>
			<div class="controls">
				<label class="checkbox">
					<input type="checkbox" value="1" id="noimage" name="noimage" <?=($event['noimage'])? 'checked="checked"' : '';?>>
					Не показывать изображение</label>
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<button class="btn btn-success" type="submit" id="send" name="submit" value="send">Сохранить</button>
		<button class="btn btn-inverse backpath" type="button">Отменить</button>
	</div>
<?= form_close(); ?>