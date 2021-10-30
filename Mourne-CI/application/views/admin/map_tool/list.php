<?php
$this->load->helper('url');
$this->load->helper('form');

$link_generate = 'admin/map_generator';
$link_form = 'admin/map_tool';

$link_back = 'admin/admin_panel';

$attr_apply = array(
	'name' => 'submit',
	'value' => 'Apply!',
	'class' => 'submit');
?>
<div class="back">
	<a href="<?=site_url($link_back); ?>"><--- Back</a>
</div>
<div class="top_menu">
	<a href="<?=site_url($link_generate); ?>">Generate New</a>
</div>
<div class="list_container">
<?php if ($files): ?>
<?php $i = 1; ?>
<?php foreach ($files as $row): ?>
	<?php if (!($i % 2)): ?>
		<div class="row">
	<?php else: ?>
		<div class="row second">
	<?php endif; ?>
		<div class="name">
			<?=$row; ?>
		</div>
		<div class="actionbox">
			Apply will not wrok from here.
		</div>
	</div>

	<?php $i++; ?>
<?php endforeach; ?>
<?php endif; ?>
</div>