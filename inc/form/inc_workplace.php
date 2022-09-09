<?php
  global $formSetting;
 ?>

 <?php
     $args = array(
         'post_type' => 'ranking',
         'orderby' => 'menu_order',
         'order'   => 'ASC',
     );
     $posts = get_posts( $args );
 ?>


 <?php foreach ($posts as $key => $value) { ?>
     <a href="<?php the_permalink($value->ID); ?>" class="listSite"><?php echo $value->post_title; ?>に強い転職サイトランキング</a>
 <?php } ?>
