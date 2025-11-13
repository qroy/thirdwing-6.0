<?php
/**
 * @file
 * Theme functions and preprocessors for the theme.
 */

/**
 * Return a themed breadcrumb trail.
 *
 * @param array $breadcrumb
 *   An array containing the breadcrumb links.
 * @return string
 *   A string containing the breadcrumb output.
 */
function phptemplate_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    return '<div class="breadcrumb">' . implode(' › ', $breadcrumb) . '</div>';
  }
}

/**
 * Allow themable wrapping of all comments.
 *
 * @param string $content
 *   The comment content.
 * @param object $node
 *   The node object.
 * @return string
 *   The wrapped comment output.
 */
function phptemplate_comment_wrapper($content, $node) {
  if (!$content || $node->type == 'forum') {
    return '<div id="comments">' . $content . '</div><a name="comments"></a>';
  }
  else {
    return '<div id="comments"><h2 class="comments">' . t('Comments') . '</h2>' . $content . '</div><a name="comments"></a>';
  }
}

/**
 * Preprocess variables for page templates.
 *
 * @param array &$vars
 *   An array of variables to pass to the theme template.
 * @param string $hook
 *   The name of the template being rendered.
 */
function phptemplate_preprocess_page(&$vars, $hook) {
  $body_classes = array($vars['body_classes']);

  // Load node if on a node page
  if ((arg(0) == 'node') && (is_numeric(arg(1)))) {
    if (!$vars['node']) {
      $vars['node'] = node_load(arg(1));
    }
  }

  // Add secondary tabs
  $vars['tabs2'] = menu_secondary_local_tasks();

  // Add taxonomy-based body classes
  if (module_exists('taxonomy') && !empty($vars['node']->nid)) {
    foreach (taxonomy_node_get_terms($vars['node']) as $term) {
      // Use preg_replace instead of deprecated eregi_replace
      $body_classes[] = 'taxonomy-' . preg_replace('/[^a-z0-9]/i', '-', strtolower($term->name));
    }
  }

  // Add hero class for sticky nodes with images
  if (!empty($vars['node']->field_afbeeldingen[0]['filepath']) && $vars['node']->sticky) {
    $body_classes[] = 'hero';
    $vars['hero'] = $vars['node']->field_afbeeldingen[0]['filepath'];
  }

  // Add hero class for activities with background images
  if (!empty($vars['node']->field_background[0]['filepath']) && $vars['node']->type == 'activiteit') {
    $body_classes[] = 'hero';
    $vars['hero'] = $vars['node']->field_background[0]['filepath'];
  }

  // Add node type class
  if (!empty($vars['node']->type)) {
    $body_classes[] = 'node-type-' . $vars['node']->type;
  }

  // Update body classes variable
  $vars['body_classes'] = implode(' ', $body_classes);
}

/**
 * Preprocess variables for node templates.
 *
 * @param array &$vars
 *   An array of variables to pass to the theme template.
 */
function phptemplate_preprocess_node(&$vars) {
  // Add taxonomy-based node classes
  if (module_exists('taxonomy') && !empty($vars['node']->nid)) {
    foreach (taxonomy_node_get_terms($vars['node']) as $term) {
      // Use preg_replace instead of deprecated eregi_replace
      $vars['node_classes'] .= ' taxonomy-' . preg_replace('/[^a-z0-9]/i', '-', strtolower($term->name));
    }
  }

  // Add status class for activity nodes
  if ($vars['node']->type == 'activiteit') {
    if (!empty($vars['node']->field_activiteit_status[0]['value'])) {
      $status_key = $vars['node']->field_activiteit_status[0]['value'];
      $vars['node_classes'] .= ' node-status-' . $status_key;
    }
    
    // Add class based on field_activiteit_soort
    if (!empty($vars['node']->field_activiteit_soort[0]['value'])) {
      $soort_value = preg_replace('/[^a-zA-Z0-9-]+/', '-', strtolower($vars['node']->field_activiteit_soort[0]['value']));
      $vars['node_classes'] .= ' activiteit-' . $soort_value;
    }
  }
}

/**
 * Returns the rendered local tasks.
 *
 * The default implementation renders them as tabs.
 * Overridden to split the secondary tasks.
 *
 * @return string
 *   The rendered local tasks.
 */
function phptemplate_menu_local_tasks() {
  return menu_primary_local_tasks();
}

/**
 * Theme the submitted by information for comments.
 *
 * @param object $comment
 *   The comment object.
 * @return string
 *   The formatted submission information.
 */
function phptemplate_comment_submitted($comment) {
  return t('Geplaatst op !datetime door !username', array(
    '!username' => theme('username', $comment),
    '!datetime' => format_date($comment->timestamp),
  ));
}

/**
 * Theme the submitted by information for nodes.
 *
 * @param object $node
 *   The node object.
 * @return string
 *   The formatted submission information.
 */
function phptemplate_node_submitted($node) {
  return t('Geplaatst op !datetime door !username', array(
    '!username' => theme('username', $node),
    '!datetime' => format_date($node->created),
  ));
}

/**
 * Generates IE CSS links for LTR and RTL languages.
 *
 * @return string
 *   The IE-specific CSS link tag.
 */
function phptemplate_get_ie_styles() {
  $iecss = '<link type="text/css" rel="stylesheet" media="all" href="' . base_path() . path_to_theme() . '/css/fix-ie.css" />';
  return $iecss;
}

/**
 * Theme the all day label for date fields.
 *
 * @return string
 *   An empty string to hide the all day label.
 */
function phptemplate_date_all_day_label() {
  return '';
}

/**
 * Theme a file field item.
 *
 * @param array $file
 *   An array containing file information.
 * @return string
 *   The themed file field output.
 */
function phptemplate_filefield_file($file) {
  // Views may call this function with a NULL value, return an empty string.
  if (empty($file['fid'])) {
    return '';
  }

  $path = $file['filepath'];
  $url = file_create_url($path);
  $icon = theme('filefield_icon', $file);

  // Set options for the link
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

  // Open files of particular mime types in new window
  $new_window_mimetypes = array(
    'application/pdf',
    'text/plain',
  );
  if (in_array($file['filemime'], $new_window_mimetypes)) {
    $options['attributes']['target'] = '_blank';
  }

  return '<div class="filefield-file clear-block">' . $icon . l($link_text, $url, $options) . '</div>';
}

/**
 * Theme a radio button form element.
 *
 * @param array $element
 *   The form element array.
 * @return string
 *   The themed radio button.
 */
function phptemplate_radio($element) {
  _form_set_class($element, array('form-radio'));
  
  $output = '<input type="radio" ';
  $output .= 'id="' . $element['#id'] . '" ';
  $output .= 'name="' . $element['#name'] . '" ';
  $output .= 'value="' . $element['#return_value'] . '" ';
  $output .= (check_plain($element['#value']) == $element['#return_value']) ? ' checked="checked" ' : '';
  $output .= drupal_attributes($element['#attributes']) . ' />';
  
  if (!is_null($element['#title'])) {
    $output = '<label class="option" for="' . $element['#id'] . '">' . $output . '<div class="option__indicator"></div> ' . $element['#title'] . '</label>';
  }

  unset($element['#title']);
  return theme('form_element', $element, $output);
}

/**
 * Theme a checkbox form element.
 *
 * @param array $element
 *   The form element array.
 * @return string
 *   The themed checkbox.
 */
function phptemplate_checkbox($element) {
  _form_set_class($element, array('form-checkbox'));
  
  $checkbox = '<input ';
  $checkbox .= 'type="checkbox" ';
  $checkbox .= 'name="' . $element['#name'] . '" ';
  $checkbox .= 'id="' . $element['#id'] . '" ';
  $checkbox .= 'value="' . $element['#return_value'] . '" ';
  $checkbox .= $element['#value'] ? ' checked="checked" ' : '';
  $checkbox .= drupal_attributes($element['#attributes']) . ' />';

  if (!is_null($element['#title'])) {
    $checkbox = '<label class="option" for="' . $element['#id'] . '">' . $checkbox . '<div class="option__indicator"></div> ' . $element['#title'] . '</label>';
  }

  unset($element['#title']);
  return theme('form_element', $element, $checkbox);
}

/**
 * Theme a select form element.
 *
 * @param array $element
 *   The form element array.
 * @return string
 *   The themed select element.
 */
function phptemplate_select($element) {
  $size = $element['#size'] ? ' size="' . $element['#size'] . '"' : '';
  _form_set_class($element, array('form-select'));
  $multiple = $element['#multiple'];
  
  $select = '<div class="select">';
  $select .= '<select name="' . $element['#name'] . ($multiple ? '[]' : '') . '"';
  $select .= ($multiple ? ' multiple="multiple"' : '');
  $select .= drupal_attributes($element['#attributes']);
  $select .= ' id="' . $element['#id'] . '"';
  $select .= $size . '>';
  $select .= form_select_options($element);
  $select .= '</select>';
  $select .= '<div class="select__arrow"></div>';
  $select .= '</div>';
  
  return theme('form_element', $element, $select);
}