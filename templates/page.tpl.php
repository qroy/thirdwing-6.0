<?php
// $Id: page.tpl.php,v 1.18.2.1 2009/04/30 00:13:31 goba Exp $
  phptemplate_comment_wrapper(NULL, $node->type); 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <?php print $styles ?>

    <!--[if lt IE 7]>
      <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
    <link rel="apple-touch-icon" href="<?php print base_path() . path_to_theme() ?>/images/apple-touch-icon.png" />
      <script src="https://code.jquery.com/jquery-latest.min.js"></script>
      <script type="text/javascript"> 
        var $jq = jQuery.noConflict(); 
      </script> 
      <?php print $scripts ?>
        <script>
	$jq( function()
	{
		$( '#nav li:has(ul)' ).doubleTapToGo();
	});
</script>
  </head>
  <body class="<?php print $body_classes; ?>">

<!-- Layout -->
    <div id="wrapper">
    <div id="container" class="container clear-block">
<div id="topbar">
      <?php print $topbar; ?>

      </div>
      <div id="header">
      <div id="logo">
          <?php if ($logo): ?><div id="logo-img"></div><?php endif; ?>
          <?php if ($site_name): ?><div id="logo-title"><?php print $site_name; ?></div><?php endif; ?>
          <?php if ($site_slogan): ?><div id="logo-slogan"><?php print $site_slogan; ?></div><?php endif; ?>
      </div> <!-- /logo -->
      <nav id="nav" role="navigation"><?php print $header; ?></nav>
      </div> <!-- /header -->

      <?php if ($left): ?>
        <div id="sidebar-left" class="sidebar">
          <?php if ($search_box): ?><div class="block block-theme"><?php print $search_box ?></div><?php endif; ?>
          <?php print $left ?>
        </div>
      <?php endif; ?>

      <div id="center"><div id="squeeze"><div class="left-corner">
          <?php print $breadcrumb; ?>
          <?php if ($tabs): print '<div id="tabs"><ul class="tabs primary">'. $tabs .'</ul>'; endif; ?>
          <?php if ($tabs): print '</div>'; endif; ?>
          <?php if ($mission): print '<div id="mission">'. $mission .'</div>'; endif; ?>
          <?php if ($title): print '<h1>'. $title .'</h1>'; endif; ?>
          <?php if ($tabs2): print '<div id="tabs2"><ul class="tabs secondary">'. $tabs2 .'</ul></div>'; endif; ?>
          <div class="clear-block"></div>
          <?php if ($show_messages && $messages): print $messages; endif; ?>
          <?php if (arg(0) == 'node' || arg(0) == 'taxonomy' || arg(0) == 'image') :
global $user;
$user_roles = array_keys($user->roles);
if (in_array(6, $user_roles) || in_array(12, $user_roles)) {
  print '<span class="admininfo dontprint"><strong>Link hierheen:</strong> internal:' . $_GET['q'] . ' - http://www.thirdwing.nl/' . $_GET['q'] . '</span>';
}
endif; ?><?php print $help; ?>
          <div class="clear-block">
            <?php print $content ?>
          </div>
          <?php print $feed_icons ?>
      </div></div></div> <!-- /.left-corner, /#squeeze, /#center -->

      <?php if ($right): ?>
        <div id="sidebar-right" class="sidebar">
          <?php if (!$left && $search_box): ?><div class="block block-theme"><?php print $search_box ?></div><?php endif; ?>
          <?php print $right ?>
        </div>
      <?php endif; ?>

    </div> <!-- /container -->

<div id="footer"><div class="container"><?php print $footer_message ?><?php print $footer ?></div></div>

  </div><!-- /wrapper -->

  <?php print $closure ?>
  </body>
</html>
