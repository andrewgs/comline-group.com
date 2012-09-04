<?=form_open($this->uri->uri_string(),array('id'=>'for-clients')); ?>
	<input type="text" name="company" placeholder="Название вашей компании" />
	<input type="text" name="name" placeholder="Ваше имя" />
	<input type="text" name="email" placeholder="E-mail" />
	<input type="text" name="phone" placeholder="Контактный телефон" />
	<textarea name="comments" placeholder="Комментарии"> </textarea>
	<button name="send">Отправить</button>
<?= form_close(); ?>