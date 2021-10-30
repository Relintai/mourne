<?php
$this->load->helper('url');
$this->load->helper('form');

$link_back = 'admin/sql_tool';

$link_form = 'admin/sql_new';

$attr_textarea = array(
		'name' => 'sql',
		'rows' => '15',
		'cols' => '100',
		'class' => 'textarea');

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Submit',
		'class' => 'submit'); 

?>
<div class="back">
<a href="<?=site_url($link_back); ?>"><-- Back</a>
</div>
<div class="action">
	New SQL!
</div>

<?=form_open($link_form); ?>
<div class="sql_textbox">
<?=form_textarea($attr_textarea); ?>
</div>
<div class="edit_submit">
	<?=form_submit($attr_submit); ?>
</div>
<?=form_close(); ?>
