<?php

//--------------------------------------------------------------------------------------------------
// ブログ
//--------------------------------------------------------------------------------------------------
function vie_article_blog($id){
    //$idが空だったら何もしない
    if(empty($id)) return false;

?>
    <article class="listBlog__items boxBlog">
        <a href="<?php echo get_post_permalink($id); ?>"  class="boxBlog__figure">
           <?php echo get_thumb( $id, 'medium', array( 'class' => 'boxBlog__img verAlign-b msimg', 'loading' => 'lazy' ) ); ?>
        </a>
        <div class="boxBlog__lead">
            <time class="boxBlog__time"><?php echo get_post_time('Y.m.d [D]', false,$id) ?></time>
            <h3 class="boxBlog__tit"><a href="<?php echo get_post_permalink($id); ?>" class="boxBlog__link"><?php echo get_the_title($id); ?></a></h3>
        </div>
    </article>
<?php

}
?>
