<header class="cf">
	<h1><?=anchor('','Comfort Line - одежда для дома и отдыха',array('id'=>'logo'));?></h1>
	<ul id="main-nav">
		<li><?=anchor('','Главная');?></li>
		<li><?=anchor('about','О компании');?></li>
		<li><?=anchor('brands','Каталоги');?></li>
		<li><?=anchor('clients','Клиентам');?></li>
		<li><?=anchor('contacts','Контактная информация');?></li>
	</ul>
	<div class="right">
		<div class="phone cf">
			<p>
				<span class="small">+7(495)</span>729-51-22
			</p>
			<?=anchor('#','заказать звонок',array('class'=>'dashed'));?>
		</div>
		<ul class="actions">
			<li><?=anchor('#','Интернет-магазин',array('id'=>'action-shop'));?></li>
			<li><?=anchor('#','Стать партнером',array('id'=>'action-partner'));?></li>
		</ul>
	</div>
	<div class="cf"></div>
	
	<div id="slogan">
		<img src="images/slogan.png" alt="Комфорт в каждой линии" />
	</div>
	
	<div class="popup become-partner">
		<?=form_open($this->uri->uri_string(),array('id'=>'form-feedback-default','class'=>'popup-form')); ?>
			<fieldset>
				<label for="feedback-company">Название вашей компании <span>*</span></label>
				<input type="text" class="valid-required FieldSend" name="company" id="feedback-company">
			</fieldset>
			<fieldset>
				<label for="feedback-name">Ваше имя <span>*</span></label>
				<input type="text" class="valid-required FieldSend" name="name" id="feedback-name">
			</fieldset>
			<fieldset>
				<label for="feedback-mail">Эл. почта <span>*</span></label>
				<input type="text" class="valid-required valid-email FieldSend" name="email" id="feedback-mail">
			</fieldset>
			<fieldset>
				<label for="feedback-phone">Телефон <span>*</span></label>
				<input type="text" class="valid-required valid-phone FieldSend" name="phone" id="feedback-phone">
			</fieldset>
			<fieldset>
				<label for="feedback-message">Ваше сообщение</label>
				<textarea class="FieldSend" name="message" id="feedback-message"></textarea>
			</fieldset>
			<fieldset class="submit">
				<button type="submit" name="partner" value="" id="PartnerSend">Отправить</button>
				<em>Сообщение отправлено!</em>
			</fieldset>
		<?= form_close(); ?>
	</div>
	<div class="popup get-call">
		<form id="form-feedback-default" class="popup-form" action="/forms/feedback/">
			<fieldset>
				<label for="feedback-name">Ваше имя <span>*</span></label>
				<input type="text" class="valid-required FieldSend" name="name" id="feedback-name">
			</fieldset>
			<fieldset>
				<label for="feedback-phone">Телефон <span>*</span></label>
				<input type="text" class="valid-required valid-phone FieldSend" name="phone" id="feedback-phone">
			</fieldset>
			<fieldset>
				<label for="feedback-message">Ваше сообщение</label>
				<textarea class="FieldSend" name="message" id="feedback-message"></textarea>
			</fieldset>
			<fieldset class="submit">
				<button type="submit" name="call" value="send" id="CallSend">Отправить</button>
				<em>Сообщение отправлено!</em>
			</fieldset>
		</form>
	</div>	
</header>