<?php
$this->load->helper('url');
$this->load->helper('form');

$link_back = 'admin/ai_settings_tool';

$attr_description = array(
        'name' => 'description',
        'rows' => '5',
        'cols' => '50',
        'class' => 'textarea');

$attr_setting = array(
        'name' => 'setting',
        'class' => 'input');

$attr_value = array(
        'name' => 'value',
        'class' => 'input');

$attr_submit = array(
        'name' => 'submit',
        'value' => 'Submit',
        'class' => 'submit');

if ($new) {
    //set every value with set_value()
    $link_form = 'admin/ai_settings';

    $attr_setting['value'] = set_value('setting');
    $attr_value['value'] = set_value('value');
    $attr_description['value'] = set_value('description');
} else {
    //set every value from data sent
    $link_form = 'admin/ai_settings/' . $setting['id'];

    $attr_setting['value'] = $setting['setting'];
    $attr_value['value'] = $setting['value'];
    $attr_description['value'] = $setting['description'];
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
Description:
</div>
<div class="edit_input">
<?=form_textarea($attr_description); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Setting:
</div>
<div class="edit_input">
<?=form_input($attr_setting); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Value:
</div>
<div class="edit_input">
<?=form_input($attr_value); ?>
</div>
</div>

<div class="edit_submit">
<?=form_submit($attr_submit); ?>
</div>
<?=form_close(); ?>
