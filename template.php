<?php
/**
 * @file
 * Theme functions - logic moved to thirdwing_modifications module.
 * 
 */

/**
 * Theme the submitted by information for nodes.
 */
function phptemplate_node_submitted($node) {
  return t('Geplaatst op !datetime door !username', array(
    '!username' => theme('username', $node),
    '!datetime' => format_date($node->created),
  ));
}