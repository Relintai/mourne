<?php
$this->load->helper('url');

$link_village = 'village/selected';
$link_map = 'village/map';
$link_units = 'village/units';
$link_log = 'village/log';
$link_events = 'village/events/';
?>
<div class="village_menu_container">
<div class="village_menu">
<div class="village_menuentry_first">
<a href="<?=site_url($link_village); ?>">Village</a> 
</div>
<div class="village_menuentry">
<a href="<?=site_url($link_map); ?>">Map</a> 
</div>
<div class="village_menuentry">
<a href="<?=site_url($link_units); ?>">Units</a> 
</div>
<div class="village_menuentry">
<a href="<?=site_url($link_log); ?>">Log</a> 
<?php if ($newlog): ?>
  (!)
<?php endif; ?>
</div>
<div class="village_menuentry">
<a href="<?=site_url($link_events); ?>">Events</a> 
</div>
</div>
</div>