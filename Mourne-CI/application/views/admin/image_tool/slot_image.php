<?php
$this->load->helper('form');
$this->load->helper('url');

$link_back = 'admin/admin_panel';
$link_form = 'admin/slot_image';

$attr_drop = 'class="drop"';

$name_font = 'font';
$attr_font = 'class="drop"';

$opt_wm_type = array(
	'text' => 'Text',
	'overlay' => 'Overlay');

$attr_wm_opacity = array(
	'name' => 'wm_opacity',
	'value' => '1',
	'class' => 'input');

$attr_wm_x_transp = array(
	'name' => 'wm_x_transp',
	'value' => '1',
	'class' => 'input');

$attr_wm_y_transp = array(
	'name' => 'wm_y_transp',
	'value' => '1',
	'class' => 'input');

$attr_padding = array(
	'name' => 'padding',
	'value' => '0',
	'class' => 'input');

$attr_rank_padding = array(
	'name' => 'rank_padding',
	'value' => '0',
	'class' => 'input');

$attr_h_offset = array(
	'name' => 'h_offset',
	'value' => '-1',
	'class' => 'input');

$attr_v_offset = array(
	'name' => 'v_offset',
	'value' => '-5',
	'class' => 'input');

$attr_rank_h_offset = array(
	'name' => 'rank_h_offset',
	'value' => '0',
	'class' => 'input');

$attr_rank_v_offset = array(
	'name' => 'rank_v_offset',
	'value' => '0',
	'class' => 'input');

$attr_text = array(
	'name' => 'text',
	'class' => 'input');

$attr_rank_text = array(
	'name' => 'rank_text',
	'class' => 'input');

$attr_font_size = array(
	'name' => 'font_size',
	'value' => '5',
	'class' => 'input');

$attr_rank_font_size = array(
	'name' => 'rank_font_size',
	'value' => '8',
	'class' => 'input');

$attr_font_color = array(
	'name' => 'font_color',
	'value' => 'ffffff',
	'class' => 'input');

$attr_shadow_color = array(
	'name' => 'shadow_color',
	'value' => 'ffffff',
	'class' => 'input');

$attr_shadow_distance = array(
	'name' => 'shadow_distance',
	'value' => '0',
	'class' => 'input');

$attr_apply_all = array(
	'name' => 'apply_all',
	'value' => '1',
	'checked' => 'TRUE');

$attr_submit = array(
	'name' => 'submit',
	'value' => 'Submit',
	'class' => 'submit');
?>
<div class="back">
<a href="<?=site_url($link_back); ?>"><-- Back</a>
</div>
<div class="action">
	Slot Image Text Generator
</div>

<?=form_open($link_form); ?>

<div class="row_edit">
<div class="edit_name">
Type:
</div>
<div class="edit_input">
<?=form_dropdown('wm_type', $opt_wm_type, 'text', $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Surce File:
</div>
<div class="edit_input">
<?=form_dropdown('file', $optimg, 'slot.png', $attr_drop); ?>
</div>
</div>

<div class="action">
	Alignment:
</div>

<div class="row_edit">
<div class="edit_name">
Padding:
</div>
<div class="edit_input">
<?=form_input($attr_padding); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Vertical Alignment:
</div>
<div class="edit_input">
<?=form_dropdown('v_align', $optvalign, 'middle', $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Horizontal Alignment:
</div>
<div class="edit_input">
<?=form_dropdown('h_align', $opthalign, 'center', $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Horizontal Offset:
</div>
<div class="edit_input">
<?=form_input($attr_h_offset); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Vertical Offset:
</div>
<div class="edit_input">
<?=form_input($attr_v_offset); ?>
</div>
</div>

<div class="action">
---------------------------------------Text:-------------------------------------
</div>

<div class="row_edit">
<div class="edit_name">
Text:
</div>
<div class="edit_input">
<?=form_input($attr_text); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Font:
</div>
<div class="edit_input">
<?=form_dropdown($name_font, $optfont, FALSE, $attr_font); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Font Size:
</div>
<div class="edit_input">
<?=form_input($attr_font_size); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Font Color:
</div>
<div class="edit_input">
<?=form_input($attr_font_color); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Shadow Color:
</div>
<div class="edit_input">
<?=form_input($attr_shadow_color); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Shadow Distance:
</div>
<div class="edit_input">
<?=form_input($attr_shadow_distance); ?>
</div>
</div>

<div class="action">
----------------------------------------Rank:------------------------------------
</div>

<div class="row_edit">
<div class="edit_name">
Rank Text:
</div>
<div class="edit_input">
<?=form_input($attr_rank_text); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Rank Font Size:
</div>
<div class="edit_input">
<?=form_input($attr_rank_font_size); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Vertical Alignment:
</div>
<div class="edit_input">
<?=form_dropdown('rank_v_align', $optvalign, 'bottom', $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Horizontal Alignment:
</div>
<div class="edit_input">
<?=form_dropdown('rank_h_align', $opthalign, 'left', $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Horizontal Offset:
</div>
<div class="edit_input">
<?=form_input($attr_rank_h_offset); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Vertical Offset:
</div>
<div class="edit_input">
<?=form_input($attr_rank_v_offset); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Padding:
</div>
<div class="edit_input">
<?=form_input($attr_rank_padding); ?>
</div>
</div>

<div class="action">
---------------------------------------Image:------------------------------------
</div>

<div class="row_edit">
<div class="edit_name">
Overlay Image:
</div>
<div class="edit_input">
<?=form_dropdown('wm_overlay_path', $optoverlay, 'overlay.png', $attr_drop); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Opacity:
</div>
<div class="edit_input">
<?=form_input($attr_wm_opacity); ?>
</div>
</div>

<div class="edit_spacer"></div>

<div class="row_edit">
<div class="edit_name">
X Transp:
</div>
<div class="edit_input">
<?=form_input($attr_wm_x_transp); ?>
</div>
</div>

<div class="row_edit">
<div class="edit_name">
Y Transp:
</div>
<div class="edit_input">
<?=form_input($attr_wm_y_transp); ?>
</div>
</div>

<div class="row_edit_textbox">
<div class="edit_name">
(If your watermark image is a PNG or GIF image, you may specify a color on the image to be "transparent". 
This setting (along with the next) will allow you to specify that color. This works by specifying the 
"X" and "Y" coordinate pixel (measured from the upper left) within the image that corresponds to a pixel 
representative of the color you want to be transparent.)
</div>
</div>

<div class="edit_submit">
<?=form_submit($attr_submit); ?>
</div>
<?=form_close(); ?>
