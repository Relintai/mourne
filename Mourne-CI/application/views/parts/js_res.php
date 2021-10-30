<?php if ($resources): ?>
<div id="js_resource">
<script>
var resData = [<?=$resources['food']; ?>, <?=$resources['wood']; ?>, <?=$resources['stone']; ?>,
    <?=$resources['iron']; ?>, <?=$resources['mana']; ?>];
var resMaxData = [<?=$resources['max_food']; ?>, <?=$resources['max_wood']; ?>, 
    <?=$resources['max_stone']; ?>, <?=$resources['max_iron']; ?>, <?=$resources['max_mana']; ?>];
var resTickData = [<?=$resources['rate_food']; ?>, <?=$resources['rate_wood']; ?>, 
    <?=$resources['rate_stone']; ?>, <?=$resources['rate_iron']; ?>, <?=$resources['rate_mana']; ?>];
var resTimerTick = <?=$resources['timer_tick']; ?>;
</script>
</div>
<?php endif; ?>