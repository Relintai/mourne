login lawl!
<?php
$this->load->helper('url');

$link_register = 'user/register';

$attr_form = array('class' => 'login_form');

$attr_username = array(
		'name' => 'username',
		'maxlength' => '32',
		'class' => 'login_input');
$attr_username['value'] = set_value('username');

$attr_password = array(
		'name' => 'password',
		'maxlength' => '32',
		'class' => 'login_input');

$attr_submit = array(
		'name' => 'login',
		'value' => 'Login',
		'class' => 'login_submit');
?>

<?=validation_errors() ?>

<?=form_open('user/login', $attr_form); ?>
Username: <?=form_input($attr_username); ?><br />
Password: <?=form_password($attr_password); ?><br />
<?=form_submit($attr_submit); ?>
<?=form_close(); ?>
<a href="<?=site_url($link_register); ?>">Register</a>
