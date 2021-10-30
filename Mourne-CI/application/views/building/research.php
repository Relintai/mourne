<?php
$this->load->helper('form');
$this->load->helper('date');

$link_form = 'building/doresearch';

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Research!',
		'class' => 'submit');
?>
<div class="building_container">
<?php if ($primary): ?>
<div class="research_header">
Primary researches:
</div>
<?php foreach ($primary as $row): ?>
	<div class="research_data">
		<div class="left">
       			<div class="cost">
				<div class="cost_icon">
		        		D:
				</div>
				<div class="cost_research">
					<?=timespan(time(), (time() + $row['time'])); ?>
				</div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					F:
				</div>
			        <div class="cost_research">
		        		<?=$row['cost_food']; ?>
			        </div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					W:
				</div>
	        		<div class="cost_research">
		        	        <?=$row['cost_wood']; ?>
        			</div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					S:
				</div>
			        <div class="cost_research">
	        		        <?=$row['cost_stone']; ?>
			        </div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					I:
				</div>
        			<div class="cost_research">
			        	<?=$row['cost_iron']; ?>
        			</div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					M:
				</div>
			        <div class="cost_research">
	        		        <?=$row['cost_mana']; ?>
				</div>
			</div>
			<div class="nofloat"></div>
		        <div class="research_description">
				<?=$row['description']; ?>
			</div>
		</div>
		<div class="right">
			<div class="research_box">
				<?=form_open($link_form); ?>
				<?=form_hidden('id', $row['id']); ?>
				<?=form_hidden('slotid', $slotid); ?>
				<?=form_submit($attr_submit); ?>
				<?=form_close(); ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
<br />
<?php else: ?>
<div class="research_header">
No primary researches.
</div>
<?php endif; ?>
<?php if ($secondary): ?>
<div class="research_header">
Secondary researches:
</div>
<?php foreach ($secondary as $row): ?>
	<div class="research_data">
		<div class="left">
       			<div class="cost">
				<div class="cost_icon">
		        		D:
				</div>
				<div class="cost_research">
					<?=timespan(time(), (time() + $row['time'])); ?>
				</div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					F:
				</div>
			        <div class="cost_research">
		        		<?=$row['cost_food']; ?>
			        </div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					W:
				</div>
	        		<div class="cost_research">
		        	        <?=$row['cost_wood']; ?>
        			</div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					S:
				</div>
			        <div class="cost_research">
	        		        <?=$row['cost_stone']; ?>
			        </div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					I:
				</div>
        			<div class="cost_research">
			        	<?=$row['cost_iron']; ?>
        			</div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					M:
				</div>
			        <div class="cost_research">
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
				<?=form_open($link_form); ?>
				<?=form_hidden('id', $row['id']); ?>
				<?=form_hidden('slotid', $slotid); ?>
				<?=form_submit($attr_submit); ?>
				<?=form_close(); ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
<?php else: ?>
<div class="research_header">
No Secondary researches.
</div>
<?php endif; ?>
</div>