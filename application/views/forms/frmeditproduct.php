<?=form_open_multipart($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>Форма редактирования товара</legend>
	<fieldset>
		<ul id="ProductTab" class="nav nav-tabs">
			<li class="active"><a href="#main" data-toggle="tab">Основные</a></li>
			<li><a href="#category" data-toggle="tab">Категории</a></li>
			<li><a href="#colors" data-toggle="tab">Цвета</a></li>
			<li><a href="#sizes" data-toggle="tab">Размеры</a></li>
		</ul>
		<div id="ProductTabContent" class="tab-content">
			<div class="tab-pane fade in active" id="main">
				<div class="control-group">
					<label for="title" class="control-label">Название: </label>
					<div class="controls">
						<input type="text" class="span5 input-valid" name="title" value="<?=$product['title'];?>">
						<span class="help-inline" style="display:none;">&nbsp;</span>
					</div>
				</div>
				<div class="control-group">
					<label for="art" class="control-label">Артикул: </label>
					<div class="controls">
						<input type="text" class="span2 input-valid" name="art" value="<?=$product['art'];?>">
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
							<input type="checkbox" value="<?=$i;?>" class="chGender" name="gender[]" <?=($gender[$i]['checked'])?'checked="checked"':''?>>
							<?=$gender[$i]['title'];?>
						</label>
					<?php endfor;?>
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
				<div class="control-group">
					<label for="showitem" class="control-label">&nbsp;</label>
					<div class="controls">
						<label class="checkbox">
							<input type="checkbox" value="1" id="showitem" name="showitem" <?=($product['showitem'])?'checked="checked"':''?> />
							Показывать товар</label>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="category">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="w100">Название</th>
							<th class="w10">&nbsp;</th>
							<th class="w100">Название</th>
							<th class="w10">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php for($i=0;$i<count($category);$i+=2):?>
						<tr>
						<?php if(isset($category[$i]['id'])):?>
							<td class="w100"><?=$category[$i]['title'];?></td>
							<td class="w10">
								<input type="checkbox" class="chCategory" <?=($category[$i]['checked'])?'checked="checked"':'';?> name="category[]" value="<?=$category[$i]['id'];?>" />
							</td>
						<?php endif;?>
						<?php if(isset($category[$i+1]['id'])):?>
							<td class="w100"><?=$category[$i+1]['title'];?></td>
							<td class="w10">
								<input type="checkbox" class="chCategory" <?=($category[$i+1]['checked'])?'checked="checked"':'';?> name="category[]" value="<?=$category[$i+1]['id'];?>" />
							</td>
						<?php else:?>
							<td class="w100">&nbsp;</td>
							<td class="w10">&nbsp;</td>
						<?php endif;?>
						</tr>
					<?php endfor; ?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane fade" id="colors">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="w50"><center>Цвет</center></th>
							<th class="w50"><center>Код</center></th>
							<th class="w100">[Номер] Название</th>
							<th class="w10">&nbsp;</th>
							<th class="w50"><center>Цвет</center></th>
							<th class="w50"><center>Код</center></th>
							<th class="w100">[Номер] Название</th>
							<th class="w10">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php for($i=0;$i<count($colors);$i+=2):?>
						<tr>
						<?php if(isset($colors[$i]['id'])):?>
							<td class="w50"><div style="background-color:<?=$colors[$i]['code'];?>; width: 50px; height: 20px;"></div></td>
							<td class="w50"><?=$colors[$i]['code'];?></td>
							<td class="w100"><strong>[<?=$colors[$i]['number'];?>]</strong> <?=$colors[$i]['title'];?></td>
							<td class="w10">
								<input type="checkbox" class="chColor" <?=($colors[$i]['checked'])?'checked="checked"':'';?> name="colors[]" value="<?=$colors[$i]['id'];?>" />
							</td>
						<?php endif;?>
						<?php if(isset($colors[$i+1]['id'])):?>
							<td class="w50"><div style="background-color:<?=$colors[$i+1]['code'];?>; width: 50px; height: 20px;"></div></td>
							<td class="w50"><?=$colors[$i+1]['code'];?></td>
							<td class="w100"><strong>[<?=$colors[$i+1]['number'];?>]</strong> <?=$colors[$i+1]['title'];?></td>
							<td class="w10">
								<input type="checkbox" class="chColor" <?=($colors[$i+1]['checked'])?'checked="checked"':'';?> name="colors[]" value="<?=$colors[$i+1]['id'];?>" />
							</td>
						<?php else:?>
							<td class="w50">&nbsp;</td>
							<td class="w50">&nbsp;</td>
							<td class="w100">&nbsp;</td>
							<td class="w10">&nbsp;</td>
						<?php endif;?>
						</tr>
					<?php endfor; ?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane fade" id="sizes">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="w200"><center><nobr>Размер</nobr></center></th>
							<th class="w10">&nbsp;</th>
							<th class="w200"><center><nobr>Размер</nobr></center></th>
							<th class="w10">&nbsp;</th>
							<th class="w200"><center><nobr>Размер</nobr></center></th>
							<th class="w10">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
				<?php for($i=0;$i<9;$i+=3):?>
						<tr>
						<?php if(isset($sizes[$i]['id'])):?>
							<td class="w200"><?=$sizes[$i]['code'];?></td>
							<td class="w10"><input type="checkbox" class="chSize" <?=($sizes[$i]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i]['id'];?>" /></td>
						<?php endif;?>
						<?php if(isset($sizes[$i+1]['id'])):?>
							<td class="w200"><?=$sizes[$i+1]['code'];?></td>
							<td class="w10"><input type="checkbox" class="chSize" <?=($sizes[$i+1]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i+1]['id'];?>" /></td>
						<?php endif;?>
						<?php if(isset($sizes[$i+2]['id'])):?>
							<td class="w200"><?=$sizes[$i+2]['code'];?></td>
							<td class="w10"><input type="checkbox" class="chSize" <?=($sizes[$i+2]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i+2]['id'];?>" /></td>
						<?php endif;?>
						</tr>
				<?php endfor; ?>
						<tr><td colspan="6">&nbsp;</td></tr>
				<?php for($i=9;$i<17;$i+=3):?>
						<tr>
						<?php if(isset($sizes[$i]['id'])):?>
							<td class="w200"><?=$sizes[$i]['code'];?></td>
							<td class="w10"><input type="checkbox" class="chSize" <?=($sizes[$i]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i]['id'];?>" /></td>
						<?php endif;?>
						<?php if(isset($sizes[$i+1]['id']) && $i < 16):?>
							<td class="w200"><?=$sizes[$i+1]['code'];?></td>
							<td class="w10"><input type="checkbox" class="chSize" <?=($sizes[$i+1]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i+1]['id'];?>" /></td>
						<?php endif;?>
						<?php if(isset($sizes[$i+2]['id']) && $i < 15):?>
							<td class="w200"><?=$sizes[$i+2]['code'];?></td>
							<td class="w10"><input type="checkbox" class="chSize" <?=($sizes[$i+2]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i+2]['id'];?>" /></td>
						<?php else:?>
							<td class="w200">&nbsp;</td>
							<td class="w10">&nbsp;</td>
						<?php endif;?>
						</tr>
				<?php endfor; ?>
						<tr><td colspan="6">&nbsp;</td></tr>
				<?php for($i=17;$i<21;$i+=3):?>
						<tr>
						<?php if(isset($sizes[$i]['id'])):?>
							<td class="w200"><?=$sizes[$i]['code'];?></td>
							<td class="w10"><input type="checkbox" class="chSize" <?=($sizes[$i]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i]['id'];?>" /></td>
						<?php endif;?>
						<?php if(isset($sizes[$i+1]['id']) && $i < 19):?>
							<td class="w200"><?=$sizes[$i+1]['code'];?></td>
							<td class="w10"><input type="checkbox" class="chSize" <?=($sizes[$i+1]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i+1]['id'];?>" /></td>
						<?php endif;?>
						<?php if(isset($sizes[$i+2]['id']) && $i < 18):?>
							<td class="w200"><?=$sizes[$i+2]['code'];?></td>
							<td class="w10"><input type="checkbox" class="chSize" <?=($sizes[$i+2]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i+2]['id'];?>" /></td>
						<?php else:?>
							<td class="w200">&nbsp;</td>
							<td class="w10">&nbsp;</td>
							<td class="w200">&nbsp;</td>
							<td class="w10">&nbsp;</td>
						<?php endif;?>
						</tr>
				<?php endfor; ?>
						<tr><td colspan="6">&nbsp;</td></tr>
				<?php for($i=21;$i<30;$i+=3):?>
						<tr>
						<?php if(isset($sizes[$i]['id'])):?>
							<td class="w200"><?=$sizes[$i]['code'];?></td>
							<td class="w10"><input type="checkbox" class="chSize" <?=($sizes[$i]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i]['id'];?>" /></td>
						<?php endif;?>
						<?php if(isset($sizes[$i+1]['id'])):?>
							<td class="w200"><?=$sizes[$i+1]['code'];?></td>
							<td class="w10"><input type="checkbox" class="chSize" <?=($sizes[$i+1]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i+1]['id'];?>" /></td>
						<?php endif;?>
						<?php if(isset($sizes[$i+2]['id'])):?>
							<td class="w200"><?=$sizes[$i+2]['code'];?></td>
							<td class="w10"><input type="checkbox" class="chSize" <?=($sizes[$i+2]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i+2]['id'];?>" /></td>
						<?php endif;?>
						</tr>
				<?php endfor; ?>
						<tr><td colspan="6">&nbsp;</td></tr>
				<?php for($i=30;$i<count($sizes);$i+=3):?>
						<tr>
						<?php if(isset($sizes[$i]['id'])):?>
							<td class="w200"><?=$sizes[$i]['code'];?></td>
							<td class="w10"><input type="checkbox" class="chSize" <?=($sizes[$i]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i]['id'];?>" /></td>
						<?php endif;?>
						<?php if(isset($sizes[$i+1]['id'])):?>
							<td class="w200"><?=$sizes[$i+1]['code'];?></td>
							<td class="w10"><input type="checkbox" class="chSize" <?=($sizes[$i+1]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i+1]['id'];?>" /></td>
						<?php endif;?>
						<?php if(isset($sizes[$i+2]['id'])):?>
							<td class="w200"><?=$sizes[$i+2]['code'];?></td>
							<td class="w10"><input type="checkbox" class="chSize" <?=($sizes[$i+2]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i+2]['id'];?>" /></td>
						<?php endif;?>
						</tr>
				<?php endfor; ?>
					</tbody>
				</table>
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<button class="btn btn-success" type="submit" id="send" name="submit" value="send">Сохранить</button>
		<button class="btn btn-inverse backpath" type="button">Отменить</button>
	</div>
<?= form_close(); ?>