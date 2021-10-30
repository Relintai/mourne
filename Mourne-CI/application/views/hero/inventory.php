<?php
$this->load->helper('murl');
$this->load->helper('url');
$this->load->helper('equipment');

if (!isset($d1))
  $d1 = FALSE;

if (!isset($d2))
  $d2 = FALSE;

if (!isset($target))
  $target = 'hero/selected/inventory/';

if (($d1 !== FALSE) && ($d2 !== FALSE))
  $link_sel = $target . $d1 .  '/' . $d2 . '/';
else
  $link_sel = $target;
?>
<?php $i = 1;$j = 0; ?>
<div class="inventory_box">
<?php foreach ($inventory as $row): ?>
<a href="<?=site_url($link_sel . 'iv/' . $j); ?>">
<?php
if (ss($d1, $d2, 'iv', $j))
  $class = ss($d1, $d2, 'iv', $j);
else
  $class = qi($row); 
?>
<div class="inventory_entry <?=$class; ?>">
  <?php if ($row): ?>
    <img src="<?=ibase_url(('hero/inventory/' . $row['icon'])); ?>">
  <?php else: ?>
    <img src="<?=ibase_url('hero/inventory/base.png'); ?>">
  <?php endif; ?>
</div>
</a>
<?php if (!($i % 10)): ?>
<div class="nofloat"></div>
<?php endif; ?>
<?php $i++;$j++; ?>
<?php endforeach; ?>
</div>