<?php
$this->load->helper('url');
$this->load->helper('form');

$link_form = 'admin/technology_requirements/' . $id;

$link_back = 'admin/technology_requirements_tool';

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
	Editing: [<?=$technology['id']; ?>] <?=$technology['description']; ?>
</div>
<?=validation_errors(); ?>

<?php if ($required): ?>
<?php foreach ($required as $row): ?>
	<?=form_open($link_form); ?>
	<?=form_hidden('action', 'delete'); ?>
	<?=form_hidden('id', $row['id']); ?>
	<div class="row_edit">
		<div class="edit_name">
			[<?=$row['req_tech_id']; ?>] <?=$row['description']; ?> 
		</div>
		<div class="edit_input">
			<?=form_submit($attr_delete); ?>
		</div>
	</div>
	<?=form_close(); ?>
<?php endforeach; ?>
<?php endif; ?>
<br />
<?=form_open($link_form); ?>


<?=form_hidden('action', 'add'); ?>
<?=form_hidden('technologyid', $technology['id']); ?>
<div class="row_edit">
	<div class="edit_name">
		Add:
	</div>
        <div class="edit_input">
		<?=form_dropdown($name_add_drop, $opttech, $seltech, $attr_add_drop); ?> 
		<?=form_submit($attr_add); ?>
	</div>
</div>

<?=form_close(); ?>
