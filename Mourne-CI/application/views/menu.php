<?php $this->load->helper('url'); ?>
<?php
$menu_news = 'news/index';
$menu_mail = 'mail/inbox';
$menu_hero = 'hero/selected';
$menu_village = 'village/selected';
$menu_select_village = 'village/select';
$menu_alliance = 'alliance/current';
$menu_alliance_menu = 'alliance/alliance_menu';
$menu_forum = 'forum/index';
$menu_changelog = 'changelog/show';
$menu_settings = 'user/settings';
$menu_logout = 'user/logout';

if (!isset($villagename))
  $villagename = 'Village';

if (!$villagename)
  $villagename = 'Village';

if (!isset($alliancename))
  $alliancename = FALSE;

$link_forum_mod = 'forummod/mod_panel';
$link_gm = 'gm/gm_panel';
$link_admin = 'admin/admin_panel';

$create_v = 'village/create_village';
?>
<?php if ($weather): ?>
<div class="menu_base <?=$weather['css']; ?>">
<?php else: ?>
<div class="menu_base">
<?php endif; ?>
<div class="left">
<div class="menu_news">
	<a href="<?=site_url($menu_news); ?>">News</a>
</div>
<div class="menu_mail">
  <a href="<?=site_url($menu_mail); ?>">Mails<?php if ($newmail) echo '!'; ?></a>
</div>
<div class="menu_hero">
	<a href="<?=site_url($menu_hero); ?>">Hero</a>
</div>
<div class="menu_village">
	<a href="<?=site_url($menu_village); ?>"><?=$villagename; ?></a>
</div>
<div class="menu_sel_village">
	<a href="<?=site_url($menu_select_village); ?>">v</a>
</div>
<?php if ($alliancename): ?>
<div class="menu_alliance">
  <a href="<?=site_url($menu_alliance); ?>">[<?=$alliancename; ?>]</a>
</div>
<?php endif; ?>
<?php if ($weather): ?>
<div class="weather">
<abbr title="<?=$weather['description']; ?>"><?=$weather['name']; ?></abbr>
</div>
<?php endif; ?>
</div>
<div class="right">
<?php if ($userlevel > 4): ?>
<div class="menu_gm">
<a href="<?=site_url($link_gm); ?>">GM</a>
</div>
<?php endif; ?>
<?php if ($userlevel > 5): //dev+?>
<div class="menu_admin">
<a href="<?=site_url($link_admin); ?>">Admin</a>
</div>
<?php endif; ?>
<div class="menu_alliance_menu">
	<a href="<?=site_url($menu_alliance_menu); ?>">Alliances</a>
</div>
<div class="menu_forum">
	<a href="<?=site_url($menu_forum); ?>">Forum</a>
</div>
<div class="menu_settings">
	<a href="<?=site_url($menu_settings); ?>">Settings</a>
</div>
<div class="menu_logout">
	<a href="<?=site_url($menu_logout); ?>">Logout</a>
</div>
</div>
<div class="nofloat"></div>
</div>
<div class="main">