<?php
$this->load->helper('url');
$this->load->helper('form');

$link_back = 'admin/unit_tool';

$attr_drop = 'class="drop"';

$attr_name = array(
		'name' => 'name',
		'class' => 'input');

$attr_type = array(
		'name' => 'type',
		'class' => 'input');

$attr_icon = array(
		'name' => 'icon',
		'class' => 'input');

$attr_score = array(
		'name' => 'score',
		'class' => 'input');

$opt_can_defend = array(
		'0' => 'Not',
		'1' => 'Yes');

$attr_defense = array(
		'name' => 'defense',
		'class' => 'input');

$attr_attack = array(
		'name' => 'attack',
		'class' => 'input');

$attr_turn = array(
		'name' => 'turn',
		'class' => 'input');

$attr_ability = array(
		'name' => 'ability',
		'class' => 'input');

$attr_time_to_create = array(
		'name' => 'time_to_create',
		'class' => 'input');

$name_cost_unit = 'cost_unit';

$attr_cost_unit = 'class="drop"';

$attr_cost_num_unit = array(
		'name' => 'cost_num_unit',
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

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Submit',
		'class' => 'submit');

if ($new)
{
	//set every value with set_value()
	$link_form = 'admin/unit';
	$attr_type['value'] = set_value('type');
	$attr_name['value'] = set_value('name');
	$attr_icon['value'] = set_value('icon');

	$attr_score['value'] = set_value('score');
	$attr_defense['value'] = set_value('icon');
	$attr_attack['value'] = set_value('icon');
	$attr_turn['value'] = set_value('icon');
	$attr_ability['value'] = set_value('icon');

	$attr_time_to_create['value'] = set_value('time_to_create');

	$attr_cost_unit['value'] = set_value('cost_unit');
	$attr_cost_num_unit['value'] = set_value('cost_num_unit');

	$attr_cost_food['value'] = set_value('cost_food');
	$attr_cost_wood['value'] = set_value('cost_wood');
	$attr_cost_stone['value'] = set_value('cost_stone');
	$attr_cost_iron['value'] = set_value('cost_iron');
	$attr_cost_mana['value'] = set_value('cost_mana');

	$attr_mod_rate_food['value'] = set_value('mod_rate_food');
	$attr_mod_rate_wood['value'] = set_value('mod_rate_wood');
	$attr_mod_rate_stone['value'] = set_value('mod_rate_stone');
	$attr_mod_rate_iron['value'] = set_value('mod_rate_iron');
	$attr_mod_rate_mana['value'] = set_value('mod_rate_mana');
}
else
{
	//set every value from data sent
	$link_form = 'admin/unit/' . $unit['id'];
	$attr_type['value'] = $unit['type'];
	$attr_name['value'] = $unit['name'];
	$attr_icon['value'] = $unit['icon'];

	$attr_score['value'] = $unit['score'];
	$scd = $unit['can_defend'];
	$attr_defense['value'] = $unit['defense'];
	$attr_attack['value'] = $unit['attack'];
	$sstrong = $unit['strong_against'];
	$sweak = $unit['weak_against'];
	$attr_turn['value'] = $unit['turn'];
	$attr_ability['value'] = $unit['ability'];

	$attr_time_to_create['value'] = $unit['time_to_create'];

	$costu = $unit['cost_unit'];
	$attr_cost_num_unit['value'] = $unit['cost_num_unit'];

	$attr_cost_food['value'] = $unit['cost_food'];
	$attr_cost_wood['value'] = $unit['cost_wood'];
	$attr_cost_stone['value'] = $unit['cost_stone'];
	$attr_cost_iron['value'] = $unit['cost_iron'];
	$attr_cost_mana['value'] = $unit['cost_mana'];

	$attr_mod_rate_food['value'] = $unit['mod_rate_food'];
	$attr_mod_rate_wood['value'] = $unit['mod_rate_wood'];
	$attr_mod_rate_stone['value'] = $unit['mod_rate_stone'];
	$attr_mod_rate_iron['value'] = $unit['mod_rate_iron'];
	$attr_mod_rate_mana['value'] = $unit['mod_rate_mana'];
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

<div class="row_edit">
<div class="edit_name">
Icon:
</div>
<div class="edit_input">
<?=form_input($attr_icon); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Type:
</div>
<div class="edit_input">
<?=form_input($attr_type); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Time to Create:
</div>
<div class="edit_input">
<?=form_input($attr_time_to_create); ?>
</div>
</div>

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
Can Defend?
</div>
<div class="edit_input">
<?=form_dropdown('can_defend', $opt_can_defend, $scd, $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Defense:
</div>
<div class="edit_input">
<?=form_input($attr_defense); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Attack:
</div>
<div class="edit_input">
<?=form_input($attr_attack); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Strong Against:
</div>
<div class="edit_input">
<?=form_dropdown('strong_against', $optaiu, $sstrong, $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Weak Against:
</div>
<div class="edit_input">
<?=form_dropdown('weak_against', $optaiu, $sweak, $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Turn:
</div>
<div class="edit_input">
<?=form_input($attr_turn); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Ability:
</div>
<div class="edit_input">
<?=form_input($attr_ability); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Cost Unit:
</div>
<div class="edit_input">
<?=form_dropdown($name_cost_unit, $optu, $costu, $attr_cost_unit); ?>
X <?=form_input($attr_cost_num_unit); ?>
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
Mos Rate Food:
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

<div class="edit_submit">
<?=form_submit($attr_submit); ?>
</div>
<?=form_close(); ?>
