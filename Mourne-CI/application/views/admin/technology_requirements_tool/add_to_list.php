<?php
$this->load->helper('form');
$this->load->helper('url');

$link_back = 'admin/technology_requirements_tool';

$link_form = 'admin/have_technology_requirement';

$name_drop = 'technologyid';

$attr_comment = array(
		'name' => 'comment',
		'class' => 'textarea');

$attr_drop = 'class="drop"';

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Add!',
		'class' => 'submit');
?>
Add new!<br />
<a href="<?=site_url($link_back); ?>"><-- Back</a><br />
<?=form_open($link_form); ?>
<?=form_hidden('action', 'new'); ?>
Description: <br />
<?=form_dropdown($name_drop, $opts, FALSE, $attr_drop); ?><br />
<?=form_textarea($attr_comment); ?><br />
<?=form_submit($attr_submit); ?><br />
<?=form_close(); ?>
