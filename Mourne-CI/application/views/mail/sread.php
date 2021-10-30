<?php
$this->load->helper('form');
$this->load->helper('url');
$this->load->helper('date');

$ds = '%Y.%m.%d %H:%m:%s';

$link_back = 'mail/inbox';

?>
<div class="mail_container">
<?php if ($mail): ?>
<div class="back">
<a href="<?=site_url($link_back); ?>"><-- Back</a>
</div>
<div class="mail_row mail_first_row">
	<div class="mail_reader_attr">
		Sent to:
	</div>
	<div class="mail_reader_object">
		<?=$mail['to']; ?>
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
<?php else: ?>
<div class="cannot">
You cannot read that message.
</div>
<?php endif; ?>
</div>