<?php
$this->load->helper('url');
$this->load->helper('form');

$link_form = 'admin/hero_inventory_templates/' . $id;

$link_back = 'admin/hero_inventory_template_tool';

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
	Editing: [<?=$hero['id']; ?>] <?=$hero['classname']; ?>
</div>
<?=validation_errors(); ?>
<?php if ($items): ?>
<?php foreach ($items as $row): ?>
  <?=form_open($link_form); ?>
  <?=form_hidden('action', 'delete'); ?>
  <?=form_hidden('id', $row['id']); ?>
  <div class="row_edit">
    <div class="edit_name">
      [<?=$row['id']; ?>] <?=$row['name']; ?> 
    </div>
    <div class="edit_input">
      <?=form_submit($attr_delete); ?>
    </div>
  </div>
  <?=form_close(); ?>
<?php endforeach; ?>
<?php endif; ?>
<?=form_open($link_form); ?>
<?=form_hidden('action', 'add'); ?>
<?=form_hidden('classid', $hero['id']); ?>
<div class="row_edit">
  <div class="edit_name">
    Add:
  </div>
  <div class="edit_input">
    <?=form_dropdown($name_add_drop, $optitems, $selitems, $attr_add_drop); ?> 
    <?=form_submit($attr_add); ?>
  </div>
</div>
<?=form_close(); ?>