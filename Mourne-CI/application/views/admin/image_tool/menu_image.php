<?php
$this->load->helper('form');
$this->load->helper('url');

$link_back = 'admin/admin_panel';
$link_form = 'admin/menu_image';

$attr_drop = 'class="drop"';

$name_font = 'font';
$attr_font = 'class="drop"';

$attr_padding = array(
	'name' => 'padding',
	'value' => '0',
	'class' => 'input');

$attr_h_offset = array(
	'name' => 'h_offset',
	'value' => '0',
	'class' => 'input');

$attr_v_offset = array(
	'name' => 'v_offset',
	'value' => '0',
	'class' => 'input');

$attr_text = array(
	'name' => 'text',
	'class' => 'input');

$attr_font_size = array(
	'name' => 'font_size',
	'value' => '12',
	'class' => 'input');

$attr_font_color = array(
	'name' => 'font_color',
	'value' => 'ffffff',
	'class' => 'input');

$attr_shadow_color = array(
	'name' => 'shadow_color',
	'value' => 'ffffff',
	'class' => 'input');

$attr_shadow_distance = array(
	'name' => 'shadow_distance',
	'value' => '0',
	'class' => 'input');

$attr_apply_all = array(
	'name' => 'apply_all',
	'value' => '1',
	'checked' => 'TRUE');

$attr_submit = array(
	'name' => 'submit',
	'value' => 'Submit',
	'class' => 'submit');
?>
<div class="back">
<a href="<?=site_url($link_back); ?>"><-- Back</a>
</div>
<div class="action">
	Menu Image Text Generator
</div>
<?=form_open($link_form); ?>

<div class="row_edit">
<div class="edit_name">
Source File:
</div>
<div class="edit_input">
<?=form_dropdown('file', $optimg, 'menu.png', $attr_drop); ?>
</div>
</div>

<div class="action">
Alignment:
</div>

<div class="row_edit">
<div class="edit_name">
Padding:
</div>
<div class="edit_input">
<?=form_input($attr_padding); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Vertical Alignment:
</div>
<div class="edit_input">
<?=form_dropdown('v_align', $optvalign, 'middle', $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Horizontal Alignment:
</div>
<div class="edit_input">
<?=form_dropdown('h_align', $opthalign, 'center', $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Horizontal Offset:
</div>
<div class="edit_input">
<?=form_input($attr_h_offset); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Vertical Offset:
</div>
<div class="edit_input">
<?=form_input($attr_v_offset); ?>
</div>
</div>

<div class="action">
	Text:
</div>

<div class="row_edit">
<div class="edit_name">
Text:
</div>
<div class="edit_input">
<?=form_input($attr_text); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Font:
</div>
<div class="edit_input">
<?=form_dropdown($name_font, $optfont, FALSE, $attr_font); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Font Size:
</div>
<div class="edit_input">
<?=form_input($attr_font_size); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Font Color:
</div>
<div class="edit_input">
<?=form_input($attr_font_color); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Shadow Color:
</div>
<div class="edit_input">
<?=form_input($attr_shadow_color); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Shadow Distance:
</div>
<div class="edit_input">
<?=form_input($attr_shadow_distance); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Apply to all menu images? (text field will be ignored)
</div>
<div class="edit_input">
 <?=form_checkbox($attr_apply_all); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Menu Group (only when Apply All is set): n
</div>
<div class="edit_input">
<?=form_dropdown('menu_group', $optgroup, 1, $attr_drop); ?>
</div>
</div>

<div class="edit_submit">
<?=form_submit($attr_submit); ?>
</div>
<?=form_close(); ?>
