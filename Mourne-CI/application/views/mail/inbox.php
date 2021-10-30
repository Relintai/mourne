<?php
$this->load->helper('url');
$this->load->helper('date');

$ds = "%Y-%m-%d - %H:%i:%s";

$link_read = "mail/read/";

?>
<div class="mail_container">
<?php if ($mails): ?>

<div class="mail_list_row mail_list_row_first">

<div class="mail_list_entry_new">
	New
</div>

<div class="mail_list_entry_time">
	Time
</div>

<div class="mail_list_entry_username">
	Sender
</div>

<div class="mail_list_entry_subject">
	Subject
</div>

</div>
<?php $i = 0; ?>
<?php foreach ($mails as $row): ?>
	<?php $link = $link_read . $row['id']; ?>
	<a href="<?=site_url($link); ?>">
	<?php if ($i % 2): ?>
	<div class="mail_list_row mail_list_row_first">
	<?php else: ?>
	<div class="mail_list_row">
	<?php endif; ?>

	<div class="mail_list_entry_new">
	<?php if ($row['new']): ?>
		!
	<?php endif; ?>
	</div>

	<div class="mail_list_entry_time">
	<?=mdate($ds, $row['time']); ?>
	</div>

	<div class="mail_list_entry_username">
	<?=$row['username']; ?>
	</div>

	<div class="mail_list_entry_subject">
	<?=$row['subject']; ?>
	</div>

	</div>
	</a>
	<?php $i++; ?>
<?php endforeach; ?>
<?php else: ?>
<div class="cannot">
You don't have mails.
</div>
<?php endif; ?>
</div>