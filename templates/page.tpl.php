<?php phptemplate_comment_wrapper(NULL, $node->type); ?>
<!DOCTYPE html>
<html lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
<head profile="http://www.w3.org/1999/xhtml/vocab">
<meta name="viewport" content="viewport-fit=cover, width=device-width, initial-scale=1.0">
<?php print $head ?>
<title><?php print $head_title ?></title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<?php if ($hero): print '<style>.page-bg { background-image: url(/' . $hero . '); }</style>'; endif; ?>
<?php print $styles ?>
<link rel="apple-touch-icon" href="<?php print base_path() . path_to_theme() ?>/images/apple-touch-icon.png" />
<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">var $jq = jQuery.noConflict();</script> 
<?php print $scripts ?>
</head>
<body class="<?php print $body_classes; ?>">
<div class="page-bg"></div>
<div class="page">
<header id="header" role="banner">
<div id="logo">
<?php if ($logo): ?><a href="/" title="Keer terug naar home"><div id="logo-img"></div><?php endif; ?>
<?php if ($site_name): ?><div id="logo-title"><?php print $site_name; ?></div><?php endif; ?>
<?php if ($logo): ?></a><?php endif; ?>
<?php if ($site_slogan): ?><div id="logo-slogan"><?php print $site_slogan; ?></div><?php endif; ?>
</div>
<nav id="menu-wrapper" role="navigation">
<div id="menu-main"><button aria-expanded="false" aria-controls="main-menu" aria-label="Toggle menu" class="menu-toggle button button-alt fa fa-bars">Menu</button><?php print $header; ?></div>
<div id="menu-service"><?php print $topbar; ?></div>
</nav>
</header>
<main id="main">
<?php if ($breadcrumb): print $breadcrumb; endif; ?>
<?php if ($mission): print '<div id="mission">'. $mission .'</div>'; endif; ?>
<?php if ($title): print '<h1>'. $title .'</h1>'; endif; ?>
<?php if ($tabs): print '<div id="menu-local"><button aria-expanded="false" aria-controls="local-menu" aria-label="Toggle menu" class="local-toggle button button-alt fa fa-cogs">Bewerk</button><ul class="tabs">'. $tabs .'</ul>'; endif; ?>
<?php if ($tabs2): print '<ul class="tabs">'. $tabs2 .'</ul>'; endif; ?>
<?php if ($tabs): print '</div>'; endif; ?>
<?php if ($show_messages && $messages): print $messages; endif; ?>
<?php print $help; ?>
<?php print $before_content ?>
<?php print $content ?>
<?php print $feed_icons ?>
</main>
<?php if ($left): ?><aside role="complementary" id="sidebar-left" class="sidebar"><?php print $left ?></aside><?php endif; ?>
<?php if ($right): ?><aside role="complementary" id="sidebar-right" class="sidebar"><?php print $right ?></aside><?php endif; ?>
<footer id="footer"><?php print $footer_message ?>
<?php print $footer ?>
</footer>
<div id="header-bg"></div>
<div id="footer-bg"></div>
</div>
<?php print $closure ?>
</body>
</html>
