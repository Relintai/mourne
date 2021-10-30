<?php
$this->load->helper('url');

$link_back = 'village/log';
?>
<div class="back">
<a href="<?=site_url($link_back); ?>"><--- Back</a>
</div>
<?php if ($log): ?>
<div class="village_container">
<div class="log_data">
<?=$log['log']; ?>
</div>
</div>
<?php else: ?>
<div class="cannot">
Some error happened.
</div>
<?php endif; ?>