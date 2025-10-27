<article id="node-<?php print $node->nid; ?>" class="node<?php if ($page == 0) { print ' teaser'; } ?><?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?><?php print ' type_' . $node->type; print $node_classes; ?> <?php print $zebra ?>">
<div class="content">
<?php if ($page == 0): ?><a name="<?php print $node->nid; ?>" id="<?php print $node->nid; ?>"></a><h2><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2><?php endif; ?>
<?php if ($submitted): ?><span class="submitted"><?php print $submitted; ?></span><?php endif; ?>
<?php print $content ?>
<?php 
print content_format('field_view', $node->field_view[0], 'default', $node); 
print content_format('field_view', $node->field_view[1], 'default', $node); 
print content_format('field_view', $node->field_view[2], 'default', $node); 
print content_format('field_view', $node->field_view[3], 'default', $node); 
print content_format('field_view', $node->field_view[4], 'default', $node); 
?>
<div class="clear-block clear"></div>
</div>
<?php if ($links): ?>
<div class="clear-block clear">
<div class="links"><?php print $links; ?></div>
</div>
<?php endif; ?></article>
<!-- HOI HOI -->