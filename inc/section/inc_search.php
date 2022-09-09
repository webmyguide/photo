<?php
    //検索結果の案件リスト
    $search_posts = get_search_posts();
?>


<section class="contentSearchResult">
    <h1 class="titleCommon">診断結果！<span class="txtSiz-l"><?php echo count($search_posts);?></span>件見つかりました</h1>

    <div class="contentSearchResult__sort">
        <div class="contentSearchResult__lead">
            <div>
                <img src="<?php echo get_template_directory_uri(); ?>/images/tit_search_pc_01.png" alt="転職成功者の約80%が最低2サイトに登録しています" width="744" height="90" class="contentSearchResult__appeal img-r img-pc"/>
                <img src="<?php echo get_template_directory_uri(); ?>/images/tit_search_01.png" alt="転職成功者の約80%が最低2サイトに登録しています" width="529" height="92" class="contentSearchResult__appeal img-r img-sp"/>
            </div>
        </div>

        <?php
          get_template_part('inc/box/inc_sort');
        ?>

    </div>

    <div data-product-list="1">
        <?php
            $setting = array(
                'page_search' => true,
                'ranking' => 1,
            );
            foreach ($search_posts as $key => $search) {
                view_product($search,$setting);
                $setting['ranking']++;
             }
         ?>
    </div>
</section>
