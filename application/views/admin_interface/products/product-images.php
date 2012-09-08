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
						Изображения продукта
					</li>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
				<ul class="thumbnails">
				<?php for($i=0;$i<count($primages);$i++):?>
					<li class="span3">
						<div class="thumbnail">
							<img src="<?=$baseurl;?>productimage/viewimage/<?=$primages[$i]['id'];?>" />
							<hr />
							<div class="caption">
								<p>
									<div id="params<?=$i;?>" style="display:none" data-imgID="<?=$primages[$i]['id'];?>" data-main="<?=$primages[$i]['main'];?>"></div>
									<a class="btn btn-danger deleteImage" data-param="<?=$i;?>" data-toggle="modal" href="#deleteImage">Удалить</a>
								<?php if($primages[$i]['main']):?>
									<button class="btn btn-primary" disabled="disabled" type="button">Основная</button>
								<?php endif;?>
								</p>
							</div>
						</div>
					</li>
				<?php endfor;?>
				</ul>
				<?=anchor('admin-panel/actions/products/productid/'.$this->uri->segment(5).'/images/add','<nobr><i class="icon-plus icon-white"></i> Добавить</nobr>',array('class'=>'btn btn-info'));?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		<?php $this->load->view("admin_interface/modal/delete-primage");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script type="text/javascript">
		$(document).ready(function(){
			var imgID = 0;
			$(".deleteImage").click(function(){var Param = $(this).attr('data-param'); imgID = $("div[id = params"+Param+"]").attr("data-imgID");imgMain = $("div[id = params"+Param+"]").attr("data-main"); if(imgMain == 1){alert('Основное изображение удалить невозможно!'); return false;}});
			$("#DelImage").click(function(){location.href='<?=$baseurl;?>admin-panel/actions/products/image-delete/imagesid/'+imgID;});
		});
	</script>
</body>
</html>

