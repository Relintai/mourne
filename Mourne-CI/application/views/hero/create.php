<?php
$this->load->helper('form');

$link_form = 'hero/create';

$attr_name = array(
  'name' => 'name',
  'size' => '17',
  'maxlength' => 15,
  'class' => 'input');

$attr_submit = array(
  'name' => 'submit',
  'value' => 'Create!',
  'class' => 'submit');

$gender = set_value('gender');

$m = FALSE;
$fm = FALSE;

if ($gender == 1)
  $m = TRUE;
elseif ($gender == 2)
  $fm = TRUE;

$c1 = FALSE;
$c2 = FAlSE;
$c3 = FALSE;
$c4 = FALSE;
$c5 = FALSE;
$c6 = FALSE;

$cl = set_value('class');

switch ($cl)
{
  case 1:
    $c1 = TRUE;
    break;
  case 2:
    $c2 = TRUE;
    break;
  case 3:
    $c3 = TRUE;
    break;
  case 4:
    $c4 = TRUE;
    break;
  case 5:
    $c5 = TRUE;
    break;
  case 6:
    $c6 = TRUE;
    break;
}
?>

<div class="hero_create_container">
<div class="hero_create_data">
<div class="hero_create_header">
Create new hero!
</div>
<?=validation_errors(); ?>
<div class="vspace"></div>
<?=form_open($link_form); ?>
<div class="input_row rowf">
<div class="input_name">
name:
</div>
<div class="input_input">
<?=form_input($attr_name); ?>
</div>
</div>
<div class="vspace"></div>

<div class="hero_create_header">
Gender:
</div>
<div class="vspace"></div>
<div class="input_row rowf">
<div class="left">
Male: <?=form_radio('gender', 1, $m); ?>
</div>
<div class="right">
Female: <?=form_radio('gender', 2, $fm); ?>
</div>
</div>
<div class="vspace"></div>
<div class="hero_create_header">
Class:
</div>
<div class="vspace"></div>
<div class="hero_create_header">
Fighter Classes:
</div>

<div class="hero_create_row rowf">
<div class="left">
<div class="hero_create_class rows">
Warrior
</div>
<div class="hero_create_description">
cool description here
</div>
</div>
<div class="right">
<div class="hero_create_select">
  <?=form_radio('class', '1', $c1); ?>
</div>
</div>
</div>

<div class="hero_create_row">
<div class="left">
<div class="hero_create_class rowf">
Rogue
</div>
<div class="hero_create_description">
cool description here
</div>
</div>
<div class="right">
<div class="hero_create_select">
  <?=form_radio('class', '2', $c2); ?>
</div>
</div>
</div>

<div class="hero_create_row rowf">
<div class="left">
<div class="hero_create_class rows">
Archer
</div>
<div class="hero_create_description">
cool description here
</div>
</div>
<div class="right">
<div class="hero_create_select">
  <?=form_radio('class', '3', $c3); ?>
</div>
</div>
</div>
<div class="vspace"></div>
<div class="hero_create_header">
Healer classes:
</div>

<div class="hero_create_row rowf">
<div class="left">
<div class="hero_create_class rows">
?
</div>
<div class="hero_create_description">
cool description here
</div>
</div>
<div class="right">
<div class="hero_create_select">
  <?=form_radio('class', '4', $c4); ?>
</div>
</div>
</div>
<div class="vspace"></div>
<div class="hero_create_header">
Hybrid classes:
</div>

<div class="hero_create_row rowf">
<div class="left">
<div class="hero_create_class rows">
?
</div>
<div class="hero_create_description">
cool description here
</div>
</div>
<div class="right">
<div class="hero_create_select">
  <?=form_radio('class', '5', $c5); ?>
</div>
</div>
</div>
<div class="settings_submit">
<?=form_submit($attr_submit); ?>
</div>
<?=form_close(); ?>
</div>
</div>