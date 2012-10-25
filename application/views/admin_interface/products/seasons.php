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
						<?=anchor($this->uri->uri_string(),"Сезонные коллекции");?>
					</li>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="w600">Название коллекции</th>
							<th class="w100">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php for($i=0;$i<count($seasons);$i++):?>
						<tr class="align-center">
							<td><?=$seasons[$i]['title'];?></td>
							<td>
								<?=anchor('admin-panel/actions/seasons/edit/'.$seasons[$i]['id'],'<i class="icon-pencil"></i>',array('title'=>'Редактировать', 'class'=>'btn'));?>
							<?php if($seasons[$i]['id']):?>
								<div id="params<?=$i;?>" style="display:none" data-sid="<?=$seasons[$i]['id'];?>"></div>
								<a class="deleteSeason btn" data-param="<?=$i;?>" data-toggle="modal" href="#deleteSeason" title="Удалить"><i class="icon-trash"></i></a>
							<?php endif;?>
							</td>
						</tr>
					<?php endfor; ?>
					</tbody>
				</table>
				<?=anchor('admin-panel/actions/seasons/add','<nobr><i class="icon-plus icon-white"></i> Добавить</nobr>',array('class'=>'btn btn-info'));?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		<?php $this->load->view("admin_interface/modal/delete-season");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script type="text/javascript">
		$(document).ready(function(){
			var sID = 0;
			$(".deleteSeason").click(function(){var Param = $(this).attr('data-param'); sID = $("div[id = params"+Param+"]").attr("data-sid");});
			$("#DelSeason").click(function(){location.href='<?=$baseurl;?>admin-panel/actions/seasons/delete/seasonid/'+sID;});
		});
	</script>
</body>
</html>

