<?php
$this->load->helper('url');
$this->load->helper('form');

$link_back = 'admin/spell_tool';

$name_effect = 'effect';
$attr_effect = 'class="drop"';

$attr_drop = 'class="drop"';

$attr_duration = array(
		'name' => 'duration',
		'class' => 'input');

$attr_cooldown = array(
		'name' => 'cooldown',
		'class' => 'input');

$attr_description = array(
		'name' => 'description',
		'rows' => '5',
		'cols' => '50',
		'class' => 'textarea');

$attr_description_admin = array(
		'name' => 'description_admin',
		'rows' => '5',
		'cols' => '50',
		'class' => 'textarea');

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
	$link_form = 'admin/spell';

	//spell effect goes from controller
	$attr_duration['value'] = set_value('duration');
	$attr_cooldown['value'] = set_value('cooldown');
	$attr_description['value'] = set_value('description');
	$attr_description_admin['value'] = set_value('description_admin');

	$attr_cost_food['value'] = set_value('cost_food');
	$attr_cost_wood['value'] = set_value('cost_wood');
	$attr_cost_stone['value'] = set_value('cost_stone');
	$attr_cost_iron['value'] = set_value('cost_iron');
	$attr_cost_mana['value'] = set_value('cost_mana');

	$attr_mod_max_food['value'] = set_value('mod_max_food');
	$attr_mod_max_wood['value'] = set_value('mod_max_wood');
	$attr_mod_max_stone['value'] = set_value('mod_max_stone');
	$attr_mod_max_iron['value'] = set_value('mod_max_iron');
	$attr_mod_max_mana['value'] = set_value('mod_max_mana');

	$attr_mod_rate_food['value'] = set_value('mod_rate_food');
	$attr_mod_rate_wood['value'] = set_value('mod_rate_wood');
	$attr_mod_rate_stone['value'] = set_value('mod_rate_stone');
	$attr_mod_rate_iron['value'] = set_value('mod_rate_iron');
	$attr_mod_rate_mana['value'] = set_value('mod_rate_mana');

	$attr_mod_percent_food['value'] = set_value('mod_percent_food');
	$attr_mod_percent_wood['value'] = set_value('mod_percent_wood');
	$attr_mod_percent_stone['value'] = set_value('mod_percent_stone');
	$attr_mod_percent_iron['value'] = set_value('mod_percent_iron');
	$attr_mod_percent_mana['value'] = set_value('mod_percent_mana');
}
else
{
	//set every value from data sent
	$link_form = 'admin/spell/' . $spell['id'];

	$seff = $spell['effect'];

	$attr_duration['value'] = $spell['duration'];
	$attr_cooldown['value'] = $spell['cooldown'];
	$attr_description['value'] = $spell['description'];
	$attr_description_admin['value'] = $spell['description_admin'];

	$sweather = $spell['weather_change_to'];

	$attr_cost_food['value'] = $spell['cost_food'];
	$attr_cost_wood['value'] = $spell['cost_wood'];
	$attr_cost_stone['value'] = $spell['cost_stone'];
	$attr_cost_iron['value'] = $spell['cost_iron'];
	$attr_cost_mana['value'] = $spell['cost_mana'];

	$attr_mod_max_food['value'] = $spell['mod_max_food'];
	$attr_mod_max_wood['value'] = $spell['mod_max_wood'];
	$attr_mod_max_stone['value'] = $spell['mod_max_stone'];
	$attr_mod_max_iron['value'] = $spell['mod_max_iron'];
	$attr_mod_max_mana['value'] = $spell['mod_max_mana'];

	$attr_mod_rate_food['value'] = $spell['mod_rate_food'];
	$attr_mod_rate_wood['value'] = $spell['mod_rate_wood'];
	$attr_mod_rate_stone['value'] = $spell['mod_rate_stone'];
	$attr_mod_rate_iron['value'] = $spell['mod_rate_iron'];
	$attr_mod_rate_mana['value'] = $spell['mod_rate_mana'];

	$attr_mod_percent_food['value'] = $spell['mod_percent_food'];
	$attr_mod_percent_wood['value'] = $spell['mod_percent_wood'];
	$attr_mod_percent_stone['value'] = $spell['mod_percent_stone'];
	$attr_mod_percent_iron['value'] = $spell['mod_percent_iron'];
	$attr_mod_percent_mana['value'] = $spell['mod_percent_mana'];
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
Effect:
</div>
<div class="edit_input">
<?=form_dropdown($name_effect, $opteff, $seff, $attr_effect); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Duration:
</div>
<div class="edit_input">
<?=form_input($attr_duration); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Cooldown:
</div>
<div class="edit_input">
<?=form_input($attr_cooldown); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit_textbox">
<div class="edit_name">
Description:
</div>
<div class="edit_input">
<?=form_textarea($attr_description); ?>
</div>
</div>

<div class="row_edit_textbox">
<div class="edit_name">
Admin Description:
</div>
<div class="edit_input">
<?=form_textarea($attr_description_admin); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Change Weather To:
</div>
<div class="edit_input">
<?=form_dropdown('weather_change_to', $optweather, $sweather, $attr_drop); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Cost Food:
</div>
<div class="edit_input">
<?=form_input($attr_cost_food); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Cost wood:
</div>
<div class="edit_input">
<?=form_input($attr_cost_wood); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Cost Stone:
</div>
<div class="edit_input">
<?=form_input($attr_cost_stone); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Cost Iron:
</div>
<div class="edit_input">
<?=form_input($attr_cost_iron); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Cost Mana:
</div>
<div class="edit_input">
<?=form_input($attr_cost_mana); ?>
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
Mod Rate Food:
</div>
<div class="edit_input">
<?=form_input($attr_mod_rate_food); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Mod Rate Wood:
</div>
<div class="edit_input">
<?=form_input($attr_mod_rate_wood); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Mod Rate Stone:
</div>
<div class="edit_input">
<?=form_input($attr_mod_rate_stone); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Mod Rate Iron:
</div>
<div class="edit_input">
<?=form_input($attr_mod_rate_iron); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Mod Rate Mana:
</div>
<div class="edit_input">
<?=form_input($attr_mod_rate_mana); ?>
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
