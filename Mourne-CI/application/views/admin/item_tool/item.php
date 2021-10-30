<?php
$this->load->helper('url');
$this->load->helper('form');

$link_back = 'admin/item_tool';

$attr_drop = 'class="drop"';

$attr_name = array(
		'name' => 'name',
		'class' => 'input');

$attr_icon = array(
		'name' => 'icon',
		'class' => 'input');

//quality
//names!
$opt_quality = array(
  '0' => 'Really Poor',
  '1' => 'Poor',
  '2' => 'Good',
  '3' => 'Great',
  '4' => 'Epic',
  '5' => 'Legendary',
  '6' => 'OMG');

$attr_itemlevel = array(
		'name' => 'itemlevel',
		'class' => 'input');

$attr_stack = array(
		'name' => 'stack',
		'class' => 'input');

//type
$opt_type = array(
  '0' => 'None',
  '1' => 'Equipment',
  '2' => 'Consumable',
  '3' => 'Quest Item');

//subtype note: spaces in between the numbers are intentional! (to minimize human error)
$opt_subtype = array(
  '0' => 'none',
  'Equipment' => array(
    '0' => 'Head 0',
    '1' => 'Neck 1',
    '2' => 'Shoulder 2',
    '3' => 'Back 3',
    '4' => 'Chest 4',
    '5' => 'Shirt 5',
    '6' => 'Tabard 6',
    '7' => 'Bracers 7',
    '8' => 'Gloves 8',
    '9' => 'Belt 9',
    '10' => 'Legs 10',
    '11' => 'Foots 11',
    '12' => 'Ring 12',
    '14' => 'Trinket 14',
    '16' => 'Weapon 16',
    '19' => 'ammo 19'));

//subtype
$opt_subsubtype = array(
  '0' => 'none',
  'weapon' => array(
    '1' => '2h Mace'),
  'Equipment' => array(
    '0' => 'none 0',
    '1' => 'Cloth 1',
    '2' => 'Leather 2',
    '3' => 'Mail 3',
    '4' => 'Plate 4'),
  'Weapon' => array(
    '1' => 'Staff 1',
    '2' => 'Dagger One Hand 2',
    '3' => 'Dagger Main Hand 3',
    '4' => 'Dagger Off Hand 4',
    '5' => 'Mace One Hand 5',
    '6' => 'Mace Main Hand 6',
    '7' => 'Mace Off Hand 7',
    '8' => 'Mace Two Hand 8',

    '9' => 'Axe One Hand 9',
    '10' => 'Axe Main Hand 10',
    '11' => 'Axe Off Hand 11',
    '12' => 'Axe Two Hand 12',

    '13' => 'Sword One Hand 13',
    '14' => 'Sword Main Hand 14',
    '15' => 'Sword Off Hand 15',
    '16' => 'Sword Two Hand 16',

    '17' => 'Bow 17',
    '18' => 'Crossbow 18',
    '19' => 'Gun 19'));

$attr_sell_price = array(
		'name' => 'sell_price',
		'class' => 'input');

$attr_buy_price = array(
		'name' => 'buy_price',
		'class' => 'input');

$attr_text = array(
		'name' => 'text',
		'rows' => '5',
		'cols' => '50',
		'class' => 'textarea');

//soulbound
$opt_soulbound = array(
  '0' => 'No',
  '1' => 'BoE',
  '2' => 'BoP');


//spell (from controller)
//proc (from controller)

$attr_req_level = array(
		'name' => 'req_level',
		'class' => 'input');

$opt_req_class = array(
  '0' => 'All',
  '1' => 'Warrior',
  '2' => 'Rogue',
  '3' => 'Archer');

$attr_nomod_max_health = array(
		'name' => 'nomod_max_health',
		'class' => 'input');

$attr_nomod_max_mana = array(
		'name' => 'nomod_max_mana',
		'class' => 'input');

$attr_percent_max_health = array(
		'name' => 'percent_max_health',
		'class' => 'input');

$attr_percent_max_mana = array(
		'name' => 'percent_max_mana',
		'class' => 'input');

$attr_nomod_agility = array(
		'name' => 'nomod_agility',
		'class' => 'input');

$attr_nomod_strength = array(
		'name' => 'nomod_strength',
		'class' => 'input');

$attr_nomod_stamina = array(
		'name' => 'nomod_stamina',
		'class' => 'input');

$attr_nomod_intellect = array(
		'name' => 'nomod_intellect',
		'class' => 'input');

$attr_nomod_spirit = array(
		'name' => 'nomod_spirit',
		'class' => 'input');

$attr_percent_agility = array(
		'name' => 'percent_agility',
		'class' => 'input');

$attr_percent_strength = array(
		'name' => 'percent_strength',
		'class' => 'input');

$attr_percent_stamina = array(
		'name' => 'percent_stamina',
		'class' => 'input');

$attr_percent_intellect = array(
		'name' => 'percent_intellect',
		'class' => 'input');

$attr_percent_spirit = array(
		'name' => 'percent_spirit',
		'class' => 'input');

$attr_nomod_attackpower = array(
		'name' => 'nomod_attackpower',
		'class' => 'input');

$attr_percent_attackpower = array(
		'name' => 'percent_attackpower',
		'class' => 'input');

$attr_nomod_armor = array(
		'name' => 'nomod_armor',
		'class' => 'input');

$attr_percent_armor = array(
		'name' => 'percent_armor',
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

$attr_percent_damage_min = array(
		'name' => 'percent_damage_min',
		'class' => 'input');

$attr_percent_damage_max = array(
		'name' => 'percent_damage_max',
		'class' => 'input');

$attr_nomod_ranged_damage_min = array(
		'name' => 'nomod_ranged_damage_min',
		'class' => 'input');

$attr_nomod_ranged_damage_max = array(
		'name' => 'nomod_ranged_damage_max',
		'class' => 'input');

$attr_percent_ranged_damage_min = array(
		'name' => 'percent_ranged_damage_min',
		'class' => 'input');

$attr_percent_ranged_damage_max = array(
		'name' => 'percent_ranged_damage_max',
		'class' => 'input');

$attr_nomod_heal_min = array(
		'name' => 'nomod_heal_min',
		'class' => 'input');

$attr_nomod_heal_max = array(
		'name' => 'nomod_heal_max',
		'class' => 'input');

$attr_percent_heal_min = array(
		'name' => 'percent_heal_min',
		'class' => 'input');

$attr_percent_heal_max = array(
		'name' => 'percent_heal_max',
		'class' => 'input');

$attr_life_leech = array(
		'name' => 'life_leech',
		'class' => 'input');

$attr_mana_leech = array(
		'name' => 'mana_leech',
		'class' => 'input');

$attr_level_modifier = array(
		'name' => 'level_modifier',
		'class' => 'input');

$attr_level_modifier_max = array(
		'name' => 'level_modifier_max',
		'class' => 'input');

$attr_data1 = array(
		'name' => 'data1',
		'class' => 'input');

$attr_data2 = array(
		'name' => 'data2',
		'class' => 'input');

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Submit',
		'class' => 'submit');

if ($new)
{
  //set every value with set_value()
  $link_form = 'admin/items';

  //template effect goes from controller
  $attr_name['value'] = set_value('name');
  $attr_icon['value'] = set_value('icon');
  //quality
  $attr_itemlevel['value'] = set_value('itemlevel');
  $attr_stack['value'] = set_value('stack');
  //type
  //subtype
  //subsubtype
  $attr_sell_price['value'] = set_value('sell_price');
  $attr_buy_price['value'] = set_value('buy_price');
  $attr_text['value'] = set_value('text');
  //soulbound
  //spell
  //proc
  $attr_req_level['value'] = set_value('req_level');
  $attr_req_class['value'] = set_value('req_class');

  $attr_nomod_max_health['value'] = set_value('nomod_max_health');
  $attr_nomod_max_mana['value'] = set_value('nomod_max_mana');
  $attr_percent_max_health['value'] = set_value('percent_max_health');
  $attr_percent_max_mana['value'] = set_value('percent_max_mana');

  $attr_nomod_agility['value'] = set_value('nomod_agility');
  $attr_nomod_strength['value'] = set_value('nomod_strength');
  $attr_nomod_stamina['value'] = set_value('nomod_stamina');
  $attr_nomod_intellect['value'] = set_value('nomod_intellect');
  $attr_nomod_spirit['value'] = set_value('nomod_spirit');

  $attr_percent_agility['value'] = set_value('percent_agility');
  $attr_percent_strength['value'] = set_value('percent_strength');
  $attr_percent_stamina['value'] = set_value('percent_stamina');
  $attr_percent_intellect['value'] = set_value('percent_intellect');
  $attr_percent_spirit['value'] = set_value('percent_spirit');

  $attr_nomod_attackpower['value'] = set_value('nomod_attackpower');
  $attr_percent_attackpower['value'] = set_value('percent_attackpower');

  $attr_nomod_armor['value'] = set_value('nomod_armor');
  $attr_percent_armor['value'] = set_value('percent_armor');

  $attr_nomod_dodge['value'] = set_value('nomod_dodge');
  $attr_nomod_parry['value'] = set_value('nomod_parry');
  $attr_hit['value'] = set_value('hit');
  $attr_nomod_crit['value'] = set_value('nomod_crit');

  $attr_nomod_damage_min['value'] = set_value('nomod_damage_min');
  $attr_nomod_damage_max['value'] = set_value('nomod_damage_max');
  $attr_percent_damage_min['value'] = set_value('percent_damage_min');
  $attr_percent_damage_max['value'] = set_value('percent_damage_max');

  $attr_nomod_ranged_damage_min['value'] = set_value('nomod_ranged_damage_min');
  $attr_nomod_ranged_damage_max['value'] = set_value('nomod_ranged_damage_max');
  $attr_percent_ranged_damage_min['value'] = set_value('percent_ranged_damage_min');
  $attr_percent_ranged_damage_max['value'] = set_value('percent_ranged_damage_max');

  $attr_nomod_heal_min['value'] = set_value('nomod_heal_min');
  $attr_nomod_heal_max['value'] = set_value('nomod_heal_max');
  $attr_percent_heal_min['value'] = set_value('percent_heal_min');
  $attr_percent_heal_max['value'] = set_value('percent_heal_max');

  $attr_life_leech['value'] = set_value('life_leech');
  $attr_mana_leech['value'] = set_value('mana_leech');

  $attr_level_modifier['value'] = set_value('level_modifier');
  $attr_level_modifier_max['value'] = set_value('level_modifier_max');

  $attr_data1['value'] = set_value('data1');
  $attr_data2['value'] = set_value('data2');
}
else
{
  //set every value from data sent
  $link_form = 'admin/items/' . $item['id'];

  //template effect goes from controller
  $attr_name['value'] = $item['name'];
  $attr_icon['value'] = $item['icon'];
  
  $selquality = $item['quality'];

  $attr_itemlevel['value'] = $item['itemlevel'];
  $attr_stack['value'] = $item['stack'];

  $seltype = $item['type'];
  $selsubtype = $item['subtype'];
  $selsubsubtype = $item['subsubtype'];

  $attr_sell_price['value'] = $item['sell_price'];
  $attr_buy_price['value'] = $item['buy_price'];
  $attr_text['value'] = $item['text'];

  $selsoulbound = $item['soulbound'];

  $selspell = $item['spell'];
  $selproc = $item['proc'];

  $attr_req_level['value'] = $item['req_level'];
  $attr_req_class['value'] = $item['req_class'];

  $attr_nomod_max_health['value'] = $item['nomod_max_health'];
  $attr_nomod_max_mana['value'] = $item['nomod_max_mana'];
  $attr_percent_max_health['value'] = $item['percent_max_health'];
  $attr_percent_max_mana['value'] = $item['percent_max_mana'];

  $attr_nomod_agility['value'] = $item['nomod_agility'];
  $attr_nomod_strength['value'] = $item['nomod_strength'];
  $attr_nomod_stamina['value'] = $item['nomod_stamina'];
  $attr_nomod_intellect['value'] = $item['nomod_intellect'];
  $attr_nomod_spirit['value'] = $item['nomod_spirit'];

  $attr_percent_agility['value'] = $item['percent_agility'];
  $attr_percent_strength['value'] = $item['percent_strength'];
  $attr_percent_stamina['value'] = $item['percent_stamina'];
  $attr_percent_intellect['value'] = $item['percent_intellect'];
  $attr_percent_spirit['value'] = $item['percent_spirit'];

  $attr_nomod_attackpower['value'] = $item['nomod_attackpower'];
  $attr_percent_attackpower['value'] = $item['percent_attackpower'];

  $attr_nomod_armor['value'] = $item['nomod_armor'];
  $attr_percent_armor['value'] = $item['percent_armor'];

  $attr_nomod_dodge['value'] = $item['nomod_dodge'];
  $attr_nomod_parry['value'] = $item['nomod_parry'];
  $attr_hit['value'] = $item['hit'];
  $attr_nomod_crit['value'] = $item['nomod_crit'];

  $attr_nomod_damage_min['value'] = $item['nomod_damage_min'];
  $attr_nomod_damage_max['value'] = $item['nomod_damage_max'];
  $attr_percent_damage_min['value'] = $item['percent_damage_min'];
  $attr_percent_damage_max['value'] = $item['percent_damage_max'];

  $attr_nomod_ranged_damage_min['value'] = $item['nomod_ranged_damage_min'];
  $attr_nomod_ranged_damage_max['value'] = $item['nomod_ranged_damage_max'];
  $attr_percent_ranged_damage_min['value'] = $item['percent_ranged_damage_min'];
  $attr_percent_ranged_damage_max['value'] = $item['percent_ranged_damage_max'];

  $attr_nomod_heal_min['value'] = $item['nomod_heal_min'];
  $attr_nomod_heal_max['value'] = $item['nomod_heal_max'];
  $attr_percent_heal_min['value'] = $item['percent_heal_min'];
  $attr_percent_heal_max['value'] = $item['percent_heal_max'];

  $attr_life_leech['value'] = $item['life_leech'];
  $attr_mana_leech['value'] = $item['mana_leech'];

  $attr_level_modifier['value'] = $item['level_modifier'];
  $attr_level_modifier_max['value'] = $item['level_modifier_max'];

  $attr_data1['value'] = $item['data1'];
  $attr_data2['value'] = $item['data2'];
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
Quality:
</div>
<div class="edit_input">
  <?=form_dropdown('quality', $opt_quality, $selquality, $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Itemlevel:
</div>
<div class="edit_input">
<?=form_input($attr_itemlevel); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Stack:
</div>
<div class="edit_input">
<?=form_input($attr_stack); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Type:
</div>
<div class="edit_input">
  <?=form_dropdown('type', $opt_type, $seltype, $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Subtype:
</div>
<div class="edit_input">
  <?=form_dropdown('subtype', $opt_subtype, $selsubtype, $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Subsubtype:
</div>
<div class="edit_input">
  <?=form_dropdown('subsubtype', $opt_subsubtype, $selsubsubtype, $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Sell Price:
</div>
<div class="edit_input">
<?=form_input($attr_sell_price); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Buy Price:
</div>
<div class="edit_input">
<?=form_input($attr_buy_price); ?>
</div>
</div>

<div class="row_edit_textbox">
<div class="edit_name">
Text:
</div>
<div class="edit_input">
<?=form_textarea($attr_text); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Soulbound:
</div>
<div class="edit_input">
  <?=form_dropdown('soulbound', $opt_soulbound, $selsoulbound, $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Spell:
</div>
<div class="edit_input">
  <?=form_dropdown('spell', $optspell, $selspell, $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Proc:
</div>
<div class="edit_input">
  <?=form_dropdown('proc', $optproc, $selproc, $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Req Level:
</div>
<div class="edit_input">
<?=form_input($attr_req_level); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Req Class:
</div>
<div class="edit_input">
  <?=form_dropdown('req_clas', $opt_req_class, $selreqclass, $attr_drop); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Nomod Max Health:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_max_health); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Nomod Max Mana:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_max_mana); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Percent Max Health:
</div>
<div class="edit_input">
<?=form_input($attr_percent_max_health); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Percent Max Mana:
</div>
<div class="edit_input">
<?=form_input($attr_percent_max_mana); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Nomod Agility:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_agility); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Nomod Strength:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_strength); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Nomod Stamina:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_stamina); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Nomod Intellect:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_intellect); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Nomod Spirit:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_spirit); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Percent Agility:
</div>
<div class="edit_input">
<?=form_input($attr_percent_agility); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Percent Strength:
</div>
<div class="edit_input">
<?=form_input($attr_percent_strength); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Percent Stamina:
</div>
<div class="edit_input">
<?=form_input($attr_percent_stamina); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Percent Intellect:
</div>
<div class="edit_input">
<?=form_input($attr_percent_intellect); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Percent Spirit:
</div>
<div class="edit_input">
<?=form_input($attr_percent_spirit); ?>
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

<div class="row_edit">
<div class="edit_name">
Percent Attackpower:
</div>
<div class="edit_input">
<?=form_input($attr_percent_attackpower); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Nomod Armor:
</div>
<div class="edit_input">
<?=form_input($attr_nomod_armor); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Percent Armor:
</div>
<div class="edit_input">
<?=form_input($attr_percent_armor); ?>
</div>
</div>

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
Percent Damage Min:
</div>
<div class="edit_input">
<?=form_input($attr_percent_damage_min); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Percent Damage Max:
</div>
<div class="edit_input">
<?=form_input($attr_percent_damage_max); ?>
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
Percent Ranged Damage Min:
</div>
<div class="edit_input">
<?=form_input($attr_percent_ranged_damage_min); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Percent Ranged Damage Max:
</div>
<div class="edit_input">
<?=form_input($attr_percent_ranged_damage_max); ?>
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

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Percent Heal Min:
</div>
<div class="edit_input">
<?=form_input($attr_percent_heal_min); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Percent Heal Max:
</div>
<div class="edit_input">
<?=form_input($attr_percent_heal_max); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Life Leech:
</div>
<div class="edit_input">
<?=form_input($attr_life_leech); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Mana Leech:
</div>
<div class="edit_input">
<?=form_input($attr_mana_leech); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Level Modifier:
</div>
<div class="edit_input">
<?=form_input($attr_level_modifier); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Level Modifier Max:
</div>
<div class="edit_input">
<?=form_input($attr_level_modifier_max); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
Data1:
</div>
<div class="edit_input">
<?=form_input($attr_data1); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Data2:
</div>
<div class="edit_input">
<?=form_input($attr_data2); ?>
</div>
</div>

<div class="edit_submit">
<?=form_submit($attr_submit); ?>
</div>
<?=form_close(); ?>