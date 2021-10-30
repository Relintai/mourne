<?php
$this->load->helper('url');

$link_back = 'admin/menu_image';
?>
<div class="back">
<a href="<?=site_url($link_back); ?>"><-- Back</a>
</div>
<div class="action">
Images generated:
</div>
<?php if ($applyall): ?>
<?php foreach ($list as $row): ?>
<?php $link = 'img/generated/' . $row . '.png'; ?>
<img src="<?=base_url($link); ?>">
<?php endforeach; ?>
<?php else: ?>
<?php $link = 'img/generated/' . $text . '.png'; ?>
<img src="<?=base_url($link); ?>">
<?php endif; ?>