<?php
$attr_form = array(
		'class' => 'form_addnews');

$attr_text = array(
		'name' => 'text');

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Submit');

?>

news add lawl!
<?=validation_errors(); ?>
<?=form_open('/news/add', $attr_form); ?>
<?=form_textarea($attr_text); ?>
<?=form_submit($attr_submit); ?>
<?=form_close(); ?>

