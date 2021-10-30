<?php
$this->load->helper('url');
$this->load->helper('form');

$link_back = 'admin/hero_template_tool';

$attr_drop = 'class="drop"';

$attr_classname = array(
		'name' => 'classname',
		'class' => 'input');

$attr_nomod_max_health = array(
		'name' => 'nomod_max_health',
		'class' => 'input');

$attr_nomod_max_mana = array(
		'name' => 'nomod_max_mana',
		'class' => 'input');

$attr_agility = array(
		'name' => 'agility',
		'class' => 'input');

$attr_strength = array(
		'name' => 'strength',
		'class' => 'input');

$attr_stamina = array(
		'name' => 'stamina',
		'class' => 'input');

$attr_intellect = array(
		'name' => 'intellect',
		'class' => 'input');

$attr_spirit = array(
		'name' => 'spirit',
		'class' => 'input');

$attr_nomod_attackpower = array(
		'name' => 'nomod_attackpower',
		'class' => 'input');

$attr_nomod_dodge = array(
		'name' => 'nomod_dodge',
		'class' => 'input');

$attr_nomod_parry = array(
		'name' => 'nomod_parry',
		'class' => 'input');

$attr_hit = array(
		'name' => 'hit',
		'class' => 'input');

$attr_nomod_crit = array(
		'name' => 'nomod_crit',
		'class' => 'input');

$attr_nomod_damage_min = array(
		'name' => 'nomod_damage_min',
		'class' => 'input');

$attr_nomod_damage_max = array(
		'name' => 'nomod_damage_max',
		'class' => 'input');

$attr_nomod_ranged_damage_min = array(
		'name' => 'nomod_ranged_damage_min',
		'class' => 'input');

$attr_nomod_ranged_damage_max = array(
		'name' => 'nomod_ranged_damage_max',
		'class' => 'input');


$attr_nomod_heal_min = array(
		'name' => 'nomod_heal_min',
		'class' => 'input');

$attr_nomod_heal_max = array(
		'name' => 'nomod_heal_max',
		'class' => 'input');

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Submit',
		'class' => 'submit');

if ($new)
{
	//set every value with set_value()
	$link_form = 'admin/hero_templates';

	//template effect goes from controller
	$attr_classname['value'] = set_value('classname');

	$attr_nomod_max_health['value'] = set_value('nomod_max_health');
	$attr_nomod_max_mana['value'] = set_value('nomod_max_mana');

	$attr_agility['value'] = set_value('agility');
	$attr_strength['value'] = set_value('strength');
	$attr_stamina['value'] = set_value('stamina');
	$attr_intellect['value'] = set_value('intellect');
	$attr_spirit['value'] = set_value('spirit');

	$attr_nomod_attackpower['value'] = set_value('nomod_attackpower');

	$attr_nomod_dodge['value'] = set_value('nomod_dodge');
	$attr_nomod_parry['value'] = set_value('nomod_parry');
	$attr_hit['value'] = set_value('hit');
	$attr_nomod_crit['value'] = set_value('nomod_crit');

	$attr_nomod_damage_min['value'] = set_value('nomod_damage_min');
	$attr_nomod_damage_max['value'] = set_value('nomod_damage_max');

	$attr_nomod_ranged_damage_min['value'] = set_value('nomod_ranged_damage_min');
	$attr_nomod_ranged_damage_max['value'] = set_value('nomod_ranged_damage_max');

	$attr_nomod_heal_min['value'] = set_value('nomod_heal_min');
	$attr_nomod_heal_max['value'] = set_value('nomod_heal_max');
}
else
{
	//set every value from data sent
	$link_form = 'admin/hero_templates/' . $template['id'];

	$attr_classname['value'] = $template['classname'];

	$attr_nomod_max_health['value'] = $template['nomod_max_health'];
	$attr_nomod_max_mana['value'] = $template['nomod_max_mana'];

	$attr_agility['value'] = $template['agility'];
	$attr_strength['value'] = $template['strength'];
	$attr_stamina['value'] = $template['stamina'];
	$attr_intellect['value'] = $template['intellect'];
	$attr_spirit['value'] = $template['spirit'];

	$attr_nomod_attackpower['value'] = $template['nomod_attackpower'];

	$attr_nomod_dodge['value'] = $template['nomod_dodge'];
	$attr_nomod_parry['value'] = $template['nomod_parry'];
	$attr_hit['value'] = $template['hit'];
	$attr_nomod_crit['value'] = $template['nomod_crit'];

	$attr_nomod_damage_min['value'] = $template['nomod_damage_min'];
	$attr_nomod_damage_max['value'] = $template['nomod_damage_max'];

	$attr_nomod_ranged_damage_min['value'] = $template['nomod_ranged_damage_min'];
	$attr_nomod_ranged_damage_max['value'] = $template['nomod_ranged_damage_max'];

	$attr_nomod_heal_min['value'] = $template['nomod_heal_min'];
	$attr_nomod_heal_max['value'] = $template['nomod_heal_max'];
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
Class:
</div>
<div class="edit_input">
<?=form_input($attr_classname); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Nomod Health:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_max_health); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Nomod Mana:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_max_mana); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Agility:
</div>
<div class="edit_input">
<?=form_input($attr_agility); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Strength:
</div>
<div class="edit_input">
<?=form_input($attr_strength); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Stamina:
</div>
<div class="edit_input">
<?=form_input($attr_stamina); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Intellect:
</div>
<div class="edit_input">
<?=form_input($attr_intellect); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Spirit:
</div>
<div class="edit_input">
<?=form_input($attr_spirit); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Nomod Attackpower:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_attackpower); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Nomod Dodge:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_dodge); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Nomod Parry:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_parry); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Hit:
</div>
<div class="edit_input">
<?=form_input($attr_hit); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Nomod Crit:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_crit); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Nomod Damage Min:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_damage_min); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Nomod Damage Max:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_damage_max); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Nomod Ranged Damage Min:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_ranged_damage_min); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Nomod Ranged Damage Max:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_ranged_damage_max); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Nomod Heal Min:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_heal_min); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Nomod Heal Max:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_heal_max); ?>
</div>
</div>

<?php if(!$new): ?>
<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Calculated Values:
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Max Health:
</div>
<div class="edit_input">
<?=$template['max_health']; ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Max Mana:
</div>
<div class="edit_input">
<?=$template['max_mana']; ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Attackpower:
</div>
<div class="edit_input">
<?=$template['attackpower']; ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Crit:
</div>
<div class="edit_input">
<?=$template['crit']; ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Parry:
</div>
<div class="edit_input">
<?=$template['parry']; ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Dodge:
</div>
<div class="edit_input">
<?=$template['dodge']; ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Armor:
</div>
<div class="edit_input">
<?=$template['armor']; ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Damage Min:
</div>
<div class="edit_input">
<?=$template['damage_min']; ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Damage Max:
</div>
<div class="edit_input">
<?=$template['damage_max']; ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Ranged Damage Min:
</div>
<div class="edit_input">
<?=$template['ranged_damage_min']; ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Ranged Damage Max:
</div>
<div class="edit_input">
<?=$template['ranged_damage_max']; ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Heal Min:
</div>
<div class="edit_input">
<?=$template['heal_min']; ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Heal Max:
</div>
<div class="edit_input">
<?=$template['heal_min']; ?>
</div>
</div>

<?php endif; ?>

<div class="edit_submit">
<?=form_submit($attr_submit); ?>
</div>
<?=form_close(); ?>
