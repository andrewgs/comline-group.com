<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>Форма добавления товара</legend>
	<fieldset>
		<div class="control-group">
			<label for="title" class="control-label">Название: </label>
			<div class="controls">
				<input type="text" class="span5 input-valid" name="title" value="<?=set_value('title');?>">
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="art" class="control-label">Артикл: </label>
			<div class="controls">
				<input type="text" class="span3 input-valid" name="art" value="<?=set_value('art');?>">
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="composition" class="control-label">Состав: </label>
			<div class="controls">
				<input type="text" class="span5 input-valid" name="composition" value="<?=set_value('composition');?>">
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="text" class="control-label">Описание: </label>
			<div class="controls">
				<textarea rows="10" class="span7 input-valid redactor" name="text"><?=set_value('text');?></textarea>
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="gender" class="control-label">Тип:</label>
			<div class="controls">
				<label class="checkbox">
					<input type="checkbox" value="0" class="chGender chInput" id="woman" name="gender[]" checked="checked">
					Женская одежда
				</label>
				<label class="checkbox">
					<input type="checkbox" value="1" class="chGender chInput" id="man" name="gender[]" checked="checked">
					Мужская одежда
				</label>
			</div>
		</div>
		<div class="control-group">
			<label for="category" class="control-label">Категория: </label>
			<div class="controls">
				<select class="span4" name="category" id="SetCategory">
				<?php for($i=0;$i<count($category);$i++):?>
					<option value="<?=$category[$i]['id'];?>"><?=$category[$i]['title'];?></option>
				<?php endfor;?>	
				</select>
			</div>
		</div>
		<div class="control-group">
			<label for="brand" class="control-label">Бренд: </label>
			<div class="controls">
				<select class="span4" name="brand" id="SetBrand">
				<?php for($i=0;$i<count($brands);$i++):?>
					<option value="<?=$brands[$i]['id'];?>"><?=$brands[$i]['title'];?></option>
				<?php endfor;?>	
				</select>
			</div>
		</div>
		<hr/>
		<div class="control-group">
			<label for="showitem" class="control-label">&nbsp;</label>
			<div class="controls">
				<label class="checkbox">
					<input type="checkbox" value="1" id="showitem" name="showitem" checked="checked">
					Показывать товара</label>
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<button class="btn btn-success" type="submit" id="send" name="submit" value="send">Добавить</button>
		<button class="btn btn-inverse backpath" type="button">Отменить</button>
	</div>
<?= form_close(); ?>