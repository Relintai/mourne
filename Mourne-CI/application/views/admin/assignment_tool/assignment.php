<?php
$this->load->helper('url');
$this->load->helper('form');

$link_back = 'admin/assignment_tool';

$name_unit = 'unitid';
$attr_unit = 'class="drop"';

$attr_max = array(
		'name' => 'max',
		'class' => 'input');

$attr_bonus_per_assigned = array(
		'name' => 'bonus_per_assigned',
		'class' => 'input');

$name_spellid = 'spellid';
$attr_spellid = 'class="drop"';

$name_req_tech = 'req_tech';
$attr_req_tech = 'class="drop"';

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

$attr_description = array(
		'name' => 'description',
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
	$link_form = 'admin/assignment';
	//unitid goes from controller
	$attr_max['value'] = set_value('max');
	$attr_bonus_per_assigned['value'] = set_value('bonus_per_assigned');

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

	$attr_description['value'] = set_value('description');

}
else
{
	//set every value from data sent
	$link_form = 'admin/assignment/' . $assignment['id'];

	//I have no idea why a simple = wouldn't work
	$dassign = $assignment['unitid'];
	$sassign = $dassign;

	$attr_max['value'] = $assignment['max'];
	$attr_bonus_per_assigned['value'] = $assignment['bonus_per_assigned'];

	$ssp = $assignment['spellid'];

	$srtech = $assignment['req_tech'];

	$attr_mod_max_food['value'] = $assignment['mod_max_food'];
	$attr_mod_max_wood['value'] = $assignment['mod_max_wood'];
	$attr_mod_max_stone['value'] = $assignment['mod_max_stone'];
	$attr_mod_max_iron['value'] = $assignment['mod_max_iron'];
	$attr_mod_max_mana['value'] = $assignment['mod_max_mana'];

	$attr_mod_rate_food['value'] = $assignment['mod_rate_food'];
	$attr_mod_rate_wood['value'] = $assignment['mod_rate_wood'];
	$attr_mod_rate_stone['value'] = $assignment['mod_rate_stone'];
	$attr_mod_rate_iron['value'] = $assignment['mod_rate_iron'];
	$attr_mod_rate_mana['value'] = $assignment['mod_rate_mana'];

	$attr_mod_percent_food['value'] = $assignment['mod_percent_food'];
	$attr_mod_percent_wood['value'] = $assignment['mod_percent_wood'];
	$attr_mod_percent_stone['value'] = $assignment['mod_percent_stone'];
	$attr_mod_percent_iron['value'] = $assignment['mod_percent_iron'];
	$attr_mod_percent_mana['value'] = $assignment['mod_percent_mana'];

	$attr_description['value'] = $assignment['description'];
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
Unit:
</div>
<div class="edit_input">
<?=form_dropdown($name_unit, $optass, $sassign, $attr_unit); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Max:
</div>
<div class="edit_input">
<?=form_input($attr_max); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Bonus per Assigned:
</div>
<div class="edit_input">
<?=form_input($attr_bonus_per_assigned); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Spell:
</div>
<div class="edit_input">
<?=form_dropdown($name_spellid, $optsp, $ssp, $attr_spellid); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Required Technology:
</div>
<div class="edit_input">
<?=form_dropdown($name_req_tech, $optrtech, $srtech, $attr_req_tech); ?>
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

<div class="edit_spacer"></div>

<div class="row_edit_textbox">
<div class="edit_name">
Description:
</div>
<div class="edit_input">
<?=form_textarea($attr_description); ?>
</div>
</div>

<div class="edit_submit">
<?=form_submit($attr_submit); ?>
</div>
<?=form_close(); ?>
