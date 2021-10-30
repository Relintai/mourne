<?php
$this->load->helper('form');
$this->load->helper('url');

$link_settings_form = 'village/settings/';
$link_select_form = 'village/select';

$attr_settings = array(
  'name' => 'submit',
  'value' => 'Settings',
  'class' => 'submit');

$attr_select = array(
  'name' => 'submit',
  'value' => 'Select',
  'class' => 'submit');
?>

<div class="village_container">
<?php $i = 1; ?>
<?php foreach ($villages as $row): ?>
	<?php if ($i % 2): ?>
	<div class="village_row first_village_row">
	<?php else: ?>
	<div class="village_row">
	<?php endif; ?>
	<div class="village_name">
		<?=$row['name']; ?>
	</div>
	<div class="village_score">
		Score: <?=$row['score']; ?>
	</div>
	<?php if (!$row['selected']): ?>
	<div class="village_action">
	<?=form_open($link_select_form); ?>
	<?=form_hidden('id', $row['id']); ?>
	<?=form_submit($attr_select); ?>
	<?=form_close(); ?>
	</div>
	<?php else: ?>
	<div class="village_action">
		selected
	</div>
	<?php endif; ?>
	<div class="village_action">
	<?php $link= $link_settings_form . $row['id']; ?>
	<a href="<?=site_url($link); ?>">Settings</a>
	</div>
	</div>
	<?php $i++; ?>
<?php endforeach; ?>
</div>