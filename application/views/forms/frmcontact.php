<?=form_open($this->uri->uri_string(),array('id'=>'contacts-form','name'=>'contacts-form')); ?>
	<input type="text" name="name" class="inpval" placeholder="Ваше имя" /><br/>
	<input type="text" name="email" id="email" class="inpval" placeholder="Ваш E-mail" /><br/>
	<textarea name="comments" class="inpval" placeholder="Текст сообщения"></textarea>
	<button name="submit" id="send" value="send">Отправить</button>
<?= form_close(); ?>