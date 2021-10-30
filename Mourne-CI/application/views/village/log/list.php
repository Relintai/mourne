<?php
$this->load->helper('url');
$this->load->helper('date');

$link_log = 'village/log/view/';
$link_log_del = 'village/log/delete/';

$datestring = "%Y.%m.%d - %H:%i:%s";
?>
<div class="village_container">
<?php $i = 0; ?>
<?php foreach($logs as $row): ?>
<?php $link = $link_log . $row['id']; ?>
<?php $linkd = $link_log_del . $row['id']; ?>
<?php if ($i % 2): ?>
<div class="log_list">
<?php else: ?>
<div class="log_list log_list_first">
<?php endif; ?>
	<div class="log_list_new">
	<?php if ($row['new']): ?>
		New!
	<?php endif; ?>
	</div>
	<div class="log_list_attack">
		<a href="<?=site_url($link); ?>">Attack: <?=mdate($datestring, $row['time']); ?></a>
	</div>
	<div class="log_list_delete">
		<a href="<?=site_url($linkd); ?>">[x]</a>
	</div>
</div>
<?php $i++; ?>
<?php endforeach; ?>
</div>