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
function phptemplate_preprocess_page(&$vars, $hook) {

  $body_classes = array($vars['body_classes']);

  if ((arg(0) == 'node') && (is_numeric(arg(1)))) {
    if (!$vars['node']) $vars['node'] = node_load(arg(1));
  }

  $vars['tabs2'] = menu_secondary_local_tasks(); 

  if (module_exists('taxonomy') && $vars['node']->nid) {
    foreach (taxonomy_node_get_terms($vars['node']) as $term) {
      $body_classes[] = 'taxonomy-' . eregi_replace('[^a-z0-9]', '-', $term->name);
    }
  }

  if ($vars['node']->field_afbeeldingen[0]['filepath'] && $vars['node']->sticky) {
    $body_classes[] = 'hero';
    $vars['hero'] = $vars['node']->field_afbeeldingen[0]['filepath'];
  }
  if ($vars['node']->field_background[0]['filepath'] && $vars['node']->type == 'activiteit') {
    $body_classes[] = 'hero';
    $vars['hero'] = $vars['node']->field_background[0]['filepath'];
  }
  $body_classes[] = 'node-type-' . $vars['node']->type;

  // Add new body classes to existing variable
  $vars['body_classes'] = implode(' ', $body_classes);


}
function phptemplate_preprocess_node(&$vars) {
  if (module_exists('taxonomy') && $vars['node']->nid) {
    foreach (taxonomy_node_get_terms($vars['node']) as $term) {
      $vars['node_classes'] = $vars['node_classes'] . ' taxonomy-' . eregi_replace('[^a-z0-9]', '-', $term->name);
    }
  }
  if ($vars['node']->type == 'activiteit') {
    // Add class based on field_activiteit_status select key
    if (!empty($vars['node']->field_activiteit_status[0]['value'])) {
      $status_key = $vars['node']->field_activiteit_status[0]['value'];
      $vars['node_classes'] .= ' node-status-' . $status_key;
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

function phptemplate_filefield_file($file) {
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

function phptemplate_radio($element) {
  _form_set_class($element, array('form-radio'));
  $output = '<input type="radio" ';
  $output .= 'id="' . $element['#id'] . '" ';
  $output .= 'name="' . $element['#name'] . '" ';
  $output .= 'value="' . $element['#return_value'] . '" ';
  $output .= (check_plain($element['#value']) == $element['#return_value']) ? ' checked="checked" ' : ' ';
  $output .= drupal_attributes($element['#attributes']) . ' />';
  if (!is_null($element['#title'])) {
    $output = '<label class="option" for="' . $element['#id'] . '">' . $output . '<div class="option__indicator"></div> ' . $element['#title'] . '</label>';
  }

  unset($element['#title']);
  return theme('form_element', $element, $output);
}
function phptemplate_checkbox($element) {
  _form_set_class($element, array('form-checkbox'));
  $checkbox = '<input ';
  $checkbox .= 'type="checkbox" ';
  $checkbox .= 'name="' . $element['#name'] . '" ';
  $checkbox .= 'id="' . $element['#id'] . '" ';
  $checkbox .= 'value="' . $element['#return_value'] . '" ';
  $checkbox .= $element['#value'] ? ' checked="checked" ' : ' ';
  $checkbox .= drupal_attributes($element['#attributes']) . ' />';

  if (!is_null($element['#title'])) {
    $checkbox = '<label class="option" for="' . $element['#id'] . '">' . $checkbox . '<div class="option__indicator"></div> ' . $element['#title'] . '</label>';
  }

  unset($element['#title']);
  return theme('form_element', $element, $checkbox);
}
function phptemplate_select($element) {
  $select = '';
  $size = $element['#size'] ? ' size="' . $element['#size'] . '"' : '';
  _form_set_class($element, array('form-select'));
  $multiple = $element['#multiple'];
  return theme('form_element', $element, '<div class="select"><select name="' . $element['#name'] . '' . ($multiple ? '[]' : '') . '"' . ($multiple ? ' multiple="multiple" ' : '') . drupal_attributes($element['#attributes']) . ' id="' . $element['#id'] . '" ' . $size . '>' . form_select_options($element) . '</select><div class="select__arrow"></div></div>');
}