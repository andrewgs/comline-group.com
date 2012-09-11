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
	<div class="popup become-partner">
		<form id="form-feedback-default" class="popup-form" action="/forms/feedback/">
			<fieldset>
				<label for="feedback-company">Название вашей компании <span>*</span></label>
				<input type="text" class="valid-required" name="data[company]" id="feedback-company">
			</fieldset>
			<fieldset>
				<label for="feedback-name">Ваше имя <span>*</span></label>
				<input type="text" class="valid-required" name="data[name]" id="feedback-name">
			</fieldset>
			<fieldset>
				<label for="feedback-mail">Эл. почта <span>*</span></label>
				<input type="text" class="valid-required valid-email" name="data[email]" id="feedback-mail">
			</fieldset>
			<fieldset>
				<label for="feedback-phone">Телефон <span>*</span></label>
				<input type="text" class="valid-required valid-phone" name="data[phone]" id="feedback-phone">
			</fieldset>
			<fieldset>
				<label for="feedback-message">Ваше сообщение</label>
				<textarea class="resetted" name="data[message]" id="feedback-message"></textarea>
			</fieldset>
			<fieldset class="submit">
				<button type="submit">
					Отправить
				</button>
				<em>Сообщение отправлено!</em>
			</fieldset>
		</form>
	</div>
	<div class="popup get-call">
		<form id="form-feedback-default" class="popup-form" action="/forms/feedback/">
			<fieldset>
				<label for="feedback-name">Ваше имя <span>*</span></label>
				<input type="text" class="valid-required" name="data[name]" id="feedback-name">
			</fieldset>
			<fieldset>
				<label for="feedback-phone">Телефон <span>*</span></label>
				<input type="text" class="valid-required valid-phone" name="data[phone]" id="feedback-phone">
			</fieldset>
			<fieldset>
				<label for="feedback-message">Ваше сообщение</label>
				<textarea class="resetted" name="data[message]" id="feedback-message"></textarea>
			</fieldset>
			<fieldset class="submit">
				<button type="submit">
					Отправить
				</button>
				<em>Сообщение отправлено!</em>
			</fieldset>
		</form>
	</div>	
</header>