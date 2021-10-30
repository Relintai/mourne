<?php
$this->load->helper('url');
$this->load->helper('form');

$link_back = 'admin/technology_tool';

$attr_description = array(
		'name' => 'description',
		'rows' => '5',
		'cols' => '50',
		'class' => 'textarea');

$attr_time = array(
		'name' => 'time',
		'class' => 'input');

$attr_score = array(
		'name' => 'score',
		'class' => 'input');

$opt_flag_ai = array(
		'0' => 'No',
		'1' => 'Yes');

$attr_num_creates = array(
		'name' => 'num_creates',
		'class' => 'input');

$attr_time_to_build = array(
		'name' => 'time_to_build',
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

$name_mod_spell_id = 'mod_spell_id';
$attr_mod_spell_id = 'class="drop"';

$name_mod_create_id = 'mod_create_id';
$attr_mod_create_id = 'class="drop"';

$attr_drop = 'class="drop"';

$name_is_secondary = 'is_secondary';
$attr_is_secondary = 'class="drop"';

$opt_is_secondary = array(
			'0' => 'Primary',
			'1' => 'Secondary');

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Submit',
		'class' => 'submit');

if ($new)
{
	//set every value with set_value()
	$link_form = 'admin/technology';
	$attr_description['value'] = set_value('description');
	$attr_time['value'] = set_value('time');

	$attr_score['value'] = set_value('score');

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
	$link_form = 'admin/technology/' . $technology['id'];
	$attr_description['value'] = $technology['description'];

	$attr_time['value'] = $technology['time'];

	$attr_score['value'] = $technology['score'];

	$attr_cost_food['value'] = $technology['cost_food'];
	$attr_cost_wood['value'] = $technology['cost_wood'];
	$attr_cost_stone['value'] = $technology['cost_stone'];
	$attr_cost_iron['value'] = $technology['cost_iron'];
	$attr_cost_mana['value'] = $technology['cost_mana'];

	$attr_mod_max_food['value'] = $technology['mod_max_food'];
	$attr_mod_max_wood['value'] = $technology['mod_max_wood'];
	$attr_mod_max_stone['value'] = $technology['mod_max_stone'];
	$attr_mod_max_iron['value'] = $technology['mod_max_iron'];
	$attr_mod_max_mana['value'] = $technology['mod_max_mana'];

	$attr_mod_rate_food['value'] = $technology['mod_rate_food'];
	$attr_mod_rate_wood['value'] = $technology['mod_rate_wood'];
	$attr_mod_rate_stone['value'] = $technology['mod_rate_stone'];
	$attr_mod_rate_iron['value'] = $technology['mod_rate_iron'];
	$attr_mod_rate_mana['value'] = $technology['mod_rate_mana'];

	$attr_mod_percent_food['value'] = $technology['mod_percent_food'];
	$attr_mod_percent_wood['value'] = $technology['mod_percent_wood'];
	$attr_mod_percent_stone['value'] = $technology['mod_percent_stone'];
	$attr_mod_percent_iron['value'] = $technology['mod_percent_iron'];
	$attr_mod_percent_mana['value'] = $technology['mod_percent_mana'];

	$sspid = $technology['mod_spell_id'];
	$smcid = $technology['mod_create_id'];
	$sflai = $technology['flag_ai'];

	$selissec = $technology['is_secondary'];
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

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Time:
</div>
<div class="edit_input">
<?=form_input($attr_time); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Score:
</div>
<div class="edit_input">
<?=form_input($attr_score); ?>
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
Cost Wood:
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
Cost iron:
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

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Mod Spell Id:
</div>
<div class="edit_input">
<?=form_dropdown($name_mod_spell_id, $mspidopt, $sspid, $attr_mod_spell_id); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Mod Create Id:
</div>
<div class="edit_input">
<?=form_dropdown($name_mod_create_id, $mcidopt, $smcid, $attr_mod_create_id); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Flag AI:
</div>
<div class="edit_input">
<?=form_dropdown('flag_ai', $opt_flag_ai, $sflai, $attr_drop); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Type:
</div>
<div class="edit_input">
<?=form_dropdown($name_is_secondary, $opt_is_secondary, $selissec, $attr_is_secondary); ?>
</div>
</div>

<div class="edit_submit">
<?=form_submit($attr_submit); ?>
</div>
<?=form_close(); ?>
