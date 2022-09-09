<?php


function archive_sort_order($query){
    if(is_post_type_archive('product')):
        $set = array(
            'meta_key' => 'sort_num',
            'orderby' => 'menu_order',
        );
        $query->set( 'order', 'ASC' );
        //Set the orderby
        $query->set('orderby' , 'menu_order');
        // $query->set(  );
    endif;
};
add_action( 'pre_get_posts', 'archive_sort_order');

?>
