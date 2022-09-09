<?php
    global $setting_diagnosis;

    if($setting_diagnosis['flg_rankng']){
        $is_section = false;
        $class_box = 'contentRanking__diagnosis';
    }else {
        $is_section = true;
        $class_box = 'contentCommon__box';
    }
?>

<?php if($is_section){ ?>
<section class="contentCommon">
    <div class="contentCommon__wrap">
<?php } ?>

        <div class="<?php echo $class_box; ?> boxCommon boxCommon-pn">
            <h2 class="titleBox">
                <strong>10秒であなたに</strong>ぴったりの<strong>サイトが見つかる！</strong>
            </h2>
            <div class="contentCommon__detail">
            <?php
              get_template_part('inc/form/inc_diagnosis');
            ?>
            </div>
        </div>

<?php if($is_section){ ?>
    </div>
</section>
<?php } ?>
