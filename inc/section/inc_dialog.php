
<div class="dialog" id="dialogMenu">
    <div class="dialog__mask"></div>
    <div class="dialog__close"></div>
    <section class="dialog__box" id="targetDialogSearch">
        <?php
            get_template_part('inc/form/inc_search');
        ?>
    </section>

    <section class="dialog__box" id="targetDialogRanking">
        <?php
            global $setting_ranking_list;
            $setting_ranking_list = array(
                'type' => 'dialog',
            );
            get_template_part('inc/list/inc_findSiteWorkplace');
        ?>
    </section>
</div>
