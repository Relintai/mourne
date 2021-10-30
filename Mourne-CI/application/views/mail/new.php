<?php
$this->load->helper('url');
$this->load->helper('form');

$link_form = 'mail/compose';

$attr_name = array(
  'name' => 'name',
  'class' => 'input');

$attr_subject = array(
  'name' => 'subject',
  'size' => '68',
  'maxlenght' => '100',
  'class' => 'input');

$attr_textarea = array(
  'name' => 'message',
  'rows' => '15',
  'cols' => '90',
  'class' => 'textarea');

$attr_send = array(
  'name' => 'send',
  'value' => 'Send!',
  'class' => 'submit');

$attr_draft = array(
  'name' => 'draft',
  'value' => 'To Drafts',
  'class' => 'submit');

if ($draft)
{
  $attr_name['value'] = $draft['name'];
  $attr_subject['value'] = $draft['subject'];
  $attr_textarea['value'] = $draft['body'];
}
else
{
  $attr_name['value'] = set_value('name');
  $attr_subject['value'] = set_value('subject');
  $attr_message['value'] = set_value('message');
}

?>
<div class="mail_container">
<?=validation_errors(); ?>

<?=form_open($link_form); ?>
<div class="mail_row mail_first_row">
<div class="new_name">
Username:
</div>
<div class="new_input">
  <?=form_input($attr_name); ?>
</div>
</div>

<div class="mail_row">
<div class="new_name">
Subject:
</div>
<div class="new_input">
  <?=form_input($attr_subject); ?>
</div>
</div>

<div class="mail_row mail_first_row">
<div class="new_name">
Message:
</div>
</div>

<div class="mail_row_textarea">
  <?=form_textarea($attr_textarea); ?>
</div>

<div class="mail_submit">
  <?=form_submit($attr_send);?>
</div>

<div class="mail_submit">
  <?=form_submit($attr_draft);?>
</div>


<?=form_close(); ?>
</div>