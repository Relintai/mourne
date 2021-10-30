<?php
$this->load->helper('url');

$link_new = 'admin/sql_new';
$link_apply_all = 'admin/sql_apply_all';

$link_back = 'admin/admin_panel';
?>
<div class="back">
	<a href="<?=site_url($link_back); ?>"><--- Back</a>
</div>
<div class="top_menu">
	<a href="<?=site_url($link_new); ?>">New SQL</a> 
	<a href="<?=site_url($link_apply_all); ?>">Apply all SQL</a>
</div>
<div class="list_container">

<?php if ($list): ?>
	<div class="top_menu">
		Appliable sqls:
	</div>
	<?php $i = 1; ?>
	<?php foreach($list as $row): ?>
		<?php if (!($i % 2)): ?>
			<div class="row">
		<?php else: ?>
			<div class="row second">
		<?php endif; ?>
		<div class="name">
			<?=$row; ?>
		</div>
		</div>
		<?php $i++; ?>
	<?php endforeach; ?>
<?php else: ?>
<div class="top_menu">
	Nothing to apply.
</div>
<?php endif; ?>
</div>