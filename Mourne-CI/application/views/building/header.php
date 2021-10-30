<?php 
$this->load->helper('murl'); 
$this->load->helper('url');

$link_back = 'village/selected';
?>
<div class="building_header_container">
<div class="building_header">
<div class="building_header_back">
<a href="<?=site_url($link_back); ?>"><-- <?=$building['name']; ?> (Rank: <?=$building['rank']; ?>)</a>
</div>
</div>
</div>