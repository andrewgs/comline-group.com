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
						<?=anchor($this->uri->uri_string(),"Склады");?>
					</li>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="w600"><center>Название</center></th>
							<th class="w50">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php for($i=0;$i<count($storage);$i++):?>
						<tr class="align-center">
							<td class="w500">
								<i><b><?=$storage[$i]['title'];?></b></i><br/>
								<?=$storage[$i]['address'];?><br/>
								<?=$storage[$i]['metro'];?>
								
							</td>
							<td class="w50">
								<div id="params<?=$i;?>" style="display:none" data-sid="<?=$storage[$i]['id'];?>"></div>
								<?=anchor('admin-panel/actions/storage/edit/storageid/'.$storage[$i]['id'],'Редактировать',array('title'=>'Редактировать'));?>
								<a class="deleteStorage" data-param="<?=$i;?>" data-toggle="modal" href="#deleteStorage" title="Удалить">Удалить</a>
							</td>
						</tr>
					<?php endfor; ?>
					</tbody>
				</table>
				<?=anchor('admin-panel/actions/storage/add','<nobr><i class="icon-plus icon-white"></i> Добавить</nobr>',array('class'=>'btn btn-info'));?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		<?php $this->load->view("admin_interface/modal/delete-storage");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script type="text/javascript">
		$(document).ready(function(){
			var sID = 0;
			$(".deleteStorage").click(function(){var Param = $(this).attr('data-param'); sID = $("div[id = params"+Param+"]").attr("data-sid");});
			$("#DelStorage").click(function(){location.href='<?=$baseurl;?>admin-panel/actions/storage/delete/storageid/'+sID;});
		});
	</script>
</body>
</html>

