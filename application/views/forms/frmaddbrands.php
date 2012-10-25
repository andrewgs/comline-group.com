<?=form_open_multipart($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>Форма добавления брендов</legend>
	<fieldset>
		<ul id="ProductTab" class="nav nav-tabs">
			<li class="active"><a href="#main" data-toggle="tab">Основные</a></li>
			<li><a href="#seasons" data-toggle="tab">Сезонные коллекции</a></li>
		</ul>
		<div id="ProductTabContent" class="tab-content">
			<div class="tab-pane fade in active" id="main">
				<div class="control-group">
					<label for="title" class="control-label">Название: </label>
					<div class="controls">
						<input type="text" class="input-xlarge input-valid" name="title" value="<?=set_value('title');?>">
						<span class="help-inline" style="display:none;">&nbsp;</span>
					</div>
				</div>
				<div class="control-group">
					<label for="status_string" class="control-label">Статусная строка: </label>
					<div class="controls">
						<input type="text" class="input-xlarge" name="status_string" value="<?=set_value('status_string');?>">
						<span class="help-inline" style="display:none;">&nbsp;</span>
					</div>
				</div>
				<div class="control-group">
					<label for="image" class="control-label">Логотип: </label>
					<div class="controls">
						<input type="file" class="input-file" name="image" size="30">
						<span class="help-inline" style="display:none;">&nbsp;</span>
						<p class="help-block">Поддерживаются форматы: JPG,PNG,GIF</p>
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
					<label for="sort" class="control-label">Пордковый номер: </label>
					<div class="controls">
						<input type="text" class="span1 digital" name="sort" value="<?=set_value('sort');?>">
						<span class="help-inline" style="display:none;">&nbsp;</span>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="seasons">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="w200">Название</th>
							<th class="w10">&nbsp;</th>
							<th class="w200">Название</th>
							<th class="w10">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php for($i=0;$i<count($seasons);$i+=2):?>
						<tr>
						<?php if(isset($seasons[$i]['id'])):?>
							<td class="w200"><?=$seasons[$i]['title'];?></td>
							<td class="w10">
								<input type="checkbox" class="chSeason" name="seasons[]" value="<?=$seasons[$i]['id'];?>" <?=($seasons[$i]['id'] == 0)?'checked="checked" disabled="disabled"':''?> />
							</td>
						<?php endif;?>
						<?php if(isset($seasons[$i+1]['id'])):?>
							<td class="w200"><?=$seasons[$i+1]['title'];?></td>
							<td class="w10">
								<input type="checkbox" class="chSeason" name="seasons[]" value="<?=$seasons[$i+1]['id'];?>" />
							</td>
						<?php else:?>
							<td class="w200">&nbsp;</td>
							<td class="w10">&nbsp;</td>
						<?php endif;?>
						</tr>
					<?php endfor; ?>
					</tbody>
				</table>
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<button class="btn btn-success" type="submit" id="send" name="submit" value="send">Добавить</button>
		<button class="btn btn-inverse backpath" type="button">Отменить</button>
	</div>
<?= form_close(); ?>