<div class="hero_container">
<?php if (isset($message) && !($message === TRUE || $message === FALSE)): ?>
<div class="hero_message">
  <?=$message; ?>
</div>
<?php endif; ?>
<div class="hero_inventory_container">
  <div class="left">
     <?=$equipment; ?>
  </div>
  <div class="right">
     <?=$inventory; ?>
  </div>
</div>
</div>







