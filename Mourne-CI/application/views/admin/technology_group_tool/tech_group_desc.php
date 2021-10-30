<?php
$this->load->helper('url');
$this->load->helper('form');

$link_back = 'admin/technology_group_tool';

$attr_group_name = array(
		'name' => 'group_name',
		'rows' => '5',
		'cols' => '50',
		'class' => 'textarea');

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Submit',
		'class' => 'submit');

if ($new)
{
	//set every value with set_value()
	$link_form = 'admin/technology_group_desc';
	$attr_group_name['value'] = set_value('description');
}
else
{
	//set every value from data sent
	$link_form = 'admin/technology_group_desc/' . $group['id'];
	$attr_group_name['value'] = $group['group_name'];
}
?>
<div class="back">
<a href="<?=site_url($link_back); ?>"><-- Back</a>
</div>
<div class="action">
<?php if ($new): ?>
	Creating!
<?php else: ?>
	Editing!
<?php endif; ?>
</div>
<?=validation_errors(); ?>
<?=form_open($link_form); ?>

<div class="row_edit_textbox">
<div class="edit_name">
Group Name:
</div>
<div class="edit_input">
<?=form_textarea($attr_group_name); ?>
</div>
</div>

<div class="edit_submit">
<?=form_submit($attr_submit); ?>
</div>
<?=form_close(); ?>
