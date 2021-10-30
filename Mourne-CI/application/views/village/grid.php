<?php
$this->load->helper('url');
$this->load->helper('murl');

$link_build = 'building/build/';
$link_upgrade = 'building/stats/';
?>
<div class="village_grid">
<?php $i = 1; ?>
<div class="grid_row">
<?php foreach ($buildings as $row): ?>
	<?php if (isset($row['buildingid'])): ?>
		<?php $link = $link_upgrade . $i ?>
	<?php else: ?>
		<?php $link = $link_build . $i ?>
	<?php endif; ?>
	<div class="grid_entry">
	<a href="<?=site_url($link); ?>">
	<img src="<?=ibase_url('buildings/' . $row['icon']); ?>" alt="<?=$row['name']; ?>">
	</a>
	</div>
	<?php if ($i % 19 == 0 && $i != 209): ?>
		<div class="nofloat"></div>
	</div>
	<div class="grid_row">
	<?php endif; ?>
	<?php $i++; ?>
<?php endforeach; ?>
</div>