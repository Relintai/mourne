<?php
$this->load->helper('url');

$link_edit = 'admin/assignment/';
$link_new = 'admin/assignment';
$link_back = 'admin/admin_panel';
?>
<div class="back">
	<a href="<?=site_url($link_back); ?>"><--- Back</a>
</div>
<div class="top_menu">
	<a href="<?=site_url($link_new); ?>">Create New</a>
</div>
<div class="list_container">
	<?php $i = 1; ?>
<?php foreach ($assignments as $row): ?>
	<?php $link = $link_edit . $row['id']; ?>
	<?php if (!($i % 2)): ?>
		<div class="row">
	<?php else: ?>
		<div class="row second">
	<?php endif; ?>
		<div class="attr_box">
			[<?=$row['id']; ?>]
		</div>
		<div class="attr_box">
			[U: <?=$row['unitid']; ?>]
		</div>
		<div class="attr_box">
			[M: <?=$row['max']; ?>]
		</div>
		<div class="name">
			<?=$row['description']; ?>
		</div>
		<div class="actionbox">
			<a href="<?=site_url($link); ?>">Edit</a>
		</div>
	</div>
	<?php $i++; ?>
<?php endforeach; ?>
</div>