<?php
/**
 * @file
 * Theme functions - logic moved to thirdwing_modifications module.
 * 
 * Alternative version with comment wrapper function.
 */

/**
 * Allow themable wrapping of all comments.
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
 * Theme the submitted by information for comments.
 */
function phptemplate_comment_submitted($comment) {
  return t('Geplaatst op !datetime door !username', array(
    '!username' => theme('username', $comment),
    '!datetime' => format_date($comment->timestamp),
  ));
}

/**
 * Theme the submitted by information for nodes.
 */
function phptemplate_node_submitted($node) {
  return t('Geplaatst op !datetime door !username', array(
    '!username' => theme('username', $node),
    '!datetime' => format_date($node->created),
  ));
}

/**
 * Generates IE CSS links for LTR and RTL languages.
 */
function phptemplate_get_ie_styles() {
  return '<link type="text/css" rel="stylesheet" media="all" href="' . base_path() . path_to_theme() . '/css/fix-ie.css" />';
}
