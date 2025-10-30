<?php

/**
 * @file
 * This template is optimized for use with the Node displays module.
 *
 * Differences with the default node.tpl.php
 *   - Uses only the $content variable.
 *   - Extra check on $sticky because this node might be build with another build mode.
 */
?>

<article id="node-<?php print $node->nid; ?>" class="node node-type-<?php print $node->type; ?><?php if (isset($node_classes)): print $node_classes; endif; ?><?php if ($sticky && $node->build_mode == 'sticky'): print ' sticky'; endif; ?><?php if (!$status): print ' node-unpublished'; endif; ?> buildmode-<?php print $node->build_mode; ?> clear-block"><?php print $content; ?><?php if ($content): print $taxonomy_term_divs; endif; ?></article>