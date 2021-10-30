<?php 
$this->load->helper('url');

$link_quest = 'hero/quest';
$link_hero = 'hero/selected';
$link_village = 'hero/village';
$link_settings = 'hero/settings';
$link_select = 'hero/select';

switch ($this->hero['class'])
{
  case 1:
    $class = 'warrior';
    break;
  case 2:
    $class = 'rogue';
    break;
  case 3:
    $class = 'archer';
    break;
  default:
    $class = '';
    break;
}

?>
<div class="hero_base_menu_container <?=$class; ?>">
<div class="hero_base_menu">
<div class="hero_base_menuentry_first">
<a href="<?=site_url($link_quest); ?>">Quest</a> 
</div>
<div class="hero_base_menuentry">
<a href="<?=site_url($link_hero); ?>"><?=$hero['name']; ?></a> 
</div>
<div class="hero_base_menuentry">
<a href="<?=site_url($link_village); ?>">Village</a> 
</div>
<div class="hero_base_menuentry">
<a href="<?=site_url($link_settings); ?>">Settings</a> 
</div>
<div class="hero_base_menuentry">
<a href="<?=site_url($link_select); ?>">Select</a> 
</div>
</div>
</div>