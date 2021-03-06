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
						<?=anchor($this->uri->uri_string(),"Категории товаров");?>
					</li>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="w600">Категории товаров</th>
							<th class="w100">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php for($i=0;$i<count($category);$i++):?>
						<tr class="align-center">
							<td>
								<?=$category[$i]['title'];?>
								<?php if(!$category[$i]['showitem']):?>
									<i class="icon-eye-close" title="Не показывать" style="float:right;"></i>
								<?php endif;?>
							</td>
							<td>
								<div id="params<?=$i;?>" style="display:none" data-cid="<?=$category[$i]['id'];?>"></div>
								<?=anchor('admin-panel/actions/category/edit/'.$category[$i]['translit'],'<i class="icon-pencil"></i>',array('title'=>'Редактировать', 'class'=>'btn'));?>
								<a class="deleteCategory btn" data-param="<?=$i;?>" data-toggle="modal" href="#deleteCategory" title="Удалить"><i class="icon-trash"></i></a>
							</td>
						</tr>
					<?php endfor; ?>
					</tbody>
				</table>
				<?=anchor('admin-panel/actions/category/add','<nobr><i class="icon-plus icon-white"></i> Добавить</nobr>',array('class'=>'btn btn-info'));?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		<?php $this->load->view("admin_interface/modal/delete-category");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script type="text/javascript">
		$(document).ready(function(){
			var cID = 0;
			$(".deleteCategory").click(function(){var Param = $(this).attr('data-param'); cID = $("div[id = params"+Param+"]").attr("data-cid");});
			$("#DelCategory").click(function(){location.href='<?=$baseurl;?>admin-panel/actions/category/delete/categoryid/'+cID;});
		});
	</script>
</body>
</html>

