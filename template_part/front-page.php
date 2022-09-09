<?php
if(is_front_page() || is_home())set_transient( 'topPageType', 0 );

get_header();

 ?>

<?php get_template_part('main_panel'); ?>



<section class="content form-search" id="anchorForm">
		<div class="inner cf">
			<div class="side-left">
				<h2>現在の状況をご選択ください</h2>
				<form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
					<div class="box-form">
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
  									<ul class="list-form cf">
  										<?php foreach ($itemForm['inputList'] as $keyInput => $itemInput) { ?>
  											<li>
  												<?php if( !empty( $itemForm['key'] ) && $itemForm['key'] == $itemInput['value'] || empty( $itemForm['key'] ) ){
  												echo '<input class="'.$itemForm['class'].'" type="'.$itemForm['type'].'" name="'.$itemForm['name'].'" id="'.$itemForm['name'].$keyInput.'" value="'.$itemInput['value'].'" checked="checked"><label for="'.$itemForm['name'].$keyInput.'"><span>'.$itemInput['label'].'</span></label>';
  											} else {
  												echo '<input class="'.$itemForm['class'].'" type="'.$itemForm['type'].'" name="'.$itemForm['name'].'" id="'.$itemForm['name'].$keyInput.'" value="'.$itemInput['value'].'"><label for="'.$itemForm['name'].$keyInput.'"><span>'.$itemInput['label'].'</span></label>';
  											} ?>
  											</li>
  										<?php } ?>
  									</ul>
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
							<input type="hidden" name="s" id="s" />
							<div class="button-form cursor-p">
								<span class="main-text">診断する</span>
								<span class="icon-arrow ani-finger-1"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_yubi.png" alt="arrow" width="49" height="49" class="img-r"/></span>
								<input id="submit" type="submit" value="診断する" />
								<img src="<?php echo get_template_directory_uri(); ?>/images/button_2.jpg" alt="診断する" width="639" height="112" class="img-r"/>
							</div>
						</div>
					</div>

				</form>
			</div>
			<?php get_sidebar(); ?>
		</div>

</section>

<section class="content secondary-footer">
	<div></div>
</section>

<section class="content top-ranking-by-terms">
	<div class="inner">
		<?php
			//条件別ランキング　SPのみ表示
			get_template_part('template_part/inc_ranking_by_terms');
		?>
	</div>
</section>

<section class="content ranking colum">
	<div class="inner cf">
		<div class="side-left">
			<h2 class="title-ranking"><img src="<?php echo get_template_directory_uri(); ?>/images/title_ranking.png" alt="転職者が選ぶ　人気ランキング" width="530" height="138" class="img-r"/></h2>
			<div>
				<?php
					$rankingCount = 1;
					$rankingData = getTopRankingPosts('rankingtop');
					foreach($rankingData as $rankingPost) {
						if( !empty($rankingPost) ) {
							//案件BOXの取得
							getProductDe($rankingPost,true,$rankingCount,true);
							$rankingCount++;
						}
					?>

					<?php
						$args = array(
								'posts_per_page' => 2,
								'post_type' => 'reputationList',
								'meta_query' => array(
									'relation' => 'AND',
										array(
											'key' => 'reputation_id',
											'value' => $rankingPost->ID,
											'compare' => 'LIKE',
										),
								),
						);
						$reputationPosts = get_posts( $args );
						if(!empty($reputationPosts)){
					?>
					<div class="box-reputation-list top">
						<h3 class="title-common-01"><?php echo $rankingPost->post_title; ?>口コミ評判</h3>
						<ul class="list-reputation-single cf">
							<?php	foreach($reputationPosts as $reputationPost) { ?>

								<li data-heightid="<?php echo $rankingPost->ID;?>">

									<?php getReputationBoxDe($reputationPost->ID,false); ?>
								</li>
							<?php

								} ?>
						</ul>
					</div>

					<?php
						}
					} ?>

			</div>
		</div>
		<div class="box-side side-right">
			<div>
				<h2 class="title-common-01">お役たち情報</h2>
				<ul class="list-useful-info">
					<?php
						$args = array(
							'posts_per_page' => -1,
							'tax_query' => array(
									array(
										'taxonomy'=> 'toplist',
										'terms'=>array( 'toppoint1','toppoint2','toppoint3','toppoint4','toppoint5','toppoint6'),
										'field'=>'slug',
										'include_children'=>true,
										'operator'=>'IN'
									),
							),
						);
						$usefulInfoPosts = get_posts( $args );

						foreach ( $usefulInfoPosts as $usefulInfoPost ) {
					?>
					<li>
						<a href="<?php echo get_permalink($usefulInfoPost->ID); ?>"><?php echo $usefulInfoPost->post_title;?></a>
					</li>
					<?php } ?>
				</ul>
			</div>
      <div class="box-side-bnner">
        <?php

          $sideBnnerPosts = getSideBneerPosts();
          foreach ($sideBnnerPosts as $sideBnnerPost) {
            $fieldThumbBnner = wp_get_attachment_image_src(get_post_field('field_thumb',$sideBnnerPost->ID),'full');
            ?>
        <a href="<?php echo get_permalink($sideBnnerPost->ID); ?>" class="button-common detail"><img src="<?php echo $fieldThumbBnner[0]; ?>" alt="star" width="239" height="auto" class="img-r"/></a>
        <?php } ?>
      </div>
		</div>
	</div>
</section>


<section class="content page">
	<div class="inner">
		<?php
			$args = array(
				'order' => 'ASC',
				'category' => 8
			);
			$topPosts = get_posts( $args );

			foreach ( $topPosts as $catPost ) {
		?>
			<div class="box-page">
				<h2><?php echo $catPost->post_title;?></h2>
				<div class="article">
          <?php echo apply_filters('the_content',$catPost->post_content); ?>
				</div>
			</div>
		<?php } ?>
			<div class="box-related-btn">
				<div class="summary-block catch">
					たった<span class="emphasis1">５</span><span class="emphasis2">問</span>の質問で<br>
					自分に<span class="emphasis2">ピッタリ</span>の<span class="emphasis2">転職サイト</span>を診断!!
				</div>
				<a href="#anchorForm" class="button-common use">
					<span class="sub-text">あなたに最適な</span>
					<span class="main-text">転職サイト診断ツールを使う</span>
					<span class="icon-arrow ani-finger-1"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_yubi.png" alt="arrow" width="49" height="49" class="img-r"/></span>
					<img src="<?php echo get_template_directory_uri(); ?>/images/button_2.jpg" alt="あなたに最適な 転職サイト診断ツールを使う" width="639" height="112" class="img-r"/>
				</a>
			</div>
	</div>
</section>



<section class="content page non-margin">
	<div class="inner">
		<ul class="list-point-article cf">

			<?php
				$topPagePosts = array();

				for($i = 1; $i <= 6; $i++){
					$args = array(
						'posts_per_page' => 5,
						'tax_query' => array(
								array(
									'taxonomy'=> 'toplist',
									'terms'=>array( 'toppoint'.$i),
									'field'=>'slug',
									'include_children'=>true,
									'operator'=>'IN'
								),
						),
					);
					$toplist = get_posts( $args );
					$terms = get_the_terms($toplist[0]->ID,'toplist');
					$topPagePosts[] = array(
						'title' => $terms[0]->name,
						'list' => $toplist,
					);
				}


				foreach ( $topPagePosts as $keyPage => $pagePost ) {
					if(!empty($pagePost['list'])){
			?>
					<li class="cat" data-heightid="1">
						<h2>
							<span class="sub"><span>POINT</span>0<?php echo $keyPage+1;?></span><br>
							<span class="main"><?php echo $pagePost['title'];?></span>
						</h2>
						<ul class="list-point-link">
							<?php foreach ( $pagePost['list'] as $pageList ) { ?>
								<li>
									<a href="<?php echo get_permalink($pageList->ID); ?>"><?php echo $pageList->post_title;?></a>
								</li>
							<?php } ?>
						</ul>
					</li>
			<?php
					}
				} ?>

		</ul>
	</div>
</section>

<section class="content top-banner-sp disp-sp">
	<div class="inner">
		<a href="<?php echo esc_url( get_home_url() ); ?>/転職サイト診断テスト"><img src="<?php echo get_template_directory_uri(); ?>/images/banner_diagnosis_sp.jpg" alt="転職サイト診断テスト" width="639" height="112" class="img-r"/></a>
		<a href="<?php echo esc_url( get_home_url() ); ?>/口コミ投稿"><img src="<?php echo get_template_directory_uri(); ?>/images/banner_review_post_sp.jpg" alt="口コミはこちら" width="768" height="112" class="img-r"/></a>
	</div>
</section>


<?php get_footer(); ?>
