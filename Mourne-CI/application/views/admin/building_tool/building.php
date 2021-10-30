<?php
$this->load->helper('url');
$this->load->helper('form');

$link_back = 'admin/building_tool';

$attr_drop = 'class="drop"';

$attr_name = array(
		'name' => 'name',
		'class' => 'input');

$attr_description = array(
		'name' => 'description',
		'rows' => '5',
		'cols' => '50',
		'class' => 'textarea');

$attr_icon = array(
		'name' => 'icon',
		'class' => 'input');

$attr_rank = array(
		'name' => 'rank',
		'class' => 'input');


$name_next_rank = 'next_rank';
$attr_next_rank = 'class="drop"';

$attr_time_to_build = array(
		'name' => 'time_to_build',
		'class' => 'input');

$name_creates = 'creates';
$attr_creates = 'class="drop"';

$attr_num_creates = array(
		'name' => 'num_creates',
		'class' => 'input');

$attr_score = array(
		'name' => 'score',
		'class' => 'input');

$attr_defense = array(
		'name' => 'defense',
		'class' => 'input');

$opt_ability = array(
		'0' => 'Nothing',
		'1' => "Enemy can't steal resources");

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

$name_assign1 = 'assign1';
$name_assign2 = 'assign2';
$name_assign3 = 'assign3';
$name_assign4 = 'assign4';
$name_assign5 = 'assign5';

$attr_assign = 'class="drop"';

$name_req_tech = 'req_tech';
$attr_req_tech = 'class="drop"';

$name_tech_group = 'tech_group';
$attr_tech_group = 'class="drop"';

$name_tech_secondary_group = 'tech_secondary_group';
$attr_tech_secondary_group = 'class="drop"';

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Submit',
		'class' => 'submit');

if ($new)
{
	//set every value with set_value()
	$link_form = 'admin/building';
	$attr_name['value'] = set_value('name');
	$attr_description['value'] = set_value('description');
	$attr_icon['value'] = set_value('icon');
	$attr_rank['value'] = set_value('rank');
	//next rank goes from controller
	$attr_time_to_build['value'] = set_value('time_to_build');

	$attr_num_creates['value'] = set_value('num_creates');

	$attr_score['value'] = set_value('score');
	$attr_defense['value'] = set_value('defense');

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
	$link_form = 'admin/building/' . $building['id'];
	$attr_name['value'] = $building['name'];
	$attr_description['value'] = $building['description'];
	$attr_icon['value'] = $building['icon'];
	$attr_rank['value'] = $building['rank'];
	$nextr = $building['next_rank'];
	$attr_time_to_build['value'] = $building['time_to_build'];

	$screate = $building['creates'];
	$attr_num_creates['value'] = $building['num_creates'];

	$attr_score['value'] = $building['score'];
	$attr_defense['value'] = $building['defense'];

	$sability = $building['ability'];

	$attr_cost_food['value'] = $building['cost_food'];
	$attr_cost_wood['value'] = $building['cost_wood'];
	$attr_cost_stone['value'] = $building['cost_stone'];
	$attr_cost_iron['value'] = $building['cost_iron'];
	$attr_cost_mana['value'] = $building['cost_mana'];

	$attr_mod_max_food['value'] = $building['mod_max_food'];
	$attr_mod_max_wood['value'] = $building['mod_max_wood'];
	$attr_mod_max_stone['value'] = $building['mod_max_stone'];
	$attr_mod_max_iron['value'] = $building['mod_max_iron'];
	$attr_mod_max_mana['value'] = $building['mod_max_mana'];

	$attr_mod_rate_food['value'] = $building['mod_rate_food'];
	$attr_mod_rate_wood['value'] = $building['mod_rate_wood'];
	$attr_mod_rate_stone['value'] = $building['mod_rate_stone'];
	$attr_mod_rate_iron['value'] = $building['mod_rate_iron'];
	$attr_mod_rate_mana['value'] = $building['mod_rate_mana'];

	$attr_mod_percent_food['value'] = $building['mod_percent_food'];
	$attr_mod_percent_wood['value'] = $building['mod_percent_wood'];
	$attr_mod_percent_stone['value'] = $building['mod_percent_stone'];
	$attr_mod_percent_iron['value'] = $building['mod_percent_iron'];
	$attr_mod_percent_mana['value'] = $building['mod_percent_mana'];

	$assign1 = $building['assignment1'];
	$assign2 = $building['assignment2'];
	$assign3 = $building['assignment3'];
	$assign4 = $building['assignment4'];
	$assign5 = $building['assignment5'];

	$selreqtech = $building['req_tech'];

	$seltechgroup = $building['tech_group'];
	$seltechsecgroup = $building['tech_secondary_group'];
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
<div class="edit_container">
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
Icon:
</div>
<div class="edit_input">
<?=form_input($attr_icon); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Rank:
</div>
<div class="edit_input">
<?=form_input($attr_rank); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Next Rank:
</div>
<div class="edit_input">
<?=form_dropdown($name_next_rank, $optnr, $nextr, $attr_next_rank); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Time to Build:
</div>
<div class="edit_input">
<?=form_input($attr_time_to_build); ?>
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
Ability:
</div>
<div class="edit_input">
<?=form_dropdown('ability', $opt_ability, $sability, $attr_drop); ?>
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
Creates:
</div>
<div class="edit_input">
<?=form_dropdown($name_creates, $optcre, $screate, $attr_creates); ?>
X (max) <?=form_input($attr_num_creates); ?>
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
Mos Max Stone:
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
Mod rate Wood:
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
Assignment 1:
</div>
<div class="edit_input">
<?=form_dropdown($name_assign1, $optass, $assign1, $attr_assign); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Assignment 2:
</div>
<div class="edit_input">
<?=form_dropdown($name_assign2, $optass, $assign2, $attr_assign); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Assignment 3:
</div>
<div class="edit_input">
<?=form_dropdown($name_assign3, $optass, $assign3, $attr_assign); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Assignment 4:
</div>
<div class="edit_input">
<?=form_dropdown($name_assign4, $optass, $assign4, $attr_assign); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Assignment 5:
</div>
<div class="edit_input">
<?=form_dropdown($name_assign5, $optass, $assign5, $attr_assign); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Required Technology:
</div>
<div class="edit_input">
<?=form_dropdown($name_req_tech, $optreqtech, $selreqtech, $attr_req_tech); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Technology Group:
</div>
<div class="edit_input">
<?=form_dropdown($name_tech_group, $opttechgroup, $seltechgroup, $attr_assign);?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Secondary Technology Group:
</div>
<div class="edit_input">
<?=form_dropdown($name_tech_secondary_group, $opttechgroup, 
			$seltechsecgroup, $attr_tech_secondary_group); ?>
</div>
</div>

<div class="edit_submit">
<?=form_submit($attr_submit); ?>
</div>
<?=form_close(); ?>
</div>