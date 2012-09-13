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
						<?=$product;?><span class="divider">/</span>Цвета продукта
					</li>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
			<?=form_open($this->uri->uri_string()); ?>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="w50"><center><nobr>Цвет</nobr></center></th>
							<th class="w50"><center><nobr>Код</nobr></center></th>
							<th class="w100">Название<br/>номер</th>
							<th class="w50">&nbsp;</th>
							<th class="w50"><center><nobr>Цвет</nobr></center></th>
							<th class="w50"><center><nobr>Код</nobr></center></th>
							<th class="w100">Название<br/>номер</th>
							<th class="w50">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php for($i=0;$i<count($colors);$i+=2):?>
						<tr>
						<?php if(isset($colors[$i]['id'])):?>
							<td class="w50"><div style="background-color:<?=$colors[$i]['code'];?>; width: 50px; height: 20px;"></div></td>
							<td class="w50"><?=$colors[$i]['code'];?></td>
							<td class="w100"><?=$colors[$i]['title'];?><br/><?=$colors[$i]['number'];?></td>
							<td class="w50">
								<input type="checkbox" class="chInput" <?=($colors[$i]['checked'])?'checked="checked"':'';?> name="code[]" value="<?=$colors[$i]['id'];?>" />
							</td>
						<?php endif;?>
						<?php if(isset($colors[$i+1]['id'])):?>
							<td class="w50"><div style="background-color:<?=$colors[$i+1]['code'];?>; width: 50px; height: 20px;"></div></td>
							<td class="w50"><?=$colors[$i+1]['code'];?></td>
							<td class="w100"><?=$colors[$i+1]['title'];?><br/><?=$colors[$i+1]['number'];?></td>
							<td class="w50">
								<input type="checkbox" class="chInput" <?=($colors[$i+1]['checked'])?'checked="checked"':'';?> name="code[]" value="<?=$colors[$i+1]['id'];?>" />
							</td>
						<?php else:?>
							<td class="w50">&nbsp;</td>
							<td class="w50">&nbsp;</td>
							<td class="w100">&nbsp;</td>
							<td class="w50">&nbsp;</td>
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

