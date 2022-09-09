<?php

//--------------------------------------------------------------------------------------------------
// ページネーション
//--------------------------------------------------------------------------------------------------
/**
* ページネーション出力関数
* $paged : 現在のページ
* $pages : 全ページ数
* $range : 左右に何ページ表示するか
* $show_only : 1ページしかない時に表示するかどうか
*/
function vie_pagination( $pages, $paged, $range = 1, $show_only = true){


    $pages = ( int ) $pages;    //float型で渡ってくるので明示的に int型 へ
    $paged = $paged ?: 1;       //get_query_var('paged')をそのまま投げても大丈夫なように

    //表示テキスト
    $text_first   = "«";
    $text_before  = "‹";
    $text_next    = "›";
    $text_last    = "»";
?>

    <?php if ( $show_only && $pages === 1 ) {// １ページのみで表示設定が true の時 ?>
        <div class="pagination">
            <span class="pagination__pager pagination__pager-current">1</span>
        </div>
        <?php return; ?>
    <?php } ?>
<?php
    if ( $pages === 1 ) return;    // １ページのみで表示設定もない場合
?>
    <?php if ( 1 !== $pages ) {//２ページ以上の時 ?>
        <div class="pagination">
            <?php if ( $paged > $range + 1 ) {// 「最初へ」 の表示 ?>
                <a href="<?php echo get_pagenum_link(1);?>" class="pagination__pager pagination__pager-prve"><?php echo $text_first;?></a>
            <?php } ?>

            <?php if ( $paged > 1 ) {// 「前へ」 の表示 ?>
                <a href="<?php echo get_pagenum_link($paged - 1);?>" class="pagination__pager pagination__pager-prve"><?php echo $text_before;?></a>
            <?php } ?>

            <?php for ( $i = 1; $i <= $pages; $i++ ) { ?>
                <?php if ( $i <= $paged + $range && $i >= $paged - $range ) {// $paged +- $range 以内であればページ番号を出力 ?>
                    <?php if ( $paged === $i ) { ?>
                        <span class="pagination__pager pagination__pager-current"><?php echo $i;?></span>
                    <?php } else { ?>
                        <a href="<?php echo get_pagenum_link($i);?>" class="pagination__pager"><?php echo $i;?></a>
                    <?php } ?>

                <?php } ?>
            <?php } ?>

            <?php if ( $paged < $pages ) {// 「次へ」 の表示 ?>
                <a href="<?php echo get_pagenum_link($paged + 1);?>" class="pagination__pager pagination__pager-next"><?php echo $text_next;?></a>
            <?php } ?>

            <?php if ( $paged + $range < $pages ) {// 「最後へ」 の表示 ?>
                <a href="<?php echo get_pagenum_link($pages);?>" class="pagination__pager pagination__pager-next"><?php echo $text_last;?></a>
            <?php } ?>
        </div>
    <?php } ?>
<?php

}
?>
