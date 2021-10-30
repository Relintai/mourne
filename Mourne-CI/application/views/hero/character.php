<?php
$this->load->helper('equipment');
$this->load->helper('murl');
$this->load->helper('class');
$this->load->helper('url');

if (($d1 !== FALSE) && ($d2 !== FALSE))
  $link_sel = 'hero/selected/inventory/' . $d1 .  '/' . $d2 . '/';
else
  $link_sel = 'hero/selected/inventory/';
?>
<div class="equipment_box">
<div class="left">
  <a href="<?=site_url($link_sel . 'eq/0'); ?>">
  <div class="equipment_entry <?=qc($equipment, 0); ?> <?=ss($d1, $d2, 'eq', 0); ?>">
    <?php if ($equipment[0]): ?>
      <img src="<?=ibase_url('hero/inventory/' . $equipment[0]['icon']); ?>" title="Head">
    <?php else: ?>
      <img src="<?=ibase_url('hero/inv_base/head.png'); ?>" title="Head">
    <?php endif; ?>
  </div>
  </a>
  <a href="<?=site_url($link_sel . 'eq/1'); ?>">
  <div class="equipment_entry <?=qc($equipment, 1); ?> <?=ss($d1, $d2, 'eq', 1); ?>">
    <?php if ($equipment[1]): ?>
      <img src="<?=ibase_url('hero/inventory/' . $equipment[1]['icon']); ?>" title="Neck">
    <?php else: ?>
      <img src="<?=ibase_url('hero/inv_base/neck.png'); ?>" title="Neck">
    <?php endif; ?>
  </div>
  </a>
  <a href="<?=site_url($link_sel . 'eq/2'); ?>">
  <div class="equipment_entry <?=qc($equipment, 2); ?> <?=ss($d1, $d2, 'eq', 2); ?>">
    <?php if ($equipment[2]): ?>
      <img src="<?=ibase_url('hero/inventory/' . $equipment[2]['icon']); ?>" title="Shoulders">
    <?php else: ?>
      <img src="<?=ibase_url('hero/inv_base/shoulders.png'); ?>" title="Shoulders">
    <?php endif; ?>
  </div>
  </a>
  <a href="<?=site_url($link_sel . 'eq/3'); ?>">
  <div class="equipment_entry <?=qc($equipment, 3); ?> <?=ss($d1, $d2, 'eq', 3); ?>">
    <?php if ($equipment[3]): ?>
      <img src="<?=ibase_url('hero/inventory/' . $equipment[3]['icon']); ?>" title="Back">
    <?php else: ?>
      <img src="<?=ibase_url('hero/inv_base/back.png'); ?>" title="Back">
    <?php endif; ?>
  </div>
  </a>
  <a href="<?=site_url($link_sel . 'eq/4'); ?>">
  <div class="equipment_entry <?=qc($equipment, 4); ?> <?=ss($d1, $d2, 'eq', 4); ?>">
    <?php if ($equipment[4]): ?>
      <img src="<?=ibase_url('hero/inventory/' . $equipment[4]['icon']); ?>" title="Chest">
    <?php else: ?>
      <img src="<?=ibase_url('hero/inv_base/chest.png'); ?>" title="Chest">
    <?php endif; ?>
  </div>
  </a>
  <a href="<?=site_url($link_sel . 'eq/5'); ?>">
  <div class="equipment_entry <?=qc($equipment, 5); ?> <?=ss($d1, $d2, 'eq', 5); ?>">
    <?php if ($equipment[5]): ?>
      <img src="<?=ibase_url('hero/inventory/' . $equipment[5]['icon']); ?>" title="Shirt">
    <?php else: ?>
      <img src="<?=ibase_url('hero/inv_base/shirt.png'); ?>" title="Shirt">
    <?php endif; ?>
  </div>
  </a>
  <a href="<?=site_url($link_sel . 'eq/6'); ?>">
  <div class="equipment_entry <?=qc($equipment, 6); ?> <?=ss($d1, $d2, 'eq', 6); ?>">
    <?php if ($equipment[6]): ?>
      <img src="<?=ibase_url('hero/inventory/' . $equipment[6]['icon']); ?>" title="Tabard">
    <?php else: ?>
      <img src="<?=ibase_url('hero/inv_base/tabard.png'); ?>" title="Tabard">
    <?php endif; ?>
  </div>
  </a>
  <a href="<?=site_url($link_sel . 'eq/7'); ?>">
  <div class="equipment_entry <?=qc($equipment, 7); ?> <?=ss($d1, $d2, 'eq', 7); ?>">
    <?php if ($equipment[7]): ?>
      <img src="<?=ibase_url('hero/inventory/' . $equipment[7]['icon']); ?>" title="Bracers">
    <?php else: ?>
      <img src="<?=ibase_url('hero/inv_base/bracers.png'); ?>" title="Bracers">
    <?php endif; ?>
  </div>
  </a>
</div>
<div class="left">
  <div class="equipment_entry_head_box rowf">
    <div class="left">
      <div class="eq_name_box rowf">
        <?=$hero['name']; ?>
      </div>
      <div class="eq_info_box rowf">
        Level <?=$hero['level']; ?> <?=class_name($hero['class']); ?>
      </div>
      <div class="eq_st_box info_slider_health">
        <?=$hero['max_health']; ?>
      </div>
      <div class="eq_st_box info_slider_mana">
        <?=$hero['max_mana']; ?>
      </div>
    </div>
    <div class="right">
     <img src="<?=ibase_url($hero['avatar']); ?>">
    </div>
  </div>
  <div class="eq_base_stat_box rowf">
    <div class="left">
      <div class="eq_base_stat_stat rowf">
        <div class="left">
          Agi:
        </div>
        <div class="right">
          <?=$hero['agility']; ?>
        </div>
      </div>
      <div class="eq_base_stat_stat rows">
        <div class="left">
          Str:
        </div>
        <div class="right">
          <?=$hero['strength']; ?>
        </div>
      </div>
      <div class="eq_base_stat_stat rowf">
        <div class="left">
          Sta:
        </div>
        <div class="right">
          <?=$hero['stamina']; ?>
        </div>
      </div>
      <div class="eq_base_stat_stat rows">
        <div class="left">
          Int:
        </div>
        <div class="right">
          <?=$hero['intellect']; ?>
        </div>
      </div>
      <div class="eq_base_stat_stat rowf">
        <div class="left">
          Spi:
        </div>
        <div class="right">
          <?=$hero['spirit']; ?>
        </div>
      </div>
    </div>
    <div class="right">
      <div class="eq_base_stat_stat rowf">
        <div class="left">
          Ap:
        </div>
        <div class="right">
          <?=$hero['attackpower']; ?>
        </div>
      </div>
      <div class="eq_base_stat_stat rows">
        <div class="left">
          Dodge:
        </div>
        <div class="right">
          <?=floor(($hero['dodge'] * 100) / 100); ?>%
        </div>
      </div>
      <div class="eq_base_stat_stat rowf">
        <div class="left">
          Parry:
        </div>
        <div class="right">
          <?=floor(($hero['parry'] * 100) / 100); ?>%
        </div>
      </div>
      <div class="eq_base_stat_stat rows">
        <div class="left">
          Hit:
        </div>
        <div class="right">
          <?=$hero['hit']; ?>%
        </div>
      </div>
      <div class="eq_base_stat_stat rowf">
        <div class="left">
          Crit:
        </div>
        <div class="right">
          <?=floor(($hero['crit'] * 100) / 100); ?>%
        </div>
      </div>
    </div>
  </div>
  <div class="eq_other_stat_box rowf">
    <div class="eq_other_stat_stat rowf">
      <div class="left">
        Armor:
      </div>
      <div class="right">
        <?=$hero['armor']; ?>
      </div>
    </div>
    <div class="eq_other_stat_stat rows">
      <div class="left">
        Damage Min:
      </div>
      <div class="right">
        <?=$hero['damage_min']; ?>
      </div>
    </div>
    <div class="eq_other_stat_stat rowf">
      <div class="left">
        Damage Max:
      </div>
      <div class="right">
        <?=$hero['damage_max']; ?>
      </div>
    </div>
    <div class="eq_other_stat_stat rows">
      <div class="left">
        Ranged Damage Min:
      </div>
      <div class="right">
        <?=$hero['ranged_damage_min']; ?>
      </div>
    </div>
    <div class="eq_other_stat_stat rowf">
      <div class="left">
        Ranged Damage Max:
      </div>
      <div class="right">
        <?=$hero['ranged_damage_max']; ?>
      </div>
    </div>
    <div class="eq_other_stat_stat rows">
      <div class="left">
        Heal Min:
      </div>
      <div class="right">
        <?=$hero['heal_min']; ?>
      </div>
    </div>
    <div class="eq_other_stat_stat rowf">
      <div class="left">
        Life Leech:
      </div>
      <div class="right">
        <?=$hero['life_leech']; ?>%
      </div>
    </div>
    <div class="eq_other_stat_stat rows">
      <div class="left">
        Mana Leech:
      </div>
      <div class="right">
        <?=$hero['mana_leech']; ?>%
      </div>
    </div>
  </div>
  <div class="eq_bspc"></div>
  <div class="left">
    <a href="<?=site_url($link_sel . 'eq/16'); ?>">
    <div class="equipment_entry <?=qc($equipment, 16); ?> <?=ss($d1, $d2, 'eq', 16); ?>">
      <?php if ($equipment[16]): ?>
        <img src="<?=ibase_url('hero/inventory/' . $equipment[16]['icon']); ?>" title="Main Hand">
      <?php else: ?>
        <img src="<?=ibase_url('hero/inv_base/main_hand.png'); ?>" title="Main Hand">
      <?php endif; ?>
    </div>
    </a>
  </div>
  <div class="left">
    <a href="<?=site_url($link_sel . 'eq/17'); ?>">
    <div class="equipment_entry <?=qc($equipment, 17); ?> <?=ss($d1, $d2, 'eq', 17); ?>">
      <?php if ($equipment[17]): ?>
        <img src="<?=ibase_url('hero/inventory/' . $equipment[17]['icon']); ?>" title="Off Hand">
      <?php else: ?>
        <img src="<?=ibase_url('hero/inv_base/off_hand.png'); ?>" title="Off Hand">
      <?php endif; ?>
    </div>
    </a>
  </div>
  <div class="left">
    <a href="<?=site_url($link_sel . 'eq/18'); ?>">
    <div class="equipment_entry <?=qc($equipment, 18); ?> <?=ss($d1, $d2, 'eq', 18); ?>">
      <?php if ($equipment[18]): ?>
        <img src="<?=ibase_url('hero/inventory/' . $equipment[18]['icon']); ?>" title="Ranged">
      <?php else: ?>
        <img src="<?=ibase_url('hero/inv_base/ranged.png'); ?>" title="Ranged">
      <?php endif; ?>
    </div>
    </a>
  </div>
  <div class="left">
    <a href="<?=site_url($link_sel . 'eq/19'); ?>">
    <div class="equipment_entry <?=qc($equipment, 19); ?> <?=ss($d1, $d2, 'eq', 19); ?>">
      <?php if ($equipment[19]): ?>
        <img src="<?=ibase_url('hero/inventory/' . $equipment[19]['icon']); ?>" title="Ammo">
      <?php else: ?>
        <img src="<?=ibase_url('hero/inv_base/ammo.png'); ?>" title="Ammo">
      <?php endif; ?>
    </div>
    </a>
  </div>
</div>
<div class="right">
  <a href="<?=site_url($link_sel . 'eq/8'); ?>">
  <div class="equipment_entry <?=qc($equipment, 8); ?> <?=ss($d1, $d2, 'eq', 8); ?>">
    <?php if ($equipment[8]): ?>
      <img src="<?=ibase_url('hero/inventory/' . $equipment[8]['icon']); ?>" title="Gloves">
    <?php else: ?>
      <img src="<?=ibase_url('hero/inv_base/gloves.png'); ?>" title="Gloves">
    <?php endif; ?>
  </div>
  </a>
  <a href="<?=site_url($link_sel . 'eq/9'); ?>">
  <div class="equipment_entry <?=qc($equipment, 9); ?> <?=ss($d1, $d2, 'eq', 9); ?>">
    <?php if ($equipment[9]): ?>
      <img src="<?=ibase_url('hero/inventory/' . $equipment[9]['icon']); ?>" title="Belt">
    <?php else: ?>
      <img src="<?=ibase_url('hero/inv_base/belt.png'); ?>" title="Belt">
    <?php endif; ?>
  </div>
  </a>
  <a href="<?=site_url($link_sel . 'eq/10'); ?>">
  <div class="equipment_entry <?=qc($equipment, 10); ?> <?=ss($d1, $d2, 'eq', 10); ?>">
    <?php if ($equipment[10]): ?>
      <img src="<?=ibase_url('hero/inventory/' . $equipment[10]['icon']); ?>" title="Legs">
    <?php else: ?>
      <img src="<?=ibase_url('hero/inv_base/legs.png'); ?>" title="Legs">
    <?php endif; ?>
  </div>
  </a>
  <a href="<?=site_url($link_sel . 'eq/11'); ?>">
  <div class="equipment_entry <?=qc($equipment, 11); ?> <?=ss($d1, $d2, 'eq', 11); ?>">
    <?php if ($equipment[11]): ?>
      <img src="<?=ibase_url('hero/inventory/' . $equipment[11]['icon']); ?>" title="Foots">
    <?php else: ?>
      <img src="<?=ibase_url('hero/inv_base/foots.png'); ?>" title="Foots">
    <?php endif; ?>
  </div>
  </a>
  <a href="<?=site_url($link_sel . 'eq/12'); ?>">
  <div class="equipment_entry <?=qc($equipment, 12); ?> <?=ss($d1, $d2, 'eq', 12); ?>">
    <?php if ($equipment[12]): ?>
      <img src="<?=ibase_url('hero/inventory/' . $equipment[12]['icon']); ?>" title="Ring">
    <?php else: ?>
      <img src="<?=ibase_url('hero/inv_base/ring.png'); ?>" title="Ring">
    <?php endif; ?>
  </div>
  </a>
  <a href="<?=site_url($link_sel . 'eq/13'); ?>">
  <div class="equipment_entry <?=qc($equipment, 13); ?> <?=ss($d1, $d2, 'eq', 13); ?>">
    <?php if ($equipment[13]): ?>
      <img src="<?=ibase_url('hero/inventory/' . $equipment[13]['icon']); ?>" title="Ring">
    <?php else: ?>
      <img src="<?=ibase_url('hero/inv_base/ring.png'); ?>" title="Ring">
    <?php endif; ?>
  </div>
  </a>
  <a href="<?=site_url($link_sel . 'eq/14'); ?>">
  <div class="equipment_entry <?=qc($equipment, 14); ?> <?=ss($d1, $d2, 'eq', 14); ?>">
    <?php if ($equipment[14]): ?>
      <img src="<?=ibase_url('hero/inventory/' . $equipment[14]['icon']); ?>" title="Trinket">
    <?php else: ?>
      <img src="<?=ibase_url('hero/inv_base/trinket.png'); ?>" title="Trinket">
    <?php endif; ?>
  </div>
  </a>
  <a href="<?=site_url($link_sel . 'eq/15'); ?>">
  <div class="equipment_entry <?=qc($equipment, 15); ?> <?=ss($d1, $d2, 'eq', 15); ?>">
    <?php if ($equipment[15]): ?>
      <img src="<?=ibase_url('hero/inventory/' . $equipment[15]['icon']); ?>" title="Trinket">
    <?php else: ?>
      <img src="<?=ibase_url('hero/inv_base/trinket.png'); ?>" title="Trinket">
    <?php endif; ?>
  </div>
  </a>
</div>
</div>