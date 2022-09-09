<?php
    global $formSetting;

    $formInfo = getFormInfo();
    $moreFlg = false;

    $formType = '';
?>


<form action="<?php echo esc_url( get_home_url() ); ?>" method="get">
    <div class="formSearch">
        <div class="formSearch__select">
            <?php foreach ($formInfo as $keyForm => $itemForm) { ?>
                <?php if($itemForm['type'] == 'hidden'){ ?>
                    <?php foreach ($itemForm['inputList'] as $keyInput => $itemInput) { ?>
                        <input type="<?php echo $itemForm['type']; ?>" name="<?php echo $itemForm['name']; ?>" value="<?php echo $itemInput['value']; ?>">
                    <?php } ?>
                <?php }else{ ?>
                    <?php if($keyForm == 4) $moreFlg = true; ?>
                        <div class="formSearch__item <?php if($keyForm >= 5) echo "formSearch__item-hide"; ?>">
                            <div class="formSearch__label <?php if($keyForm%2 == 1) echo "formSearch__label-even"; ?>"><?php echo $itemForm['title']; ?></div>
                            <div class="formSearch__input">
                                <?php if($itemForm['type'] == 'select'){?>
                                    <select name="search_element_0" class="selecting">
                                        <?php foreach ($itemForm['inputList'] as $selecting) {?>
                                            <option value="<?php echo $selecting['value']; ?>"><?php echo $selecting['label']; ?></option>
                                        <?php } ?>
                                    </select>
                                <?php }else { ?>
                                    <ul class="listForm">
                                        <?php foreach ($itemForm['inputList'] as $keyInput => $itemInput) { ?>
                                            <?php if( !isset($itemInput['def_flg']) ){?>
                                                <li class="listForm__item">
                                                    <?php
                                                            $itemFormClass = $itemForm['class'];
                                                            $itemFormName = ( $itemForm['type'] == 'checkbox' )?$itemForm['name'].'[]': $itemForm['name'];
                                                            $itemFormId = $itemForm['name'].$keyInput.$formType;
                                                            $itemFormChecked = ( (!empty( $itemForm['key'] ) && $itemForm['key'] == $itemInput['value']) || empty( $itemForm['key'] ) )?'checked="checked"': '';
                                                    ?>
                                                    <input class="<?php echo $itemFormClass; ?>" type="<?php echo $itemForm['type']; ?>" name="<?php echo $itemFormName; ?>" id="<?php echo $itemFormId; ?>" value="<?php echo $itemInput['value']; ?>" <?php echo $itemFormChecked; ?>>
                                                    <label for="<?php echo $itemFormId; ?>"><span <?php if(isset($itemInput['class'])){ ?>class="<?php echo $itemInput['class']; ?>"<?php } ?> ><?php echo $itemInput['label']; ?></span></label>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div>
                <?php } ?>
            <?php } ?>
        </div>
        <?php if($moreFlg){ ?>
            <div class="formSearch__add">
                <a href="javascript:void(0)" class="btnSub" id="tggleInput">＋こだわり条件を追加</a>
            </div>
        <?php } ?>

        <div class="formSearch__action">
            <input type="hidden" name="s" <?php if($formSetting['isIdName']){ ?>id="s"<?php } ?> />
            <input type="submit" class="btnMain btnForm" value="上記の条件で検索">
        </div>
    </div>
</form>
