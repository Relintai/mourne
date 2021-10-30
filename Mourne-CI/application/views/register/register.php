<?php   
$attr_form = array('class' => 'register_form');

$attr_username = array(
		'name' => 'username',
		'maxlength' => '32', //TODO set
		'class' => 'register_input');

$attr_username['value'] = set_value('username');

$attr_password = array(
		'name' => 'password',
		'maxlength' => '32', //TODO set
		'class' => 'register_input');

$attr_password2 = array(
		'name' => 'password_check',
		'maxlength' => '32', //TODO set
		'class' => 'register_input');


$attr_email = array(
		'name' => 'email',
		'maxlength' => '100', //TODO set
		'class' => 'register_input');
$attr_email['value'] = set_value('email');

$attr_email2 = array(
		'name' => 'email_check',
		'maxlength' => '100', //TODO set
		'class' => 'register_input');
$attr_email2['value'] = set_value('email_check');

$attr_license = array(
		'name' => 'license',
		'class' => 'register_checkbox',
		'checked' => FALSE);
//$attr_license['checked'] = set_value('license');

$attr_submit = array(
		'name' => 'regiser_submit',
		'value' => 'Register');

?>

Register lawl!
<?=validation_errors(); ?>

<?=form_open('user/register', $attr_form); ?>
Username: <?=form_input($attr_username); ?><br />
<?=form_error('username'); ?>
Password: <?=form_password($attr_password); ?><br />
Password2: <?=form_password($attr_password2); ?><br />
Email: <?=form_input($attr_email); ?><br />
Email2: <?=form_input($attr_email2); ?><br />
License: <?=form_checkbox($attr_license); ?><br />
<?=form_submit($attr_submit); ?>
<?=form_close();?>

