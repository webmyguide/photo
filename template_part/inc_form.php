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



<?php if($formSetting['isTitle']){ ?>
  <div class="title-form">
    <img src="<?php echo get_template_directory_uri(); ?>/images/title_form_sp.png" alt="arrow" width="777" height="156" class="img-r img-sp"/>
    <img src="<?php echo get_template_directory_uri(); ?>/images/title_form_pc.png" alt="arrow" width="777" height="156" class="img-r img-pc"/>
  </div>
<?php } ?>
<section class="content form-search <?php if($formSetting['formType']){ ?>type-form-<?php echo $formSetting['formType']; ?><?php } ?> <?php if($sutepForm){ ?>form-search_type-stepup<?php } ?>" <?php if($formSetting['isIdName']){ ?>id="anchorForm"<?php } ?>>
		<div class="inner cf">
			<div class="side-left <?php if($formSetting['formType']){ ?>type-form-<?php echo $formSetting['formType']; ?><?php } ?>">
                <?php if($sutepForm){ ?>
                    <div class="box-stepup">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/prog_stepup_01.png" alt="5ステップ診断" width="777" height="114" class="img-r" data-step-img="<?php echo get_template_directory_uri(); ?>/images/prog_stepup_0" />
                    </div>
                <?php } ?>
				<h2>現在の状況をご選択ください</h2>
				<form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
					<div class="box-form" <?php if($sutepForm){ ?>data-stepup-box="<?php echo ($formSetting['formType'])?$formSetting['formType']:0; ?>"<?php } ?>>
						<?php
						$formInfo = getFormInfo();
						foreach ($formInfo as $keyForm => $itemForm) { ?>
                      <?php if($itemForm['type'] == 'hidden'){ ?>
                        <?php foreach ($itemForm['inputList'] as $keyInput => $itemInput) { ?>
                          <input type="<?php echo $itemForm['type']; ?>" name="<?php echo $itemForm['name']; ?>" value="<?php echo $itemInput['value']; ?>">
                        <?php } ?>
                      <?php }else{ ?>
  							<?php if($keyForm == 5){ ?>
  								<div class="item-add">
  									<a href="javascript:void(0)" class="button-add-input" id="tggleInput">＋こだわり条件を追加</a>
  								</div>
  							<?php } ?>

  							<div class="row <?php if($keyForm >= 5) echo "initial-hide"; ?>">
  								<div class="cell title" data-key="Q<?php echo $keyForm+1; ?>">
  									<?php echo $itemForm['title']; ?>
  								</div>
  								<div class="cell input">

  								</div>
  							</div>
              <?php } ?>
						<?php } ?>
					</div>

					<div class="box-button">
						<div class="summary-block diagnosis">
							<span class="emphasis1" data-num-registrants=""><span class="fixedNum"><?php echo (!empty(get_transient( 'numberRegistrants')))?get_transient( 'numberRegistrants'):'--'; ?></span><span class="cagNum"></span></span><span class="emphasis2">人</span>が診断中
						</div>
						<div>
							<input type="hidden" name="s" <?php if($formSetting['isIdName']){ ?>id="s"<?php } ?> />
							<div class="button-form button-form_result cursor-p" <?php if($sutepForm){ ?>data-stepup-result="<?php echo ($formSetting['formType'])?$formSetting['formType']:0; ?>"<?php } ?>>
                                <?php if($sutepForm){ ?>
                                    <span class="main-text disp-sp">診断結果をチェック</span>
                                    <span class="main-text disp-pc">診断する</span>
                                    <span class="icon-arrow-2 ani-arrow-2 disp-sp"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_arrow_1.png" alt="arrow" width="49" height="49" class="img-r"></span>
                                    <span class="icon-arrow ani-finger-1 disp-pc"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_yubi.png" alt="arrow" width="49" height="49" class="img-r"/></span>
                                <?php }else{ ?>
                                    <span class="main-text">診断する</span>
                                    <span class="icon-arrow ani-finger-1"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_yubi.png" alt="arrow" width="49" height="49" class="img-r"/></span>
                                <?php } ?>

								<input id="submit" type="submit" value="診断する" />
								<img src="<?php echo get_template_directory_uri(); ?>/images/button_2_red.jpg" alt="診断する" width="639" height="112" class="img-r"/>
							</div>



                            <?php if($sutepForm){ ?>
                                <div class="button-form button-form_next cursor-p" data-stepup-form="<?php echo ($formSetting['formType'])?$formSetting['formType']:0; ?>" data-step="1" >
                                    <span class="main-text">診断開始</span>
                                    <span class="icon-arrow-2 ani-arrow-2"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_arrow_1.png" alt="arrow" width="49" height="49" class="img-r"></span>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/button_2_red.jpg" alt="診断開始" width="639" height="112" class="img-r"/>
                                </div>
                                <br>
                                <div class="button-form-return" data-stepup-return="<?php echo ($formSetting['formType'])? $formSetting['formType']:0; ?>" data-step="1">
                                    <div class="btn-return">戻る</div>
                                </div>
                            <?php } ?>
						</div>
					</div>

				</form>
			</div>
			<?php if($formSetting['isSidebar']) get_sidebar(); ?>
		</div>

</section>
