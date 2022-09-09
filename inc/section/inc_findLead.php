<?php
	global $int_post_id;

    //TOPページの場合
	if(is_front_page() || is_home()){
        $content_post = get_post($int_post_id);
		$title = get_post_meta($int_post_id,'cf_top_title',true);
        $content = $content_post->post_content;
	}else {
		$page_id = get_the_ID();
		$content_post = get_post($page_id);
		$title = get_post_meta($page_id,'cf_top_title',true);
		$content = $content_post->post_content;
	}
	//GETでキーワードを変える
	// if( isset( $_GET[ 'contentoptkw' ] ) )$title = get_keyword(2);

	if( !$title )$title = get_post_meta($int_post_id,'cf_top_title',true);
?>

<section class="contentCommon">
    <div class="boxFindLead">
        <h2 class="boxFindLead__title"><?php echo apply_filters('the_content',$title); ?></h2>
        <div class="boxFindLead__detail">
            <?php echo apply_filters('the_content',$content); ?>
        </div>
    </div>

</section>
