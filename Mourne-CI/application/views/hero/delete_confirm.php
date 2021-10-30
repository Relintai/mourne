<?php
$this->load->helper('url');
$this->load->helper('form');
$this->load->helper('class');

$link_back = 'hero/select';

$link_form = 'hero/delete/' . $id;

$attr_confirm = array(
  'name' => 'confirm',
  'class' => 'input');

$attr_submit = array(
  'name' => 'submit',
  'value' => 'Delete!',
  'class' => 'submit');
?>
<div class="hero_container">
<div class="back">
<a href="<?=site_url($link_back); ?>"><-- Back</a>
</div>
  <?=validation_errors(); ?>
  <div class="hero_text">
    If you sure you want to delete this character write DELETE (hase to be all uppercase!) 
    into the field and hit Delete!
  </div>
  <div class="hero_delete_data">
    <?=$hero['name']; ?> 
    [Level <?=$hero['level']; ?>] 
    <?=gender($hero['gender']); ?> 
    <?=class_name($hero['class']); ?> 
  </div>
  <div class="hero_delete">
    <?=form_open($link_form); ?>
    <?=form_input($attr_confirm); ?>
    <?=form_submit($attr_submit); ?>
    <?=form_close(); ?>
  </div>
</div>