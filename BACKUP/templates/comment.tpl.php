<?php
// $Id: comment.tpl.php,v 1.10 2008/01/04 19:24:24 goba Exp $
?>
<div class="comment<?php print ($comment->new) ? ' comment-new' : ''; print ' '. $status; print ' '. $zebra; ?>">

  <?php print $picture ?>

    <div class="content">
     <div class="commentbox">

      <div class="clear-block">

      <?php if ($submitted): ?>
        <span class="submitted"><?php print $submitted; ?></span>
      <?php endif; ?>

      <?php if ($comment->new) : ?>
        <span class="new"><?php print drupal_ucfirst($new) ?></span>
      <?php endif; ?>

      <?php print $content ?>
      <?php if ($signature): ?>
      <div class="clear-block">
        <div>—</div>
        <?php print $signature ?>
      </div>
      <?php endif; ?>
    
      </div>
     </div>

     <?php if ($links): ?>
       <div class="links"><?php print $links ?></div>
     <?php endif; ?>

    </div>

</div>
