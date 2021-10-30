<?php
$this->load->helper('form');
$this->load->helper('url');

$link_back = 'admin/technology_requirements_tool';

$link_form = 'admin/have_technology_requirement';

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Remove!',
		'class' => 'submit');
?>
Add new!<br />
<a href="<?=site_url($link_back); ?>"><-- Back</a><br />
<?=form_open($link_form); ?>
<?=form_hidden('action', 'delete'); ?>
<?=form_hidden('technologyid', $id); ?>
Are you sure you want to remove this from the list?<br />
NOTE: This won't remove requirements, only from the tool's list!<br />
<br />
id: <?=$tech['id']; ?><br />
technology id: <?=$tech['technologyid']; ?><br />
Technology description: <?=$tech['description']; ?><br />
Comment: <?=$tech['comment']; ?><br />
<br />
<?=form_submit($attr_submit); ?> 
<a href="<?=site_url($link_back); ?>">Nope!</a>
<br />
<?=form_close(); ?>
