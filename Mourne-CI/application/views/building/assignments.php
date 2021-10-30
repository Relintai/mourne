<?php
$this->load->helper('form');
$link_form = 'building/doassign';

$attr_deass = array(
		'name' => 'submit',
		'value' => 'Deassign',
		'class' => 'submit');

$attr_input = array(
		'name' => 'num_assign',
		'maxlength' => '10',
		'size' => '8',
		'class' => 'input');

$attr_assign = array(
		'name' => 'submit',
		'value' => 'Assign',
		'class' => 'submit');
?>
<div class="building_container">
<?php if ($assigndata): ?>
<?php foreach($assigndata as $row): ?>
	<div class="building_data">
	<?php $found = FALSE; ?>
	<?php if ($assigned): ?>
		<?php foreach ($assigned as $ass): ?>
			<?php if ($found) continue; ?>
			<?php if ($ass['assignmentid'] == $row['id']): ?>
	                        <div class="left">
	                        <div class="description">
				<?=$row['description']; ?><br />
	                        </div>
                                </div>
	                        <div class="right">
				<?=form_open($link_form); ?>
				<?=form_hidden('slotid', $slotid); ?>
				<?=form_hidden('assignmentid', $row['id']); ?>
				Assigned <?=$row['name']; ?> 
				<?=$row['max']; ?>/<?=$ass['num_unit']; ?>
				<?=form_submit($attr_deass); ?>
				<?=form_close(); ?>
                                </div>
				<?php $found = TRUE; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
	<?php if (!$found): ?>
                <div class="left">
                        <div class="description">
	                        <?=$row['description']; ?>
	                </div>
                </div>
	        <div class="right">
		<?=form_open($link_form); ?>
		<?=form_hidden('slotid', $slotid); ?>
		<?=form_hidden('assignmentid', $row['id']); ?>
		(You have: 
		<?php if ($units): ?>
		<?php foreach ($units as $u): ?>
			<?php if ($u['unitid'] == $row['unitid']): ?>
				<?=$u['unitcount']; ?>)
			<?php endif; ?>
		<?php endforeach; ?>
		<?php else: ?>
			0)
		<?php endif; ?> 
		<?=$row['max']; ?>/<?=form_input($attr_input); ?>
		<?=form_submit($attr_assign); ?>
		<?=form_close(); ?>
                </div>
	<?php endif; ?>
	</div>
<?php endforeach; ?>
<?php else: ?>
<div class="cannot">
This building doesn't have assignments!
</div>
<?php endif; ?>
</div>
