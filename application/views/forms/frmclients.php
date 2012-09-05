<?=form_open($this->uri->uri_string(),array('id'=>'for-clients')); ?>
	<input type="text" name="company" class="inpval" placeholder="Название вашей компании" />
	<input type="text" name="name" class="inpval" placeholder="Ваше имя" />
	<input type="text" name="email" id="email" class="inpval" placeholder="E-mail" />
	<input type="text" name="phone" id="phone" class="inpval" placeholder="Контактный телефон" />
	<textarea name="comments" class="inpval" placeholder="Комментарии"></textarea>
	<button name="submit" id="send" value="send">Отправить</button>
<?= form_close(); ?>