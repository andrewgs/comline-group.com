<!DOCTYPE html>
<html lang="en">
<?php $this->load->view("admin_interface/includes/head");?>
<body>
	<?php $this->load->view("admin_interface/includes/header");?>
	<div class="container">
		<div class="row">
			<div class="span9">
				<ul class="breadcrumb">
					<li>
						<?=anchor('',"Продукты",array('class'=>'none backpath'));?><span class="divider">/</span>
					</li>
					<li class="active">
						Размер продукта
					</li>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
			<?=form_open($this->uri->uri_string()); ?>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="w100"><center><nobr>Размер</nobr></center></th>
							<th class="w50">&nbsp;</th>
							<th class="w100"><center><nobr>Размер</nobr></center></th>
							<th class="w50">&nbsp;</th>
							<th class="w100"><center><nobr>Размер</nobr></center></th>
							<th class="w50">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
				<?php for($i=0;$i<9;$i+=3):?>
						<tr>
						<?php if(isset($sizes[$i]['id'])):?>
							<td class="w85"><?=$sizes[$i]['code'];?></td>
							<td class="w85">
								<input type="checkbox" class="chInput" <?=($sizes[$i]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i]['id'];?>" />
							</td>
						<?php endif;?>
						<?php if(isset($sizes[$i+1]['id'])):?>
							<td class="w85"><?=$sizes[$i+1]['code'];?></td>
							<td class="w85">
								<input type="checkbox" class="chInput" <?=($sizes[$i+1]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i+1]['id'];?>" />
							</td>
						<?php endif;?>
						<?php if(isset($sizes[$i+2]['id'])):?>
							<td class="w85"><?=$sizes[$i+2]['code'];?></td>
							<td class="w85">
								<input type="checkbox" class="chInput" <?=($sizes[$i+2]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i+2]['id'];?>" />
							</td>
						<?php else:?>
							<td class="w85">&nbsp;</td>
							<td class="w85">&nbsp;</td>
						<?php endif;?>
						</tr>
				<?php endfor; ?>
						<tr><td colspan="6">&nbsp;</td></tr>
				<?php for($i=9;$i<17;$i+=3):?>
						<tr>
						<?php if(isset($sizes[$i]['id'])):?>
							<td class="w85"><?=$sizes[$i]['code'];?></td>
							<td class="w85">
								<input type="checkbox" class="chInput" <?=($sizes[$i]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i]['id'];?>" />
							</td>
						<?php endif;?>
						<?php if(isset($sizes[$i+1]['id'])):?>
							<td class="w85"><?=$sizes[$i+1]['code'];?></td>
							<td class="w85">
								<input type="checkbox" class="chInput" <?=($sizes[$i+1]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i+1]['id'];?>" />
							</td>
						<?php endif;?>
						<?php if(isset($sizes[$i+2]['id'])):?>
							<td class="w85"><?=$sizes[$i+2]['code'];?></td>
							<td class="w85">
								<input type="checkbox" class="chInput" <?=($sizes[$i+2]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i+2]['id'];?>" />
							</td>
						<?php else:?>
							<td class="w85">&nbsp;</td>
							<td class="w85">&nbsp;</td>
						<?php endif;?>
						</tr>
				<?php endfor; ?>
						<tr><td colspan="6">&nbsp;</td></tr>
						<?php for($i=17;$i<count($sizes);$i+=3):?>
						<tr>
						<?php if(isset($sizes[$i]['id'])):?>
							<td class="w85"><?=$sizes[$i]['code'];?></td>
							<td class="w85">
								<input type="checkbox" class="chInput" <?=($sizes[$i]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i]['id'];?>" />
							</td>
						<?php endif;?>
						<?php if(isset($sizes[$i+1]['id'])):?>
							<td class="w85"><?=$sizes[$i+1]['code'];?></td>
							<td class="w85">
								<input type="checkbox" class="chInput" <?=($sizes[$i+1]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i+1]['id'];?>" />
							</td>
						<?php endif;?>
						<?php if(isset($sizes[$i+2]['id'])):?>
							<td class="w85"><?=$sizes[$i+2]['code'];?></td>
							<td class="w85">
								<input type="checkbox" class="chInput" <?=($sizes[$i+2]['checked'])?'checked="checked"':'';?> name="sizes[]" value="<?=$sizes[$i+2]['id'];?>" />
							</td>
						<?php else:?>
							<td class="w85">&nbsp;</td>
							<td class="w85">&nbsp;</td>
							<td class="w85">&nbsp;</td>
							<td class="w85">&nbsp;</td>
						<?php endif;?>
						</tr>
				<?php endfor; ?>
					</tbody>
				</table>
				<hr/>
				<button class="btn btn-success" type="submit" id="sendColor" name="submit" value="send">Сохранить</button>
				<button class="btn btn-inverse backpath" type="button">Отменить</button>
			<?= form_close(); ?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".chInput").click(function(){
				if($(".chInput:checkbox:checked").length == 0){$(this).attr('checked','checked');}
			});
		});
	</script>
</body>
</html>

