<?php
$this->load->helper('url');
$this->load->helper('form');
$this->load->helper('date');

$link_form = 'building/docreate/' . $slotid;

$attr_create_num = array(
		'name' => 'create_num',
		'size' => '8',
		'maxlength' => '10',
		'class' => 'input');

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Create!',
		'class' => 'submit');

?>
<div class="building_container">
<?php if ($building['creates']): ?>
	<div class="create_data">
		<div class="create_name">
			Create: <?=$unit['name']; ?>
		</div>
		<div class="left">
			<div class="cost">
				<div class="cost_icon">
				        F:
				</div>
				<div class="cost_food">
					<?=$unit['cost_food']; ?>
			        </div>
			</div>
			<div class="cost">
				<div class="cost_icon">
				        W:
				</div>
			        <div class="cost_wood">
				        <?=$unit['cost_wood']; ?>
			        </div>
		        </div>
			<div class="cost">
				<div class="cost_icon">
				        S:
				</div>
			        <div class="cost_stone">
				        <?=$unit['cost_stone']; ?>
			        </div>
			</div>
		       	<div class="cost">
				<div class="cost_icon">
				        I:
				</div>
			        <div class="cost_iron">
				        <?=$unit['cost_iron']; ?>
			        </div>
			</div>
			<div class="cost">
				<div class="cost_icon">
				        M:
				</div>
			        <div class="cost_mana">
				        <?=$unit['cost_mana']; ?>
			        </div>
			</div>
			<div class="nofloat"></div>
			<div class="cost">
				<div class="cost_unit_time_container">
					<div class="cost_icon">
					        D:
					</div>
				        <div class="cost_unit_time">
						<?=timespan(time(), (time() + $unit['time_to_create'])); ?>
							/ <?=$unit['name']; ?>
	        			</div>
				</div>
			</div>
			<div class="nofloat"></div>
			<div class="cost">
				<div class="cost_unit_container">
					<div class="cost_icon">
					        Unit:
					</div>
				        <div class="cost_unit">
						<?php if ($unit['cost_unit']): ?>
							<?=$unit['cost_num_unit']; ?> 
							<?=$costu['name']; ?> / 
							<?=$unit['name']; ?>
						<?php else: ?>
							Nothing
						<?php endif; ?>
	        			</div>
				</div>
			</div>
        	</div>
	        <div class="right">
			<div class="create_unit_container">
				<?=form_open($link_form); ?>
				<div class="create_unit">
					<?=$maxunit; ?>/<?=form_input($attr_create_num); ?> 
					<?=form_submit($attr_submit); ?>
				</div>
				<?=form_close(); ?>
			</div>
		</div>
        </div>
<?php else: ?>
	<div class="cannot">
		This building cannot create units.
	</div>
<?php endif; ?>
</div>