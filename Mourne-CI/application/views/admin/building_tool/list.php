<?php
$this->load->helper('url');

$link_edit = 'admin/building/';
$link_new = 'admin/building';
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
<?php foreach ($buildings as $row): ?>
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
			[Rank: <?=$row['rank']; ?>]
		</div>
		<div class="attr_box">
			[N Rank: <?=$row['next_rank']; ?>] 
		</div>
		<div class="name">
			<?=$row['name']; ?>
		</div>
		<div class="actionbox">
			<a href="<?=site_url($link); ?>">Edit</a>
		</div>
	</div>
	<?php $i++; ?>
<?php endforeach; ?>
</div>
