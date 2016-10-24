<?php
// $Id: template.php,v 1.16.2.1 2009/02/25 11:47:37 goba Exp $

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function phptemplate_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    return '<div class="breadcrumb">'. implode(' › ', $breadcrumb) .'</div>';
  }
}

/**
 * Allow themable wrapping of all comments.
 */
function phptemplate_comment_wrapper($content, $node) {
  if (!$content || $node->type == 'forum') {
    return '<div id="comments">'. $content .'</div><a name="comments"></a>';
  }
  else {
    return '<div id="comments"><h2 class="comments">'. t('Comments') .'</h2>'. $content .'</div><a name="comments"></a>';
  }
}

/**
 * Override or insert PHPTemplate variables into the templates.
 */
function thirdwing_22_preprocess_page(&$vars) {
  if ((arg(0) == 'node') && (is_numeric(arg(1)))) {
    if (!$vars['node']) $vars['node'] = node_load(arg(1));
  }
  $vars['tabs2'] = menu_secondary_local_tasks(); 
  if (module_exists('taxonomy') && $vars['node']->nid) {
    foreach (taxonomy_node_get_terms($vars['node']) as $term) {
      $vars['body_classes'] = $vars['body_classes'] . ' taxonomy-' . eregi_replace('[^a-z0-9]', '-', $term->name);
    }
  }
}
function thirdwing_22_preprocess_node(&$vars) {
  if (module_exists('taxonomy') && $vars['node']->nid) {
    foreach (taxonomy_node_get_terms($vars['node']) as $term) {
      $vars['node_classes'] = $vars['node_classes'] . ' taxonomy-' . eregi_replace('[^a-z0-9]', '-', $term->name);
    }
  }
}


/**
 * Returns the rendered local tasks. The default implementation renders
 * them as tabs. Overridden to split the secondary tasks.
 *
 * @ingroup themeable
 */
function phptemplate_menu_local_tasks() {
  return menu_primary_local_tasks();
}

function phptemplate_comment_submitted($comment) {
  return t('Geplaatst op !datetime door !username',
    array(
      '!username' => theme('username', $comment),
      '!datetime' => format_date($comment->timestamp)
    ));
}

function phptemplate_node_submitted($node) {
  return t('Geplaatst op !datetime door !username',
    array(
      '!username' => theme('username', $node),
      '!datetime' => format_date($node->created),
    ));
}

/**
 * Generates IE CSS links for LTR and RTL languages.
 */
function phptemplate_get_ie_styles() {
  global $language;

  $iecss = '<link type="text/css" rel="stylesheet" media="all" href="'. base_path() . path_to_theme() .'/css/fix-ie.css" />';

  return $iecss;
}

function phptemplate_date_all_day_label() {
  return '';
}

function thirdwing_22_filefield_file($file) {
  // Views may call this function with a NULL value, return an empty string.
  if (empty($file['fid'])) {
    return '';
  }

  $path = $file['filepath'];
  $url = file_create_url($path);
  $icon = theme('filefield_icon', $file);

  // Set options as per anchor format described at
  $options = array(
    'attributes' => array(
      'type' => $file['filemime'] . '; length=' . $file['filesize'],
    ),
  );

  // Use the description as the link text if available.
  if (empty($file['data']['description'])) {
    $link_text = $file['filename'];
  }
  else {
    $link_text = $file['data']['description'];
    $options['attributes']['title'] = $file['filename'];
  }

  //open files of particular mime types in new window
  $new_window_mimetypes = array(
    'application/pdf',
    'text/plain'
  );
  if (in_array($file['filemime'], $new_window_mimetypes)) {
    $options['attributes']['target'] = '_blank';
  }

  return '<div class="filefield-file clear-block">'. $icon . l($link_text, $url, $options) .'</div>';
}