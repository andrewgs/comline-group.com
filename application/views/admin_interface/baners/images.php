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
						<?=anchor($this->uri->uri_string(),'Слайдшоу на главной');?>
					</li>
				</ul>
				<?php $this->load->view("alert_messages/alert-error");?>
				<?php $this->load->view("alert_messages/alert-success");?>
				<ul class="thumbnails">
				<?php for($i=0;$i<count($baners);$i++):?>
					<li class="span3">
						<img class="img-polaroid" src="<?=$baseurl;?>baner/viewimage/<?=$baners[$i]['id'];?>" />
						<p>
							<div id="params<?=$i;?>" style="display:none" data-imgID="<?=$baners[$i]['id'];?>"></div>
							<?=anchor('admin-panel/actions/baners/edit/imageid/'.$baners[$i]['id'],'<i class="icon-pencil icon-white"></i>',array('class'=>'btn btn-success','title'=>'Редактировать'));?>
							<a class="btn btn-danger deleteImage" data-param="<?=$i;?>" data-toggle="modal" href="#deleteImage"><i class="icon-trash icon-white"></i></a>
						</p>
					</li>
				<?php endfor;?>
				</ul>
				<?=anchor('admin-panel/actions/baners/add','<nobr><i class="icon-plus icon-white"></i> Добавить</nobr>',array('class'=>'btn btn-info'));?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		<?php $this->load->view("admin_interface/modal/delete-primage");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script type="text/javascript">
		$(document).ready(function(){
			var imgID = 0;
			$(".deleteImage").click(function(){var Param = $(this).attr('data-param'); imgID = $("div[id = params"+Param+"]").attr("data-imgID");});
			$("#DelImage").click(function(){location.href='<?=$baseurl;?>admin-panel/actions/baners/delete/banersid/'+imgID;});
		});
	</script>
</body>
</html>

