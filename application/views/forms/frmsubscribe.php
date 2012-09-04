<?=form_open($this->uri->uri_string(),array('id'=>'subscribe')); ?>
	<input id="email" type="text" name="email" placeholder="Введите ваш e-mail" />
	<input id="ok" type="button" value="ok" name="submit" />
<?= form_close(); ?>