<?php
$this->load->helper('url');

$style_menu = 'css/menu.css';
$style_base = 'css/base.css';
$style_admin_panel = 'css/admin.css';
$style_mail = 'css/mail.css';
$style_hero = 'css/hero.css';

$js_res = 'js/resource.js';
?>
<!DOCTYPE html> 
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="RPG browsergame">
<meta name="keywords" content="RPG,browsergame,Mourne,game,play">
<meta name="author" content="Verot">
<title>Mourne</title>
<link rel="stylesheet" type="text/css" href="<?=base_url($style_base); ?>">
<link rel="stylesheet" type="text/css" href="<?=base_url($style_menu); ?>">
<?php if (isset($hero)): ?>
<link rel="stylesheet" type="text/css" href="<?=base_url($style_hero); ?>">
<?php endif; ?>
<?php if ($userlevel > 2): ?>
	<link rel="stylesheet" type="text/css" href="<?=base_url($style_admin_panel); ?>">
<?php endif; ?>
<?php if ($page == 'mail'): ?>
	<link rel="stylesheet" type="text/css" href="<?=base_url($style_mail); ?>">
<?php endif; ?>
<?php if ($resources): ?>
	<script src="<?=base_url($js_res); ?>"></script>
<?php endif; ?>
</head>
<body>