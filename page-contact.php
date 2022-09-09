<?php
/*
Template Name: お問い合わせtemp
*/

global $int_setting_ids;
global $setting_page;

//ページの設定を取得
$setting_page = get_post_setting($int_setting_ids['contact']);

$current_step = $_GET['step'];

?>

<?php get_header(); ?>

<?php vie_main_visual(); ?>

<main class="main pageContact">
    <?php if( $current_step != 3 ){ ?>
        <?php
            if( ($current_step == 1) || empty($current_step) ){
                vie_reception_calendar('','contact');
            }
        ?>

        <p class="pageContact__info <?php if ($current_step == 2) echo 'pageContact__info-cfm'; ?>">
            受付時間&nbsp;<?php echo $setting_common['common_reception_time_1'];?>〜<?php echo $setting_common['common_reception_time_2'];?>&nbsp;/&nbsp;定休日&nbsp;<?php echo $setting_common['common_regular_holiday'];?><br>
            <?php if(!empty($setting_common['common_phone_number'])){ ?><span class="pageContact__tel">TEL&nbsp;<?php echo $setting_common['common_phone_number'];?></span><?php } ?>
        </p>

        <?php if( ($current_step == 1) || empty($current_step) ){ ?>
            <h2 class="titCommon titCommon-sl">メールでお問い合わせ</h2>
        <?php }elseif ($current_step == 2) { ?>
            <h2 class="titCommon titCommon-sl">メールでお問い合わせ</h2>
            <div class="pageContact__cfm">
                <?php echo apply_filters('the_content',$setting_page['contact_confirm_detail']);?>
            </div>
        <?php } ?>
    <?php } ?>


    <?php echo do_shortcode('[mwform_formkey key="1355"]'); ?>


    <?php if( $current_step == 3 ){ ?>
        <div class="pageContact__thanks boxThanks">
            <h1 class="titCommon titCommon-sl"><?php echo $post->post_title; ?></h1>
            <p class="boxThanks__emp"><?php echo $setting_page['contact_thanks_title']; ?></p>
            <div class="boxThanks__detail"><?php echo apply_filters('the_content',$setting_page['contact_thanks_detail']); ?></div>
        </div>

        <p class="pageContact__info pageContact__info-cfm">
            受付時間&nbsp;<?php echo $setting_common['common_reception_time_1'];?>〜<?php echo $setting_common['common_reception_time_2'];?>&nbsp;/&nbsp;定休日&nbsp;<?php echo $setting_common['common_regular_holiday'];?><br>
            <?php if(!empty($setting_common['common_phone_number'])){ ?><span class="pageContact__tel">TEL&nbsp;<?php echo $setting_common['common_phone_number'];?></span><?php } ?>
        </p>

        <?php echo do_shortcode('[contact_step]'); ?>

        <a href="<?php echo esc_url(home_url( '/' )); ?>" class="pageContact__pagetop btnContact btnContact-submit">TOPへ戻る</a>
    <?php } ?>
</main>



<?php get_footer(); ?>
