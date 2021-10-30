<?php
$this->load->helper('url');

$link_stats = 'building/stats/' . $slotid;
$link_create = 'building/create/' . $slotid;
$link_assignments = 'building/assign/' . $slotid;
$link_spells = 'building/spells/' . $slotid;
$link_research = 'building/research/' . $slotid;
$link_events = 'building/events/' . $slotid;
$link_upgrade = 'building/upgrade/' . $slotid;
?>
<div class="building_menu_container">
<div class="building_menu">
<div class="building_menuentry_first">
<a href="<?=site_url($link_stats); ?>">Stats</a> 
</div>
<div class="building_menuentry">
<a href="<?=site_url($link_create); ?>">Create</a> 
</div>
<div class="building_menuentry">
<a href="<?=site_url($link_assignments); ?>">Assignments</a> 
</div>
<div class="building_menuentry">
<a href="<?=site_url($link_spells); ?>">Spells</a> 
</div>
<div class="building_menuentry">
<a href="<?=site_url($link_research); ?>">Research</a> 
</div>
<div class="building_menuentry">
<a href="<?=site_url($link_events); ?>">Events</a> 
</div>
<div class="building_menuentry">
<a href="<?=site_url($link_upgrade); ?>">Uprade</a> 
</div>
</div>
</div>