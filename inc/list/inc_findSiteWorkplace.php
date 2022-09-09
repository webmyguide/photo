<?php
    global $setting_ranking_list;

    $args = array(
        'post_type' => 'ranking',
        'orderby' => 'menu_order',
        'order'   => 'ASC',
    );
    $posts = get_posts( $args );
    $ranking_num = 1;
?>


<?php if($setting_ranking_list['type'] == 'dialog'){ ?>
    <ul class="boxDialogList">
        <?php foreach ($posts as $key => $value) { ?>
            <li class="boxDialogList__item">
                <a href="<?php the_permalink($value->ID); ?>" class="boxDialogList__link">
                    <figure class="boxDialogList__figure">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/ico_ranking_0<?php echo $ranking_num; ?>.png" width="75" height="75" class="img-r verAlign-b"/>
                    </figure>
                    <div class="boxDialogList__detail">
                        <div class="boxDialogList__title"><?php echo $value->post_title; ?></div>
                        <div class="boxDialogList__lead">
                            <?php echo get_post_meta($value->ID,'cf_ranking_balloon',true); ?>
                        </div>
                    </div>
                </a>
            </li>
            <?php $ranking_num++; ?>
        <?php } ?>
    </ul>
<?php }else{ ?>
    <ul class="boxFindLinks__list">
        <?php foreach ($posts as $key => $value) { ?>
            <?php
                if($value->post_name == "company") {
                    $class_name = "boxFindLinks__link-company";
                } elseif ($value->post_name == "hospital") {
                    $class_name = "boxFindLinks__link-hospital";
                }elseif ($value->post_name == "drug-store") {
                    $class_name = "boxFindLinks__link-drugstore";
                }else {
                    $class_name = "boxFindLinks__link-dispensing";
                }
            ?>
            <li class="boxFindLinks__item">
                <a href="<?php the_permalink($value->ID); ?>" class="boxFindLinks__link <?php echo $class_name; ?>">
                    <div class="boxFindLinks__subtitle"><?php echo get_post_meta($value->ID,'cf_ranking_subtitle',true); ?></div>
                    <?php echo $value->post_title; ?>
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
