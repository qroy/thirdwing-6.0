<?php
// $Id: page.tpl.php,v 1.18.2.1 2009/04/30 00:13:31 goba Exp $
  phptemplate_comment_wrapper(NULL, $node->type); 
  $date = format_date($node->changed, 'custom', 'l d F Y');
  $time = format_date($node->changed, 'custom', 'H:m');

  if ($node->changed):
  $last_updated = '<p>Pagina laatst aangepast op ' . $date . ' om ' . $time . '</p>';
  endif;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN"
  "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
<head profile="http://www.w3.org/1999/xhtml/vocab">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>

    <!--[if lt IE 7]>
      <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
    <link rel="apple-touch-icon" href="<?php print base_path() . path_to_theme() ?>/images/apple-touch-icon.png" />
      <script src="http://code.jquery.com/jquery-latest.min.js"></script>
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

<div id="top"></div>

<div id="wrapper">

  <div class="container clear-block"><div id="topbar"><?php print $topbar; ?></div></div>

  <div class="container clear-block">
  <div id="logo">
      <div id="logo-img"></div>
      <div id="logo-title"><?php print $site_name; ?></div>
  </div> <!-- /logo -->
  </div>

  <div class="clear-block container">
      
    <div id="header">
      <nav id="nav" role="navigation"><a href="#" class="toggle-nav icon icon-bars">Menu</a><?php print $header; ?></nav>
    </div> <!-- /header -->

    <?php if ($left): ?><div id="sidebar-left" class="sidebar"><?php print $left ?></div><?php endif; ?>

    <div id="center"><div id="squeeze">
      <div id="breadcrumb"><?php print $breadcrumb; ?></div>
      <?php if ($show_messages && $messages): print $messages; endif; ?>
      <?php print $help; ?>
      <?php if ($tabs): print '<div id="tabs-wrapper" class="clear-block"><a href="#" class="toggle-tabs icon icon-pencil-square-o">Bewerk</a><ul class="tabs primary">'. $tabs;
            if (arg(0) == 'node') :
            global $user; $user_roles = array_keys($user->roles);
            if (in_array(6, $user_roles) || in_array(12, $user_roles)) { print '<li><a href="' . $_GET['q'] . '">' . $_GET['q'] . '</a></li>'; }
            endif;
            print '</ul>'; endif;
            if ($tabs): print '</div>'; endif; 
      ?>
      <?php if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
      <?php if ($title): print '<h1>'. $title .'</h1>'; endif; ?>
      <div class="clear-block">
      <?php print $content ?>
      </div>
      <?php print $feed_icons ?>
    </div></div> <!-- /#squeeze, /#center -->

    <?php if ($right): ?><div id="sidebar-right" class="sidebar"><?php print $right ?></div><?php endif; ?>

  </div> <!-- /container -->

  <div id="footer"><div class="container clear-block"><?php print $last_updated ?><?php print $footer_message ?></div></div>

  <div id="to-top"><a href="#top" title="Terug naar boven"></a></div>

</div><!-- /wrapper -->

<?php print $closure ?>

</body>

<html>
