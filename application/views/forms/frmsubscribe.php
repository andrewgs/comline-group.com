<?=form_open($this->uri->uri_string(),array('id'=>'subscribe')); ?>
	<input id="email" type="text" class="inpval" name="email" id="subscribe-email" placeholder="Введите ваш e-mail" />
	<input id="ok" type="submit" value="ok" name="ssubmit" />
<?= form_close(); ?>