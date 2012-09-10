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
						<?=anchor($this->uri->uri_string(),"События и Новости");?>
					</li>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
				<?php if($pages): ?>
					<?=$pages;?>
				<?php endif;?>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="w85">Тип / Дата</th>
							<th class="w600">Содержание</th>
							<th class="w110">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php for($i=0;$i<count($events);$i++):?>
						<tr class="align-center">
							<td><nobr><?=($events[$i]['type']==1) ? 'Новость' : 'Акция' ;?><br/><?=$events[$i]['date'];?></nobr></td>
							<td>
								<p>
									<strong><?=$events[$i]['title'];?></strong> <br />
									<?=$events[$i]['text'];?>
								</p>
							</td>
							<td>
								<div id="params<?=$i;?>" style="display:none" data-nid="<?=$events[$i]['id'];?>"></div>
								<?=anchor('admin-panel/actions/events/edit/'.$events[$i]['translit'],'<i class="icon-pencil"></i>',array('title'=>'Редактировать', 'class'=>'btn'));?>
								<a class="deleteNews btn" data-param="<?=$i;?>" data-toggle="modal" href="#deleteNews" title="Удалить"><i class="icon-trash"></i></a>
							</td>
						</tr>
					<?php endfor; ?>
					</tbody>
				</table>
				<?php if($pages): ?>
					<?=$pages;?>
				<?php endif;?>
				<?=anchor('admin-panel/actions/events/add','<nobr><i class="icon-plus icon-white"></i> Добавить</nobr>',array('class'=>'btn btn-info'));?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		<?php $this->load->view("admin_interface/modal/delete-news");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script type="text/javascript">
		$(document).ready(function(){
			var nID = 0;
			$(".deleteNews").click(function(){var Param = $(this).attr('data-param'); nID = $("div[id = params"+Param+"]").attr("data-nid");});
			$("#DelNews").click(function(){location.href='<?=$baseurl;?>admin-panel/actions/events/delete/eventsid/'+nID;});
		});
	</script>
</body>
</html>
