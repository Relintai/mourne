<?php
$this->load->helper('url');

$link_edit = 'admin/technology_group/';

$link_edit_desc = 'admin/technology_group_desc/';
$link_new_desc = 'admin/technology_group_desc';

$link_back = 'admin/admin_panel';
?>
<div class="back">
	<a href="<?=site_url($link_back); ?>"><--- Back</a>
</div>
<div class="top_menu">
	<a href="<?=site_url($link_new_desc); ?>">Create New</a>
</div>
<div class="list_container">
	<?php $i = 1; ?>
<?php foreach ($groups as $row): ?>
	<?php $link = $link_edit . $row['id']; ?>
	<?php $link_desc = $link_edit_desc . $row['id']; ?>
	<?php if (!($i % 2)): ?>
		<div class="row">
	<?php else: ?>
		<div class="row second">
	<?php endif; ?>
		<div class="attr_box">
			[<?=$row['id']; ?>]
		</div>
		<div class="name">
			<?=$row['group_name']; ?>
		</div>
		<div class="actionbox">
			<a href="<?=site_url($link_desc); ?>">Edit Description</a>
			<a href="<?=site_url($link); ?>">Edit</a> 
		</div>
	</div>
	<?php $i++; ?>
<?php endforeach; ?>
</div>