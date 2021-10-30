<?php
$this->load->helper('url');

$link_inbox = 'mail/inbox';
$link_new = 'mail/compose';
$link_drafts = 'mail/drafts';
$link_sent = 'mail/sent';
$link_friends = 'mail/friends';

?>
<div class="mail_menu_container">
<div class="mail_menu">
<div class="mail_menuentry_first">
<a href="<?=site_url($link_inbox); ?>">Inbox</a> 
</div>
<div class="mail_menuentry">
<a href="<?=site_url($link_new); ?>">New</a>
</div>
<div class="mail_menuentry">
<a href="<?=site_url($link_drafts); ?>">Drafts</a> 
</div>
<div class="mail_menuentry">
<a href="<?=site_url($link_sent); ?>">Sent</a> 
</div>
<div class="mail_menuentry">
<a href="<?=site_url($link_friends); ?>">Friends</a> 
</div>
</div>
</div>