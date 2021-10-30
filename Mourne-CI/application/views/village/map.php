<?php
$this->load->helper('url');
$this->load->helper('murl');
$this->load->helper('form');

$link_form = 'village/map';

$link_map = 'village/map/';

$attr_x = array(
	'name' => 'x',
	'maxlength' => '3',
	'size' => '1',
	'class' => 'input');

$attr_y = array(
	'name' => 'y',
	'maxlength' => '3',
	'size' => '1',
	'class' => 'input');

$attr_name = array(
	'name' => 'name',
	'class' => 'input');


$attr_submit = array(
	'name' => 'submit',
	'value' => 'Lookup!',
	'class' => 'submit');
?>
<div class="map_options">
	<div class="map_village">
		<a href="<?=site_url($link_map); ?>">Your Village</a>
	</div>
	<div class="map_s_xy">
		<?=form_open($link_form); ?>
		<?=form_hidden('action', 'xy'); ?>
		Lookup X: <?=form_input($attr_x); ?> 
		Y: <?=form_input($attr_y); ?>
		<?=form_submit($attr_submit); ?>
		<?=form_close(); ?>
	</div>
	<div class="map_s_name">
		<?=form_open($link_form); ?>
		<?=form_hidden('action', 'name'); ?>
		Name: <?=form_input($attr_name); ?>
		<?=form_submit($attr_submit); ?>
		<?=form_close(); ?>	
	</div>
</div>
<div class="map_nav">
	<div class="map_vertical">
		<?php $link = $link_map . $x . '/' . ($y - 3); ?>
		<a href="<?=site_url($link); ?>"><img src="<?=ibase_url('map/top.png'); ?>"></a>
	</div>
	<div class="map_center">
		<div class="map_horizontal">
			<?php $link = $link_map . ($x - 3) . '/' . $y; ?>
			<a href="<?=site_url($link); ?>"><img src="<?=ibase_url('map/left.png'); ?>"></a>
		</div>
		<div class="map">
			<?php $i = 1; ?>
				<?php foreach ($map as $row): ?>
				<div class="map_entry">
					<?php if ($row['type'] == 0): ?>
						<img src="<?=ibase_url('map/empty.png'); ?>" title="Empty"> 
					<?php elseif ($row['type'] == 1): ?>
						<img src="<?=ibase_url('map/rocks.png'); ?>" title="Rocks"> 
					<?php elseif ($row['type'] == 2): ?>
						<img src="<?=ibase_url('map/water.png'); ?>" 
						title="Water X: <?=$row['X']; ?> Y: <?=$row['Y']; ?>"> 
					<?php elseif ($row['type'] == 4): ?>
						<img src="<?=ibase_url('map/ai_village.png'); ?>" 
				title="<?=$row['ai_name']; ?> X: <?=$row['X']; ?> Y: <?=$row['Y']; ?>">
					<?php else: ?>
						<img src="<?=ibase_url('map/village.png'); ?>" 
					title="<?=$row['name']; ?> X: <?=$row['X']; ?> Y: <?=$row['Y']; ?>">
					<?php endif; ?>
				</div>
				<?php if (!($i % 12)): ?>
					<div class="nofloat"></div>
				<?php endif; ?>
				<?php $i++; ?>
		<?php endforeach; ?>
		</div>
		<div class="map_horizontal">
			<?php $link = $link_map . ($x + 3) . '/' . $y; ?>
			<a href="<?=site_url($link); ?>"><img src="<?=ibase_url('map/right.png'); ?>"></a>
		</div>
	</div>
	<div class="map_vertical">
		<?php $link = $link_map . $x . '/' . ($y + 3); ?>
		<a href="<?=site_url($link); ?>"><img src="<?=ibase_url('map/bottom.png'); ?>"></a>
	</div>
</div>