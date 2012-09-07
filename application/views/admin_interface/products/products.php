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
						<?=anchor($this->uri->uri_string(),"Продукты");?>
					</li>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
				<?php if($pages): ?>
					<?=$pages;?>
				<?php endif;?>
				<hr/>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="w30"><center>Фото</center></th>
							<th class="w100"><center>Название/Свойства</center></th>
							<th class="w400"><center>Описание</center></th>
							<th class="w50">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php for($i=0;$i<count($products);$i++):?>
						<tr class="align-center">
							<td class="w30"><img src="<?=$baseurl;?>product/viewimage/<?=$products[$i]['id'];?>" alt="" style="width:30px;" /></td>
							<td class="w100">
								<nobr><b><?=$products[$i]['title'];?></b></nobr><br/>
								арт.<?=$products[$i]['art'];?><br/>
							</td>
							<td class="w400">
								<p><?=$products[$i]['text'];?></p>
								<p>
									<?=anchor('admin-panel/actions/products/productid/'.$products[$i]['id'].'/images','[Рисунки]');?>
									<span class="divider"> / </span>
									<?=anchor('admin-panel/actions/products/productid/'.$products[$i]['id'].'/colors','[Цвета]');?>
									<span class="divider"> / </span>
									<?=anchor('admin-panel/actions/products/productid/'.$products[$i]['id'].'/sizes','[Размеры]');?>
								</p>
							</td>
							<td class="w50">
								<div id="params<?=$i;?>" style="display:none" data-pid="<?=$products[$i]['id'];?>"></div>
								<?=anchor('admin-panel/actions/products/edit/'.$products[$i]['id'],'[Редакт.]',array('title'=>'Редактировать'));?>
								<a class="deleteProduct" data-param="<?=$i;?>" data-toggle="modal" href="#deleteProduct" title="Удалить">[Удалить]</a>
								<?php if(!$products[$i]['showitem']):?>
									<i class="icon-eye-close"></i>
								<?php endif;?>
							</td>
						</tr>
					<?php endfor; ?>
					</tbody>
				</table>
				<?php if($pages): ?>
					<?=$pages;?>
				<?php endif;?>
				<hr/>
				<?=anchor('admin-panel/actions/products/add','<nobr><i class="icon-plus icon-white"></i> Добавить</nobr>',array('class'=>'btn btn-info'));?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		<?php $this->load->view("admin_interface/modal/delete-product");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script type="text/javascript">
		$(document).ready(function(){
			var pID = 0;
			
			$(".deleteProduct").click(function(){var Param = $(this).attr('data-param'); pID = $("div[id = params"+Param+"]").attr("data-pid");});
			$("#DelProduct").click(function(){location.href='<?=$baseurl;?>admin-panel/actions/products/delete/productid/'+pID;});
		});
	</script>
</body>
</html>

