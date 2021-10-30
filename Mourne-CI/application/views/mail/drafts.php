<?php
$this->load->helper('url');
$this->load->helper('date');

$ds = "%Y-%m-%d - %H:%i:%s";

$link_read = "mail/compose/";
$link_delete = "mail/del_draft/";
?>
<div class="mail_container">
<?php if ($mails): ?>

<div class="mail_list_row mail_list_row_first">

<div class="mail_list_entry_new">
	Del
</div>

<div class="mail_list_entry_time">
	Time
</div>

<div class="mail_list_entry_username">
	To
</div>

<div class="mail_list_entry_subject">
	Subject
</div>

</div>
<?php $i = 0; ?>
<?php foreach ($mails as $row): ?>
	<?php if ($i % 2): ?>
	<div class="mail_list_row mail_list_row_first">
	<?php else: ?>
	<div class="mail_list_row">
	<?php endif; ?>

	<?php $linkd = $link_delete . $row['id']; ?>
	<a href="<?=site_url($linkd); ?>">
	<div class="mail_list_entry_new">
	[x]
	</div>
	</a>

	<?php $link = $link_read . $row['id']; ?>
	<a href="<?=site_url($link); ?>">
	<div class="mail_list_entry_time">
	<?=mdate($ds, $row['time']); ?>
	</div>

	<div class="mail_list_entry_username">
	<?php if ($row['name']): ?>
	<?=$row['name']; ?>
	<?php endif; ?>
	</div>

	<div class="mail_list_entry_subject">
	<?=$row['subject']; ?>
	</div>
	</a>
	</div>
	<?php $i++; ?>
<?php endforeach; ?>
<?php else: ?>
<div class="cannot">
You don't have drafts.
</div>
<?php endif; ?>
</div>