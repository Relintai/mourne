<?php
$this->load->helper('url');
$this->load->helper('form');
$this->load->helper('class');
$this->load->helper('murl');

$link_create = 'hero/create';
$link_delete = 'hero/delete/';

$link_form = 'hero/select';

$attr_submit = array(
  'name' => 'submit',
  'value' => 'Select!',
  'class' => 'submit');
?>
<div class="hero_container">
<?php if ($heroes): ?>
<?php $i = 0; ?>
<?php foreach ($heroes as $row): ?>
<?php 
if ($i % 2)
  $r = "rows";
else
  $r = "rowf";
?>
<div class="hero_row <?=$r; ?>">
  <div class="left">
    <?=$row['name']; ?> 
    [Level <?=$row['level']; ?>] 
    <?=gender($row['gender']); ?> 
    <?=class_name($row['class']); ?> 
  </div>
  <div class="right">
    <div class="hero_row_sel">
      <a href="<?=site_url(($link_delete . $row['id'])); ?>">Delete</a>
    </div>
    <div class="hero_row_sel">
      <?php if (!$row['selected']): ?>
        <?=form_open($link_form); ?>
        <?=form_hidden('heroid', $row['id']); ?>
        <?=form_submit($attr_submit);?>
        <?=form_close(); ?>
      <?php else: ?>
        Selected
      <?php endif; ?>
    </div>
  </div>
</div>
<?php $i++; ?>
<?php endforeach; ?>

<?php else: ?>
<div class="cannot">
  You don't have any Heroes.
</div>
<?php endif; ?>
<div class="back">
  <a href="<?=site_url($link_create); ?>">Create New</a>
</div>
</div>