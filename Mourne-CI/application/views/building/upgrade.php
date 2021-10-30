<?php
//$this->load->helper('url');
$this->load->helper('form');
$this->load->helper('date');

$link_form = 'building/doupgrade/';

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Upgrade!',
		'class' => 'submit');
?>
<div class="building_container">
<?php if ($building['next_rank']): ?>
	<?php if ($upgrade == 3): ?>
		<?=form_open($link_form); ?>
	<?php endif; ?>
	<div class="upgrade_data">
		<div class="left">
       			<div class="cost">
				<div class="cost_icon">
		        		D:
				</div>
				<div class="cost_upgrade">
					<?=timespan(time(), (time() + $nextrank['time_to_build'])); ?>
				</div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					F:
				</div>
			        <div class="cost_upgrade">
		        		<?=$nextrank['cost_food']; ?>
			        </div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					W:
				</div>
	        		<div class="cost_upgrade">
		        	        <?=$nextrank['cost_wood']; ?>
        			</div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					S:
				</div>
			        <div class="cost_upgrade">
	        		        <?=$nextrank['cost_stone']; ?>
			        </div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					I:
				</div>
        			<div class="cost_upgrade">
			        	<?=$nextrank['cost_iron']; ?>
        			</div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					M:
				</div>
			        <div class="cost_upgrade">
	        		        <?=$nextrank['cost_mana']; ?>
				</div>
			</div>
			<div class="nofloat"></div>
		        <div class="upgrade_description">
				<?php if ($upgrade == 0): ?>
					Already upgrading.
				<?php elseif ($upgrade == 1): ?>
					Technology requirement not met.
				<?php elseif ($upgrade == 2): ?>
					Not enough resources.
				<?php else: ?>
					Every requirement met.
				<?php endif; ?>
			</div> 
		</div>
		<div class="right">
			<div class="upgrade_box">
				<?php if($upgrade == 3): ?>
					<?=form_hidden('slotid', $slotid); ?>
					<?=form_submit($attr_submit); ?>
					<?=form_close(); ?>
				<?php else: ?>
					Cannot Upgrade.
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php else: ?>
<div class="cannot">
	This building cannot be upgraded.
</div>
<?php endif; ?>
</div>