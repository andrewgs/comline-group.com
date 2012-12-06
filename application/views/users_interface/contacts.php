<!DOCTYPE html>
<!-- /ht Paul Irish - http://front.ie/j5OMXi -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en"><!--<![endif]-->
	<?php $this->load->view("users_interface/includes/head");?>
	
<body>
	<div class="container cf">
		<?php $this->load->view("users_interface/includes/header");?>
		
		<div id="main" class="substrate large contacts">
			<h1>Контактная информация</h1>
			<h3>Офис компании и шоу-рум находятся по адресу:</h3>
			<address>
				<?=$text[0];?>
				<a class="show-map" data-address="<?=$text[0];?>" href="#">Показать на карте</a>
			</address>
			<aside id="map">
				<!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту (начало) -->
				<div id="ya-map" style="width: 450px; height: 505px;"></div>
				<!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту (конец) -->
				<img class="storage-map" src="<?= base_url(); ?>/images/storage_map.jpg" alt="" />
			</aside>
			<h3>Склад<?php if (count($storage)>1): ?>ы<?php endif; ?></h3>
			<ul class="warehouses">
			<?php for($i=0;$i<count($storage);$i++):?>
				<li>
					<?=$storage[$i]['title'];?> на м.<?=$storage[$i]['metro'];?>
					<br/> <span class="noweight"><?=$storage[$i]['address'];?></span><br />
					<a class="show-map" data-address="<?=$storage[$i]['address'];?>" href="#">Показать на карте</a>
					<p class="noweight">
						<strong>Описание проезда из Москвы:</strong> <br/>
						По Киевскому шоссе, поворот направо после ТЦ «Румянцево» на мост (развязка). Пересечь Киевское шоссе и продолжить движение в сторону д. Саларьево. Далее вдоль строительного рынка до указателя «СКЛАД С7». По указателю направо. Через 100 м. бело-голубой складской комплекс с синими воротами.
						<br/>
						<strong>Описание проезда из области:</strong> <br/>
						По Киевскому шоссе, поворот направо после указателя «Саларьево». Далее вдоль строительного рынка до указателя «СКЛАД С7». По указателю направо. Через 100 м. бело-голубой складской комплекс с синими воротами.
					</p>					
				</li>
			<?php endfor;?>
			</ul>
			<h3>Обратная связь</h3>
			<div class="descr">
				Вы можете задать свой вопрос по e-mail, заполнив эту форму, или <br/>позвонить по телефону +7 (495) 729-51-22
			</div>
			<?php $this->load->view("alert_messages/alert-error");?>
			<?php $this->load->view("alert_messages/alert-success");?>
			<div id="message_box"></div>
			<?php $this->load->view("forms/frmcontact");?>
			<p>
				E-mail: <?=safe_mailto($text[1],$text[1]);?>
			</p>
		</div>
	</div>
	<?php $this->load->view("users_interface/includes/footer");?>
	<?php $this->load->view("users_interface/includes/scripts");?>
	<script src="http://api-maps.yandex.ru/2.0/?coordorder=longlat&load=package.full&lang=ru-RU" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#send").click(function(event){
				var err = false;
				$(".inpval").removeClass('empty-error');
				var email = $("#email").val();
				$(".inpval").each(function(i,element){if($(this).val()==''){err = true;$(this).addClass('empty-error');}});
				if(err){$("#message_box").html('<div class="alert alert-error">Поля не могут быть пустыми</div>'); event.preventDefault();};
				if(!err && !isValidEmailAddress(email)){$("#message_box").html('<div class="alert alert-error">Не верный адрес E-Mail</div>');$("#email").addClass('empty-error');err = true; event.preventDefault();}
			});
			
			$('address a.show-map').click(function(e){
				// myMap.destroy(); // Деструктор карты
                // myMap = null;
                e.preventDefault();
                $('#ya-map').html('');
				$('img.storage-map').hide();                
            	init();
			});
			
			$('ul.warehouses li:first a.show-map').click(function(e){
				// myMap.destroy(); // Деструктор карты
                // myMap = null;
                e.preventDefault();
                $('#ya-map').html('');
				
				var map = new ymaps.Map("ya-map", {
					center: [37.440441664558705, 55.62150895057685],
        			zoom: 13,
				});
				map.controls.add("zoomControl").add("mapTools").add(new ymaps.control.TypeSelector(["yandex#map", "yandex#satellite", "yandex#hybrid", "yandex#publicMap"]));
				map.geoObjects.add(new ymaps.Placemark([37.441986616951304, 55.61451437943528], {
					balloonContent : 'Склад компании "Логолэнд"'
				}, {
					preset : "twirl#blueDotIcon"
				}));
				$('img.storage-map').show();
			});
		});

		// Как только будет загружен API и готов DOM, выполняем инициализацию
		ymaps.ready(init);

		// Инициализация и уничтожение карты при нажатии на кнопку.
		function init() {
			var myMap = new ymaps.Map("ya-map", {
				center : [37.57648693445605, 55.77801272351318],
				zoom : 15,
				type : "yandex#map"
			});
			myMap.controls.add("zoomControl").add("mapTools").add(new ymaps.control.TypeSelector(["yandex#map", "yandex#satellite", "yandex#hybrid", "yandex#publicMap"]));
			myMap.geoObjects.add(new ymaps.Placemark([37.571372, 55.778279], {
				balloonContent : ""
			}, {
				preset : "twirl#blueDotIcon"
			})).add(new ymaps.Polyline([[37.58200727814918, 55.77743263249227], [37.57986151093737, 55.77677956638348], [37.57707201356189, 55.77677956638348], [37.57320963258039, 55.77910152941231], [37.57149301881082, 55.77835174403129]], {
				balloonContent : ""
			}, {
				strokeColor : "ff0000",
				strokeWidth : 5,
				strokeOpacity : 0.8
			}));
		}
	</script>	
</body>
</html>