<?php phptemplate_comment_wrapper(NULL, $node->type); ?>
<!DOCTYPE html>
<html lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
<head profile="http://www.w3.org/1999/xhtml/vocab">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php print $head ?>
<title><?php print $head_title ?></title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<?php print $styles ?>
<!--[if lt IE 7]><?php print phptemplate_get_ie_styles(); ?><![endif]-->
<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">var $jq = jQuery.noConflict();</script> 
<?php print $scripts ?>
<script>$jq( function() { $( '#menu-main li:has(ul)' ).doubleTapToGo(); });</script>
</head>
<body class="<?php print $body_classes; ?>">
<div id="top"></div>
<div id="page-wrapper">
<div id="page">
<header id="header" role="banner" class="layout-container clearfix">
<div id="menu-service"><?php print $topbar; ?></div>
<div id="logo">
<?php if ($logo): ?><div id="logo-img"></div><?php endif; ?>
<?php if ($site_name): ?><div id="logo-title"><?php print $site_name; ?></div><?php endif; ?>
<?php if ($site_slogan): ?><div id="logo-slogan"><?php print $site_slogan; ?></div><?php endif; ?>
</div>
<nav id="menu-main" role="navigation"><a href="#" class="toggle-nav fa fa-bars">Menu</a><?php print $header; ?></nav>
</header>
<div id="main-wrapper" class="layout-container clearfix">
<main id="main"><div id="main-squeeze">
<div id="breadcrumb"><?php print $breadcrumb; ?></div>
<?php if ($show_messages && $messages): print $messages; endif; ?>
<?php print $help; ?>
<?php if ($tabs): print '<div id="tabs-wrapper" class="clear-block"><a href="#" class="toggle-tabs fa fa-pencil-square-o">Bewerk</a><ul class="tabs primary">'. $tabs;
  if (arg(0) == 'node') :
  global $user; $user_roles = array_keys($user->roles);
  if (in_array(6, $user_roles) || in_array(12, $user_roles)) { print '<li><a href="' . $_GET['q'] . '">' . $_GET['q'] . '</a></li>'; }
  endif;
  print '</ul>'; endif;
  if ($tabs): print '</div>'; endif;
?>
<?php if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
<?php if ($title): print '<h1>'. $title .'</h1>'; endif; ?>
<?php print $content ?>
<?php print $feed_icons ?>
</div></main>
<?php if ($left): ?><aside role="complementary" id="sidebar-left" class="sidebar"><?php print $left ?></aside><?php endif; ?>
<?php if ($right): ?><aside role="complementary" id="sidebar-right" class="sidebar"><?php print $right ?></aside><?php endif; ?>
</div>
<footer id="footer"><div class="layout-container"><?php print $footer_message ?>
<div id="footer-left"><?php print $footerleft ?></div>
<div id="footer-right"><?php print $footerright ?></div>
</div></footer>
<div id="to-top"><a href="#top" title="Terug naar boven"></a></div>
</div></div>
<?php print $closure ?>
</body>
<html>