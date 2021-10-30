<?php
$this->load->helper('form');
$this->load->helper('date');

$link_form = 'building/dospell';

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Use',
		'class' => 'submit');
?>
<div class="building_container">
<?php if ($spells): ?>
<?php foreach ($spells as $row): ?>
	<div class="spell_data">
		<?php if (!$row['cooldown_end']): ?>
			<?=form_open($link_form); ?>
		<?php endif; ?>
		<div class="left">
       			<div class="cost">
				<div class="cost_icon">
		        		D:
				</div>
				<div class="cost_spell">
		       			<?=$row['duration']; ?>
				</div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					C:
				</div>
		        	<div class="cost_spell">
	                		<?=$row['cooldown']; ?>
		        	</div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					F:
				</div>
			        <div class="cost_spell">
		        		<?=$row['cost_food']; ?>
			        </div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					W:
				</div>
	        		<div class="cost_spell">
		        	        <?=$row['cost_wood']; ?>
        			</div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					S:
				</div>
			        <div class="cost_spell">
	        		        <?=$row['cost_stone']; ?>
			        </div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					I:
				</div>
        			<div class="cost_spell">
			        	<?=$row['cost_iron']; ?>
        			</div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					M:
				</div>
			        <div class="cost_spell">
	        		        <?=$row['cost_mana']; ?>
				</div>
			</div>
			<div class="nofloat"></div>
		        <div class="spell_description">
				<?=$row['description']; ?>
			</div>
		</div>
		<div class="right">
			<div class="spell_box">
				<?php if (!$row['cooldown_end']): ?>
					<?=form_hidden('slotid', $slotid); ?>
					<?=form_hidden('spellid', $row['id']); ?>
					<?=form_submit($attr_submit); ?>
				<?php else: ?>
					<span class="cooldown_text">
					<?=timespan(time(), $row['cooldown_end']); ?></span>
				<?php endif; ?>
				<?php if (!$row['cooldown_end']): ?>
					<?=form_close(); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
<?php else: ?>
	<div class="cannot">
		This building doesn't have spells.
	</div>
<?php endif; ?>
</div>