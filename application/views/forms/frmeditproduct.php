<?=form_open_multipart($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>Форма редактирования товара</legend>
	<fieldset>
		<div class="control-group">
			<label for="title" class="control-label">Название: </label>
			<div class="controls">
				<input type="text" class="span5 input-valid" name="title" value="<?=$product['title'];?>">
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="art" class="control-label">Артикл: </label>
			<div class="controls">
				<input type="text" class="span3 input-valid" name="art" value="<?=$product['art'];?>">
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div><div class="control-group">
			<label for="composition" class="control-label">Состав: </label>
			<div class="controls">
				<input type="text" class="span5 input-valid" name="composition" value="<?=$product['composition'];?>">
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="text" class="control-label">Описание: </label>
			<div class="controls">
				<textarea rows="10" class="span7 input-valid redactor" name="text"><?=$product['text'];?></textarea>
				<span class="help-inline" style="display:none;">&nbsp;</span>
			</div>
		</div>
		<div class="control-group">
			<label for="gender" class="control-label">Тип:</label>
			<div class="controls">
			<?php for($i=0;$i<count($gender);$i++):?>
				<label class="checkbox">
					<input type="checkbox" value="<?=$i;?>" class="chGender chInput" name="gender[]" <?=($gender[$i]['checked'])?'checked="checked"':''?>>
					<?=$gender[$i]['title'];?>
				</label>
			<?php endfor;?>
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
		<div class="span4">
			<div class="control-group">
				<label for="colors" class="control-label">Цвета: </label>
				<div class="controls">
					<select class="span2" name="colors[]" id="SetColors" multiple="multiple" size="<?=(count($colors)>=8)?'8':count($colors);?>">
					<?php for($i=0;$i<count($colors);$i++):?>
						<option style="background-color:<?=$colors[$i]['code'];?>" <?=($colors[$i]['checked'])?'selected':'';?> value="<?=$colors[$i]['id'];?>"><?=$colors[$i]['title'];?></option>
					<?php endfor;?>	
					</select>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<label for="sizes" class="control-label">Размеры: </label>
				<div class="controls">
					<select class="span2" name="sizes[]" id="SetSizes" multiple="multiple" size="<?=(count($sizes)>=8)?'8':count($sizes);?>">
					<?php for($i=0;$i<count($sizes);$i++):?>
						<option value="<?=$sizes[$i]['id'];?>" <?=($sizes[$i]['checked'])?'selected':'';?> ><?=$sizes[$i]['code'];?></option>
					<?php endfor;?>	
					</select>
				</div>
			</div>
		</div>
		<div class="clear"></div>
		<hr/>
		<div class="control-group">
			<label for="showitem" class="control-label">&nbsp;</label>
			<div class="controls">
				<label class="checkbox">
					<input type="checkbox" value="1" id="showitem" name="showitem" <?=($product['showitem'])?'checked="checked"':''?> />
					Показывать товара</label>
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<button class="btn btn-success" type="submit" id="send" name="submit" value="send">Сохранить</button>
		<button class="btn btn-inverse backpath" type="button">Отменить</button>
	</div>
<?= form_close(); ?>