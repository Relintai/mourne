<?php
$this->load->helper('date');

$dstring = '%Y-%m-%d - %H:%i:%s';
?>
<?php if ($event): ?>
<div class="building_container">
	<div class="event_data">
		<?php $i = 0; ?>
		<?php foreach ($event as $row): ?>
		<?php if ($i % 2): ?>
		<div class="event">
		<?php else: ?>
		<div class="event event_first">
		<?php endif; ?>
			<?php $left = $row['end'] - time(); ?>
			Type: <?=$row['type']; ?> Vid: <?=$row['villageid']; ?> D1: <?=$row['data1']; ?>
			D2: <?=$row['data2']; ?> Ends: <?=mdate($dstring, $row['end']); ?> 
			Left: <?=timespan(time(), $row['end']); ?><br />
		</div>
		<?php $i++; ?>
		<?php endforeach; ?>
	</div>
</div>
<?php else: ?>
	<div class="building_container">
	</div>
<?php endif; ?>
