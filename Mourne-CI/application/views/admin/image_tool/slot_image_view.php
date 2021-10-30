<?php
$this->load->helper('url');

$link_back = 'admin/slot_image';

$link = 'img/generated/gen.png';
?>
<div class="back">
<a href="<?=site_url($link_back); ?>"><-- Back</a>
</div>
<div class="action">
Image generated:
</div>
<img src="<?=base_url($link); ?>">