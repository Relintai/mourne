changelog lawl!<br />
<?php 
$this->load->helper('date'); 
$datestring = '%y.%m.%d - %H:%i';
?>

<?php if ($userlevel > $required_userlevel):
	$this->load->helper('url'); 	

	$link_new_commit = 'changelog/add_new_commit';
	$link_new_version = 'changelog/add_new_version';
?>
	<a href="<?=site_url($link_new_commit); ?>">New Commit</a>  
	<a href="<?=site_url($link_new_version); ?>">New version</a><br />
<?php endif; ?>

<?php if ($versions && $commits): ?>
	<?php foreach ($versions as $i): ?>
		<div class="changelog">
		Version: <?=$i['version']; ?> <br />
		<?php foreach ($commits as $com): ?>
			<? if ($i['id'] == $com['versionid']): ?>
				(<?=mdate($datestring, $com['timestamp']); ?>) - <?=$com['text']; ?><br />
			<? endif; ?>
		<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	sorry, nothing here :(
<?php endif; ?>
