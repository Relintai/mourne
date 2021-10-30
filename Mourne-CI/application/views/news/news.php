<p>news placeholder lawl</p>
<br />
<?php $this->load->helper('url'); ?>
<?php if ($admin): ?>
<a href="<?=site_url('news/add'); ?>">Add New</a>
<?php endif; ?>

<br />
<?php foreach ($news as $f): ?>
<?php if ($admin): ?>
<?php $a = 'news/delete/' + $f['id'] ?>
<a href="<?=site_url($a); ?>">Delete</a>
<?php $a = 'news/edit/' + $f['id'] ?>
<a href="<?=site_url($a); ?>">Edit</a><br />
<?php endif; ?>
writer: <?=$f['written_by']; ?><br />
text: <?=$f['text']; ?><br />
<?php endforeach; ?>

<?php //TODO: pagination here ?>
