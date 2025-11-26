<?php
/**
 * @file
 * Theme functions and preprocessing for the theme.
 */

// Constants
define('THIRDWING_ACCESS_VOCABULARY_ID', 4);

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
    return '<div id="breadcrumb">' . implode(' › ', $breadcrumb) . '</div>';
  }
}

/**
 * Override or insert PHPTemplate variables into the page templates.
 *
 * @param array $vars
 *   Template variables.
 * @param string $hook
 *   The hook being preprocessed.
 */
function phptemplate_preprocess_page(&$vars, $hook) {
  global $user;
  
  $body_classes = array($vars['body_classes']);
  
  // Load node if on node page
  if (arg(0) == 'node' && is_numeric(arg(1))) {
    if (!isset($vars['node']) || !$vars['node']) {
      $vars['node'] = node_load(arg(1));
    }
  }
  
  // Add secondary tabs
  $vars['tabs2'] = menu_secondary_local_tasks();
  
  // Only process if we have a valid node
  if (isset($vars['node']) && is_object($vars['node']) && !empty($vars['node']->nid)) {
    $node = $vars['node'];
    
    // Add taxonomy classes
    if (module_exists('taxonomy')) {
      $terms = taxonomy_node_get_terms($node);
      foreach ($terms as $term) {
        $body_classes[] = 'taxonomy-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($term->name));
      }
    }
    
    // Add hero class for sticky nodes with images
    if (!empty($node->field_afbeeldingen[0]['filepath']) && $node->sticky) {
      $body_classes[] = 'node-hero';
      $vars['hero'] = $node->field_afbeeldingen[0]['filepath'];
    }
    
    // Add hero class for activity nodes with backgrounds
    if (!empty($node->field_background[0]['filepath']) && $node->type == 'activiteit') {
      $body_classes[] = 'node-hero';
      $vars['hero'] = $node->field_background[0]['filepath'];
    }
    
    // Add node type class
    $body_classes[] = 'node-type-' . $node->type;
  }
  
  // Add user role classes
  if ($user->uid && !empty($user->roles)) {
    foreach ($user->roles as $role) {
      $body_classes[] = 'role-' . str_replace(' ', '-', strtolower($role));
    }
  }
  
  // Combine all body classes
  $vars['body_classes'] = implode(' ', array_unique($body_classes));
}

/**
 * Preprocess node variables.
 *
 * @param array $vars
 *   Template variables.
 */
function phptemplate_preprocess_node(&$vars) {
  $node = $vars['node'];
  
  // Add taxonomy classes and badges
  if (module_exists('taxonomy') && !empty($node->nid)) {
    _phptemplate_add_taxonomy_classes($vars);
  }
  
  // Add hero classes
  if (!empty($node->field_afbeeldingen[0]['filepath']) && $node->sticky) {
    $vars['node_classes'] .= ' node-hero';
  }
  
  if (!empty($node->field_background[0]['filepath']) && $node->type == 'activiteit') {
    $vars['node_classes'] .= ' node-hero';
  }
  
  // Add content-type specific classes
  switch ($node->type) {
    case 'activiteit':
      _phptemplate_add_activity_classes($vars);
      break;
    
    case 'profiel':
      _phptemplate_add_profile_classes($vars);
      break;
      
    case 'programma':
      _phptemplate_add_programma_classes($vars);
      break;
  }
}

/**
 * Helper function to add taxonomy classes and badges.
 *
 * @param array $vars
 *   Template variables passed by reference.
 */
function _phptemplate_add_taxonomy_classes(&$vars) {
  static $access_labels;
  
  if (!isset($access_labels)) {
    $access_labels = array(
      'Bezoekers' => 'BEZ',
      'Vrienden' => 'VRI',
      'Aspirant-Leden' => 'ASP',
      'Leden' => 'LED',
      'Bestuur' => 'BES',
      'Muziekcommissie' => 'MC',
      'Concertcommissie' => 'CC',
      'Commissie Interne Relaties' => 'IR',
      'Commissie Koorregie' => 'REG',
      'Feestcommissie' => 'FC',
      'Band' => 'BAN',
      'Beheer' => 'BEH',
    );
  }
  
  $node = $vars['node'];
  $term_divs = array();
  $terms = taxonomy_node_get_terms($node);
  
  foreach ($terms as $term) {
    $class = preg_replace('/[^a-zA-Z0-9-]+/', '-', strtolower($term->name));
    $vars['node_classes'] .= ' taxonomy-' . $class;
    
    // Only create badges for access level vocabulary
    if ($term->vid == THIRDWING_ACCESS_VOCABULARY_ID && isset($access_labels[$term->name])) {
      $class_short = $access_labels[$term->name];
      $term_divs[] = '<span class="badge-access badge-access-' . $class . '" title="Zichtbaar voor ' . check_plain($term->name) . '">' . $class_short . '</span>';
    }
  }
  
  if (!empty($term_divs)) {
    $vars['taxonomy_term_divs'] = '<div class="badge-access-wrapper">' . implode("\n", $term_divs) . '</div>';
  }
}

/**
 * Helper function to add activity-specific classes.
 *
 * @param array $vars
 *   Template variables passed by reference.
 */
function _phptemplate_add_activity_classes(&$vars) {
  $node = $vars['node'];
  
  // Add class based on field_activiteit_status select key
  if (!empty($node->field_activiteit_status[0]['value'])) {
    $status_key = $node->field_activiteit_status[0]['value'];
    $vars['node_classes'] .= ' node-status-' . $status_key;
  }
  
   // Add class based on field_activiteit_soort
  if (!empty($node->field_activiteit_soort[0]['value'])) {
    $soort_value = preg_replace('/[^a-zA-Z0-9-]+/', '-', strtolower($node->field_activiteit_soort[0]['value']));
    $vars['node_classes'] .= ' activiteit-' . $soort_value;
  }
}

/**
 * Helper function to add profile-specific classes.
 *
 * @param array $vars
 *   Template variables passed by reference.
 */
function _phptemplate_add_profile_classes(&$vars) {
  $node = $vars['node'];
  
  // Add class based on field_koor (choir function)
  if (!empty($node->field_koor[0]['value'])) {
    $vars['node_classes'] .= ' persoon-' . $node->field_koor[0]['value'];
  }
  
  // Add class based on field_positie (position)
  if (!empty($node->field_positie[0]['value'])) {
    $vars['node_classes'] .= ' persoon-positie-' . $node->field_positie[0]['value'];
  }
  
  // Add class based on field_positie_rij (row position)
  if (!empty($node->field_positie_rij[0]['value'])) {
    $vars['node_classes'] .= ' persoon-positie-' . $node->field_positie_rij[0]['value'];
  }
  
  // Add class based on field_positie_kolom (column position)
  if (!empty($node->field_positie_kolom[0]['value'])) {
    $vars['node_classes'] .= ' persoon-positie-' . $node->field_positie_kolom[0]['value'];
  }
  
  // Add classes based on author's roles
  if (!empty($node->uid)) {
    $author = user_load($node->uid);
    if ($author && !empty($author->roles)) {
      foreach ($author->roles as $rid => $role_name) {
        $role_class = preg_replace('/[^a-zA-Z0-9-]+/', '-', strtolower($role_name));
        $vars['node_classes'] .= ' persoon-groep-' . $role_class;
      }
    }
  }
}

/**
 * Helper function to add programma-specific classes.
 *
 * @param array $vars
 *   Template variables passed by reference.
 */
function _phptemplate_add_programma_classes(&$vars) {
  $node = $vars['node'];
  
   // Add class based on field_prog_type
  if (!empty($node->field_prog_type[0]['value'])) {
    $soort_value = preg_replace('/[^a-zA-Z0-9-]+/', '-', strtolower($node->field_prog_type[0]['value']));
    $vars['node_classes'] .= ' programma-' . $soort_value;
  }
}

/**
 * Returns the rendered local tasks.
 *
 * Overridden to show only primary tasks.
 *
 * @return string
 *   Rendered primary local tasks.
 */
function phptemplate_menu_local_tasks() {
  return menu_primary_local_tasks();
}

/**
 * Theme function for date all day label.
 *
 * @return string
 *   Empty string to hide the label.
 */
function phptemplate_date_all_day_label() {
  return '';
}

/**
 * Theme function for FileField files.
 *
 * @param array $file
 *   File array.
 * @return string
 *   Formatted file output.
 */
function phptemplate_filefield_file($file) {
  // Views may call this function with a NULL value
  if (empty($file['fid'])) {
    return '';
  }

  $url = file_create_url($file['filepath']);
  $icon = theme('filefield_icon', $file);

  // Set options for the link
  $options = array(
    'attributes' => array(
      'type' => $file['filemime'] . '; length=' . $file['filesize'],
    ),
  );

  // Use the description as the link text if available
  if (empty($file['data']['description'])) {
    $link_text = $file['filename'];
  }
  else {
    $link_text = $file['data']['description'];
    $options['attributes']['title'] = $file['filename'];
  }

  // Open files of particular mime types in new window
  $new_window_mimetypes = array('application/pdf', 'text/plain');
  if (in_array($file['filemime'], $new_window_mimetypes)) {
    $options['attributes']['target'] = '_blank';
  }

  return '<div class="filefield-file clear-block">' . $icon . l($link_text, $url, $options) . '</div>';
}

/**
 * Theme function for radio buttons with custom styling.
 *
 * @param array $element
 *   Form element array.
 * @return string
 *   Themed radio button.
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
 * Theme function for checkboxes with custom styling.
 *
 * @param array $element
 *   Form element array.
 * @return string
 *   Themed checkbox.
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
 * Theme function for select elements with custom styling.
 *
 * @param array $element
 *   Form element array.
 * @return string
 *   Themed select element.
 */
function phptemplate_select($element) {
  _form_set_class($element, array('form-select'));
  
  $size = $element['#size'] ? ' size="' . $element['#size'] . '"' : '';
  $multiple = $element['#multiple'];
  $name = $element['#name'] . ($multiple ? '[]' : '');
  $multiple_attr = $multiple ? ' multiple="multiple"' : '';
  
  $select = '<select name="' . $name . '"' . $multiple_attr . drupal_attributes($element['#attributes']) . ' id="' . $element['#id'] . '"' . $size . '>';
  $select .= form_select_options($element);
  $select .= '</select>';
  
  return theme('form_element', $element, '<div class="select">' . $select . '<div class="select__arrow"></div></div>');
}