<?php //needs event_name_helper or maybe logic of what to display ?>
<?php
$this->load->helper('date');

$dstring = '%Y-%m-%d - %H:%i:%s';
?>
<?php if ($event): ?>
<div class="event_container">
	<div class="event">
		Type: <?=$event['type']; ?> Vid: <?=$event['villageid']; ?> D1: <?=$event['data1']; ?>
		Ends: <?=mdate($dstring, $event['end']); ?> Left: <?=timespan(time(), $event['end']); ?>
	</div>
</div>
<?php else: ?>
	<div class="event_container" style="display:none;">
	</div>
<?php endif; ?>
