<div id="node-<?php print $node->nid; ?>" class="node<?php if ($page == 0) { print ' teaser'; } ?><?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?><?php print ' type_' . $node->type; print $node_classes; ?> <?php print $zebra ?>">

  <div class="content">

   <?php if ($page == 0): ?><strong><?php print $title ?></strong><?php endif; ?>
   <?php print $content ?>
   <div class="clear-block clear"></div>
  </div>

</div>