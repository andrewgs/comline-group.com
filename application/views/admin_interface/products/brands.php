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
						<?=anchor($this->uri->uri_string(),"Бренды");?>
					</li>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="w130">Логотип</th>
							<th class="w600">Описание</th>
							<th class="w130">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php for($i=0;$i<count($brands);$i++):?>
						<tr class="align-center">
							<td><img src="<?=$baseurl;?>brands/viewimage/<?=$brands[$i]['id'];?>" alt="" /></td>
							<td>
								<strong><?=$brands[$i]['title'];?></strong>
								<p><?=$brands[$i]['text'];?></p>
								<p>
									<?=anchor('admin-panel/actions/brands/brandsid/'.$brands[$i]['id'].'/catalogs','Каталоги');?>&nbsp;
								</p>
							</td>
							<td>
								<div id="params<?=$i;?>" style="display:none" data-bid="<?=$brands[$i]['id'];?>"></div>
								<?=anchor('admin-panel/actions/brands/edit/'.$brands[$i]['translit'],'<i class="icon-pencil"></i>',array('title'=>'Редактировать', 'class'=>'btn'));?>
								<a class="deleteBrand btn" data-param="<?=$i;?>" data-toggle="modal" href="#deleteBrand" title="Удалить"><i class="icon-trash"></i></a>
							</td>
						</tr>
					<?php endfor; ?>
					</tbody>
				</table>
				<?=anchor('admin-panel/actions/brands/add','<nobr><i class="icon-plus icon-white"></i> Добавить</nobr>',array('class'=>'btn btn-info'));?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		<?php $this->load->view("admin_interface/modal/delete-brands");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script type="text/javascript">
		$(document).ready(function(){
			var bID = 0;
			$(".deleteBrand").click(function(){var Param = $(this).attr('data-param'); bID = $("div[id = params"+Param+"]").attr("data-bid");});
			$("#DelBrand").click(function(){location.href='<?=$baseurl;?>admin-panel/actions/brands/delete/brandsid/'+bID;});
		});
	</script>
</body>
</html>

