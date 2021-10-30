<?php
$this->load->helper('form');
//$this->load->helper('url');
$this->load->helper('class');
$this->load->helper('murl');

$link_form = 'hero/addstat';

$attr_add_submit = array(
  'name' => 'submit',
  'value' => 'Add!',
  'class' => 'submit');

?>
<div class="hero_container">
<div class="stats_base">
<div class="left">
  <div class="info_base">
    <?=$hero['name']; ?> 
    [Level <?=$hero['level']; ?>] 
    <?=gender($hero['gender']); ?> 
    <?=class_name($hero['class']); ?> 
  </div>
  <?php if ($hero['health'] > 0): ?>
  <div class="info_slider">
    <div class="info_slider_health" style="width:<?=$hpp; ?>%">
    </div>
    <div class="info_slider_text">
      <?=$hero['max_health']; ?>/<?=$hero['health']; ?>
    </div>
  </div>
  <div class="info_slider">
    <div class="info_slider_mana" style="width:<?=$mpp; ?>%">
    </div>
    <div class="info_slider_text">
      <?=$hero['max_mana']; ?>/<?=$hero['mana']; ?>
    </div>
  </div>
  <div class="info_slider">
    <div class="info_slider_experience" style="width:<?=$exp; ?>%">
    </div>
    <div class="info_slider_text">
       <?=$experience; ?>/<?=$hero['experience']; ?>
    </div>
  </div>
  <?php else: ?>
  <div class="info_slider">
    <div class="info_slider_health" style="width:0%">
    </div>
    <div class="info_slider_text">
      Dead
    </div>
  </div>
  <div class="info_slider">
  </div>
  <div class="info_slider">
    <div class="info_slider_experience" style="width:<?=$exp; ?>%">
    </div>
    <div class="info_slider_text">
       <?=$experience; ?>/<?=$hero['experience']; ?>
    </div>
  </div>
  <?php endif; ?>
</div>
<div class="right">
  <img src="<?=ibase_url($hero['avatar']); ?>">
</div>
</div>
<div class="stats_stats">

  <div class="stats_stats_row rowf">
    <div class="info_stat">
      Agility: <?=$hero['agility']; ?> 
      <abbr title="Points Used">(<?=$hero['points_agility']; ?>)</abbr>
    </div>
    <div class="info_stat_desc">
      Increases your critical chance, attackpower, dodge.
    </div>
    <div class="info_stat_add">
      <?php if ($hero['points']): ?>
        <?=form_open($link_form); ?>
        <?=form_hidden('attrid', 1); ?>
        <?=form_submit($attr_add_submit); ?>
        <?=form_close(); ?>
      <?php else: ?>
        No Points
      <?php endif; ?>
    </div>
  </div>

  <div class="stats_stats_row rows">
    <div class="info_stat">
      Strength: <?=$hero['strength']; ?> 
      <abbr title="Points Used">(<?=$hero['points_strength']; ?>)</abbr>
    </div>
    <div class="info_stat_desc">
      Increases your critical chance, attackpower, parry chance.
    </div>
    <div class="info_stat_add">
      <?php if ($hero['points']): ?>
        <?=form_open($link_form); ?>
        <?=form_hidden('attrid', 2); ?>
        <?=form_submit($attr_add_submit); ?>
        <?=form_close(); ?>
      <?php else: ?>
        No Points
      <?php endif; ?>
    </div>
  </div>
  <div class="stats_stats_row rowf">
    <div class="info_stat">
      Stamina: <?=$hero['stamina']; ?> 
      <abbr title="Points Used">(<?=$hero['points_stamina']; ?>)</abbr>
    </div>
    <div class="info_stat_desc">
      Increases your maximum health.
    </div>
    <div class="info_stat_add">
      <?php if ($hero['points']): ?>
        <?=form_open($link_form); ?>
        <?=form_hidden('attrid', 3); ?>
        <?=form_submit($attr_add_submit); ?>
        <?=form_close(); ?>
      <?php else: ?>
        No Points
      <?php endif; ?>
    </div>
  </div>
  <div class="stats_stats_row rows">
    <div class="info_stat">
      Intellect: <?=$hero['intellect']; ?> 
      <abbr title="Points Used">(<?=$hero['points_intellect']; ?>)</abbr>
    </div>
    <div class="info_stat_desc">
      Increases your maximum mana, critical chance.
    </div>
    <div class="info_stat_add">
      <?php if ($hero['points']): ?>
        <?=form_open($link_form); ?>
        <?=form_hidden('attrid', 4); ?>
        <?=form_submit($attr_add_submit); ?>
        <?=form_close(); ?>
      <?php else: ?>
        No Points
      <?php endif; ?>
    </div>
  </div>
  <div class="stats_stats_row rowf">
    <div class="info_stat">
      Spirit: <?=$hero['spirit']; ?> 
      <abbr title="Points Used">(<?=$hero['points_spirit']; ?>)</abbr>
    </div>
    <div class="info_stat_desc">
      Increases your in combat regeneration.
    </div>
    <div class="info_stat_add">
      <?php if ($hero['points']): ?>
        <?=form_open($link_form); ?>
        <?=form_hidden('attrid', 5); ?>
        <?=form_submit($attr_add_submit); ?>
        <?=form_close(); ?>
      <?php else: ?>
        No Points
      <?php endif; ?>
    </div>
  </div>
  <div class="stats_stats_row rows">
    <div class="info_stat_points">
      Stat Points: <?=$hero['points']; ?>
    </div>
  </div>
</div>
<div class="stats_other">
<div class="left">
  <div class="stats_other_box">
    <div class="stats_other_row rowf">
      <div class="stats_other_name">
        Attackpower:
      </div>
      <div class="stats_other_value">
        <?=$hero['attackpower']; ?>
      </div>
    </div>
    <div class="stats_other_row rows">
      <div class="stats_other_name">
        Dodge:
      </div>
      <div class="stats_other_value">
       <?=(floor($hero['dodge'] * 100) / 100); ?>%
      </div>
    </div>
    <div class="stats_other_row rowf">
      <div class="stats_other_name">
        Parry: 
      </div>
      <div class="stats_other_value">
       <?=(floor($hero['parry'] * 100) / 100); ?>%
      </div>
    </div>
    <div class="stats_other_row rows">
      <div class="stats_other_name">
        Hit:
      </div>
      <div class="stats_other_value">
       <?=(floor($hero['hit'] * 100) / 100); ?>%
      </div>
    </div>
    <div class="stats_other_row rowf">
      <div class="stats_other_name">
        Crit:
      </div>
      <div class="stats_other_value">
       <?=(floor($hero['crit'] * 100) / 100); ?>%
      </div>
    </div>
    <div class="stats_other_row rows">
      <div class="stats_other_name">
        Armor:
      </div>
      <div class="stats_other_value">
        <?=$hero['armor']; ?>
      </div>
    </div>
    <div class="stats_other_row rowf">
      <div class="stats_other_name">
        Mana Leech:
      </div>
      <div class="stats_other_value">
        <?=$hero['mana_leech']; ?>%
      </div>
    </div>
  </div>
</div>
<div class="right">
  <div class="stats_other_box">
    <div class="stats_other_row rowf">
      <div class="stats_other_name">
        Damage Min:
      </div>
      <div class="stats_other_value">
        <?=$hero['damage_min']; ?>
      </div>
    </div>
    <div class="stats_other_row rows">
      <div class="stats_other_name">
        Damage Max:
      </div>
      <div class="stats_other_value">
        <?=$hero['damage_max']; ?>
      </div>
    </div>
    <div class="stats_other_row rowf">
      <div class="stats_other_name">
        Ranged Damage Min:
      </div>
      <div class="stats_other_value">
        <?=$hero['ranged_damage_min']; ?>
      </div>
    </div>
    <div class="stats_other_row rows">
      <div class="stats_other_name">
        Ranged Damage Max:
      </div>
      <div class="stats_other_value">
        <?=$hero['ranged_damage_max']; ?>
      </div>
    </div>
    <div class="stats_other_row rowf">
      <div class="stats_other_name">
        Heal Min:
      </div>
      <div class="stats_other_value">
        <?=$hero['heal_min']; ?>
      </div>
    </div>
    <div class="stats_other_row rows">
      <div class="stats_other_name">
        Heal Max:
      </div>
      <div class="stats_other_value">
        <?=$hero['heal_max']; ?>
      </div>
    </div>
    <div class="stats_other_row rowf">
      <div class="stats_other_name">
        Life Leech:
      </div>
      <div class="stats_other_value">
        <?=$hero['life_leech']; ?>%
      </div>
    </div>



  </div>
</div>
</div>
</div>