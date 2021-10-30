New version lawl!
<?php 
$this->load->helper('url'); 
$this->load->helper('form');

$link_back = 'changelog/show';

$link_form = 'changelog/add_new_version';

$attr_form = array(
		'class' => 'changelog_form');

$attr_text = array(
		'name' => 'text',
		'class' => 'changelog_input');

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Submit',
		'class' => 'changelog_submit');
?>
<a href="<?=site_url($link_back); ?>">Back</a><br />

<?=form_open($link_form, $attr_form); ?>
<?=form_input($attr_text); ?>
<?=form_submit($attr_submit); ?>
<?=form_close(); ?>
