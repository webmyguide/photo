<?php
  global $formSetting;
 ?>

 <?php
     $args = array(
         'post_type' => 'feature',
         'orderby' => 'menu_order',
         'order'   => 'ASC',
     );
     $posts = get_posts( $args );
 ?>

 <?php foreach ($posts as $key => $value) { ?>
     <a href="<?php the_permalink($value->ID); ?>" class="listSite"><?php echo $value->post_title; ?>で選ぶ</a>
 <?php } ?>
