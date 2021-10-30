<?php
$this->load->helper('url');
$this->load->helper('form');

$link_back = 'admin/weather_tool';

$name_effect = 'effect';
$attr_effect = 'class="drop"';

$attr_name = array(
		'name' => 'name',
		'class' => 'input');

$attr_description = array(
		'name' => 'description',
		'rows' => '5',
		'cols' => '50',
		'class' => 'textarea');

$attr_art = array(
		'name' => 'art',
		'class' => 'input');

$attr_css = array(
		'name' => 'css',
		'class' => 'input');

$attr_cost_food = array(
		'name' => 'cost_food',
		'class' => 'input');

$attr_cost_wood = array(
		'name' => 'cost_wood',
		'class' => 'input');

$attr_cost_stone = array(
		'name' => 'cost_stone',
		'class' => 'input');

$attr_cost_iron = array(
		'name' => 'cost_iron',
		'class' => 'input');

$attr_cost_mana = array(
		'name' => 'cost_mana',
		'class' => 'input');

$attr_mod_max_food = array(
		'name' => 'mod_max_food',
		'class' => 'input');

$attr_mod_max_wood = array(
		'name' => 'mod_max_wood',
		'class' => 'input');

$attr_mod_max_stone = array(
		'name' => 'mod_max_stone',
		'class' => 'input');

$attr_mod_max_iron = array(
		'name' => 'mod_max_iron',
		'class' => 'input');

$attr_mod_max_mana = array(
		'name' => 'mod_max_mana',
		'class' => 'input');


$attr_mod_rate_food = array(
		'name' => 'mod_rate_food',
		'class' => 'input');

$attr_mod_rate_wood = array(
		'name' => 'mod_rate_wood',
		'class' => 'input');

$attr_mod_rate_stone = array(
		'name' => 'mod_rate_stone',
		'class' => 'input');

$attr_mod_rate_iron = array(
		'name' => 'mod_rate_iron',
		'class' => 'input');

$attr_mod_rate_mana = array(
		'name' => 'mod_rate_mana',
		'class' => 'input');


$attr_mod_percent_food = array(
		'name' => 'mod_percent_food',
		'class' => 'input');

$attr_mod_percent_wood = array(
		'name' => 'mod_percent_wood',
		'class' => 'input');

$attr_mod_percent_stone = array(
		'name' => 'mod_percent_stone',
		'class' => 'input');

$attr_mod_percent_iron = array(
		'name' => 'mod_percent_iron',
		'class' => 'input');

$attr_mod_percent_mana = array(
		'name' => 'mod_percent_mana',
		'class' => 'input');

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Submit',
		'class' => 'submit');

if ($new)
{
	//set every value with set_value()
	$link_form = 'admin/weather';

	$attr_name['value'] = set_value('name');
	$attr_description['value'] = set_value('description');
	$attr_art['value'] = set_value('art');
	$attr_css['value'] = set_value('css');
	//weather effect goes from controller

	$attr_mod_max_food['value'] = set_value('mod_max_food');
	$attr_mod_max_wood['value'] = set_value('mod_max_wood');
	$attr_mod_max_stone['value'] = set_value('mod_max_stone');
	$attr_mod_max_iron['value'] = set_value('mod_max_iron');
	$attr_mod_max_mana['value'] = set_value('mod_max_mana');

	$attr_mod_percent_food['value'] = set_value('mod_percent_food');
	$attr_mod_percent_wood['value'] = set_value('mod_percent_wood');
	$attr_mod_percent_stone['value'] = set_value('mod_percent_stone');
	$attr_mod_percent_iron['value'] = set_value('mod_percent_iron');
	$attr_mod_percent_mana['value'] = set_value('mod_percent_mana');
}
else
{
	//set every value from data sent
	$link_form = 'admin/weather/' . $weather['id'];



	$attr_name['value'] = $weather['name'];
	$attr_description['value'] = $weather['description'];
	$attr_art['value'] = $weather['art'];
	$attr_css['value'] = $weather['css'];

	$seff = $weather['effect'];

	$attr_mod_max_food['value'] = $weather['mod_max_food'];
	$attr_mod_max_wood['value'] = $weather['mod_max_wood'];
	$attr_mod_max_stone['value'] = $weather['mod_max_stone'];
	$attr_mod_max_iron['value'] = $weather['mod_max_iron'];
	$attr_mod_max_mana['value'] = $weather['mod_max_mana'];

	$attr_mod_percent_food['value'] = $weather['mod_percent_food'];
	$attr_mod_percent_wood['value'] = $weather['mod_percent_wood'];
	$attr_mod_percent_stone['value'] = $weather['mod_percent_stone'];
	$attr_mod_percent_iron['value'] = $weather['mod_percent_iron'];
	$attr_mod_percent_mana['value'] = $weather['mod_percent_mana'];
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

<div class="row_edit">
<div class="edit_name">
Name:
</div>
<div class="edit_input">
<?=form_input($attr_name); ?>
</div>
</div>

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
Art:
</div>
<div class="edit_input">
<?=form_input($attr_art); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
CSS:
</div>
<div class="edit_input">
<?=form_input($attr_css); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Effect:
</div>
<div class="edit_input">
<?=form_dropdown($name_effect, $opteff, $seff, $attr_effect); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Mod Max Food:
</div>
<div class="edit_input">
<?=form_input($attr_mod_max_food); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Mod Max Wood:
</div>
<div class="edit_input">
<?=form_input($attr_mod_max_wood); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Mod Max Stone:
</div>
<div class="edit_input">
<?=form_input($attr_mod_max_stone); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Mod Max Iron:
</div>
<div class="edit_input">
<?=form_input($attr_mod_max_iron); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Mod Max Mana:
</div>
<div class="edit_input">
<?=form_input($attr_mod_max_mana); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Mod Percent Food:
</div>
<div class="edit_input">
<?=form_input($attr_mod_percent_food); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Mod Percent Wood:
</div>
<div class="edit_input">
<?=form_input($attr_mod_percent_wood); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Mod Percent Stone:
</div>
<div class="edit_input">
<?=form_input($attr_mod_percent_stone); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Mod Percent Iron:
</div>
<div class="edit_input">
<?=form_input($attr_mod_percent_iron); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Mod Percent Mana:
</div>
<div class="edit_input">
<?=form_input($attr_mod_percent_mana); ?>
</div>
</div>


<div class="edit_submit">
<?=form_submit($attr_submit); ?>
</div>
<?=form_close(); ?>
