<!DOCTYPE html>
<html lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
<head profile="http://www.w3.org/1999/xhtml/vocab">

<?php print $head ?>
<title><?php print $head_title ?></title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<?php if ($hero): print '<style>#header { background-image: url(/' . $hero . '); }</style>'; endif; ?>
<?php print $styles ?>
<link rel="apple-touch-icon" href="<?php print base_path() . path_to_theme() ?>/images/apple-touch-icon.png" />
<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">var $jq = jQuery.noConflict();</script> 
<?php print $scripts ?>
<script>$jq( function() { $( '#menu-main li:has(ul)' ).doubleTapToGo(); });</script>
</head>
<body class="<?php print $body_classes; ?>">
<div id="top"></div>
<div id="page-wrapper">
<div id="page" class="layout-container clear-block">
<div id="menu-service"><?php print $topbar; ?></div>
<header id="header" role="banner">
<div id="logo">
<?php if ($logo): ?><div id="logo-img"><a href="/" title="Keer terug naar home"></a></div><?php endif; ?>
<?php if ($site_name): ?><div id="logo-title"><?php print $site_name; ?></div><?php endif; ?>
<?php if ($site_slogan): ?><div id="logo-slogan"><?php print $site_slogan; ?></div><?php endif; ?>
</div>
<nav id="menu-main" role="navigation"><a href="#" class="toggle-nav button button-x2 button-alt button-inline fa fa-bars">Menu</a><?php print $header; ?></nav>
</header>
<div id="grid"><main id="main">
<div id="breadcrumb"><?php print $breadcrumb; ?></div>
<?php if ($show_messages && $messages): print $messages; endif; ?>
<?php print $help; ?>
<div class="clear-block"></div>
<?php if ($tabs): print '<div id="tabs"><ul class="tabs primary">'. $tabs .'</ul>'; endif; ?>
<?php if ($tabs): print '</div>'; endif; ?>
<?php if ($mission): print '<div id="mission">'. $mission .'</div>'; endif; ?>
<?php if ($title): print '<h1>'. $title .'</h1>'; endif; ?>
<?php if ($tabs2): print '<div id="tabs2"><ul class="tabs secondary">'. $tabs2 .'</ul></div>'; endif; ?>
<div class="clear-block"><?php print $before_content ?><?php print $content ?></div>
<?php print $feed_icons ?>
</main>
<?php if ($left): ?><aside role="complementary" id="sidebar-left" class="sidebar"><?php print $left ?></aside><?php endif; ?>
<?php if ($right): ?><aside role="complementary" id="sidebar-right" class="sidebar"><?php print $right ?></aside><?php endif; ?>
</div>
</div>
<footer id="footer"><div class="layout-container"><?php print $footer_message ?>
<div id="footer-left"><?php print $footerleft ?></div>
<div id="footer-right"><?php print $footerright ?></div>
</div></footer>
<div id="to-top"><a href="#top" title="Terug naar boven"></a></div>
</div>
<?php print $closure ?>
</body>
</html>
