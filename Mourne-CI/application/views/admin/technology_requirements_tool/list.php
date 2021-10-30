<?php
$this->load->helper('url');

$link_edit = 'admin/technology_requirements/';
$link_add_tech = 'admin/have_technology_requirement';
$link_remove = 'admin/have_technology_requirement/';

$link_back = 'admin/admin_panel';
?>
<div class="back">
	<a href="<?=site_url($link_back); ?>"><--- Back</a>
</div>
<div class="top_menu">
	<a href="<?=site_url($link_add_tech); ?>">Add technology</a>
</div>
<div class="list_container">
<?php $i = 1; ?>
<?php foreach ($technologies as $row): ?>
	<?php $link = $link_edit . $row['id']; ?>
	<?php $rlink = $link_remove . $row['id']; ?>
	<?php if (!($i % 2)): ?>
		<div class="row">
	<?php else: ?>
		<div class="row second">
	<?php endif; ?>
		<div class="attr_box">
			[<?=$row['technologyid']; ?>]
		</div>
		<div class="name">
			<?=$row['description']; ?> (<?=$row['comment']; ?>)
		</div>
		<div class="actionbox">
			<a href="<?=site_url($rlink); ?>">Remove from list</a> 
			<a href="<?=site_url($link); ?>">Edit Requirements</a>
		</div>
	</div>
	<?php $i++; ?>
<?php endforeach; ?>
</div>