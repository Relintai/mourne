<?php 
$this->load->helper('url');

$link_stats = 'hero/selected/stats';
$link_inventory = 'hero/selected/inventory';
$link_talents = 'hero/selected/talents';
$link_spells = 'hero/selected/spells';
$link_actionbars = 'hero/selected/actionbars';
?>
<div class="hero_menu_container">
<div class="hero_menu">
<div class="hero_menuentry">
<a href="<?=site_url($link_stats); ?>">Stats</a> 
</div>
<div class="hero_menuentry">
<a href="<?=site_url($link_inventory); ?>">Inventory</a> 
</div>
<div class="hero_menuentry">
<a href="<?=site_url($link_talents); ?>">Talents</a> 
</div>
<div class="hero_menuentry">
<a href="<?=site_url($link_spells); ?>">Spells</a> 
</div>
<div class="hero_menuentry">
<a href="<?=site_url($link_actionbars); ?>">Actionbars</a> 
</div>
</div>
<div class="hero_menu_underline"></div>
</div>
