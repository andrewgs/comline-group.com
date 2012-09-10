<!DOCTYPE html>
<html lang="en">
<?php $this->load->view("admin_interface/includes/head");?>
<body>
	<?php $this->load->view("admin_interface/includes/header");?>
	<div class="container">
		<div class="row">
			<div class="span9">
				<ul class="breadcrumb">
					<li class="active">
						<?=anchor($this->uri->uri_string(),"Цвета");?>
					</li>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="w100">Цвет</th>
							<th class="w100">Код</th>
							<th class="w50">&nbsp;</th>
							<th class="w100">Цвет</th>
							<th class="w100">Код</th>
							<th class="w50">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php for($i=0;$i<count($colors);$i+=2):?>
						<tr>
						<?php if(isset($colors[$i]['id'])):?>
							<td class="w85"><div style="background-color:#<?=$colors[$i]['code'];?>; width: 100px; height: 20px;"></div></td>
							<td class="w85">#<?=$colors[$i]['code'];?></td>
							<td class="w50">
								<div id="params<?=$i;?>" style="display:none" data-cid="<?=$colors[$i]['id'];?>" data-code="<?=$colors[$i]['code'];?>"></div>
								<a class="deleteColor btn" data-param="<?=$i;?>" data-toggle="modal" href="#deleteColor" title="Удалить цвет"><i class="icon-trash"></i></a>
							</td>
						<?php endif;?>
						<?php if(isset($colors[$i+1]['id'])):?>
							<td class="w85"><div style="background-color:#<?=$colors[$i+1]['code'];?>; width: 100px; height: 20px;"></div></td>
							<td class="w85"><b>#<?=$colors[$i+1]['code'];?></b></td>
							<td class="w50">
								<div id="params<?=$i+1;?>" style="display:none" data-cid="<?=$colors[$i+1]['id'];?>" data-code="<?=$colors[$i+1]['code'];?>"></div>
								<a class="deleteColor btn" data-param="<?=$i+1;?>" data-toggle="modal" href="#deleteColor" title="Удалить цвет"><i class="icon-trash"></i></a>
							</td>
						<?php else:?>
							<td class="w85">&nbsp;</td>
							<td class="w85">&nbsp;</td>
							<td class="w85">&nbsp;</td>
						<?php endif;?>
						</tr>
					<?php endfor; ?>
					</tbody>
				</table>
				<?=anchor('admin-panel/actions/color/add','<nobr><i class="icon-plus icon-white"></i> Добавить</nobr>',array('class'=>'btn btn-info'));?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		<?php $this->load->view("admin_interface/modal/delete-color");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script type="text/javascript">
		$(document).ready(function(){
			var cID = 0;
			$(".deleteColor").click(function(){var Param = $(this).attr('data-param'); cID = $("div[id = params"+Param+"]").attr("data-cid");});
			$("#DelColor").click(function(){location.href='<?=$baseurl;?>admin-panel/actions/colors/delete/colorid/'+cID;});
		});
	</script>
</body>
</html>

