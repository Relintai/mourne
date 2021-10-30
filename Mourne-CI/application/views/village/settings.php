<?php
$this->load->helper('form');
$this->load->helper('url');

$link_back = 'village/select';

$link_form = 'village/settings/' . $id;

$attr_name = array(
  'name' => 'name',
  'class' => 'input',
  'value' => $village['name']);

$attr_ai = array(
  'name' => 'ai',
  'value' => 'ai');

if ($village['ai_on'])
  $attr_ai['checked'] = TRUE;

$attr_submit = array(
  'name' => 'submit',
  'value' => 'Save',
  'class' => 'submit');


?>
<div class="settings_container">
<div class="back">
<a href="<?=site_url($link_back); ?>"><-- Back</a>
</div>

<?=validation_errors(); ?>

<?=form_open($link_form); ?>
<div class="village_settings_row first_village_settings_row">
	<div class="settings_name">
		Village's name:
	</div>
	<div class="settings_input">
		<?=form_input($attr_name); ?>
	</div>
</div>
<div class="village_settings_row">
	<div class="settings_name">
		AI turned on:
	</div>
	<div class="settings_input">
		<?=form_checkbox($attr_ai); ?>
	</div>
</div>
<div class="settings_submit">
	<?=form_submit($attr_submit); ?>
</div>
<?=form_close(); ?>
</div>