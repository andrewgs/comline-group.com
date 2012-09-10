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
						<?=anchor('',"Бренды",array('class'=>'none backpath'));?><span class="divider">/</span>
					</li>
					<li class="active">
						Каталоги
					</li>
				</ul>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="w100">Название</th>
							<th class="w600">Описание</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php for($i=0;$i<count($catalogs);$i++):?>
						<tr class="align-center">
							<td>
								<strong><?=$catalogs[$i]['title'];?></strong>
							</td>
							<td>
								<p><?=$catalogs[$i]['text'];?></p>
							</td>
							<td>
								<div id="params<?=$i;?>" style="display:none" data-cid="<?=$catalogs[$i]['id'];?>"></div>
								<?=anchor('admin-panel/actions/brands/brandid/'.$this->uri->segment(5).'/edit-catalog/catalogid/'.$catalogs[$i]['id'],'<i class="icon-pencil"></i>',array('title'=>'Редактировать', 'class'=>'btn'));?>
								<a class="deleteCatalog btn" data-param="<?=$i;?>" data-toggle="modal" href="#deleteCatalog" title="Удалить"><i class="icon-trash"></i></a>
							</td>
						</tr>
					<?php endfor; ?>
					</tbody>
				</table>
				<?=anchor('admin-panel/actions/brands/brandid/'.$this->uri->segment(5).'/add-catalog','<nobr><i class="icon-plus icon-white"></i> Добавить</nobr>',array('class'=>'btn btn-info'));?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		<?php $this->load->view("admin_interface/modal/delete-catalog");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script type="text/javascript">
		$(document).ready(function(){
			var cID = 0;
			$(".deleteCatalog").click(function(){var Param = $(this).attr('data-param'); cID = $("div[id = params"+Param+"]").attr("data-cid");});
			$("#DelCatalog").click(function(){location.href='<?=$baseurl;?>admin-panel/actions/brands/brandid/<?=$this->uri->segment(5);?>/delete-catalog/catalogid/'+cID;});
		});
	</script>
</body>
</html>

