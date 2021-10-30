<?php if ($weather): ?>
<div class="weather">
<img title="<?=$weather['name']; ?> (<?=$weather['description']; ?>)" src="<?=$weather['art']; ?>"
  alt="<?=$weather['name']; ?> (<?=$weather['description']; ?>)">
</div>
<?php endif; ?>