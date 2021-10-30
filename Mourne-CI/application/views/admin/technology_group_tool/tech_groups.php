<?php
$this->load->helper('url');
$this->load->helper('form');

$link_form = 'admin/technology_group/' . $id;

$link_back = 'admin/technology_group_tool';

$name_add_drop = 'add';
$attr_add_drop = 'class="drop"';

$attr_add = array(
		'name' => 'submit',
		'value' => 'Add!',
		'class' => 'submit');

$attr_delete = array(
		'name' => 'submit',
		'value' => 'Delete!',
		'class' => 'submit');
?>
<div class="back">
<a href="<?=site_url($link_back); ?>"><-- Back</a>
</div>
<div class="action">
	Editing!
</div>
<?=validation_errors(); ?>
<?php if ($group): ?>
<?php foreach ($group as $row): ?>
	<?=form_open($link_form); ?>
	<?=form_hidden('action', 'delete'); ?>
	<?=form_hidden('id', $row['technologyid']); ?>
	<div class="row_edit">
		<div class="edit_name">
			[<?=$row['technologyid']; ?>] <?=$row['description']; ?> 
		</div>
		<div class="edit_input">
			<?=form_submit($attr_delete); ?>
		</div>
	</div>
	<?=form_close(); ?>
<?php endforeach; ?>
<?php endif; ?>

<div class="edit_spacer"></div>

<?=form_open($link_form); ?>
<div class="row_edit">
	<div class="edit_name">
		Add:
	</div>
	<div class="edit_input">
		<?=form_dropdown($name_add_drop, $opttech, $seltech, $attr_add_drop); ?> 
		<?=form_hidden('action', 'add'); ?>
		<?=form_submit($attr_add); ?><br />
	</div>
</div>
<?=form_close(); ?>
