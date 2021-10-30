<?php
$this->load->helper('form');
$this->load->helper('url');
$this->load->helper('date');

$ds = '%Y.%m.%d %H:%m:%s';

$link_back = 'mail/inbox';

if ($mail)
{
  $link_reply = 'mail/compose/' . $mail['id'];
  $link_delete = 'mail/delete/' . $mail['id'];
}
?>
<div class="mail_container">
<?php if ($mail): ?>
<div class="back">
<a href="<?=site_url($link_back); ?>"><-- Back</a>
</div>
<div class="mail_row mail_first_row">
	<div class="mail_reader_attr">
		Sender:
	</div>
	<div class="mail_reader_object">
		<?=$mail['username']; ?>
	</div>
</div>
<div class="mail_row">
	<div class="mail_reader_attr">
		Sent at:
	</div>
	<div class="mail_reader_object">
		<?=mdate($ds, $mail['time']); ?>
	</div>
</div>
<div class="mail_row mail_first_row">
	<div class="mail_reader_attr">
		Subject:
	</div>
	<div class="mail_reader_object">
		<?=$mail['subject']; ?>
	</div>
</div>
<div class="mail_row_textarea">
	<?=$mail['body']; ?>
</div>
<div class="mail_row mail_first_row">
	<a href="<?=site_url($link_reply); ?>">
	<div class="mail_reader_action mail_reader_action_f">
		Reply
	</div>
	</a>
	<a href="<?=site_url($link_delete); ?>">
	<div class="mail_reader_action">
  		Delete
	</div>
	</a>
</div>
<?php else: ?>
<div class="cannot">
You cannot read that message.
</div>
<?php endif; ?>
</div>