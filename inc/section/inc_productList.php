<?php
    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'product',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_key' => 'sort_num',
    );

    $product_posts = get_posts( $args );
?>


<section class="contentCommon">
    <div class="contentCommon__wrap">
        <h2 class="contentCommon__title">
            <img src="<?php echo get_template_directory_uri(); ?>/images/tit_productlist_01.png" alt="看護師転職サイト一覧" width="580" height="104" class="img-r disp-sp"/>
            <img src="<?php echo get_template_directory_uri(); ?>/images/tit_productlist_pc_01.png" alt="看護師転職サイト一覧" width="1014" height="153" class="img-r disp-pc"/>
        </h2>
        <div class="contentCommon__box boxCommon">
            <table id="table-product" class="tableProduct">
                <thead>
                    <tr>
                        <th class="tableProduct__th tableProduct__th-site">サイト名</th>
                        <th class="tableProduct__th tableProduct__th-list">エリア</th>
                        <th class="tableProduct__th tableProduct__th-list">派遣</th>
                        <!-- <th class="tableProduct__th tableProduct__th-list">予備</th> -->
                        <th class="tableProduct__th tableProduct__th-official">公式</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($product_posts as $key => $value) { ?>
                        <?php
                            $official_url = get_cushion_url($value->ID);
                            $sort_num = get_post_meta($value->ID,'sort_num',true);
                            $fieldData = get_field( "product_table_data_1", $value->ID );
                            $table_value_1 = '';
                            $size_c = '';
                            $flg_all = '';
                            foreach($fieldData as $fd){
                                if(!$flg_all){
                                    if($size_c >= 1){
                                      $table_value_1 .= ' / ';
                                    }
                                    $table_value_1 .= $fd['label'];
                                    $size_c++;
                                }

                                if($fd['value'] == 0)$flg_all = true;
                            }
                            $table_value_2 = get_post_meta($value->ID,'product_table_data_2',true);
                            $table_value_3 = get_post_meta($value->ID,'product_table_data_3',true);
                        ?>
                        <tr class="tableProduct__tbodyTr">
                            <td class="tableProduct__td tableProduct__td-site" data-order="<?php echo $sort_num; ?>"><?php echo $value->post_title; ?></td>
                            <td class="tableProduct__td"><?php echo ($table_value_1); ?></td>
                            <td class="tableProduct__td tableProduct__td-boolean" data-order="<?php echo $table_value_2; ?>"><?php echo ($table_value_2)? '○':'×'; ?></td>
                            <!-- <td class="tableProduct__td tableProduct__td-boolean"><?php echo ($table_value_3)? '○':'×'; ?></td> -->
                            <td class="tableProduct__td tableProduct__td-official"><a href="<?php echo $official_url;?>" class="btnMain btnTableProduct">公式ページへ</a></td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</section>
