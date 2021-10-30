<?php
$this->load->helper('url');
$this->load->helper('form');

$link_back = 'admin/ai_unit_tool';

$attr_drop = 'class="drop"';

$attr_name = array(
		'name' => 'name',
		'class' => 'input');

$attr_icon = array(
		'name' => 'icon',
		'class' => 'input');

$attr_ability = array(
		'name' => 'ability',
		'class' => 'input');

$attr_can_carry = array(
		'name' => 'can_carry',
		'class' => 'input');

$attr_attack = array(
		'name' => 'attack',
		'class' => 'input');

$attr_defense = array(
		'name' => 'defense',
		'class' => 'input');

$attr_rate = array(
		'name' => 'rate',
		'class' => 'input');

$attr_per_score = array(
		'name' => 'per_score',
		'class' => 'input');

$attr_turn = array(
		'name' => 'turn',
		'class' => 'input');

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Submit',
		'class' => 'submit');

if ($new)
{
	//set every value with set_value()
	$link_form = 'admin/ai_unit';

	$attr_name['value'] = set_value('name');
	$attr_icon['value'] = set_value('icon');
	$attr_ability['value'] = set_value('ability');

	$attr_can_carry['value'] = set_value('can_carry');
	$attr_attack['value'] = set_value('attack');
	$attr_defense['value'] = set_value('defense');
	$attr_rate['value'] = set_value('rate');
	$attr_per_score['value'] = set_value('per_score');
	$attr_turn['value'] = set_value('turn');
}
else
{
	//set every value from data sent
	$link_form = 'admin/ai_unit/' . $unit['id'];

	$attr_name['value'] = $unit['name'];
	$attr_icon['value'] = $unit['icon'];
	$attr_ability['value'] = $unit['ability'];
	$attr_can_carry['value'] = $unit['can_carry'];

	$attr_attack['value'] = $unit['attack'];
	$attr_defense['value'] = $unit['defense'];
	$attr_rate['value'] = $unit['rate'];
	$attr_per_score['value'] = $unit['per_score'];
	$attr_turn['value'] = $unit['turn'];

	$sstrong = $unit['strong_against'];
	$sweak = $unit['weak_against'];
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

<div class="edit_spacer"></div>

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
Can Carry:
</div>
<div class="edit_input">
<?=form_input($attr_can_carry); ?>
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
Defense:
</div>
<div class="edit_input">
<?=form_input($attr_defense); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Rate:
</div>
<div class="edit_input">
<?=form_input($attr_rate); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Per Score:
</div>
<div class="edit_input">
<?=form_input($attr_per_score); ?>
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

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Strong Against:
</div>
<div class="edit_input">
<?=form_dropdown('strong_against', $optu, $sstrong, $attr_drop); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Weak Against:
</div>
<div class="edit_input">
<?=form_dropdown('weak_against', $optu, $sweak, $attr_drop); ?>
</div>
</div>

<div class="edit_submit">
<?=form_submit($attr_submit); ?>
</div>
<?=form_close(); ?>
