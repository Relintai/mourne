<?php
$this->load->helper('url');
$this->load->helper('date');
$this->load->helper('form');

$link_back = 'village/selected';

$link_form = 'building/dobuild';

$attr_submit = array(
		'name' => 'submit',
		'value' => 'Build!',
		'class' => 'submit');
?>
<div class="building_container">
<div class="back">
<a href="<?=site_url($link_back); ?>"><-- Back to Village</a>
</div>
<?php foreach ($buildings as $row): ?>
	<div class="building_list_data">
		<div class="left">
			<div class="cost">
				<div class="cost_icon">
		        		D:
				</div>
				<div class="cost_building_list">
					<?=timespan(time(), (time() + $row['time_to_build'])); ?>
				</div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					F:
				</div>
			        <div class="cost_building_list">
		        		<?=$row['cost_food']; ?>
			        </div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					W:
				</div>
	        		<div class="cost_building_list">
		        	        <?=$row['cost_wood']; ?>
        			</div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					S:
				</div>
			        <div class="cost_building_list">
	        		        <?=$row['cost_stone']; ?>
			        </div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					I:
				</div>
        			<div class="cost_building_list">
			        	<?=$row['cost_iron']; ?>
        			</div>
			</div>
			<div class="cost">
				<div class="cost_icon">
					M:
				</div>
			        <div class="cost_building_list">
	        		        <?=$row['cost_mana']; ?>
				</div>
			</div>
			<div class="nofloat"></div>
		        <div class="research_description">
				<?=$row['name']; ?>: (<?=$row['description']; ?>)
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
</div>
