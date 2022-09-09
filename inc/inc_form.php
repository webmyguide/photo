<?php
  global $formSetting;

  $formType = '';
  if($formSetting['formType']){
    $formType = '-'.$formSetting['formType'];
  }

  //ステップアップフォーム有無
  $sutepForm = get_post_field('cff_stepup_enable',2);
  $sutepTopOnly = get_post_field('cff_stepup_only',2);

  if($formType && $sutepTopOnly) $sutepForm = false;
 ?>




 <section class="content form-search <?php if($formSetting['formType']){ ?>type-form-<?php echo $formSetting['formType']; ?><?php } ?> <?php if($sutepForm){ ?>form-search_type-stepup<?php } ?>" <?php if($formSetting['isIdName']){ ?>id="anchorForm"<?php } ?>>

<div class="elementor-element elementor-element-1b0ecb6 elementor-column elementor-col-50 elementor-inner-column">
    <div class="elementor-column-wrap  elementor-element-populated">
        <div class="elementor-widget-wrap">
            <div class="elementor-element elementor-element-5d42d62 elementor-widget elementor-widget-image">
                <div class="elementor-widget-container">
                    <div class="elementor-image">
                        条件を指定して理想の転職サイトを検索！
                    </div>
                </div>
            </div>
            <div class="">
                <div class="elementor-widget-container">
                    <form id="feas-searchform-0" action="" method="get">
                        <table class="searchFormTable">
                            <tbody>
                                <?php
            						$formInfo = getFormInfo();
                                    foreach ($formInfo as $keyForm => $itemForm) {
                                        if($itemForm['type'] == 'hidden'){
                                            foreach ($itemForm['inputList'] as $keyInput => $itemInput) {
                                            ?>
                                                <tr class="">
                                                    <td class="submit" colspan="2">
                                                        <input type="<?php echo $itemForm['type']; ?>" name="<?php echo $itemForm['name']; ?>" value="<?php echo $itemInput['value']; ?>">
                                                    </td>
                                                </tr>
                                            <?php }

                                        }else{
                                            if($keyForm == 5){
                                            ?>
                                                <tr class="">
                                                    <td class="submit" colspan="2">
                                                        <div class="item-add">
                          									<a href="javascript:void(0)" class="button-add-input" id="tggleInput">＋こだわり条件を追加</a>
                          								</div>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                            <tr class="row <?php if($keyForm >= 5) echo "initial-hide"; ?>">
                                                <th data-key="Q<?php echo $keyForm+1; ?>"><?php echo $itemForm['title']; ?></th>
                                                <td class="still">

                                                    <?php if($itemForm['type'] == 'select'){?>
                                                        <select name="search_element_0" id="feas_0_0" class="selecting">
                                                            <?php foreach ($itemForm['inputList'] as $selecting) {?>
                                                                <option id="feas_0_0_none" value="<?php echo $selecting['value']; ?>"><?php echo $selecting['label']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    <?php }else { ?>
                                                        <ul class="list-form<?php if($sutepForm){ ?>-stepup<?php } ?> cf">
                      										<?php foreach ($itemForm['inputList'] as $keyInput => $itemInput) { ?>
                      											<li>
                      												<?php if( !empty( $itemForm['key'] ) && $itemForm['key'] == $itemInput['value'] || empty( $itemForm['key'] ) ){
                                                                    $itemFormClass = $itemForm['class'];
                                                                    if($sutepForm) $itemFormClass .= '-stepup';
                      												echo '<input class="'.$itemFormClass.'" type="'.$itemForm['type'].'" name="'.$itemForm['name'].'" id="'.$itemForm['name'].$keyInput.$formType.'" value="'.$itemInput['value'].'" checked="checked"><label for="'.$itemForm['name'].$keyInput.$formType.'"><span>'.$itemInput['label'].'</span></label>';
                      											} else {
                                                                    $itemFormClass = $itemForm['class'];
                                                                    if($sutepForm) $itemFormClass .= '-stepup';
                      												echo '<input class="'.$itemFormClass.'" type="'.$itemForm['type'].'" name="'.$itemForm['name'].'" id="'.$itemForm['name'].$keyInput.$formType.'" value="'.$itemInput['value'].'"><label for="'.$itemForm['name'].$keyInput.$formType.'"><span>'.$itemInput['label'].'</span></label>';
                      											} ?>
                      											</li>
                      										<?php } ?>
                      									</ul>
                                                    <?php } ?>

                                                </td>
                                            </tr>
                                    <?php } ?>
                                <?php } ?>

                                    <tr class="submitBox">
                                        <td class="submit" colspan="2">
                                            <input type="hidden" name="s" <?php if($formSetting['isIdName']){ ?>id="s"<?php } ?> />

                                            <input type="submit" name="searchbutton" id="feas-submit-button-0" class="feas-submit-button" value="上記の条件で検索">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
sssssssss






</section>
