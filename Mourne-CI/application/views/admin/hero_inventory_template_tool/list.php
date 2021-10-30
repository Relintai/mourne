<?php
$this->load->helper('url');

$link_edit = 'admin/hero_inventory_templates/';

$link_back = 'admin/admin_panel';
?>
<div class="back">
	<a href="<?=site_url($link_back); ?>"><--- Back</a>
</div>
<div class="list_container">
<?php $i = 1; ?>
<?php foreach ($classes as $row): ?>
  <?php $link = $link_edit . $row['id']; ?>
  <?php if (!($i % 2)): ?>
    <div class="row">
  <?php else: ?>
    <div class="row second">
  <?php endif; ?>
    <div class="attr_box">
      [<?=$row['id']; ?>]
    </div>
    <div class="name">
      <?=$row['classname']; ?>
    </div>
    <div class="actionbox">
      <a href="<?=site_url($link); ?>">Edit Items</a>
    </div>
  </div>
  <?php $i++; ?>
<?php endforeach; ?>
</div>